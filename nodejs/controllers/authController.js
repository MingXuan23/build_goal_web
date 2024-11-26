const bcrypt = require("bcryptjs");
const nodemailer = require("nodemailer");
const jwt = require("jsonwebtoken");
const crypto = require('crypto');
const os = require("os");



require("dotenv").config();

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])

const { registerSchema, loginSchema, forgetPasswordSchema, changePasswordSchema, validateSessionSchema } = require("../validators/authValidator");
const {
  getUserByEmail,
  createUser,
  updateUserStatus,
  updateVerificationCode,
  updatePassword,
  getStaticToken
} = require("../models/userModel");
const { v4: uuidv4 } = require("uuid");
const { create } = require("domain");

const sendVerificationEmail = async (userEmail, userName, verificationCode) => {
  const transporter = nodemailer.createTransport({
    host: process.env.SMTP_HOST,
    port: process.env.SMTP_PORT,
    secure: true,
    auth: {
      user: process.env.SMTP_USER,
      pass: process.env.SMTP_PASS,
    },
  });

  const mailOptions = {
    from: `"xBug Account" <${process.env.SMTP_USER}>`,
    to: userEmail,
    subject: "Account Verification - xBug.Online",
    html: `
      <p>Hey ${userName},</p>
      <p>Welcome to [xBug.online]! We’re excited to have you on board. To complete your account setup, please use the verification code below:</p>
      <h2>Verification Code: ${verificationCode}</h2>
      <p>Please enter this code in the verification section of your account settings to activate your account. If you didn’t sign up for [xBug.online], you can ignore this email.</p>
      <br>
      <p>Thank you for choosing [xBug.online]!</p>
      <p>Best Regards,<br>[Admin xBug]</p>
    `,
  };
  await transporter.sendMail(mailOptions);

};

const sendResetPasswordEmail = async (userEmail, userName, newPassword) => {
  const transporter = nodemailer.createTransport({
    host: process.env.SMTP_HOST,
    port: process.env.SMTP_PORT,
    secure: true,
    auth: {
      user: process.env.SMTP_USER,
      pass: process.env.SMTP_PASS,
    },
  });

  const mailOptions = {
    from: `"xBug Account" <${process.env.SMTP_USER}>`,
    to: userEmail,
    subject: "Your New Password - xBug.Online",
    html: `
      <p>Hi ${userName},</p>
      <p>We’ve reset your password as requested. Below is your new password:</p>
      <h3>Password: ${newPassword}</h3>
      <p>We recommend that you change this password after logging in for security purposes.</p>
      <br>
      <p>If you did not request a password reset, please contact support immediately.</p>
      <p>Thank you for choosing [xBug.online]!</p>
      <p>Best Regards,<br>[Admin xBug]</p>
    `,
  };

  await transporter.sendMail(mailOptions);

};

const sendForgetPasswordRequestEmail = async (userEmail, userName, link) => {
  const transporter = nodemailer.createTransport({
    host: process.env.SMTP_HOST,
    port: process.env.SMTP_PORT,
    secure: true,
    auth: {
      user: process.env.SMTP_USER,
      pass: process.env.SMTP_PASS,
    },
  });

  const mailOptions = {
    from: `"xBug Account" <${process.env.SMTP_USER}>`,
    to: userEmail,
    subject: "Your Forget Password Request - xBug.Online",
    html: `
      <p>Hi ${userName},</p>
      <p>We’ve received your forget password request. Please click the button below to validate the action:</p>
      <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 20px 0;">
        <tr>
          <td align="center" bgcolor="#007bff" style="border-radius: 5px; background-color: #007bff;">
            <a href="${link}" 
               style="display: inline-block; font-family: Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 5px; border: 1px solid #007bff;">
              Reset Password
            </a>
          </td>
        </tr>
      </table>
  
      <!-- Clickable link text for copying -->
      <p>If you are unable to click the button, copy and paste the link below into your browser:</p>
      <p>
        <a href="${link}" style="color: #007bff; text-decoration: none;">${link}</a>
      </p>
  
      <p>If you did not request a password reset, please ignore this email or contact support immediately.</p>
      <br>
      <p>Thank you for choosing xBug.online!</p>
      <p>Best Regards,<br>Admin xBug</p>
    `,
  };

  try {
    await transporter.sendMail(mailOptions);
    console.log(`Reset password email sent to ${userEmail}`);
    return { success: true, message: "Reset password email sent successfully." };
  } catch (error) {
    console.error("Error sending reset password email:", error);
    throw new Error("Something went wrong while sending the reset email. Please try again later.");
  }
};



const register = async (req, res) => {

  try {
    const validatedData = registerSchema.parse(req.body);
    const { email, password, name, state, address, telno } = validatedData;

    const existingUser = await getUserByEmail(email);
    if (existingUser)
      return res.status(403).json({ message: "Email already in use. Please complete previous registration!" });

    const uuid = uuidv4();
    const hashedPassword = await bcrypt.hash(password, 10);
    const verificationCode = Math.floor(100000 + Math.random() * 900000);
    const role = { type: "mobile-user" };
    const success_acc = "Pending email verification";
    const email_status = "NOT VERIFY";
    const result = await createUser({
      ...validatedData,
      password: hashedPassword,
      verification_code: verificationCode,
      role: JSON.stringify(role),
      success: success_acc,
      email_status: email_status,
    });

    if (result) {
      await sendVerificationEmail(email, name, verificationCode);
      const responseData = {
        name: validatedData.name,
        telno: validatedData.telno,
        email: validatedData.email,
      };
      res
        .status(201)
        .json({ success: true, message: "User registered successfully", data: responseData });
    }
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: messages });
    } else {
      res.status(500).json({ success: false, message: error.message });
    }
  }
};

const verifyCode = async (req, res) => {
  try {
    const { email } = req.params;
    const { code } = req.body;

    const user = await getUserByEmail(email);
    // console.log(user)

    if (!user) {
      return res.status(404).json({ success: false, message: "User not found" });
    }

    if (user.email_status === "VERIFY") {
      return res.status(401).json({ success: false, message: "Your Account is Active" });
    }


    if (user.verification_code !== code) {
      return res.status(400).json({ success: false, message: "Invalid verification code" });
    }


    await updateUserStatus(email);

    res.status(200).json({ success: true, message: "Account has successfully activated" });
  } catch (error) {
    res.status(500).json({ success: false, message: "Internal server error", error });
  }
};

const resendVerificationCode = async (req, res) => {
  const { email } = req.params;

  try {
    const user = await getUserByEmail(email);

    if (!user) {
      return res.status(404).json({ success: false, message: "User not found" });
    }

    if (user.email_status === "VERIFY") {
      return res.status(401).json({ success: false, message: "Your Account is Already Active" });
    }

    const newVerificationCode = Math.floor(100000 + Math.random() * 900000);

    const result = await updateVerificationCode(email, newVerificationCode);
    if (result) {
      await sendVerificationEmail(email, user.name, newVerificationCode);
      res.status(200).json({
        success: true,
        message: `Verification code resent successfully to email ${email}`
      });
    }


  } catch (error) {
    res.status(500).json({ success: false, message: "Internal server error", error });
  }
};

const login = async (req, res) => {


  try {
    const validatedData = loginSchema.parse(req.body);
    const { email, password, device_token } = validatedData;



    const user = await getUserByEmail(email);
    // console.log(user);
    if (!user || !(await bcrypt.compare(password, user.password))) {
      return res.status(401).json({ success: false, message: "Invalid credentials" });
    }
    if (user.email_status === "NOT VERIFY") {
      return res.status(401).json({ success: false, message: "Your Account is Not Active." });
    }
    if (user.status === "ACTIVE") {
      const token = getStaticToken(user.id, user.created_at);



      const existingTokenRecord = await knex("user_token").where({ user_id: user.id }).first();


      const ipAddress = req.header('x-forwarded-for') || req.connection.remoteAddress; // Get user's IP address

      const rememberToken = crypto.randomBytes(30).toString("hex"); // Generate 40-char random token

      // Generate bcrypt hash of user_id

      if (!existingTokenRecord) {
        // If user_id does not exist, create a new record
        await knex("user_token").insert({
          user_id: user.id,
          remember_token: rememberToken,
          app_id: app.id,
          device_token: device_token,
          token: token, // Use only the first 20 chars of the hash
          ip_address: ipAddress,
          created_at: knex.fn.now(),

        });
      } else {
        // If user_id exists, update the record
        await knex("user_token")
          .where({ user_id: user.id })
          .update({
            remember_token: rememberToken,
            device_token: device_token,
            ip_address: ipAddress,
            token: token,
            updated_at: knex.fn.now()

          });
      }

      res.status(200).json({ success: true, token, rememberToken, email: user.email });
    }
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: messages });
    } else {
      res.status(400).json({ success: false, message: error.message });
    }
  }
};


const validateSession = async (req, res) => {


  try {
    const validatedData = validateSessionSchema.parse(req.body);
    const { email, rememberToken } = validatedData;
    const applicationId = req.headers['application-id'];

    if (!applicationId) {
      res.status(503).json({
        success: false,
        message: 'Service Not Available'
      });
    }

    const app = await knex('application')
      .select('*')
      .where({ name: applicationId })
      .first();

    if (!app) {
      res.status(503).json({
        success: false,
        message: 'Service Not Available'
      });
    }



    const existingTokenRecord = await knex("user_token as ut")
      .join("users as u", "ut.user_id", "u.id") // Use aliases for table names
      .where({ "ut.remember_token": rememberToken, "u.email": email }) // Use the alias in the condition

      .select("ut.*") // Select all fields from both tables using aliases
      .first(); // Get the first matching record


    const ipAddress = req.header('x-forwarded-for') || req.connection.remoteAddress; // Get user's IP address

    const newRememberToken = crypto.randomBytes(30).toString("hex"); // Generate 40-char random token

    // Generate bcrypt hash of user_id

    await knex("user_token")
      .where({ id: existingTokenRecord.id })
      .update({
        remember_token: newRememberToken,
        updated_at: knex.fn.now(),
        ip_address: ipAddress,

      });

    res.status(200).json({ success: true, rememberToken: newRememberToken });

  } catch (error) {
    res.status(400).json({ success: false, message: 'Your session is expired. Please login again.', error: error });

  }
};

const generateRandomPassword = () => {
  return Math.random().toString(36).slice(-8);
};

const performForgetPassword = async (req, res) => {
  try {

    const by = req.query.by;

    const data = jwt.verify(by, process.env.JWT_SECRET);

    const user = await getUserByEmail(data.email);

    if (!user) {
      return res.status(404).json(`You have not Active Password Request now.`);

    }

    const password_reset = await knex('user_password_reset')
      .select('*') // Select all columns (or specify the columns you need)
      .where({ status: 1, user_id: user.id ,unique_id : data.unique_id}) // Filter by status and user_id
      .andWhere('expired_at', '>=', knex.fn.now())
      .first();

    if (!password_reset) {
      console.log(user.id, data.unique_id)
      return res.status(404).json(`You have not Active Password Request now.`);
    }

    const newPassword = generateRandomPassword();
    const hashedPassword = await bcrypt.hash(newPassword, 10);

    const result = await updatePassword(data.email, hashedPassword);

    if (result) {
      await sendResetPasswordEmail(
        data.email,
        user.name,
        newPassword
      );


      await knex('user_password_reset') .where({ status: true, user_id: user.id}).update({
       status:0,
        updated_at: knex.fn.now(),
  
      });
      return res.status(200).json(`A new password has been sent to your email: ${data.email}`);
    }
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: messages });
    } else {
      res.status(500).json({ success: false, message: error.message });
    }
  }
};




const forgetPassword = async (req, res) => {
  try {

    const validatedData = forgetPasswordSchema.parse(req.body);
    const { email } = validatedData;

    const user = await getUserByEmail(email);

    if (!user) {
      return res.status(404).json({ success: false, message: "Email not found" });
    }

    const exists = await knex('user_password_reset')
      .select('*') // Select all columns (or specify the columns you need)
      .where({ status: true, user_id: user.id }) // Filter by status and user_id
      .andWhere('expired_at', '>=', knex.fn.now())
      .first();

    if (exists) {
      res.status(403).json({
        success: true,
        message: `You have perform forget password within previous 24 hours. Please check your email for following actions.`,
      });
      return;
    }

    const host = `${req.protocol}://${req.get('host')}`;
    const unique_id = crypto.randomBytes(40).toString("hex");

    const expirationTime = new Date();
    expirationTime.setDate(expirationTime.getDate() + 1);


    await knex('user_password_reset').insert({
      unique_id: unique_id,
      status: 1,
      expired_at: expirationTime,
      user_id: user.id,
      created_at: knex.fn.now(),
      updated_at: knex.fn.now(),

    });

    // Prepare the data object
    const data = {
      unique_id: unique_id,
      email: email,
      name: user.name
    };
    const content = jwt.sign(data, process.env.JWT_SECRET, { expiresIn: '24h' });

    // Construct the URL dynamically
    const url = `${host}/api/auth/perform-forget-password?by=${encodeURIComponent(content)}`;

    await sendForgetPasswordRequestEmail(
      email,
      user.name,
      url
    );

    res.status(200).json({
      success: true,
      message: `Please check your email to perform forget password action.`,
    });

  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: messages });
    } else {
      res.status(200).json({ success: false, message: error.message, error: error });

    }
  }
};


const changePassword = async (req, res) => {
  try {
    const validatedData = changePasswordSchema.parse(req.body)
    const { oldPassword, newPassword } = validatedData;

    const user = req.user;

    if (!user || !(await bcrypt.compare(oldPassword, user.password))) {
      return res.status(401).json({ success: false, message: "Your old password is inccorrect" });
    }

    const hashedPassword = await bcrypt.hash(newPassword, 10);
    await updatePassword(user.email, hashedPassword);

    res.status(200).json({ success: true, message: "Your password was successfully updated" });
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: messages });
    } else {
      res.status(500).json({ success: false, message: error.message });
    }
  }
};


module.exports = { register, login, verifyCode, resendVerificationCode, forgetPassword, changePassword, validateSession, sendForgetPasswordRequestEmail, performForgetPassword };

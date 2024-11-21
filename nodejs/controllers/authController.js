const bcrypt = require("bcryptjs");
const nodemailer = require("nodemailer");
const jwt = require("jsonwebtoken");
const crypto = require('crypto');



require("dotenv").config();

const knexConfig = require('../knexfile');
//initialize knex
const knex = require('knex')(knexConfig['docker'])

const { registerSchema, loginSchema, forgetPasswordSchema, changePasswordSchema } = require("../validators/authValidator");
const {
  getUserByEmail,
  createUser,
  updateUserStatus,
  updateVerificationCode,
  updatePassword
} = require("../models/userModel");
const { v4: uuidv4 } = require("uuid");

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

  try {
    await transporter.sendMail(mailOptions);
  } catch (error) {
    res
      .status(500)
      .json({ success: false, message: "Something wrong, Please try again later" });
  }
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

  try {
    await transporter.sendMail(mailOptions);
  } catch (error) {
    // console.error("Error sending reset password email:", error);
    // throw new Error("Something went wrong while sending the reset email. Please try again later.");
    res
      .status(500)
      .json({ success: false, message: "Error sending reset password email:", error });
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
    const applicationId = req.headers['application-id'];

    if (!applicationId) {
      res.status(503).json({
        success: false,
        message: 'Service Not Available'
      });
    }

    const app = await knex('application')
      .select('*')
      .where({name:applicationId})
      .first();
    
    if(!app){
      res.status(503).json({
        success: false,
        message: 'Service Not Available'
      });
    }
      

    const user = await getUserByEmail(email);
    // console.log(user);
    if (!user || !(await bcrypt.compare(password, user.password))) {
      return res.status(401).json({ success: false, message: "Invalid credentials" });
    }
    if (user.email_status === "NOT VERIFY") {
      return res.status(401).json({ success: false, message: "Your Account is Not Active." });
    }
    if (user.status === "ACTIVE") {
      const token = jwt.sign(
        { id: user.id, role: user.role, email: user.email },
        process.env.JWT_SECRET,
        { expiresIn: "1000s" }
      );

      const existingTokenRecord = await knex("user_token").where({ user_id: user.id }).first();


      const ipAddress = req.ip; // Get user's IP address

      const rememberToken = crypto.randomBytes(30).toString("hex"); // Generate 40-char random token

      // Generate bcrypt hash of user_id
      const userIdHash = await bcrypt.hash(user.id.toString(), 10);

      if (!existingTokenRecord) {
        // If user_id does not exist, create a new record
        await knex("user_token").insert({
          user_id: user.id,
          remember_token: rememberToken,
          app_id:app.id,
          device_token: device_token,
          token: userIdHash.slice(0, 20), // Use only the first 20 chars of the hash
          ip_address: ipAddress,
          created_at: knex.fn.now(),
          
        });
      } else {
        // If user_id exists, update the record
        await knex("user_token")
          .where({ user_id: user.id })
          .update({
            remember_token: rememberToken,
            device_token: deviceToken,
            ip_address: ipAddress,
        
          });
      }

      res.status(200).json({ success: true, token });
    }
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      res.status(400).json({ success: false, message: messages });
    } else {
      res.status(400).json({ success: false, message: error.message });
    }
  }
};

const generateRandomPassword = () => {
  return Math.random().toString(36).slice(-8);
};

const forgetPassword = async (req, res) => {
  try {

    const validatedData = forgetPasswordSchema.parse(req.body);
    const { email } = validatedData;

    const user = await getUserByEmail(email);

    if (!user) {
      return res.status(404).json({ success: false, message: "User not found" });
    }

    const newPassword = generateRandomPassword();
    const hashedPassword = await bcrypt.hash(newPassword, 10);

    const result = await updatePassword(email, hashedPassword);

    if (result) {
      await sendResetPasswordEmail(
        email,
        user.name,
        newPassword
      );

      res.status(200).json({
        success: true,
        message: `A new password has been sent to your email: ${email}`,
      });
    }
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      res.status(400).json({ success: false, message: messages });
    } else {
      res.status(500).json({ success: false, message: error.message });
    }
  }
};


const changePassword = async (req, res) => {
  try {
    const validatedData = changePasswordSchema.parse(req.body)
    const { oldPassword, newPassword } = validatedData;
    const { email } = req.user
    const user = await getUserByEmail(email);

    if (!user || !(await bcrypt.compare(oldPassword, user.password))) {
      return res.status(401).json({ success: false, message: "Old Password is inccorrect" });
    }

    const hashedPassword = await bcrypt.hash(newPassword, 10);
    await updatePassword(email, hashedPassword);

    res.status(200).json({ success: true, message: "Password successfully updated" });
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      res.status(400).json({ success: false, message: messages });
    } else {
      res.status(500).json({ success: false, message: error.message });
    }
  }
};


module.exports = { register, login, verifyCode, resendVerificationCode, forgetPassword, changePassword };

const bcrypt = require("bcrypt");
const nodemailer = require("nodemailer");
const jwt = require("jsonwebtoken");
const crypto = require("crypto");

require("dotenv").config();

const knexConfig = require("../knexfile");
const knex = require("knex")(knexConfig[process.env.NODE_ENV]);

const {
  registerSchema,
  loginSchema,
  forgetPasswordSchema,
  changePasswordSchema,
  validateSessionSchema,
  profileSchema,
  userPrivacySchema,
} = require("../validators/authValidator");
const {
  getUserByEmail,
  createUser,
  updateUserStatus,
  updateVerificationCode,
  updatePassword,
  getStaticToken,
  updateUseProfile,
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
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[xBug] - Account Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Gaya dasar untuk email */
        body {
            Margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        table {
            border-collapse: collapse;
        }

        /* Gaya untuk email container */
        .email-container {
            max-width: 600px;
            Margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        /* Gaya untuk header */
        .email-header {
            background-color: #4f46e5; /* Biru tua */
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .email-header img {
            width: 100px;
            margin-bottom: 15px;
        }

        .email-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .email-header p {
            font-size: 14px;
            margin-top: 0;
        }

        /* Gaya untuk body */
        .email-body {
            padding: 30px 25px;
            font-family: 'Poppins', sans-serif;
            color: #333333;
        }

        .email-body h2 {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
            color: #4f46e5; /* Biru tua */
        }

        .email-body p {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        /* Gaya untuk verification code */
        .verification-code {
            text-align: center;
            background-color: #e0e7ff;
            padding: 15px;
            border-left: 4px solid #4f46e5; /* Biru tua */
            border-radius: 8px;
            margin: 20px 0;
        }

        .verification-code span {
            font-size: 20px;
            font-weight: 700;
            color: #4f46e5; /* Biru tua */
        }

        /* Gaya untuk tombol CTA */
        .cta-button {
            display: inline-block;
            width: 100%;
            text-align: center;
            padding: 14px 0;
            background-color: #4f46e5; /* Biru tua */
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cta-button:hover {
            background-color: #4338ca; /* Biru lebih gelap */
            transform: translateY(-2px);
        }

        /* Gaya untuk footer */
        .email-footer {
            padding: 20px 25px;
            text-align: center;
            font-size: 14px;
            color: #888888;
            background-color: #f9f9f9;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            border-top: 1px solid #e5e7eb;
            font-family: 'Poppins', sans-serif;
        }

        .email-footer a {
            color: #4f46e5; /* Biru tua */
            text-decoration: none;
            font-weight: 500;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        /* Responsivitas */
        @media (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: 10px !important;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body h2 {
                font-size: 18px;
            }

            .email-body p,
            .verification-code span,
            .email-footer p {
                font-size: 14px;
            }

            .cta-button {
                font-size: 15px;
                padding: 12px 0;
            }
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="email-container" width="600" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Header -->
                    <tr>
                        <td class="email-header">
                            <img src="https://xbug.online/assets/images/logo.png" alt="xBug Logo">
                            <h1>[xBug] - Account Verification</h1>
                            <p>Verify Your Account</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="email-body">
                            <p>Hey <strong>${userName}</strong>,</p>
                            <p>Welcome to <strong>xBug.online</strong>! We’re excited to have you on board. To complete your account setup, please use the verification code below:</p>

                            <div class="verification-code">
                                <span>${verificationCode}</span>
                            </div>

                            <p>Please enter this code in the verification section to activate your account. If you didn’t sign up for <strong>xBug.online</strong>, you can ignore this email.</p>

                            <p>Thank you for choosing <strong>xBug.online</strong>!</p>
                            <p>Best Regards,<br>Admin xBug</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer">
                            <p>If you have any questions or need assistance, feel free to contact us at <a href="mailto:help-center@xbug.online">help-center@xbug.online</a>.</p>
                            <p>&copy; 2025 xBug. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
    `,
  };
  const info = await transporter.sendMail(mailOptions);
  await knex("email_logs").insert({
    email_type: "REGISTER USER MOBILE",
    recipient_email: userEmail,
    from_email: process.env.SMTP_USER,
    name: userName.toUpperCase(),
    status: "SUCCESS",
    response_data: "VERIFICATION CODE SEND",
    created_at: new Date(),
    updated_at: new Date(),
  });
  // await transporter.sendMail(mailOptions);
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[xBug] - Password Reset</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Gaya dasar untuk email */
        body {
            Margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        table {
            border-collapse: collapse;
        }

        /* Gaya untuk email container */
        .email-container {
            max-width: 600px;
            Margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        /* Gaya untuk header */
        .email-header {
            background-color: #4f46e5; /* Biru tua */
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .email-header img {
            width: 100px;
            margin-bottom: 15px;
        }

        .email-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            font-family: 'Poppins', sans-serif;
        }

        .email-header p {
            font-size: 14px;
            margin-top: 0;
            font-family: 'Poppins', sans-serif;
        }

        /* Gaya untuk body */
        .email-body {
            padding: 30px 25px;
            font-family: 'Poppins', sans-serif;
            color: #333333;
        }

        .email-body h3 {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
            color: #4f46e5; /* Biru tua */
        }

        .email-body p {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.6;
            font-family: 'Poppins', sans-serif;
        }

        /* Gaya untuk new password section */
        .new-password {
            text-align: center;
            background-color: #e0e7ff;
            padding: 15px;
            border-left: 4px solid #4f46e5; /* Biru tua */
            border-radius: 8px;
            margin: 20px 0;
            font-family: 'Poppins', sans-serif;
        }

        .new-password span {
            font-size: 20px;
            font-weight: 700;
            color: #4f46e5; /* Biru tua */
        }

        /* Gaya untuk tombol CTA */
        .cta-button {
            display: inline-block;
            width: 100%;
            text-align: center;
            padding: 14px 0;
            background-color: #4f46e5; /* Biru tua */
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .cta-button:hover {
            background-color: #4338ca; /* Biru lebih gelap */
            transform: translateY(-2px);
        }

        /* Gaya untuk footer */
        .email-footer {
            padding: 20px 25px;
            text-align: center;
            font-size: 14px;
            color: #888888;
            background-color: #f9f9f9;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            border-top: 1px solid #e5e7eb;
            font-family: 'Poppins', sans-serif;
        }

        .email-footer a {
            color: #4f46e5; /* Biru tua */
            text-decoration: none;
            font-weight: 500;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        /* Responsivitas */
        @media (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: 10px !important;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body h3 {
                font-size: 18px;
            }

            .email-body p,
            .new-password span,
            .email-footer p {
                font-size: 14px;
            }

            .cta-button {
                font-size: 15px;
                padding: 12px 0;
            }
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="email-container" width="600" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Header -->
                    <tr>
                        <td class="email-header">
                            <img src="https://xbug.online/assets/images/logo.png" alt="xBug Logo">
                            <h1>[xBug] - Password Reset</h1>
                            <p>Reset Your Password</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="email-body">
                            <p>Hi <strong>${userName}</strong>,</p>
                            <p>We’ve reset your password as requested. Below is your new password:</p>

                            <div class="new-password">
                                <span>${newPassword}</span>
                            </div>

                            <p>We recommend that you change this password after logging in for security purposes. If you did not request a password reset, please contact support immediately.</p>

                            <p>Thank you for choosing <strong>xBug.online</strong>!</p>
                            <p>Best Regards,<br>Admin xBug</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer">
                            <p>If you have any questions or need assistance, feel free to contact us at <a href="mailto:help-center@xbug.online">help-center@xbug.online</a>.</p>
                            <p>&copy; 2025 xBug. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

    `,
  };

  const info = await transporter.sendMail(mailOptions);
  await knex("email_logs").insert({
    email_type: "RESET PASSWORD CODE EMAIL MOBILE",
    recipient_email: userEmail,
    from_email: process.env.SMTP_USER,
    name: userName.toUpperCase(),
    status: "SUCCESS",
    response_data: "RESEND RESET PASSWORD SEND",
    created_at: new Date(),
    updated_at: new Date(),
  });
  // await transporter.sendMail(mailOptions);
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[xBug] - Password Reset</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Gaya dasar untuk email */
        body {
            Margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        table {
            border-collapse: collapse;
        }

        /* Gaya untuk email container */
        .email-container {
            max-width: 600px;
            Margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        /* Gaya untuk header */
        .email-header {
            background-color: #007bff; /* Biru tua */
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .email-header img {
            width: 100px;
            margin-bottom: 15px;
        }

        .email-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            font-family: 'Poppins', sans-serif;
        }

        .email-header p {
            font-size: 14px;
            margin-top: 0;
            font-family: 'Poppins', sans-serif;
        }

        /* Gaya untuk body */
        .email-body {
            padding: 30px 25px;
            font-family: 'Poppins', sans-serif;
            color: #333333;
        }

        .email-body h3 {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
            color: #007bff; /* Biru tua */
        }

        .email-body p {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.6;
            font-family: 'Poppins', sans-serif;
        }

        /* Gaya untuk reset password section */
        .reset-password {
            text-align: center;
            background-color: #e0e7ff;
            padding: 15px;
            border-left: 4px solid #007bff; /* Biru tua */
            border-radius: 8px;
            margin: 20px 0;
            font-family: 'Poppins', sans-serif;
        }

        .reset-password span {
            font-size: 20px;
            font-weight: 700;
            color: #007bff; /* Biru tua */
        }

        /* Gaya untuk tombol CTA */
        .cta-button {
            display: inline-block;
            width: 100%;
            text-align: center;
            padding: 14px 0;
            background-color: #007bff; /* Biru tua */
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .cta-button:hover {
            background-color: #0056b3; /* Biru lebih gelap */
            transform: translateY(-2px);
        }

        /* Gaya untuk footer */
        .email-footer {
            padding: 20px 25px;
            text-align: center;
            font-size: 14px;
            color: #888888;
            background-color: #f9f9f9;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            border-top: 1px solid #e5e7eb;
            font-family: 'Poppins', sans-serif;
        }

        .email-footer a {
            color: #007bff; /* Biru tua */
            text-decoration: none;
            font-weight: 500;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        /* Responsivitas */
        @media (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: 10px !important;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body h3 {
                font-size: 18px;
            }

            .email-body p,
            .reset-password span,
            .email-footer p {
                font-size: 14px;
            }

            .cta-button {
                font-size: 15px;
                padding: 12px 0;
            }
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="email-container" width="600" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Header -->
                    <tr>
                        <td class="email-header">
                            <img src="https://xbug.online/assets/images/logo.png" alt="xBug Logo">
                            <h1>[xBug] - Password Reset</h1>
                            <p>Reset Your Password</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="email-body">
                            <p>Hi <strong>${userName}</strong>,</p>
                            <p>We’ve received your forget password request. Please click the button below to validate the action:</p>

                            <!-- Call to Action Button -->
                            <a href="${link}" class="cta-button">Reset Password</a>

                            <!-- Clickable link text for copying -->
                            <p>If you are unable to click the button, copy and paste the link below into your browser:</p>
                            <p>
                                <a href="${link}" style="color: #007bff; text-decoration: none;">${link}</a>
                            </p>

                            <p>If you did not request a password reset, please contact support immediately.</p>
                            <p>Thank you for choosing <strong>xBug.online</strong>!</p>
                            <p>Best Regards,<br>Admin xBug</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer">
                            <p>If you have any questions or need assistance, feel free to contact us at <a href="mailto:help-center@xbug.online">help-center@xbug.online</a>.</p>
                            <p>&copy; 2025 xBug. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

    `,
  };

  try {
    const info = await transporter.sendMail(mailOptions);
    await knex("email_logs").insert({
      email_type: "REQUEST RESET PASSWORD CODE EMAIL MOBILE",
      recipient_email: userEmail,
      from_email: process.env.SMTP_USER,
      name: userName.toUpperCase(),
      status: "SUCCESS",
      response_data: "REQUEST RESEND RESET PASSWORD SEND",
      created_at: new Date(),
      updated_at: new Date(),
    });
    // await transporter.sendMail(mailOptions);
    console.log(`Reset password email sent to ${userEmail}`);
    return {
      success: true,
      message: "Reset password email sent successfully.",
    };
  } catch (error) {
    console.error("Error sending reset password email:", error);
    throw new Error(
      "Something went wrong while sending the reset email. Please try again later."
    );
  }
};

const register = async (req, res) => {
  try {
    const validatedData = registerSchema.parse(req.body);
    const { email, password, name, state, address, telno } = validatedData;

    const existingUser = await getUserByEmail(email);
    if (existingUser)
      return res.status(403).json({
        message: "Email already in use. Please complete previous registration!",
      });

    const uuid = uuidv4();
    const hashedPassword = await bcrypt.hash(password, 10);
    const verificationCode = Math.floor(100000 + Math.random() * 900000);
    const role = [5];
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
      await knex("user_privacy").insert({
        user_id: result.id,
      });
      await sendVerificationEmail(email, name, verificationCode);
      const responseData = {
        name: validatedData.name,
        telno: validatedData.telno,
        email: validatedData.email,
      };
      res.status(201).json({
        success: true,
        message: "User registered successfully",
        data: responseData,
      });
    }
  } catch (error) {
    console.log(error);
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: message });
    } else {
      res.status(500).json({ success: false, message: error.message });
    }
  }
};

const getProfile = async (req, res) => {
  try {
    var user = req.user;

    const user_privacy = await knex("user_privacy")
      .where("user_id", user.id)
      .select("detail")
      .first();

    return res.status(200).json({
      telno: user.telno,
      address: user.address,
      name: user.name,
      state: user.state,
      email: user.email,
      user_privacy: user_privacy,
    });
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: message });
    } else {
      res.status(500).json({ success: false, message: error.message });
    }
  }
};

const updateProfile = async (req, res) => {
  try {
    const validatedData = profileSchema.parse(req.body);
    const { name, state, address, telno } = validatedData;

    const user = req.user;

    const result = await updateUseProfile({
      name,
      state,
      address,
      telno,
      id: user.id,
    });

    if (result) {
      res
        .status(200)
        .json({ success: true, message: "Profile update successfully" });
    }
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: message });
    } else {
      res.status(500).json({ success: false, message: error.message });
    }
  }
};

const updateUserPrivacy = async (req, res) => {
  try {
    const validatedData = userPrivacySchema.parse(req.body);
    const { user_privacy } = validatedData;

    const user = req.user;

    const result = await knex("user_privacy").where("user_id", user.id).update({
      detail: user_privacy,
    });

    res
      .status(200)
      .json({ success: true, message: "User privacy update successfully" });
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: message });
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
      return res
        .status(404)
        .json({ success: false, message: "User not found" });
    }

    if (user.email_status === "VERIFY") {
      return res
        .status(401)
        .json({ success: false, message: "Your Account is Active" });
    }

    if (user.verification_code !== code) {
      return res
        .status(400)
        .json({ success: false, message: "Invalid verification code" });
    }

    await updateUserStatus(email);

    res
      .status(200)
      .json({ success: true, message: "Account has successfully activated" });
  } catch (error) {
    res
      .status(500)
      .json({ success: false, message: "Internal server error", error });
  }
};

const resendVerificationCode = async (req, res) => {
  const { email } = req.params;

  try {
    const user = await getUserByEmail(email);

    if (!user) {
      return res
        .status(404)
        .json({ success: false, message: "User not found" });
    }

    if (user.email_status === "VERIFY") {
      return res
        .status(401)
        .json({ success: false, message: "Your Account is Already Active" });
    }

    const newVerificationCode = Math.floor(100000 + Math.random() * 900000);

    const result = await updateVerificationCode(email, newVerificationCode);
    if (result) {
      await sendVerificationEmail(email, user.name, newVerificationCode);
      res.status(200).json({
        success: true,
        message: `Verification code resent successfully to email ${email}`,
      });
    }
  } catch (error) {
    res
      .status(500)
      .json({ success: false, message: "Internal server error", error });
  }
};

const getStates = async (req, res) => {
  try {
    const states = await knex("states");
    return res.status(200).json(states);
  } catch (error) {
    return res.status(500).json(error);
  }
};
const login = async (req, res) => {
  try {
    const validatedData = loginSchema.parse(req.body);
    const { email, password, device_token } = validatedData;

    const user = await getUserByEmail(email);
    // console.log(user);
    if (
      !user ||
      !(await bcrypt.compare(password, user.password.replace("$2y$", "$2b$")))
    ) {
      return res
        .status(401)
        .json({ success: false, message: "Invalid credentials" });
    } else if (user.email_status === "NOT VERIFY") {
      return res
        .status(401)
        .json({ success: false, message: "Your Account is Not Active." });
    } else if (!user.active) {
      console.log(user.active);
      return res
        .status(401)
        .json({ success: false, message: "Your Account is Suspended." });
    } else if (user.status != "ACTIVE") {
      return res
        .status(401)
        .json({ success: false, message: "Your Account is Suspended." });
    }

    console.log(req.applicationId);

    const token = getStaticToken(user.id, user.created_at);

    const existingTokenRecord = await knex("user_token")
      .where({ user_id: user.id })
      .first();

    const ipAddress =
      req.headers["x-forwarded-for"] || req.connection.remoteAddress; // Get user's IP address

    const rememberToken = crypto.randomBytes(30).toString("hex"); // Generate 40-char random token
    console.log(req.applicationId);

    // Generate bcrypt hash of user_id

    if (!existingTokenRecord) {
      // If user_id does not exist, create a new record
      await knex("user_token").insert({
        user_id: user.id,
        remember_token: rememberToken,
        app_id: req.applicationId.id,
        device_token: device_token,
        token: token, // Use only the first 20 chars of the hash
        ip_address: ipAddress,
        created_at: knex.fn.now(),
      });
    } else {
      // If user_id exists, update the record
      await knex("user_token").where({ user_id: user.id }).update({
        remember_token: rememberToken,
        device_token: device_token,
        ip_address: ipAddress,
        token: token,
        updated_at: knex.fn.now(),
      });
    }
    console.log(req.applicationId);

    return res
      .status(200)
      .json({ success: true, token, rememberToken, email: user.email });
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: message });
    } else {
      res.status(400).json({ success: false, message: error.message });
    }
  }
};

const validateSession = async (req, res) => {
  try {
    const validatedData = validateSessionSchema.parse(req.body);
    const { email, rememberToken } = validatedData;

    const existingTokenRecord = await knex("user_token as ut")
      .join("users as u", "ut.user_id", "u.id") // Use aliases for table names
      .where({ "ut.remember_token": rememberToken, "u.email": email }) // Use the alias in the condition

      .select("ut.*") // Select all fields from both tables using aliases
      .first(); // Get the first matching record

    const ipAddress =
      req.header("x-forwarded-for") || req.connection.remoteAddress; // Get user's IP address
    console.log(req.header("x-forwarded-for"), req.connection.remoteAddress);
    const newRememberToken = crypto.randomBytes(30).toString("hex"); // Generate 40-char random token

    // Generate bcrypt hash of user_id

    await knex("user_token").where({ id: existingTokenRecord.id }).update({
      remember_token: newRememberToken,
      updated_at: knex.fn.now(),
      ip_address: ipAddress,
    });

    res.status(200).json({ success: true, rememberToken: newRememberToken });
  } catch (error) {
    res.status(400).json({
      success: false,
      message: "Your session is expired. Please login again.",
      error: error,
    });
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

    const password_reset = await knex("user_password_reset")
      .select("*") // Select all columns (or specify the columns you need)
      .where({ status: 1, user_id: user.id, unique_id: data.unique_id }) // Filter by status and user_id
      .andWhere("expired_at", ">=", knex.fn.now())
      .first();

    if (!password_reset) {
      console.log(user.id, data.unique_id);
      return res.status(404).json(`You have not Active Password Request now.`);
    }

    const newPassword = generateRandomPassword();
    const hashedPassword = await bcrypt.hash(newPassword, 10);

    const result = await updatePassword(data.email, hashedPassword);

    if (result) {
      await sendResetPasswordEmail(data.email, user.name, newPassword);

      await knex("user_password_reset")
        .where({ status: true, user_id: user.id })
        .update({
          status: 0,
          updated_at: knex.fn.now(),
        });
      return res.send(
        `A new password has been sent to your email: ${data.email}`
      );
    }
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: message });
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
      return res
        .status(404)
        .json({ success: false, message: "Email not found" });
    }

    const exists = await knex("user_password_reset")
      .select("*") // Select all columns (or specify the columns you need)
      .where({ status: true, user_id: user.id }) // Filter by status and user_id
      .andWhere("expired_at", ">=", knex.fn.now())
      .first();

    if (exists) {
      res.status(403).json({
        success: true,
        message: `You have perform forget password within previous 24 hours. Please check your email for following actions.`,
      });
      return;
    }

    const host = `${req.protocol}://${req.get("host")}`;

    const unique_id = crypto.randomBytes(40).toString("hex");

    const expirationTime = new Date();
    expirationTime.setDate(expirationTime.getDate() + 1);

    await knex("user_password_reset").insert({
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
      name: user.name,
    };
    const content = jwt.sign(data, process.env.JWT_SECRET, {
      expiresIn: "24h",
    });

    // Construct the URL dynamically
    const url = `${host}/api/auth/perform-forget-password?by=${encodeURIComponent(
      content
    )}`;

    await sendForgetPasswordRequestEmail(email, user.name, url);

    res.status(200).json({
      success: true,
      message: `Please check your email to perform forget password action.`,
    });
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: message });
    } else {
      res
        .status(200)
        .json({ success: false, message: error.message, error: error });
    }
  }
};


const getLeafStatus = async (req, res) => {
  try {
    const user = req.user;


    // Check if user_leaf exists, create if not
    let user_leaf = await knex('user_leaf')
      .where('user_id', user.id)
      .where('status', 1)
      .first();


  
    if (user_leaf == null) {
      return res.status(403).json({ 'message': "No data" });

    }

    var leaffdata = await getLeafData(user_leaf.id);

    return res.status(200).json({ 'message': "Success", 'data': leaffdata })
  } catch (e) {
    return res.status(500).json({ 'message': e })
  }



}

const getLeafData = async (user_leaf_id) => {
  const today = new Date().toISOString().split('T')[0]; // Format today as YYYY-MM-DD

  // Fetch user_leaf record
  const user_leaf = await knex('user_leaf')
    .where('status', 1)
    .where('id', user_leaf_id)
    .first();

  if (!user_leaf) {
    var no_enter = -1
    var percent2 = -1
    return { no_enter, percent2 };
  }

  // Fetch today's leaf detail
  const leaf_detail_today = await knex('leaf_detail')
    .where('status', 1)
    .where('user_leaf_id', user_leaf_id)
    .whereRaw('DATE(created_at) = ?', [today])
    .first();

  // Calculate percentage
  const moreLeafCount = await knex('user_leaf')
    .where('status', 1)
    .where('total_leaf', '>', user_leaf.total_leaf)
    .count('* as count')
    .then(result => (result[0] ? result[0].count : 0));

  const userCount = await knex('users')
    .count('* as count')
    .then(result => (result[0] ? result[0].count : 0));

    
    const percent = parseFloat(
      Math.min(
        Math.max(((userCount - moreLeafCount) / userCount) * 100, 0.01),
        99.99
      ).toFixed(2)
    );
 
  console.log(moreLeafCount, userCount, percent)

  if (!leaf_detail_today) {
    var no_enter = -1
    return { no_enter, percent };
  }

  // Calculate rank
  const rank = await knex('leaf_detail')
    .whereRaw('DATE(created_at) = ?', [today])
    .where('created_at', '<', leaf_detail_today.created_at)
    .count('* as count')
    .then(result => (result[0] ? result[0].count +1 : 1));


  return { rank, percent };
};

const addNewLeaf = async (req, res) => {
  try {
    const { detail } = req.body;
    const user = req.user;
    const today = new Date().toISOString().split('T')[0]; // Format today as YYYY-MM-DD

    // Check if user_leaf exists, create if not
    let user_leaf = await knex('user_leaf')
      .where('user_id', user.id)
      .where('status', 1)
      .first();

    if (!user_leaf) {
      await knex('user_leaf').insert({ user_id: user.id });
      user_leaf = await knex('user_leaf')
        .where('user_id', user.id)
        .where('status', 1)
        .first();
    }

    // Check if a leaf detail already exists for today
    const leafDetailExists = await knex('leaf_detail')
      .where('user_leaf_id', user_leaf.id)
      .whereRaw('DATE(created_at) = ?', [today])
      .first();

    if (!leafDetailExists) {
      // Insert new leaf detail
      await knex('leaf_detail').insert({
        user_leaf_id: user_leaf.id,
        detail: JSON.stringify(detail),
      });

      // Update total_leaf count
      const count = await knex('leaf_detail')
        .where('user_leaf_id', user_leaf.id)
        .where('status', 1)
        .count('* as count')
        .then((res) => parseInt(res[0].count ?? 0));

      await knex('user_leaf')
        .where('id', user_leaf.id)
        .update({ total_leaf: count });

      const leafdata = await getLeafData(user_leaf.id);
      console.log(leafdata);
      return res.status(201).json({ success: true, data: leafdata });
    }else{
      const leafdata = await getLeafData(user_leaf.id);
      return res.status(200).json({ success: true, data: leafdata });
    }

    
  } catch (error) {
    console.error(error);
    return res.status(500).json({
      success: false,
      message: error.message,
      error,
    });
  }
};

const changePassword = async (req, res) => {
  try {
    const validatedData = changePasswordSchema.parse(req.body);
    const { oldPassword, newPassword } = validatedData;

    const user = req.user;

    if (!user || !(await bcrypt.compare(oldPassword, user.password))) {
      return res
        .status(401)
        .json({ success: false, message: "Your old password is inccorrect" });
    }

    const hashedPassword = await bcrypt.hash(newPassword, 10);

    await updatePassword(user.email, hashedPassword);
    res.status(200).json({
      success: true,
      message: "Your password was successfully updated",
    });
  } catch (error) {
    if (error.errors) {
      const messages = error.errors.map((err) => err.message);
      const message = messages.join(", ");
      res.status(400).json({ success: false, message: message });
    } else {
      res.status(500).json({ success: false, message: error.message });
    }
  }
};

module.exports = {
  register,
  login,
  verifyCode,
  resendVerificationCode,
  forgetPassword,
  changePassword,
  validateSession,
  sendForgetPasswordRequestEmail,
  performForgetPassword,
  getStates,
  updateProfile,
  getProfile,
  updateUserPrivacy,
  addNewLeaf,
  getLeafStatus
};

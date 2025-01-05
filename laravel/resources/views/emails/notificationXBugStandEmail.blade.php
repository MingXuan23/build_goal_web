<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[xBUG Stand] - Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .email-header {
            text-align: center;
            padding: 30px;
            background-color: rgba(0, 128, 0, 0.1);
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            color: #0e0e0e;
            font-weight: bold;
        }

        .email-body {
            padding: 20px;
        }

        .email-body p {
            margin: 0 0 15px;
            line-height: 1.6;
            color: #333333;
        }

        .email-body a {
            color: rgb(90, 90, 209);
            text-decoration: none;
        }

        .email-footer {
            text-align: center;
            padding: 10px;
            background-color: #f5f5f5;
            font-size: 14px;
            color: #888888;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://xbug.online/assets/images/logo.png" alt="LOGO" width="80">
            <h1>[xBUG Stand] - Content Update Notification</h1>
        </div>
        <div class="email-body">
            <p>Dear <strong>{{ strtoupper($name) }}</strong>,</p>
            <p>We are excited to inform you that your content titled <span
                    style="font-weight: bold">{{ strtoupper($content_name) }}</span> has been successfully <strong
                    style="color: rgb(87, 205, 120); font-weight: bold;">UPDATED</strong> on the <strong>xBug
                    Stand</strong> platform.</p>
            <p>You can now check the updated details by logging in to your account at <a
                    href="https://xbug.online/login">xBug Stand</a>.</p>
            <p>If you have any further questions or need assistance, please do not hesitate to contact our support team
                at <a href="mailto:help-center@xbug.online">help-center@xbug.online</a>.</p>
            <p>Best regards,</p>
            <p><strong>[xBUG Stand Team]</strong></p>
        </div>
        <div class="email-footer">
            <p>This is an automated message. Please do not reply.</p>
        </div>
    </div>
</body>

</html>

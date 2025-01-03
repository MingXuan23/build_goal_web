
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset dan Global Styles */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Card Container */
        .notification-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            max-width: 500px;
            width: 100%;
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        .header {
            background-color: #ffffff;
            padding: 30px 20px 10px 20px;
            text-align: center;
            position: relative;
        }

        .header img {
            width: 80px;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #333333;
        }

        /* Body */
        .body {
            padding: 25px 20px;
        }

        .body p {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Verification Code */
        .verification-code {
            text-align: center;
            background-color: #e0e7ff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .verification-code span {
            font-size: 20px;
            font-weight: 700;
            color: #4f46e5;
        }

        /* Call to Action Button */
        .cta-button {
            display: block;
            width: 100%;
            text-align: center;
            padding: 14px 0;
            background-color: #4f46e5;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cta-button:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            background-color: #f0f2f5;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }

        .footer a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsivitas */
        @media (max-width: 500px) {
            .header h2 {
                font-size: 20px;
            }

            .body p {
                font-size: 15px;
            }

            .cta-button {
                font-size: 15px;
                padding: 12px 0;
            }

            .verification-code span {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

    <div class="notification-card">
        <!-- Header -->
        <div class="header">
            <img src="https://xbug.online/assets/images/logo.png" alt="xBug Logo">
            <h2>Account Verification</h2>
        </div>

        <!-- Body -->
        <div class="body">
            <p>Hey <strong>{{ $name }}</strong>,</p>
            <p>Welcome to <strong>xBug.online</strong>! We’re excited to have you on board. To complete your account setup, please use the verification code below:</p>

            <div class="verification-code">
                <span>{{ $verificationCode }}</span>
            </div>

            <p>Please enter this code in the verification section to activate your account.</p>

            If you are having trouble activating your account, please contact us by email at <a href="mailto:help-center@xbug.online">help-center@xbug.online</a>.

            <p>Thank you for choosing <strong>xBug.online</strong>!</p>
            <p>Best Regards,<br>Admin xBug</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>If you did not request this account creation, please contact <a href="mailto:help-center@xbug.online">help-center@xbug.online</a>.</p>
            <p>&copy; 2025 xBug. All rights reserved.</p>
        </div>
    </div>

</body>
</html>

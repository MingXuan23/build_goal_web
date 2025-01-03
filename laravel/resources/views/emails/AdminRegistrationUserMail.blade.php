<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Account Notification</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            font-family: 'Inter', sans-serif;
            color: #333333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: rgb(255, 255, 255);
            padding: 25px;
            text-align: center;
            color: rgb(17, 28, 67);
        }

        .header img {
            width: 72px;
            height: 62px;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .content {
            padding: 30px;
        }

        .content p {
            line-height: 1.6;
            font-size: 16px;
        }

        .details {
            background-color: #f9fafb;
            padding: 20px;
            border-left: 4px solid rgb(17, 28, 67);
            border-radius: 6px;
            margin: 20px 0;
        }

        .details p {
            margin: 0px 0;
            font-size: 15px;
        }

        .button {
            display: block;
            /* Diubah dari inline-block ke block */
            padding: 14px 0;
            /* Mengurangi padding horizontal */
            background-color: rgb(17, 28, 67);
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
            transition: background-color 0.3s ease;
            width: 100%;
            /* Diubah dari 88% ke 100% */
            box-sizing: border-box;
            /* Memastikan padding termasuk dalam width */
        }

        .button:hover {
            background-color: rgb(17, 28, 67);
        }

        .footer {
            background-color: #f0f2f5;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #888888;
        }

        .footer a {
            color: #6e8efb;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
            }

            .header,
            .content,
            .footer {
                padding: 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content p,
            .details p {
                font-size: 14px;
            }

            .button {
                padding: 12px 0;
                /* Menyesuaikan padding untuk ukuran layar kecil */
                font-size: 14px;
                width: 100%;
                /* Pastikan tombol tetap penuh lebar di layar kecil */
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="https://xbug.online/assets/images/logo.png" alt="LOGO">
            <h1>Welcome to xBug</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hello <strong>[{{ $name_user }}]</strong>,</p>
            <p>Our admin has created an account for you. Here are your account details:</p>

            <div class="details">
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
                @if ($register_type == 'Admin' || $register_type == 'Organization')
                    <p><strong>Role:</strong> {{ $register_type }}</p>
                    <p><strong>Login Type:</strong> WEB [xbug.online]</p>
                @else
                    <p><strong>Role:</strong> {{ $register_type }}</p>
                    <p><strong>Login Type:</strong> xBug APP</p>
                @endif
            </div>

            <p>For the security of your account, it is recommended to change your password immediately after logging in.
            </p>

            <a href="[link_login]" class="button">Login to Account</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>If you did not request this account creation, please contact <a
                    href="mailto:help-center@xbug.online">help-center@xbug.online</a>.</p>
            <p>&copy; 2025 xBug. All rights reserved.</p>
        </div>
    </div>

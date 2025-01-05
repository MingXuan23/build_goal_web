<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[xBUG] - Verify Your Action</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Gaya dasar untuk email */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Gaya untuk email container */
        .email-container {
            max-width: 600px;
            margin: 0 auto; /* Centering the container */
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        /* Gaya untuk header */
        .email-header {
            background-color: #007bff;
            padding: 20px 20px;
            text-align: center;
            color: #ffffff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .email-header img {
            width: 100px;
            /* margin-bottom: 15px; */
        }

        .email-header h1 {
            font-size: 24px;
            font-weight: 700;
            /* margin-bottom: 5px; */
        }

        .email-header p {
            font-size: 14px;
            margin-top: 0;
        }

        /* Gaya untuk body */
        .email-body {
            padding: 30px 25px;
            color: #333333;
        }

        .email-body h3 {
            font-size: 20px;
            font-weight: 600;
            /* margin-bottom: 20px; */
            color: #007bff;
        }

        .email-body p {
            font-size: 16px;
            /* margin-bottom: 20px; */
            line-height: 1.6;
        }

        /* Gaya untuk tombol CTA */
        .cta-button {
            display: inline-block;
            width: 100%;
            text-align: center;
            padding: 14px 0;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cta-button:hover {
            background-color: #0056b3;
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
        }

        .email-footer a {
            color: #007bff;
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
                margin: 10px auto !important; /* Center and add space */
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body h3 {
                font-size: 18px;
            }

            .email-body p,
            .cta-button {
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
                <table class="email-container" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Header -->
                    <tr>
                        <td class="email-header">
                            <img src="https://xbug.online/assets/images/logo.png" alt="xBug Logo">
                            <h1>[xBUG] - Verify Your Action</h1>
                            <p>Please verify your action by clicking below</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="email-body">
                            <p>We need to verify your action. Please click the button below to confirm:</p>

                            <!-- Call to Action Button -->
                            <a href="{{ url('/verify-action?token=' . $token) }}" class="cta-button">Verify Now</a>

                            <!-- Clickable link text for copying -->
                            <p>If the button above doesn't work, copy and paste the following URL into your browser:</p>
                            <p>
                                <a href="{{ url('/verify-action?token=' . $token) }}" style="color: #007bff; text-decoration: none;">{{ url('/verify-action?token=' . $token) }}</a>
                            </p>

                            <p>Thank you for using <strong>xBug.online</strong>!</p>
                            <p>Best Regards,<br>Admin xBUG</p>
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

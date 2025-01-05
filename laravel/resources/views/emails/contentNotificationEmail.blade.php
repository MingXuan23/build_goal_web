<?php
// $status = 3; 
// $reason = "Your application did not meet the required criteria."; 
// $name = 'khai';
$headerColor = '';
if ($status == 1) {
    $headerColor = 'rgba(0, 0, 255, 0.2)';
} elseif ($status == 2) {
    $headerColor = 'rgba(0, 128, 0, 0.2)';
} elseif ($status == 3) {
    $headerColor = 'rgba(255, 0, 0, 0.2)'; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[xBUG] - Content Notification</title>
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
            background-color: #f5f5f5;
            color: #333333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Card Container */
        .email-container {
            max-width: 600px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e0e0e0;
            animation: fadeIn 0.6s ease-out;
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

        /* Header */
        .email-header {
            background-color: <?php echo $headerColor; ?>;
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
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

        /* Body */
        .email-body {
            padding: 30px 25px;
        }

        .email-body h2 {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
            color: 
            <?php 
                if ($status == 1) { 
                    echo '#008000'; // Hijau untuk Pending 
                } elseif ($status == 2) { 
                    echo '#0000FF'; // Biru untuk Approved 
                } else { 
                    echo '#FF0000'; // Merah untuk Rejected 
                } 
            ?>;
        }

        .email-body p {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        /* Transaction Details Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .info-table th,
        .info-table td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 16px;
        }

        .info-table th {
            background-color: #f8f8f8;
            font-weight: 600;
            color: #333333;
            width: 40%;
        }

        /* Footer */
        .email-footer {
            padding: 20px 25px;
            text-align: center;
            font-size: 14px;
            color: #888888;
            background-color: #f9f9f9;
            border-top: 1px solid #e5e7eb;
        }

        .email-footer a {
            color: <?php 
                if ($status == 1) { 
                    echo '#008000'; // Hijau 
                } elseif ($status == 2) { 
                    echo '#0000FF'; // Biru 
                } else { 
                    echo '#FF0000'; // Merah 
                } 
            ?>;
            text-decoration: none;
            font-weight: 500;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        /* Responsivitas */
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body h2 {
                font-size: 18px;
            }

            .email-body p,
            .info-table th,
            .info-table td {
                font-size: 14px;
            }

            .email-footer {
                font-size: 13px;
                padding: 15px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <img src="https://xbug.online/assets/images/logo.png" alt="xBug Logo">
            <h1>[xBUG] - Content Notification</h1>
            <p>Status: 
                <?php 
                    if ($status == 1) { 
                        echo '<span style="color: #f7f3f2; font-weight: bold;">PENDING</span>'; 
                    } elseif ($status == 2) { 
                        echo '<span style="color: #f7f3f2; font-weight: bold;">APPROVED</span>'; 
                    } else { 
                        echo '<span style="color: #f7f3f2; font-weight: bold;">REJECTED</span>'; 
                    } 
                ?>
            </p>
        </div>
        <!-- Body -->
        <div class="email-body">
            <p>Dear <?php echo strtoupper($name); ?>,</p>
            <?php if ($status == 1): ?>
                <p>Your Content - <span style="font-weight: bold;"><?php echo strtoupper($content_name); ?></span> is currently <strong>PENDING</strong>. We are reviewing your information, and the verification process is underway.</p>
                <p>Please be patient during this process. If you have any urgent concerns or questions, feel free to contact our support team at <a href="mailto:help-center@xbug.online">help-center@xbug.online</a>.</p>
            <?php elseif ($status == 2): ?>
                <p>Congratulations! Your Content - <span style="font-weight: bold;"><?php echo strtoupper($content_name); ?></span> has been <strong>APPROVED</strong>. Thank you for your patience during the review process. You can log in to <a href="https://xbug.online/login">xbug.online</a> for the next steps.</p>
            <?php elseif ($status == 3): ?>
                <p>We regret to inform you that your Content - <span style="font-weight: bold;"><?php echo strtoupper($content_name); ?></span> has been <strong>REJECTED</strong>.</p>
                <p style="font-weight: bold;"><span style="color: #FF0000;">REASON: </span><?php echo htmlspecialchars($reject_reason); ?></p>
                <p>You can log in to <a href="https://xbug.online/login">xbug.online</a> for more information. If you have any questions or need further clarification, feel free to reach out to our support team at <a href="mailto:help-center@xbug.online">help-center@xbug.online</a>.</p>
            <?php endif; ?>
            <p>Thank you for choosing <strong>xBug.online</strong>!</p>
            <p>Best Regards,<br>xBug Team</p>
        </div>
        <!-- Footer -->
        <div class="email-footer">
            <p>This is an automated message. Please do not reply.</p>
            <p>&copy; 2025 xBUG. All rights reserved.</p>
        </div>
    </div>
</body>

</html>

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
    <title>[xBug] - Content Notification</title>
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
        <div class="email-header" style="background-color: <?php echo $headerColor; ?>;">
            <h1>[xBug] - Content Notification</h1>
        </div>
        <div class="email-body">
            <p>Dear {{strToUpper($name)}},</p>
            <?php if ($status == 1): ?>
                <p>Your Content - <span style="font-weight: bold"><?php echo strToUpper($content_name); ?></span> is currently <strong style="color: rgb(90, 90, 209);font-weight: bold">PENDING</strong>. We are reviewing your information, and the verification process is underway.</p>
                <p>Please be patient during this process. If you have any urgent concerns or questions, feel free to contact our support team at [help-center@xbug.online].</p>
            <?php elseif ($status == 2): ?>
                <p>Congratulations! Your Content - <span style="font-weight: bold"><?php echo strToUpper($content_name); ?></span> has been <strong style="color: rgb(87, 205, 120);font-weight: bold">APPROVED</strong>. Thank you for your patience during the review process. You can login to <a href="https://xbug.online/login">xbug.online</a> for the next process.</p>
            <?php elseif ($status == 3): ?>
                <p>We regret to inform you that your Content - <span style="font-weight: bold"><?php echo strToUpper($content_name); ?></span> has been <strong style="color: rgb(226, 85, 85);font-weight: bold">REJECTED</strong>.</p>
                <p style="font-weight: bold"><span style="color: rgb(226, 85, 85);font-weight: bold">REASON: </span><?php echo $reject_reason; ?></p>
                <p>You can login to <a href="https://xbug.online/login">xbug.online</a> for information. If you have any questions or need further clarification, feel free to reach out to our support team at [help-center@xbug.online].</p>
            <?php endif; ?>
            <p>Best regards,</p>
            <p>[xBug Team]</p>
        </div>
        <div class="email-footer">
            <p>This is an automated message. Please do not reply.</p>
        </div>
    </div>
</body>

</html>

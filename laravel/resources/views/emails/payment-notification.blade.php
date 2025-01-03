<?php
$name = $name;
$type = $type;
$content = $content;
$amount = $amount;
$transaction_no = $transaction_no;
$created_at = $created_at;
$card_quantity = $card_quantity;

$headerColor = 'rgba(40, 167, 69, 0.9)'; // Hijau untuk menunjukkan keberhasilan
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[xBug] - Payment Receipt</title>
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
            background-color: #f4f4f9;
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
            border: 1px solid #e6e6e6;
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
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
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
            border-bottom: 1px solid #e6e6e6;
            font-size: 16px;
        }

        .info-table th {
            background-color: #f8f8f8;
            font-weight: 600;
            color: #333333;
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
            color: #28a745;
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
            <h1>Payment Successful</h1>
            <p>Your transaction has been completed successfully.</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Dear <?php echo strtoupper($name); ?>,</p>
            <p>Your payment has been <span style="color: #28a745; font-weight: bold;">successfully</span> processed. Below are the details of your transaction:</p>

            <!-- Transaction Details Table -->
            <table class="info-table">
                <tr>
                    <th>Transaction Type</th>
                    <td><?php echo htmlspecialchars($type); ?></td>
                </tr>
                <?php if (!empty($content)) { ?>
                    <tr>
                        <th>Content Name</th>
                        <td><?php echo htmlspecialchars($content); ?></td>
                    </tr>
                <?php } ?>
                <?php if (!empty($card_quantity)) { ?>
                    <tr>
                        <th>Quantity</th>
                        <td><?php echo htmlspecialchars($card_quantity); ?> Unit<?php echo $card_quantity > 1 ? 's' : ''; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Amount</th>
                    <td><strong><?php echo htmlspecialchars($amount); ?></strong></td>
                </tr>
                <tr>
                    <th>Transaction No</th>
                    <td><?php echo htmlspecialchars($transaction_no); ?></td>
                </tr>
                <tr>
                    <th>Payment Date</th>
                    <td><?php echo htmlspecialchars($created_at); ?></td>
                </tr>
            </table>

            <p>If you have any questions or need further assistance, feel free to contact us at <a href="mailto:help-center@xbug.online">help-center@xbug.online</a> or visit our website at <a href="https://xbug.online">xbug.online</a>.</p>
            <p>Thank you for choosing <strong>xBug.online</strong>!</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>This is an automated message. Please do not reply.</p>
            <p>&copy; 2025 xBug. All rights reserved.</p>
        </div>
    </div>
</body>

</html>

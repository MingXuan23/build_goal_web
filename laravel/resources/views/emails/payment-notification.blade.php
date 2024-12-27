<?php
$name = $name;
$type = $type;
$content = $content ;
$amount = $amount;
$transaction_no = $transaction_no ;
$created_at = $created_at;
$card_quantity = $card_quantity ;

$headerColor = 'rgba(0, 128, 0, 0.9)';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[xBug] - Payment Receipt</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e6e6e6;
        }

        .email-header {
            background-color: <?php echo $headerColor; ?>;
            padding: 20px;
            text-align: center;
            color: #fff;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .email-body {
            padding: 30px;
        }

        .email-body h2 {
            margin: 0 0 15px;
            font-size: 22px;
            font-weight: bold;
            color: #444;
        }

        .email-body p {
            margin: 0 0 15px;
            font-size: 16px;
        }

        .email-body .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
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
            font-weight: bold;
        }

        .email-footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #888;
            background-color: #f9f9f9;
        }

        .email-footer a {
            color: #555;
            text-decoration: none;
            font-weight: bold;
        }

        .email-footer a:hover {
            color: #000;
        }

        @media (max-width: 600px) {
            .email-container {
                width: 95%;
                margin: 10px auto;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body h2 {
                font-size: 18px;
            }

            .email-body p {
                font-size: 14px;
            }

            .info-table th,
            .info-table td {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Payment Successfull</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            {{-- <h2>Thank you for your payment!</h2> --}}
            <p>Dear <?php echo strtoupper($name); ?>,</p>
            <p>Your payment has been <span style="color: green; font-weight: bold">successfully</span> processed. Below
                are the details of your transaction:</p>

            <!-- Transaction Details Table -->
            <table class="info-table">
                <tr>
                    <th>Transaction Type</th>
                    <td><?php echo $type; ?></td>
                </tr>
                <tr>
                    @if ($content)
                        <th>Content Name</th>
                        <td><?php echo $content; ?></td>
                    @endif
                </tr>
                <tr>
                    @if ($card_quantity)
                        <th>Quantity</th>
                        <td><?php echo $card_quantity; ?> Unit</td>
                    @endif
                </tr>
                <tr>
                    <th>Amount</th>
                    <td><strong><?php echo $amount; ?></strong></td>
                </tr>
                <tr>
                    <th>Transaction No</th>
                    <td><?php echo $transaction_no; ?></td>
                </tr>
                <tr>
                    <th>Payment Date</th>
                    <td><?php echo $created_at; ?></td>
                </tr>
            </table>

            <p>If you have any questions or need further assistance, feel free to contact us at
                <a href="mailto:help-center@xbug.online">[help-center@xbug.online]</a> or visit our website at <a href="https://xbug.online">xbug.online</a>.
            </p>
            <p>Thank you for choosing xBug!</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>This is an automated message. Please do not reply.</p>
        </div>
    </div>
</body>

</html>

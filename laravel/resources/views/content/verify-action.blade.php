<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Result</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .verification-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .verification-card {
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background-color: #ffffff;
            text-align: center;
        }
        .verification-card.success {
            border-top: 5px solid rgb(17, 28, 67);
        }
        .verification-card.error {
            border-top: 5px solid #dc3545; /* Bootstrap's red for error */
        }
    </style>
</head>
<body>
    <div class="container verification-container">
        <div class="verification-card @if($status == 'success') success @else error @endif">
            <img src="https://xbug.online/assets/images/logo.png" alt="Logo" class="img-fluid mb-4" style="height: 60px;">
            @if($status == 'success')
                <i class="bi bi-check-circle-fill text-primary" style="font-size: 3rem;"></i>
            @else
                <i class="bi bi-exclamation-circle-fill text-danger" style="font-size: 3rem;"></i>
            @endif
            <h4 class="mt-3">@if($status == 'success') Success @else Error @endif</h4>
            <p class="mt-2">{{ $message }}</p>
            @if($status == 'success')
                <a href="/" class="btn btn-primary mt-3">Go to Home</a>
            @else
                <button mailto="help-center@xbug.online" class="btn btn-danger mt-3">Contact Support</button>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

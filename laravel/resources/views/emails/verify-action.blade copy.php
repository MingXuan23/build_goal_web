<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Action</title>
</head>
<body>
    <h1>Hello!</h1>
    <p>We need to verify your action. Please click the button below to confirm:</p>
    <a href="{{ url('/verify-action?token=' . $token) }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">
        Verify Now
    </a>
    <p>If the button above doesn't work, copy and paste the following URL into your browser:</p>
    <p>{{ url('/verify-action?token=' . $token) }}</p>
    <p>Thank you for using xBUG!</p>
</body>
</html>

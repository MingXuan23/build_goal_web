<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Pay Form</title>
</head>
<body>
    <h2>Direct Payment Form</h2>
    <form action="{{ route('directpayIndex') }}" method="POST">
        <!-- CSRF Token for Laravel -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="org_id">Organization ID:</label><br>
        <input type="text" id="org_id" name="org_id" required value="1"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required required value="user@xbug.online"><br><br>

        <label for="telno">Phone Number:</label><br>
        <input type="text" id="telno" name="telno" required required value="601111111111"><br><br>

        <label for="name">User Name:</label><br>
        <input type="text" id="name" name="name" required required value="User1"><br><br>

        <label for="desc">Description:</label><br>
        <input type="text" id="desc" name="desc" required value="Promote"><br><br>

        <label for="amount">Amount:</label><br>
        <input type="number" id="amount" name="amount" step="0.01" required value="1"><br><br>

        <button type="submit">Submit Payment</button>
    </form>
</body>
</html>

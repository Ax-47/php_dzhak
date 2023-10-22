<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>
<body>
    <div class="signup-form">
        <form action="../api/auth/signup.php" method="post">
            <input type="text" name="username" id="username" placeholder="username">
            <input type="password" name="password" id="password" placeholder="password">
            <input type="password" name="repassword" id="repassword" placeholder="repassword">
            <input type="submit" name="signup" value="signup">
        </form>
    </div>
</body>
</html>
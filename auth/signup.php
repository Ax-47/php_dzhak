<?php
require_once "../api/utils/authorize.php";
require_once "../api/utils/response.php";
session_start();
if (is_signin())
    return ReaponseRedectToIndex();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/root.css">
    <link rel="stylesheet" href="../assets/css/product/signup.css">
    <title>Signup</title>
</head>
<body>
    <div class="form-signup">
        <form action=<?php echo "https://".$_SERVER["HTTP_HOST"]."/api/route/auth/signup.php"?> method="post">
            <input type="text" name="name" id="name" placeholder="username">
            <input type="password" name="password" id="password" placeholder="password">
            <input type="password" name="repassword" id="repassword" placeholder="repassword">
            <input type="submit" name="signup" value="signup">
        </form>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signin</title>
</head>
<body>
    <?php
    if (isset($_GET["error"])){
        echo $_GET["error"];
    }
    ?>
    <div class="a">
        <form action="../../api/auth/signin.php" method="post">
            <input type="text" name="name" id="name" placeholder="username">
            <input type="password" name="password" id="password" placeholder="password">
            <input type="submit" value="signin" name = "signin">
        </form>
    </div>
</body>
</html>
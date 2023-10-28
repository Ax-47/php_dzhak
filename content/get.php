<?php
require_once "../api/content/get.php";
require_once "../utils/auth.php";
session_start();

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $content["topic"]?></title>
</head>
<body>
    <?php
        if (IsAdmin()){
            ?>
            <a href="update.php?id=<?php echo $id?>">update</a>
            <a href="../../api/content/delete.php?id=<?php echo $id?>">delete</a>
            <?php
        }
    ?>
    <h1><?php echo $content["topic"]?></h1>
    <img src="../assets/uploads/<?php echo $content["image"]?>">
    <h2><?php echo $content["description"]?></h2>
</body>
</html>
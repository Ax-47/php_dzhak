<?php
require_once "../api/content/get.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";
session_start();
if (!IsAdmin())
    return ResponseNotFound();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>
<body>
<?php
        if (isset($_GET["error"])){
            echo $_GET["error"];
        }
        if (isset($_GET["message"])){
            echo $_GET["message"];
        }
    ?>
<div class="a">
        <form action="../../api/content/update.php?id=<?php echo $content["id"]?>" method="post" enctype="multipart/form-data">
            <input type="text" name="topic" id="topic" placeholder="topic" value="<?php echo $content["topic"]?>">
            <input type="text" name="description" id="description" placeholder="description" value="<?php echo $content["description"]?>">
            <input type="file" name="image" id="image">
            <input type="submit" value="create" name = "create">
        </form>
    </div>
</body>
</html>
<?php
require_once "../utils/auth.php";
require_once "../utils/response.php";
session_start();
if (IsNotAuthencation())
    return ResponseNotFound();
if (IsNotAdmin())
    return ResponseNotFound();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create content</title>
</head>
<body>
    <div class="create">
        <form action="../api/content/create.php" method="post" enctype="multipart/form-data">
            <input type="text" name="topic" id="topic" placeholder="topic">
            <input type="text" name="description" id="description" placeholder="description">
            <input type="file" name="image" id="image" placeholder="image">
            <input type="submit" name="create" value="create">
        </form>
    </div>
</body>
</html>
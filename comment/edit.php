<?php
require_once "../utils/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";
session_start();
$comment_id=$_GET["id"];
if (empty($comment_id))
    return ResponseNotFound();
if (IsNotAuthencation())
    return ResponseNotFound();
try{
    $stmt = $db->prepare("select * from comments where comment_id = :comment_id");
    $stmt->execute([":comment_id"=>$comment_id]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}
if (empty($comment))
    return ResponseNotFound();
if ($comment["user_id"]!== $_SESSION["user_id"])
    return ResponseNotFound();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="edit">
        <form action="../api/comment/edit.php" method="post">
            <input type="hidden" name="comment_id" value="<?php echo $_GET["id"]?>">
            <input type="hidden" name="content_id" value="<?php echo $comment["content_id"]?>">
            <input type="text" name="comment" value="<?php echo $comment["comment"]?>">
            <input type="submit" name="edit" value="edit">
        </form>
    </div>
</body>
</html>
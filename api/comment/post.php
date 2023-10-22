<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/uuid.php";
require_once "../../utils/auth.php";
session_start();
if (IsNotAuthencation())
    return ResponseNotFound();
if (IsNotAdmin())
    return ResponseNotFound();
$callback = "/content/get.php?id=";
if (empty($_POST["post"]))
    return ResponseNotFound();
$comment =$_POST["comment"];
$content_id =$_POST["content_id"];
if (empty($comment))
    return ResponseErrorWithID("comment is empty",$callback);
if (empty($content_id))
    return ResponseErrorWithID("content_id is empty",$callback);
if (strlen($comment)>256)
    return ResponseErrorWithID("comment is longer than 256 chars",$callback);

try{
    $stmt = $db->prepare("select topic from contents where content_id = :content_id");
    $stmt->execute([":content_id"=>$content_id]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}
if (empty($content))
    return ResponseNotFound();
$comment_id = GenUUID($db);
try{
    $stmt = $db->prepare("insert into comments(comment_id,content_id,user_id,comment) values(:comment_id,:content_id,:user_id,:comment)");
    $stmt->execute([":comment_id"=>$comment_id,":content_id"=>$content_id,":user_id"=>$_SESSION["user_id"],":comment"=>$comment]);
}catch(PDOException $e){
    die($e->getMessage());
}
ResponseOk("Created","/content/get.php?id=".$content_id);
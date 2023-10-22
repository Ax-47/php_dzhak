<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/uuid.php";
require_once "../../utils/auth.php";
session_start();
if (IsNotAuthencation())
    return ResponseNotFound();
$content_id=$_GET["content_id"];
$comment_id=$_GET["id"];
if (empty($comment_id))
    return ResponseNotFound();
try{
    $stmt = $db->prepare("DELETE FROM `comments` WHERE comment_id = :comment_id and user_id = :user_id");
    $stmt->execute([":comment_id"=>$comment_id,":user_id"=>$_SESSION["user_id"]]);
}catch(PDOException $e){
    die($e->getMessage());
}
if (!empty($content_id)){
    ResponseOk("ok","/content/get.php?id=".$content_id);
}else{
    ResponseOk("ok","");
}
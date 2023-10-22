<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/uuid.php";
require_once "../../utils/auth.php";
session_start();
if (IsNotAuthencation())
    return ResponseNotFound();

if (empty($_POST["edit"]))
    return ResponseNotFound();
$comment =$_POST["comment"];
$content_id=$_POST["content_id"];
$comment_id=$_POST["comment_id"];
if (empty($content_id))
        return ResponseNotFound();
if (empty($comment_id))
        return ResponseNotFound();
$callback = "/content/get.php?id=".$comment_id;
if (empty($comment))
    return ResponseErrorWithID("comment is empty",$callback);
if (strlen($comment)>256)
    return ResponseErrorWithID("comment is longer than 30 chars",$callback);
try{
        $stmt = $db->prepare("update comments set comment= :comment where comment_id = :comment_id and user_id = :user_id");
        $stmt->execute([":user_id"=>$_SESSION["user_id"],":comment_id"=>$comment_id,":comment"=>$comment]);
}catch(PDOException $e){
        die($e->getMessage());
}

ResponseOk("edited","/content/get.php?id=".$content_id);
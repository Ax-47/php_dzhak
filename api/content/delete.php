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
$content_id=$_GET["id"];
if (empty($content_id))
    return ResponseNotFound();
try{
    $stmt = $db->prepare("DELETE FROM `contents` WHERE content_id = :content_id");
    $stmt->execute([":content_id"=>$content_id]);
}catch(PDOException $e){
    die($e->getMessage());
}
ResponseOk("edited","");
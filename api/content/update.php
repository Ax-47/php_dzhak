<?php
require_once "../../utils/database.php";
require_once "../../utils/uuid.php";
require_once "../../utils/response.php";
require_once "../utils/auth.php";
session_start();
if (!IsAdmin())
    return ResponseNotFound();
$id=$_GET["id"];
if (empty($_POST["create"]) || empty($id))
    return ResponseNotFound();
$topic = $_POST["topic"];
$description = $_POST["description"];
$image = $_FILES["image"];
$callback="content/update.php?id=".$id;
$upload = "../../assets/uploads/";
if (empty($topic))
    return ResponseErrorID("topic is empty",$callback);
if (empty($description))
    return ResponseErrorID("description is empty",$callback);
if (strlen($topic)>30)
    return ResponseErrorID("name is longer than 30chars",$callback);
if (strlen($description)>512)
    return ResponseErrorID("password is longer than 512chars",$callback);
try {
    $stmt = $db->prepare("SELECT * FROM `contents` WHERE topic = :topic and id != :id");
    $stmt->execute([":topic"=>$topic,":id"=>$id]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}
if (!empty($content))
    return ResponseErrorID("some content used this topic",$callback);
if ($image["size"]!=0){
    $chack = getimagesize($image["tmp_name"]);
    if (!$chack)
        return ResponseErrorID("this is not image file",$callback); 
    if (!$image["size"]>500000)
        return ResponseErrorID("this size file is larger than 50MB",$callback);
    $mime=pathinfo($image["name"],PATHINFO_EXTENSION);
    $new_file=$id.".".$mime;
    $target = $upload.$new_file;
    if (!move_uploaded_file($image["tmp_name"],$target))
        return ResponseErrorID("failed to upload",$callback);
    try {
        $stmt = $db->prepare("UPDATE contents SET topic = :topic,description = :description,image = :image WHERE id=:id" );
        $stmt->execute([":id"=>$id,":topic"=>$topic,":description"=>$description,":image"=>$new_file]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}else{
    try {
        $stmt = $db->prepare("UPDATE contents SET topic = :topic,description = :description WHERE id=:id" );
        $stmt->execute([":id"=>$id,":topic"=>$topic,":description"=>$description]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
ResponseOkID("updated",$callback);
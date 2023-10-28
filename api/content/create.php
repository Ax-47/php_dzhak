<?php
require_once "../../utils/database.php";
require_once "../../utils/uuid.php";
require_once "../../utils/response.php";
require_once "../../utils/auth.php";
session_start();
if (!IsAdmin())
    return ResponseNotFound();
if (empty($_POST["create"]))
    return;
$topic = $_POST["topic"];
$description = $_POST["description"];
$image = $_FILES["image"];
$callback="content/create.php";
$upload = "../../assets/uploads/";
if (empty($topic))
    return ResponseError("topic is empty",$callback);
if (empty($description))
    return ResponseError("description is empty",$callback);
if (empty($image))
    return ResponseError("image is empty",$callback);

if (strlen($topic)>30)
    return ResponseError("name is longer than 30chars",$callback);
if (strlen($description)>512)
    return ResponseError("password is longer than 512chars",$callback);
try {
    $stmt = $db->prepare("SELECT * FROM `contents` WHERE topic = :topic");
    $stmt->execute([":topic"=>$topic]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}
if (!empty($content))
    return ResponseError("some content used this topic",$callback);
$id = GenUUID($db);
$chack = getimagesize($image["tmp_name"]);
if (!$chack)
    return ResponseError("this is not image file",$callback); 
if (!$image["size"]>500000)
    return ResponseError("this size file is larger than 50MB",$callback);
$mime=pathinfo($image["name"],PATHINFO_EXTENSION);
$new_file=$id.".".$mime;
$target = $upload.$new_file;
if (!move_uploaded_file($image["tmp_name"],$target))
    return ResponseError("failed to upload",$callback);
try {
    $stmt = $db->prepare("INSERT INTO contents(id,topic,description,image) VALUES(:id,:topic,:description,:image)" );
    $stmt->execute([":id"=>$id,":topic"=>$topic,":description"=>$description,":image"=>$new_file]);
} catch (PDOException $e) {
    die($e->getMessage());
}
ResponseOk("created",$callback);
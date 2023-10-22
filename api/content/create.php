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
$callback = "/content/create.php";
if (empty($_POST["create"]))
    return ResponseNotFound();
$topic =$_POST["topic"];
$description =$_POST["description"];
$image =$_FILES["image"];
if (empty($topic))
    return ResponseError("topic is empty",$callback);
if (empty($description))
    return ResponseError("description is empty",$callback);
if ($image["size"]!=0)
    return ResponseError("image is empty",$callback);
if (strlen($topic)>30)
    return ResponseError("topic is longer than 30 chars",$callback);
if (strlen($description)>512)
    return ResponseError("description is longer than 512 chars",$callback);

try{
    $stmt = $db->prepare("select content_id from contents where topic = :topic");
    $stmt->execute([":topic"=>$topic]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}
if (!empty($content))
    return ResponseError("this topic have used",$callback);
$content_id = GenUUID($db);
$frantments=explode(".",$image["name"]);
if (strpos($image["type"],"image")!=0)
    return ResponseError("this file is not image",$callback);
if (count($frantments)!=2)
    return ResponseError("this file is not image",$callback);
$file_name =$content_id.".".$frantments[1];
if (!move_uploaded_file($image["tmp_name"],"../../assets/uploads/".$file_name))
    return ResponseError("failed to upload",$callback);

try{
    $stmt = $db->prepare("insert into contents(content_id,topic,description,image) values(:content_id,:topic,:description,:image)");
    $stmt->execute([":content_id"=>$content_id,":topic"=>$topic,":description"=>$description,":image"=>$file_name]);
}catch(PDOException $e){
    die($e->getMessage());
}
ResponseOk("Created","/content/get.php?id=".$content_id);
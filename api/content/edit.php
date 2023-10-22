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
if (empty($_POST["edit"]))
    return ResponseNotFound();
    $callback = "/content/edit.php?id=".$content_id;
$topic =$_POST["topic"];
$description =$_POST["description"];
$image =$_FILES["image"];
if (empty($topic))
    return ResponseErrorWithID("topic is empty",$callback);
if (empty($description))
    return ResponseErrorWithID("description is empty",$callback);
if (strlen($topic)>30)
    return ResponseErrorWithID("topic is longer than 30 chars",$callback);
if (strlen($description)>512)
    return ResponseErrorWithID("description is longer than 512 chars",$callback);
try{
    $stmt = $db->prepare("select content_id from contents where topic = :topic and content_id != :content_id");
    $stmt->execute([":topic"=>$topic,":content_id"=>$content_id]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}
if (!empty($content))
    return ResponseErrorWithID("this topic have used",$callback);
if ($image["size"]!=0){
    $frantments=explode(".",$image["name"]);
    if (strpos($image["type"],"image")!=0)
        return ResponseErrorWithID("this file is not image",$callback);
    if (count($frantments)!=2)
        return ResponseErrorWithID("this file is not image",$callback);
    $file_name =$content_id.".".$frantments[1];
    if (!move_uploaded_file($image["tmp_name"],"../../assets/uploads/".$file_name))
        return ResponseErrorWithID("failed to upload",$callback);

    try{
        $stmt = $db->prepare("update contents set topic= :topic,description= :description,image= :image where content_id = :content_id");
        $stmt->execute([":content_id"=>$content_id,":topic"=>$topic,":description"=>$description,":image"=>$file_name]);
    }catch(PDOException $e){
        die($e->getMessage());
    }
}else{
    try{
        $stmt = $db->prepare("update contents set topic= :topic,description= :description where content_id = :content_id");
        $stmt->execute([":content_id"=>$content_id,":topic"=>$topic,":description"=>$description]);
    }catch(PDOException $e){
        die($e->getMessage());
    }
}
ResponseOk("edited","/content/get.php?id=".$content_id);
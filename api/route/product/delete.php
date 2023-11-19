<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/authorize.php";
session_start();
if (!is_admin())
    return ReaponseNotFound();
$callback = "";
$id = $_GET["id"];
if (!isset($id))
    return ReaponseNotFound();
$response = new Response($callback,$id);
try{
    $stmt = $db->prepare("DELETE FROM `products` WHERE id= :id");
    $stmt->execute([":id"=>$id]);
}catch(PDOException $e){
    die($e->getMessage());
}
ReaponseRedectToIndex();
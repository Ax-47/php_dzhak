<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/auth.php";
session_start();
if (!IsAdmin())
    return ResponseNotFound();
$id=$_GET["id"];
if (empty($id))
    return ResponseNotFound();
try {
    $stmt = $db->prepare("SELECT image FROM `contents` WHERE id = :id");
    $stmt->execute([":id"=>$id]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}
if (empty($content))
    return ResponseNotFound();
unlink("../../assets/uploads/".$content["image"]);
try {
        $stmt = $db->prepare("DELETE FROM `contents` WHERE id = :id");
        $stmt->execute([":id"=>$id]);
} catch (PDOException $e) {
        die($e->getMessage());
}
ResponseOk("");
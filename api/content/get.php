<?php
require_once "../utils/database.php";
require_once "../utils/response.php";

$id=$_GET["id"];
if (empty($id))
    return ResponseNotFound();
try {
    $stmt = $db->prepare("SELECT * FROM `contents` WHERE id = :id");
    $stmt->execute([":id"=>$id]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}
if (empty($content))
    return ResponseNotFound();
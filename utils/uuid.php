<?php
function GenUUID(PDO $db) : string {
    try {
        $stmt = $db->prepare("SELECT uuid()");
        $stmt->execute();
        return (string)$stmt->fetch(PDO::FETCH_ASSOC)["uuid()"];
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
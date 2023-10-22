<?php 

function GenUUID(PDO $db):string{
    try{
        $stmt = $db->prepare("select uuid()");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["uuid()"];
    }catch(PDOException $e){
        die($e->getMessage());
    }
}
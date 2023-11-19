<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/authorize.php";
session_start();
if (!is_admin())
    return ReaponseNotFound();
$callback = "product/update.php";
$upload_dir = "../../../assets/uploads/";
$id = $_GET["id"];
if (!isset($id))
    return ReaponseNotFound();
$response = new Response($callback,$id);
if (empty($_POST["update"]))
    return $response->ReaponseNotFound();
$name = $_POST["name"];
$description = $_POST["description"];
$stock = $_POST["stock"];
$price = $_POST["price"];
$image = $_FILES["image"];

if (!isset($name))
    return $response->ReaponseError("product-name is empty");
if (!isset($description))
    return $response->ReaponseError("description is empty");
if (!isset($stock))
    return $response->ReaponseError("stock is empty");
if (!isset($price))
    return $response->ReaponseError("price is empty");

if (strlen($name)>30)
    return $response->ReaponseError("product-name lenght is longer than 30");
if (strlen($description)>256)
    return $response->ReaponseError("description lenght is longer than 256");
if (strlen($stock)<0)
    return $response->ReaponseError("stock lenght is shorter than 0");
if (strlen($price)<0)
    return $response->ReaponseError("price lenght is shorter than 0");

try{
    $stmt = $db->prepare("select * from products where name = :name and id != :id");
    $stmt->execute([":name"=>$name,":id"=>$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}

if (!empty($product))
    return $response->ReaponseError("someone used this product-name");

if ($image["size"]!==0){
        $check = getimagesize($image["tmp_name"]);
        if (!$check)
            return $response->ReaponseError("it is not image file");
        if ($image["size"]> 500000)
            return $response->ReaponseError("it is larger than 50mb");
        $now= new DateTime();
        $mime = pathinfo($image["name"],PATHINFO_EXTENSION);
        $new_file = "PRODUCT-".$now->getTimestamp().".".$mime;
        $target=$upload_dir.$new_file;
        $old_target= $upload_dir.$product["image"];
        unlink($old_target);
        if (!move_uploaded_file($image["tmp_name"],$target))
            return $response->ReaponseError("failed to upload");
        try{
            $stmt = $db->prepare("update products set name=:name, description=:description,stock=:stock,price=:price,image=:image where id=:id");
            $stmt->execute([
                    ":name"=>$name,
                    ":description"=>$description,
                    ":stock"=>$stock,
                    ":price"=>$price,
                    ":image"=>$new_file,
                    ":id"=>$id
                ]);
        }catch(PDOException $e){
                die($e->getMessage());
        }
}else{
    try{
        $stmt = $db->prepare("update products set name=:name, description=:description,stock=:stock,price=:price where id=:id");
            $stmt->execute([
                    ":name"=>$name,
                    ":description"=>$description,
                    ":stock"=>$stock,
                    ":price"=>$price,
                    ":id"=>$id
                ]);
    }catch(PDOException $e){
            die($e->getMessage());
    }
}



$response->ReaponseOk("Updated");
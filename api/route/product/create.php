<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/authorize.php";
session_start();
$callback = "product/create.php";
$upload_dir = "../../../assets/uploads/";
$response = new Response($callback);
if (!is_admin())
    return ReaponseNotFound();
if (empty($_POST["create"]))
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
if (!isset($image))
    return $response->ReaponseError("image is empty");

if (strlen($name)>30)
    return $response->ReaponseError("product-name lenght is longer than 30");
if (strlen($description)>256)
    return $response->ReaponseError("description lenght is longer than 256");
if (strlen($stock)<0)
    return $response->ReaponseError("stock lenght is shorter than 0");
if (strlen($price)<0)
    return $response->ReaponseError("price lenght is shorter than 0");

$check = getimagesize($image["tmp_name"]);
if (!$check)
    return $response->ReaponseError("it is not image file");
if ($image["size"]> 500000)
    return $response->ReaponseError("it is larger than 50mb");

try{
    $stmt = $db->prepare("select id from products where name = :name");
    $stmt->execute([":name"=>$name]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}

if (!empty($product))
    return $response->ReaponseError("someone used this product-name");

$now= new DateTime();
$mime = pathinfo($image["name"],PATHINFO_EXTENSION);
$new_file = "PRODUCT-".$now->getTimestamp().".".$mime;
$target=$upload_dir.$new_file;
if (!move_uploaded_file($image["tmp_name"],$target))
    return $response->ReaponseError("failed to upload");

try{
    $stmt = $db->prepare("insert into products(name,description,stock,price,image) values(:name,:description,:stock,:price,:image)");
    $stmt->execute([":name"=>$name,
                    ":description"=>$description,
                    ":stock"=>$stock,
                    ":price"=>$price,
                    ":image"=>$new_file
                    ]);
}catch(PDOException $e){
    die($e->getMessage());
}
$response->ReaponseOk("Created");
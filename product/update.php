<?php
require_once "../api/utils/response.php";
require_once "../api/utils/database.php";
require_once "../api/utils/authorize.php";
session_start();
if (!is_admin())
    return ReaponseNotFound();
$id = $_GET["id"];
if (!isset($id))
    return ReaponseNotFound();
try{
    $stmt=$db->prepare("select * from products where id = :id");
    $stmt->execute([":id"=>$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}
if (empty($product))
    return ReaponseNotFound();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/root.css">
    <link rel="stylesheet" href="../assets/css/product/update.css">
    <title>Update</title>
</head>
<body>
    <div class="form-update-product">
        <form action=<?php echo "https://".$_SERVER["HTTP_HOST"]."/api/route/product/update.php?id=".$id?> method="post" enctype="multipart/form-data">
            <input type="text" name="name" id="name" placeholder="product name" value="<?php echo htmlentities($product["name"])?>">
            <input type="text" name="description" id="description" placeholder="description" value="<?php echo htmlentities($product["description"])?>">
            <input type="number" name="stock" id="stock" placeholder="stock"  value="<?php echo htmlentities($product["stock"])?>">
            <input type="number" name="price" id="price" placeholder="price"   value="<?php echo htmlentities($product["price"])?>">
            <input type="file" name="image" id="image" accept="image/*">
            <img src="<?php echo "https://".$_SERVER["HTTP_HOST"]."/assets/uploads/".$product["image"] ?>" alt="">
            <input type="submit" name="update" value="update">
        </form>
    </div>
</body>
</html>
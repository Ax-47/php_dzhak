<?php
require_once "../api/utils/response.php";
require_once "../api/utils/database.php";
require_once "../api/utils/authorize.php";
session_start();
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
    <link rel="stylesheet" href="../assets/css/product/get.css">
    <title>Update</title>
</head>
<body>
    <div class="form-update-product">
       <div class="card">
            <h1>product : <?php echo htmlentities($product["name"])?></h1>
            <h2>description : <?php echo htmlentities($product["description"])?></h2>
            <h2>stock : <?php echo htmlentities($product["stock"])?></h2>
            <h2>price : <?php echo htmlentities($product["price"])?></h2>
            <img src="<?php echo "https://".$_SERVER["HTTP_HOST"]."/assets/uploads/".$product["image"] ?>" alt="">
       </div>
       <?php if (is_admin())
            {
       ?>
        <div class="admin">
            <a href="<?php echo "https://".$_SERVER["HTTP_HOST"]."/product/update.php?id=".$id?>">update</a>
            <a href="<?php echo "https://".$_SERVER["HTTP_HOST"]."/api/route/product/delete.php?id=".$id?>">delete</a>
        </div>
        <?php
            }
            ?>

    </div>
</body>
</html>
<?php
require_once "../api/utils/database.php";
$error= null;
try{
    $stmt=$db->prepare("select * from products");
    $stmt->execute();
    $products = $stmt->fetchAll();
}catch(PDOException $e){
    die($e->getMessage());
}
if (!isset($products))
    $error=1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/root.css">
    <link rel="stylesheet" href="../assets/css/product/menu.css">
    <title>menu</title>
</head>
<body>
    <?php 
    if ($error !==1)
    ?>
    <?php
        foreach($products as $product)
        {
    ?>
        <div class="menu">
                <a href="<?php echo "https://".$_SERVER["HTTP_HOST"]."/product/get.php?id=".$product["id"] ?>">
                        <img src="<?php echo "https://".$_SERVER["HTTP_HOST"]."/assets/uploads/".$product["image"] ?>">
                        <p><?php echo htmlentities($product["name"])?></p>
                    
                    </a>
        </div>
    <?php
        }
    ?>
</body>
</html>
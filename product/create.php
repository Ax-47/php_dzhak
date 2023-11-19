<?php
require_once "../api/utils/authorize.php";
session_start();
if (!is_admin())
    return ReaponseNotFound();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/root.css">
    <link rel="stylesheet" href="../assets/css/product/create.css">
    <title>Create</title>
</head>
<body>
    <div class="form-create-product">
        <form action=<?php echo "https://".$_SERVER["HTTP_HOST"]."/api/route/product/create.php"?> method="post" enctype="multipart/form-data">
            <input type="text" name="name" id="name" placeholder="product name">
            <input type="text" name="description" id="description" placeholder="description">
            <input type="number" name="stock" id="stock" placeholder="stock">
            <input type="number" name="price" id="price" placeholder="price">
            <input type="file" name="image" id="image" accept="image/*">
            <input type="submit" name="create" value="create">
        </form>
    </div>
</body>
</html>
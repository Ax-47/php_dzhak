<?php
require_once "utils/database.php";
try{
    $stmt = $db->prepare("select * from contents");
    $stmt->execute();
    $contents = $stmt->fetchAll();
}catch(PDOException $e){
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>
    <?php
    foreach ($contents as $content)
    {
        ?>
        <h2><a href="/content/get.php?id=<?php echo $content["content_id"]?>"><?php echo $content["topic"]?></a></h2>
        <?php
    }
    ?>
</body>
</html>
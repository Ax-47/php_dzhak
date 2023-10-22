<?php
require_once "../utils/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";
session_start();
$content_id=$_GET["id"];

if (empty($content_id))
    return ResponseNotFound();
if (IsNotAuthencation())
    return ResponseNotFound();
if (IsNotAdmin())
    return ResponseNotFound();
try{
    $stmt = $db->prepare("select * from contents where content_id = :content_id");
    $stmt->execute([":content_id"=>$content_id]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
</head>
<body>
    <?php
    if (empty($content))
    {
        ?>
            <h1>not found item</h1>
        <?php
    }else{
      ?>  
        <div class="edit">
                <form action="../api/content/edit.php?id=<?php echo $content_id?>" method="post" enctype="multipart/form-data">
                    <input type="text" name="topic" id="topic" placeholder="topic" value="<?php echo $content["topic"]?>">
                    <input type="text" name="description" id="description" placeholder="description" value="<?php echo $content["description"]?>">
                    <input type="file" name="image" id="image" placeholder="image">
                    <input type="submit" name="edit" value="edit">
                </form>
        </div>
    <?php
    }
    ?>
</body>
</html>
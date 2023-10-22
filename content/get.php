<?php
require_once "../utils/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";
session_start();
$content_id=$_GET["id"];

if (empty($content_id))
    return ResponseNotFound();
try{
    $stmt = $db->prepare("select * from contents where content_id = :content_id");
    $stmt->execute([":content_id"=>$content_id]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}
if (empty($content))
    return ResponseNotFound();
try{
    $stmt = $db->prepare("select * from comments 
    inner join contents on comments.content_id =contents.content_id 
    inner join users on comments.user_id = users.user_id
    ");
    $stmt->execute();
    $comments = $stmt->fetchAll();
}catch(PDOException $e){
    die($e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $content["topic"]?></title>
</head>
<body>
    <?php
    if (IsAdmin())
    {
        ?>
        <a href="edit.php?id=<?php echo $content_id?>">edit</a>
        <a href="../api/content/delete.php?id=<?php echo $content_id?>">delete</a>
    <?php
        }
    ?>
    
    <h1><?php echo $content["topic"]?></h1>
    <img src="../assets/uploads/<?php echo $content["image"]?>" alt="">
    <h2><?php echo $content["description"]?></h2>
    <h2>Comment:</h2>
    <?php
    if (IsAuthencation())
    {
        ?>
        <form action="../api/comment/post.php" method="post">
            <input type="hidden" name="content_id" value="<?php echo $content_id?>">
            <input type="text" name="comment" id="comment" placeholder = "comment">
            <input type="submit" name="post" value="post">
        </form>
    <?php
        }
    ?>
    <?php
        if (!empty($comments)){
        foreach ($comments as $comment)
            {
                if(!empty($_SESSION["user_id"])){
                    if ($comment["user_id"]===$_SESSION["user_id"]){
                        ?>
                            <p><?php echo $comment["username"]?> : <?php echo $comment["comment"]?> <a href="../comment/edit.php?id=<?php echo $comment["comment_id"]?>">edit</a> <a href="../api/comment/delete.php?id=<?php echo $comment["comment_id"]?>&content_id=<?php echo $comment["content_id"]?>">delete</a></p>
                        <?php
                    }else{
                        ?>
                        <p><?php echo $comment["username"]?> : <?php echo $comment["comment"]?></p>
                        <?php
                    }
                }else{
                    ?>
                    <p><?php echo $comment["username"]?> : <?php echo $comment["comment"]?></p>
                    <?php
                }
            }
        }else
        {
            ?>
            <h2>not found</h2>
            <?php
        }
    ?>
</body>
</body>
</html>
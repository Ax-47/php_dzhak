<?php
require_once "../../utils/database.php";
require_once "../../utils/uuid.php";
require_once "../../utils/response.php";
session_start();
if (empty($_POST["signup"]))
    return;
$name = $_POST["name"];
$password = $_POST["password"];
$repassword = $_POST["repassword"];
$callback="auth/signup.php";
if (empty($name))
    return ResponseError("username is empty",$callback);
if (empty($password))
    return ResponseError("password is empty",$callback);
if (empty($repassword))
    return ResponseError("repassword is empty",$callback);

if (strlen($name)>30)
    return ResponseError("name is longer than 30chars",$callback);
if (strlen($password)>60)
    return ResponseError("password is longer than 30chars",$callback);
if (strlen($password)<6)
    return ResponseError("password is shorter than 6chars",$callback);
if ($password !== $repassword)
    return ResponseError("password and repassword are not same",$callback);
try {
    $stmt = $db->prepare("SELECT * FROM `users` WHERE name = :name");
    $stmt->execute([":name"=>$name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}
if (!empty($user))
    return ResponseError("someone used this name",$callback);
$id = GenUUID($db);
$hashed_password = password_hash($password,PASSWORD_BCRYPT);
try {
    $stmt = $db->prepare("INSERT INTO users(id,name,password) VALUES(:id,:name,:password)" );
    $stmt->execute([":id"=>$id,":name"=>$name,":password"=>$hashed_password]);
} catch (PDOException $e) {
    die($e->getMessage());
}
$_SESSION["id"]=$id;
$_SESSION["is_admin"]=false;
ResponseOk("created");
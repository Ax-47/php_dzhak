<?php
require_once "../../utils/database.php";
require_once "../../utils/uuid.php";
require_once "../../utils/response.php";
session_start();
if (empty($_POST["signin"]))
    return;
$name = $_POST["name"];
$password = $_POST["password"];
$callback="auth/signin.php";
if (empty($name))
    return ResponseError("username is empty",$callback);
if (empty($password))
    return ResponseError("password is empty",$callback);
try {
    $stmt = $db->prepare("SELECT * FROM `users` WHERE name = :name");
    $stmt->execute([":name"=>$name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}
if (empty($user))
    return ResponseError("username or password went wrong",$callback);
if (!password_verify($password,$user["password"]))
    return ResponseError("username or password went wrong",$callback);
$_SESSION["id"]=$user["id"];
$_SESSION["is_admin"]=$user["is_admin"];
ResponseOk("logined");
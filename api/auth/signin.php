<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/uuid.php";
session_start();
$callback = "/auth/signin.php";
if (empty($_POST["signin"]))
    return ResponseNotFound();
$username =$_POST["username"];
$password =$_POST["password"];
if (empty($username))
    return ResponseError("username is empty",$callback);
if (empty($password))
    return ResponseError("password is empty",$callback);

try{
    $stmt = $db->prepare("select * from users where username = :username");
    $stmt->execute([":username"=>$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}

if (empty($user))
    return ResponseError("username or password went wrong",$callback);
if (!password_verify($password , $user["password"]))
    return ResponseError("username or password went wrong",$callback);


$_SESSION["user_id"]=$user["user_id"];
$_SESSION["is_admin"]=$user["is_admin"];
header("location: https://".$_SERVER["HTTP_HOST"]."/");
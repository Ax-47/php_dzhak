<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/uuid.php";
session_start();
$callback = "/auth/signup.php";
if (empty($_POST["signup"]))
    return ResponseNotFound();
$username =$_POST["username"];
$password =$_POST["password"];
$repassword =$_POST["repassword"];
if (empty($username))
    return ResponseError("username is empty",$callback);
if (empty($password))
    return ResponseError("password is empty",$callback);
if (empty($repassword))
    return ResponseError("repassword is empty",$callback);
if ($password !== $repassword)
    return ResponseError("password and repassword are not same",$callback);
if (strlen($username)>30)
    return ResponseError("username is longer than 30 chars",$callback);
if (strlen($password)>60)
    return ResponseError("password is longer than 60 chars",$callback);
if (strlen($password)<6)
    return ResponseError("password is less than 6 chars",$callback);

try{
    $stmt = $db->prepare("select user_id from users where username = :username");
    $stmt->execute([":username"=>$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}
if (!empty($user))
    return ResponseError("someone used this username",$callback);
$user_id = GenUUID($db);
$hashed_password = password_hash($password,PASSWORD_BCRYPT);
try{
    $stmt = $db->prepare("insert into users(user_id,username,password) values(:id,:username,:password)");
    $stmt->execute([":id"=>$user_id,":username"=>$username,":password"=>$hashed_password]);
}catch(PDOException $e){
    die($e->getMessage());
}
$_SESSION["user_id"]=$user_id;
$_SESSION["is_admin"]=false;
header("location: https://".$_SERVER["HTTP_HOST"]."/");
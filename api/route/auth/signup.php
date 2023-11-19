<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
session_start();
$callback = "";
$response = new Response($callback);
if (empty($_POST["signup"]))
    return $response->ReaponseNotFound();
$name = $_POST["name"];
$password = $_POST["password"];
$repassword = $_POST["repassword"];

if (!isset($name))
    return $response->ReaponseError("name is empty");
if (!isset($password))
    return $response->ReaponseError("password is empty");
if (!isset($repassword))
    return $response->ReaponseError("repassword is empty");

if ($password !== $repassword)
    return $response->ReaponseError("password and repassword are not same");
if (strlen($name)>30)
    return $response->ReaponseError("name lenght is longer than 30");
if (strlen($password)>60)
    return $response->ReaponseError("password lenght is longer than 60");
if (strlen($password)<6)
    return $response->ReaponseError("password lenght is shorter than 6");

try{
    $stmt = $db->prepare("select id from users where name = :name");
    $stmt->execute([":name"=>$name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}

if (!empty($user))
    return $response->ReaponseError("someone used this name");

$hashed_password = password_hash($password,PASSWORD_BCRYPT);
try{
    $stmt = $db->prepare("insert into users(name,password) values(:name, :password)");
    $stmt->execute([":name"=>$name,":password"=>$hashed_password]);
}catch(PDOException $e){
    die($e->getMessage());
}
$_SESSION["user_id"]= $db->lastInsertID();
$_SESSION["is_admin"]= false;
ReaponseRedectToIndex();
<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
session_start();
$callback = "auth/signup.php";
$response = new Response($callback);
if (empty($_POST["signin"]))
    return $response->ReaponseNotFound();
$name = $_POST["name"];
$password = $_POST["password"];

if (!isset($name))
    return $response->ReaponseError("name is empty");
if (!isset($password))
    return $response->ReaponseError("password is empty");

try{
    $stmt = $db->prepare("select * from users where name = :name");
    $stmt->execute([":name"=>$name]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die($e->getMessage());
}
if (!isset($user))
    return $response->ReaponseError("name or password went wrong");
if (!password_verify($password,$user["password"]))
    return $response->ReaponseError("name or password went wrong");

$_SESSION["user_id"]= $user["id"];
$_SESSION["is_admin"]=  $user["is_admin"];
ReaponseRedectToIndex();
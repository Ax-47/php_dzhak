<?php
function is_admin(): bool{
    $is_admin=$_SESSION["is_admin"];
    if (empty($is_admin))
        return false;
    return $is_admin;
}
function is_signin(): bool{
    $id=isset($_SESSION["id"]) ? $_SESSION["id"] : null;
    if ($id===null)
        return false;
    return true;
}
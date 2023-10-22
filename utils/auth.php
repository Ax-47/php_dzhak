<?php
function IsNotAuthencation():bool{
    return (bool)empty($_SESSION["user_id"])||empty($_SESSION["is_admin"]);
}
function IsAuthencation():bool{
    return (bool)!(empty($_SESSION["user_id"])||empty($_SESSION["is_admin"]));
}
function IsNotAdmin():bool{
    if (empty($_SESSION["is_admin"]))
        return true;
    return (bool)!$_SESSION["is_admin"];
}
function IsAdmin():bool{
    if (empty($_SESSION["is_admin"]))
        return false;
    return (bool)$_SESSION["is_admin"];
}
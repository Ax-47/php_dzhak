<?php
function IsAdmin(){
    if (empty($_SESSION["is_admin"]))
        return false;
  
    return $_SESSION["is_admin"];
}
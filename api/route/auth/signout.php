<?php
require_once "../../utils/database.php";
require_once "../../utils/response.php";
require_once "../../utils/authorize.php";
session_start();
unset($_SESSION["id"]);
unset($_SESSION["is_admin"]);
ReaponseRedectToIndex();
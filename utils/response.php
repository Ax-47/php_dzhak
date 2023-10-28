<?php

function ResponseError(string $e,string $path="") {
    header("location: https://".$_SERVER["HTTP_HOST"]."/".$path."/"."?error=".$e);
    die();
}
function ResponseOk(string $m,string $path="") {
    header("location: https://".$_SERVER["HTTP_HOST"]."/".$path."/"."?message=".$m);
    die();
}
function ResponseNotFound() {
    header("location: https://".$_SERVER["HTTP_HOST"]."/notfound.php");
    die();
}
function ResponseErrorID(string $e,string $path="") {
    header("location: https://".$_SERVER["HTTP_HOST"]."/".$path."&error=".$e);
    die();
}
function ResponseOkID(string $m,string $path="") {
    header("location: https://".$_SERVER["HTTP_HOST"]."/".$path."&message=".$m);
    die();
}
<?php
function ResponseErrorWithID(string $e,string $path)  {
    header("location: https://".$_SERVER["HTTP_HOST"].$path."&error=".$e);
    die();
}
function ResponseError(string $e,string $path)  {
    header("location: https://".$_SERVER["HTTP_HOST"].$path."?error=".$e);
    die();
}
function ResponseOk(string $m,string $path)  {
    header("location: https://".$_SERVER["HTTP_HOST"].$path);
    die();
}
function ResponseNotFound()  {
    header("location: https://".$_SERVER["HTTP_HOST"]."/notfound.php");
    die();
}
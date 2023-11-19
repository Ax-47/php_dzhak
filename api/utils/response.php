<?php
class Response{
    private string $path;
    private int $id;
    function __construct(string $path="",int $id=-1){
        $this->path=$path;
        $this->id=$id;
    }
    function ReaponseError(string $error){
        if ($this->id === -1)
            header("location: https://".$_SERVER["HTTP_HOST"]."/".$this->path."?error=".$error);
        else
            header("location: https://".$_SERVER["HTTP_HOST"]."/".$this->path."?id=".$this->id."&error=".$m);
        return exit;
    }
    function ReaponseNotFound(){
        header("location: https://".$_SERVER["HTTP_HOST"]."/notfound.php");
        return exit;
    }
    function ReaponseOk(string $m){
        if ($this->id === -1)
            header("location: https://".$_SERVER["HTTP_HOST"]."/".$this->path."?messge=".$m);
        else
            header("location: https://".$_SERVER["HTTP_HOST"]."/".$this->path."?id=".$this->id."&messge=".$m);
        return exit;
    }
}
function ReaponseRedectToIndex(){
    header("location: https://".$_SERVER["HTTP_HOST"]."/");
    return exit;
}
function ReaponseNotFound(){
    header("location: https://".$_SERVER["HTTP_HOST"]."/notfound.php");
    return exit;
}
<?php
if($_SERVER["REQUEST_METHOD"]=="POST") {
    if(empty($_POST["nick"]) or empty($_POST["content"]))
        die("<h1 style=\"color: red;\">请输入</h1>");
}
?>
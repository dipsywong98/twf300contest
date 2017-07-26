<?php
    setcookie('login', null, -1, '/');
    setcookie("ehash",null,-1,"/");
    setcookie("usr",null,-1,"/");
    header("Location: ../index.php");
    die();
?>
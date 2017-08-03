<?php

//    setcookie('login', null, -1, '/');
//    setcookie("ehash",null,-1,"/");
//    setcookie("usr",null,-1,"/");
//    setcookie("third",null,-1,"/");
    session_start();
    unset($_SEESION['valid']);
    unset($_SESSION['timeout']);
    unset($_SESSION['usr']);
    unset($_SESSION['hash']);
    redirect("index.php");

function redirect($url){
    echo '
        <script>
            var para = document.createElement("a");
            para.href="'.$url.'";
            para.click();
        </script>
    ';
}
?>
<?php

    setcookie('login', null, -1, '/');
    setcookie("ehash",null,-1,"/");
    setcookie("usr",null,-1,"/");
    setcookie("third",null,-1,"/");
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
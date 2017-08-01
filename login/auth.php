<?php

include "../includes/helper.php";

if(!isLogin()){
    redirect("index.php");
}
if(isThirdAuth()) redirect("../");



?>
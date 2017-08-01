<?php

include "includes/helper.php";

if(!isLogin())
    redirect("../login");
else{
    if(!isAdmin()){
        alert("你未獲得授權");
        redirect("../");
        die();
    }
}

$submits = $db->all("submits");

$users = $db->all("usr");

$votes = $db->all("votes");

?>

<html>
<head>
    <title>控制台 - 300容量挑戰賽</title>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script>
    <?php
        if(isset($submits)){
            $js_array = json_encode($submits);
            echo "var submits = ". $js_array . ";\n";
        }
        else{
            echo "var submits = [];";
        }
        if(isset($users)){
            $js_array = json_encode($users);
            echo "var users = ". $js_array . ";\n";
        }
        else{
            echo "var users = [];";
        }
        if(isset($votes)){
            $js_array = json_encode($votes);
            echo "var votes = ". $js_array . ";\n";
        }
        else{
            echo "var votes = [];";
        }
    
    ?>
        
        console.log(submits);
        console.log(users);
        console.log(votes);
    </script>
</head>
</html>

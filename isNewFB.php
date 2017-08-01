<?php

include "includes/helper.php";

if(!isset($_GET["fbid"]))die();

if ($db->numberOf("third_party_auth","third_party_ac",$_GET["fbid"]."@facebook.com")){
    echo 0;
}
else echo 1;

?>
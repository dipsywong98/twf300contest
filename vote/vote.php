<?php

require "../includes/helper.php";

$ip = get_client_ip();
$submit = $db->select("submits","mission_id","-1","!=");
$hash = $submit["hash"];
$photo_type = $submit["photo_type"];
$twf_name = $submit["twf_name"];
$mission_id = $submit["mission_id"];
?>
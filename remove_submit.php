<?php

require "includes/helper.php";

if(!isLogin()){
    redirect("login");
}
if(!isAdmin()){
    alert("you are not authorized");
    redirect("index.php");
}

if(!isset($_GET["hash"])){
    die();
}

$hash = $_GET["hash"];

if(!$db->numberOf("usr","hash",$hash)){
    alert("user with hash ".$hash." does not exist");
    die();
}

if(!$db->numberOf("submits","hash",$hash)){
    alert("user with hash ".$hash." does not have submission yet!");
    die();
}

$usr = $db->select("usr","hash",$hash);

$tables = ["submits","votes","publishing"];

foreach($tables as $table){
    remove($table);
}
//
//$sql="DELETE FROM votes WHERE `voter_hash` = ".hash;
//    $stmt = $conn->prepare($sql);
//    $stmt->execute([]);

rmdir_recursive("uploads/".$hash);

alert("user ".$usr["username"]." with hash as ".$hash." successfully deleted");

function remove($table){
    $db = $GLOBALS["db"]; 
    $conn = $GLOBALS["conn"]; 
    $hash = $GLOBALS["hash"];
    $sql="DELETE FROM ".$table." WHERE `hash` = '".$hash."'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([]);
}
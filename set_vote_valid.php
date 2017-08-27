<?php
require 'includes/helper.php';

if(!isLogin())
    redirect("login");
else{
    if(!isAdmin()){
        alert("你未獲得授權");
        redirect("index.php");
        die();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hash = $_POST['hash'];
    $voter_hash = $_POST['voter_hash'];
    
    $vote = $db->selectParams('votes',[
        "hash"=>$hash,
        "voter_hash"=>$voter_hash
    ]);
    
    if(!count($vote)){
        echo '-1';
        die();
    }
    
    $is_valid = $vote[0]["is_valid"];
    
    $sql = 'UPDATE votes SET is_valid = :is_valid WHERE hash = :hash AND voter_hash = :voter_hash';
    $conn->prepare($sql)->execute([
        "hash" => $hash,
        "voter_hash" => $voter_hash,
        "is_valid" => !$is_valid
    ]);
    
    $is_valid = $db->selectParams('votes',[
        "hash"=>$hash,
        "voter_hash"=>$voter_hash
    ])[0]["is_valid"];
    
    echo $is_valid;
}
else {
    echo '-1';
    die();
}
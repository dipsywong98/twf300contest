<?php
require "includes/helper.php";

if(isset($_GET["hash"])){
    $hash = $_GET["hash"];
    $sql = "SELECT mark_experience, mark_art, mark_content, mark_tech, mark_creative, comment FROM votes WHERE is_valid=1 AND hash='".$hash."'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    PrintArray($result);
}

function PrintArray($array){
    echo json_encode($array, JSON_PRETTY_PRINT);
}
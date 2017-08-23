<?php

//echo time();

if(!isLogin())
    redirect("../login");
else{
    if(!isAdmin()){
        alert("你未獲得授權");
        redirect("../");
        die();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $hash = $_POST["hash"];
    
    if($_POST["mission_id"]==""){
        alert("請輸入任務代碼");
        redirect("");
        die();
    }
    if($_POST["mission_id"]!=$_POST["mission_id_prove"]){
        alert("兩個任務代碼不相等");
        redirect("");
        die();
    }
    
    
    $mission_id = $_POST["mission_id"];
    $foul = $_POST["foul"];
    $db->update("submits",$hash,[
        "mission_id"=>$mission_id,
        "publish_time"=>time(),
        "foul"=>$foul
    ]);
//    $db->delete("publishing",$hash);
    
    alert("success!");
    redirect("../");
}


if(isset($_GET["hash"])){
    $hash = $_GET["hash"];
    $submit = $db->select("submits","hash",$hash);
}
else{
    if($db->numberOf("submits","mission_id","-1")==0){
        alert("no submition need publish now");
        redirect("../");
    }
    $submit = $db->select("submits","mission_id","-1");
}

$twf_name = $submit["twf_name"];
$hash = $submit["hash"];
$photo_type = $submit["photo_type"];
$comment = $submit["comment"];

function isExpired($record){
    return time()>$record["expire"];
}

?>
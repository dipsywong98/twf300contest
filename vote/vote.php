<?php

require "../includes/helper.php";

$ip = get_client_ip();
$voter_hash = getLoginUserHash();
$submits = $db->selectAll("submits","mission_id","-1","!=");

$marks = [];

//push all potential missions
foreach($submits as $submit){
    
    $hash = $submit["hash"];
    
    //no 自評
    if($hash == $voter_hash) continue;
    //no 重評
    if(count($db->selectParams("votes",["voter_hash"=>$voter_hash,"hash"=>$hash]))!=0) continue;
    
    
    //the higher mark, the more unwilling the system want to let this guy play the cooresponding mission
    //mark = number of this mission played * (number of times this ip play this mission +1)
    //ummm.. it is almost impossible for a single ip to play same mission twice
    $mark = $db->numberOf("votes","hash",$hash);
    $this_ip_played_time = count($db->selectParams("votes",["ip"=>$ip,"hash"=>$submit["hash"]]));
    $mark *= $this_ip_played_time+1;
    
    $marks[$hash]=$mark;
}

if(count($marks)==0){
    alert("已經沒有可供評分的作品");
    redirect("../");
}

sort($marks);
$hash = "";
foreach ($marks as $key => $value) {
    $hash = $key;
    break;
}

$submit = $db->select("submits","hash",$hash);

$hash = $submit["hash"];
$photo_type = $submit["photo_type"];
$twf_name = $submit["twf_name"];
$mission_id = $submit["mission_id"];
?>
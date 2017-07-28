<?php

require "../includes/helper.php";

if(!isLogin()){
    redirect("../login");
}

$ip = get_client_ip();
$voter_hash = getLoginUserHash();
$submits = $conn->query("SELECT * FROM submits");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db->insert("votes",[
        "hash"=>$_POST["hash"],
        "voter_hash"=>$voter_hash,
        "voter_ip"=>$ip,
        "mark_experience"=>$_POST["mark_experience"],
        "mark_balance"=>$_POST["mark_balance"],
        "mark_art"=>$_POST["mark_art"],
        "mark_content"=>$_POST["mark_content"],
        "mark_tech"=>$_POST["mark_tech"],
        "mark_story"=>$_POST["mark_story"],
        "mark_creative"=>$_POST["mark_creative"],
        "comment"=>$_POST["comment"]
    ]);
}

$marks = [];

//push all potential missions
foreach($submits as $submit){
    
    $hash = $submit["hash"];
    
    if($submit["mission_id"]==-1){
        continue;
    }
    
    //no 自評
    if($hash == $voter_hash) {
        //echo "自評";
        continue;
    }
    //no 重評
    if(count($db->selectParams("votes",["voter_hash"=>$voter_hash,"hash"=>$hash]))!=0) {
        //echo "重平";
        continue;
    }
    
    //the higher mark, the more unwilling the system want to let this guy play the cooresponding mission
    //mark = number of this mission played * (number of times this ip play this mission +1)
    //ummm.. it is almost impossible for a single ip to play same mission twice
    $mark = $db->numberOf("votes","hash",$hash);
    $this_ip_played_time = count($db->selectParams("votes",["voter_ip"=>$ip,"hash"=>$submit["hash"]]));
    $mark *= $this_ip_played_time+1;
    
    $marks[$hash]=$mark;
    
    //echo $hash."分數".$mark."<br>";
}

//echo "<br>total ".count($marks)."<br>";

if(count($marks)==0){
    alert("已經沒有可供評分的作品");
    redirect("../");
}

//echo "<br> marks".print_r($marks);
asort($marks);
//echo "<br> marks".print_r($marks);
$hash = "";
foreach ($marks as $key => $value) {
    $hash = $key;
    //echo $hash;
    break;
}

//echo $hash;

$submit = $db->select("submits","hash",$hash);

$hash = $submit["hash"];
$photo_type = $submit["photo_type"];
$twf_name = $submit["twf_name"];
$mission_id = $submit["mission_id"];



?>
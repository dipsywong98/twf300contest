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
    
    alert("成功遞交");
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

asort($marks);

$mission_list = [];
$i=0;

foreach ($marks as $key => $value) {
    $obj = $db->select("submits","hash",$key);
    $obj["mark"] = $value;
    $mission_list[$i]=$obj;
    if(++$i>=3)break;
}

?>

<html>
<head>
    <title>評分 - 300容量挑戰賽</title>
    <script type='text/javascript'>
    <?php
    $js_array = json_encode($mission_list);
    echo "var missions = ". $js_array . ";\n";
    ?>
    </script>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script>
        
       
        
        window.onload=function(){
            
            var select = $("#selects")[0];
            
            for (var i=0; i<missions.length;i++){
                
                var inp = document.createElement("input");inp.type="radio";inp.name="hash";inp.value=missions[i].hash;
                var lbl = document.createElement("label");
                var img = document.createElement("img");img.src="../uploads/"+missions[i].hash+"/"+missions[i].hash+"."+missions[i].photo_type;
                img.style.height="300px";
                inp.addEventListener("click",function(e){
                    $("[type='submit']").click();
                })
                lbl.appendChild(img);
                lbl.appendChild(inp);
                select.appendChild(lbl);
            }
        }
    </script>
    <style>
        label > input{ /* HIDE RADIO */
            visibility: hidden; /* Makes input not-clickable */
            position: absolute; /* Remove input from document flow */
        }
    
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data" action='vote.php'>
        <div id="selects"></div>
        <input type="submit" value="submit" name="submit">
    </form>
</body>
</html>
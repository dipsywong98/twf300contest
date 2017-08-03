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
        "vote_time"=>time(),
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
    <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.indigo-pink.min.css">
      <script src="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Square card -->
<style>
.demo-card-square.mdl-card {
  width: 320px;
  height: 320px;
}
.demo-card-square > .mdl-card__title {
  color: #fff;
  background:
    url('../assets/demos/dog.png') 100% no-repeat #46B6AC;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    text-shadow: 1px 1px 3px #000000;
}
</style>
    <script>
        
       function newElement(parent,element,class_list){
            _x = document.createElement(element);
            class_list = class_list.split(" ");
            for (var i=0; i<class_list.length; i++){
                _x.classList.add(class_list[i]);
            }
            parent.appendChild(_x);
            console.log(parent,_x);
            return _x; 
        }
        
        function newSquareCard(parent,title,text,url,hash){
            _c = newElement(parent,"div","demo-card-square mdl-card mdl-shadow--2dp");
            var a = newElement(_c,"div","mdl-card__title mdl-card--expand");
            a.style.backgroundImage = "url('"+url+"')";
            var h = newElement(a,"h2","mdl-card__title-text");
            h.innerHTML = title;
            a = newElement(_c,"div","mdl-card__supporting-text");
            a.innerHTML = text;
            a = newElement(_c,"div","mdl-card__actions mdl-card--border");
            h = newElement(a,"a","mdl-button mdl-button--colored mdl-js-ripple-effect mdl-js-button");
            h.innerHTML = "PLAY";
            h.addEventListener("click",function(e){
                $("[name='hash']")[0].value = hash;
                    $("[type='submit']").click();
                })
            return _c;
        }
        
        window.onload=function(){
            
//            var tr = newElement($("#selects")[0],"div","mdl-cell mdl-cell--4-col");
            for (var i=0; i<missions.length;i++){
                var td= newElement($("#selects")[0],"div","mdl-cell mdl-cell--4-col");
                newSquareCard(td,missions[i].twf_name,"","../uploads/"+missions[i].hash+"/"+missions[i].hash+"."+missions[i].photo_type,missions[i].hash);
            }
            
//            var select = $("#selects")[0];
//            
//            var tr = document.createElement("tr");
//            
//            for (var i=0; i<missions.length;i++){
//                var td = document.createElement("td");
//                var inp = document.createElement("input");inp.type="radio";inp.name="hash";inp.value=missions[i].hash;
//                var lbl = document.createElement("label");
//                var img = document.createElement("img");img.src="../uploads/"+missions[i].hash+"/"+missions[i].hash+"."+missions[i].photo_type;
//                img.style.height="300px";
//                inp.addEventListener("click",function(e){
//                    $("[type='submit']").click();
//                })
//                lbl.appendChild(img);
//                lbl.appendChild(inp);
//                td.appendChild(lbl);
//                tr.appendChild(td);
//            }
//            select.appendChild(tr);
//            tr = document.createElement("tr");
//            for(var i=0; i<missions.length;i++){
//                var td = document.createElement("td");
//                var p = document.createElement("p");
//                p.textContent = missions[i].twf_name;
//                td.appendChild(p);
//                tr.appendChild(td);
//            }
//            select.appendChild(tr);
        }
    </script>
    <style>
        label > input{ /* HIDE RADIO */
            visibility: hidden; /* Makes input not-clickable */
            position: absolute; /* Remove input from document flow */
        }
        .mdl-grid.center-items {
          justify-content: center;
        }
    
    </style>
</head>
<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "../nav_bar.php";?>
        <main>
    <div class="mdl-grid center-items" id="selects">
    
    </div>
    <form method="post" enctype="multipart/form-data" action='vote.php'>
        <input type="hidden" value="" name="hash">
        <input type="submit" value="submit" name="submit" style="visibility: hidden;">
    </form>
        </main>
    </div>
</body>
</html>
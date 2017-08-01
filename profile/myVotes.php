<?php
require "../includes/helper.php";

$missions = [];

if($db->numberOf("votes","voter_hash",getLoginUserHash())){
    $votes = $db->selectAll("votes","voter_hash",getLoginUserHash());
    foreach($votes as $vote){
        array_push($missions,$db->select("submits","hash",$vote["hash"]));
    }
}
else{
    alert("你沒有投過票");
}

?>

<html>
<head>
    <title>我的投票 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/scheme.js"></script>
    <script>
    <?php
        if(isset($votes)){
            $js_array = json_encode($votes);
            echo "var votes = ". $js_array . ";\n";
            $js_array = json_encode($missions);
            echo "var missions = ". $js_array . ";\n";
        }
        else{
            echo "var votes = [];";
        }
    
    ?>
    </script>
    <script>
        window.onload = function(){
        
        var tb = $("#tb")[0];
        var tr = document.createElement("tr");
        var td = document.createElement("td");
        td.textContent = "任務名稱";
        tr.appendChild(td);
        td = document.createElement("td");
        td.textContent = "平均分";
        tr.appendChild(td);
        for(var i=0;i<scheme.length;i++){
            td = document.createElement("td");
            td.textContent = scheme[i].text;
            tr.appendChild(td);
        }
        td = document.createElement("td");
        td.textContent = "評語";
        tr.appendChild(td);
        tb.appendChild(tr);
        
            var avg = document.createElement("td");
            var av= 0;
        for (var j=0; j<votes.length; j++){
            
            tr = document.createElement("tr");
            td = document.createElement("td");
            
            td.textContent = missions[j]["twf_name"];
            tr.appendChild(td);
            tr.appendChild(avg);
            for(var i=0;i<scheme.length;i++){
                var td = document.createElement("td");
                av+=votes[j]["mark_"+scheme[i].name];
                td.textContent = votes[j]["mark_"+scheme[i].name];
                tr.appendChild(td);
            }
            var td = document.createElement("td");
            td.textContent = votes[j]["comment"];
            tr.appendChild(td);
            tb.appendChild(tr);
            avg.textContent = av/scheme.length;
        }
        }
    </script>
    
</head>
    <h2>投票資訊</h2>
    <table id="tb">
    
    </table>
    
    
</html>
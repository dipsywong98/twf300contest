<?php
require "../includes/helper.php";

if($db->numberOf("submits","hash",getLoginUserHash())){
    $submit = $db->select("submits","hash",getLoginUserHash());
    $votes = $db->selectAll("votes","hash",getLoginUserHash());
}
else{
    alert("你沒有遞交過作品");
}

?>

<html>
<head>
    <title>我的作品 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/scheme.js"></script>
    <script>
    <?php
        if(isset($votes)){
            $js_array = json_encode($votes);
            echo "var votes = ". $js_array . ";\n";
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
        td.textContent = "id";
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
            
            td.textContent = j;
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
    <?php require "../nav_bar.php";?>
    <h2>作品資訊</h2>
    <table id="tb">
    
    </table>
    
    
</html>
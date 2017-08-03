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
    <script src="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js"></script>
		<link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.indigo-pink.min.css">
		<!-- Material Design icon font -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="../js/scheme.js"></script>
    <script src="../js/list.min.js"></script>
    <script src="../js/sortable.min.js"></script>
    <script src="../js/helper.js"></script>
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
    
</head>
    <h2>我的投票</h2>
    <div id="xd"><script>newVoteTable($("#xd")[0],votes,missions)</script></div>
<!--
    <table class="sortable" data-sortable>
        <thead></thead>
        <tbody></tbody>
    </table>
-->
    
    
</html>
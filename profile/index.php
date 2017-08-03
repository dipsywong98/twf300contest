<?php
require "../includes/helper.php";

$missions = $recieves = $votes = [];

if($db->numberOf("votes","voter_hash",getLoginUserHash())){
    $votes = $db->selectAll("votes","voter_hash",getLoginUserHash());
    foreach($votes as $vote){
        array_push($missions,$db->select("submits","hash",$vote["hash"]));
    }
}
if($db->numberOf("submits","hash",getLoginUserHash())){
    $submit = $db->select("submits","hash",getLoginUserHash());
    $recieves = $db->selectAll("votes","hash",getLoginUserHash());
//    print_r($recieves);
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
        
            $js_array = json_encode($votes);
            echo "var votes = ". $js_array . ";\n";
            $js_array = json_encode($missions);
            echo "var missions = ". $js_array . ";\n";
        
            
            
            $js_array = json_encode($recieves);
            echo "var recieves = ". $js_array . ";\n";
    
    ?>

        </script>
<!--
<style>
        
        .center-items {
          justify-content: center;
        }
    
    </style>
-->
    </head>
        
        
    <body>
        
    <main class="mdl-layout__content">    
        <div style="align:center;">
         <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar">
               <a href="#tab1-panel" class="mdl-tabs__tab is-active">我的作品</a>
               <a href="#tab2-panel" class="mdl-tabs__tab">我的投票</a>
            </div>
            <div class="mdl-tabs__panel is-active" id="tab1-panel">
               <div id="lol">
        <script>
            newVoteTable($("#lol")[0], recieves, "")

        </script>
    </div>
            </div>
            <div class="mdl-tabs__panel" id="tab2-panel">
               <div id="xd">
        <script>
            newVoteTable($("#xd")[0], votes, missions)

        </script>
    </div>
            </div>
         </div>  
        </div>
	  </main>  
    </body>


    </html>

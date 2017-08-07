<?php

include "includes/helper.php";

if(!isLogin())
    redirect("login");
else{
    if(!isAdmin()){
        alert("你未獲得授權");
        redirect("index.php");
        die();
    }
}

$submits = $db->all("submits");

$users = $db->all("usr");

$votes = $db->all("votes");

?>

<html>
<head>
    <title>控制台 - 300容量挑戰賽</title>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/scheme.js"></script>
    <script src="js/list.min.js"></script>
    <script src="js/sortable.min.js"></script>
    <script src="js/dialog-polyfill.js"></script>
    <link rel="stylesheet" href="css/dialog-polyfill.css" />
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-red.min.css" />
      <script src="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="control_panel.js"></script>
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
    body    {overflow-x:scroll;}
</style>
    <script>
    <?php
        if(isset($submits)){
            $js_array = json_encode($submits);
            echo "var submits = ". $js_array . ";\n";
        }
        else{
            echo "var submits = [];";
        }
        if(isset($users)){
            $js_array = json_encode($users);
            echo "var users = ". $js_array . ";\n";
        }
        else{
            echo "var users = [];";
        }
        if(isset($votes)){
            $js_array = json_encode($votes);
            echo "var votes = ". $js_array . ";\n";
        }
        else{
            echo "var votes = [];";
        }
    
    ?>
        
        console.log(submits);
        console.log(users);
        console.log(votes);
        
        
        
        window.onload =function(){
            var submits_view = $("#tab1-panel")[0];
            
            
        }
        
    </script>
</head>
    <body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "nav_bar.php";?>
        
      <main class="mdl-layout__content">    
          <dialog class="mdl-dialog">
              <p id="dialog-content" style="word-wrap:break-word;"></p>
      <button type="button" class="mdl-button close">關閉</button>
  </dialog>
         <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar">
               <a href="#submits-panel" class="mdl-tabs__tab is-active">作品</a>
               <a href="#usr-panel" class="mdl-tabs__tab">用戶</a>
               <a href="#vote-panel" class="mdl-tabs__tab">投票</a>
            </div>
            <div class="mdl-tabs__panel is-active" id="submits-panel">
               <script>newTable($("#submits-panel")[0],submits,"submits")</script>
            </div>
            <div class="mdl-tabs__panel" id="usr-panel">
               <script>newTable($("#usr-panel")[0],users)</script>
            </div>
            <div class="mdl-tabs__panel" id="vote-panel">
               <script>newTable($("#vote-panel")[0],votes,"votes")</script>
            </div>
         </div>
	  </main>
    </div>
   </body>
</html>

<?php

include "includes/helper.php";

if(!isLogin())
    redirect("login");
else{
    if(!isAdmin()){
        alert("你未獲得授權");
        redirect("");
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
    url('../assets/demos/dog.png') bottom right 15% no-repeat #46B6AC;
}
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
        
        function newSquareCard(parent,title,text,url){
            _c = newElement(parent,"div","demo-card-square mdl-card mdl-shadow--2dp");
            var a = newElement(_c,"div","mdl-card__title mdl-card--expand");
            a.style.backgroundImage = "url('"+url+"')";
            var h = newElement(a,"h2","mdl-card__title-text");
            h.innerHTML = title;
            a = newElement(_c,"div","mdl-card__supporting-text");
            a.innerHTML = text;
            a = newElement(_c,"div","mdl-card__actions mdl-card--border");
            h = newElement(_c,"a","mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect");
            h.innerHTML = "BUTTON";
            return _c;
        }
        
        window.onload =function(){
            newSquareCard($("#tab1-panel")[0],"testestt","lorem ipsum","https://topick.hket.com/res/v3/image/content/1870000/1870712/KakaoTalk_20170801_181430217_1024.jpg");
        }
        
    </script>
</head>
    <body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
          
      <main class="mdl-layout__content">    
         <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar">
               <a href="#tab1-panel" class="mdl-tabs__tab is-active">作品</a>
               <a href="#tab2-panel" class="mdl-tabs__tab">用戶</a>
               <a href="#tab3-panel" class="mdl-tabs__tab">投票</a>
            </div>
            <div class="mdl-tabs__panel is-active" id="tab1-panel">
               
            </div>
            <div class="mdl-tabs__panel" id="tab2-panel">
               
            </div>
            <div class="mdl-tabs__panel" id="tab3-panel">
               
            </div>
         </div>
	  </main>
    </div>
   </body>
</html>

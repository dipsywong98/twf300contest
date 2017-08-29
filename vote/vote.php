<?php

require "../includes/helper.php";

if(!isLogin()){
    redirect("../login");
}
else if(!isThirdAuth()) redirect("../login/auth.php");

$ip = get_client_ip();
$voter_hash = getLoginUserHash();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $hash = $_POST["hash"];

    $submit = $db->select("submits","hash",$hash);

    $hash = $submit["hash"];
    $photo_type = $submit["photo_type"];
    $twf_name = $submit["twf_name"];
    $mission_id = $submit["mission_id"];
    
    if($mission_id=="-1"||$mission_id=="-2"){
        redirect("../publish?hash=".$hash);
    }
    
    if(isset($submit["time_min"])){
        $time_min = $submit["time_min"];
    }
    else{
        $time_min = 0;
    }
}
else{
    redirect("index.php");
}

if($hash == getLoginUserHash()){
    alert("請勿自評");
    redirect("index.php");
}

?>


<!DOCTYPE HTML>
<html>
<head>
    <title>作品評分 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script>
        var time_min = <?php echo $time_min;?>;
    </script>
    <script src="vote.js"></script>
    <script src="../js/browser.js"></script>
    <style>
    .section{
            position: absolute;
        top:15%;
  width: 100%;
  text-align: center;
        }
        .section-text{
            display: inline-block;
            max-width: 800px;
            width:600px;
            margin-bottom: 100px;
              margin-left: 25%;
            margin-right: 25%;
              padding-left: 24px;
            padding-bottom: 24px;
            padding-right: 24px;
              text-align: left;
        }
    
    </style>
</head>

<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "../nav_bar.php";?>
        
        <?php 
        if(isAdmin()){
            $url = "../uploads/".$hash."/".$hash.".twf";
            echo '<iframe id="my_iframe" style="display:none;"></iframe>
            <script>
function Download() {
    
    if(isIE){
        window.alert("不支援IE，請下載Chrome或Firefox");
    }
    if(isChrome==false){
        document.getElementById("my_iframe").src = "'.$url.'";    
    }
    
    var link = document.createElement("a");
        link.href = "'.$url.'";
    link.setAttribute("download","'.$hash.'.twf");
    link.click();
};
</script>';
            
        }?>
        <?php
    if(count($db->selectParams("votes",["hash"=>$hash,"voter_hash"=>getLoginUserHash()]))){
        $vote = $db->selectParams("votes",["hash"=>$hash,"voter_hash"=>getLoginUserHash()])[0];
        echo '
        <script>
        function load(){
        var vote = '.json_encode($vote).';
        for(var i=0;i<scheme.length;i++){
            document.getElementById("mark_"+scheme[i].name).value=vote["mark_"+scheme[i].name];
        }
        }
        </script>
        ';
    }
    else{
        echo'
        <script>
        function load(){}
        </script>
        ';
    }
    ?>

    <main class="mdl-layout__content">  
        <div class="section">
        <div class="section-text mdl-shadow--8dp">
            
    <h2>作品評分</h2>
        
<!--    <img width="300px" src="../uploads/<?php echo $hash."/".$hash.".".$photo_type;?>"/>-->
    
    <p>作品名稱：<?php echo $twf_name;?></p>
    <p>作家編號：<?php echo $hash;?></p>
    <p>任務代碼：<?php echo $mission_id;?></p>
    
    <iframe src="<?php echo getGameUrl($mission_id);?>" width="610px" height="510px" style="border:0px;text-align:left"></iframe>
            <a href="<?php echo getGameUrl($mission_id);?>" target="_blank" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-js-ripple-effect">如果無法載入，點我前往遊玩</a>
    <?php if(isAdmin()) echo '<button onclick="Download()" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-js-ripple-effect">Admin專用：下載原檔</button>'?>
    <hr>
    <h2>遊玩結束後請填評分</h2>
    <a href="https://lh3.google.com/u/0/d/0B2wxG8U_9xycTU1zUDdIS2VSaFE=w1360-h638-iv1" target="_blank"><img src="https://drive.google.com/uc?export=download&id=0B2wxG8U_9xycTU1zUDdIS2VSaFE" style="width:600px"></a>
    <form method="post" enctype="multipart/form-data" action='index.php'>
        <p id="desciptor"></p>
        
        <input type="hidden" name="hash" value="<?php echo $hash;?>">
        
        <table id="mark_items"></table>
        <p>平均分：<span id="avg">0</span>分</p>
        <p>評語</p>
        <textarea name="comment"><?php if(isset($vote))echo $vote["comment"];?></textarea>
        <br><br>
        
        <p id="text"></p>
    </form>
            </div>
        </div>
        </main>
    </div>
    
</body>
</html>
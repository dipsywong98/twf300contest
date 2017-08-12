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
    
    if($mission_id=="-1"){
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
    <main class="mdl-layout__content">  
        <div class="section">
        <div class="section-text mdl-shadow--8dp">
            
    <h2>作品評分</h2>
        
<!--    <img width="300px" src="../uploads/<?php echo $hash."/".$hash.".".$photo_type;?>"/>-->
    
    <p>作品名稱：<?php echo $twf_name;?></p>
    <p>作家編號：<?php echo $hash;?></p>
    
    <iframe src="<?php echo getGameUrl($mission_id);?>" width="610px" height="510px" style="border:0px;text-align:left"></iframe>
    
    <hr>
    <h2>遊玩結束後請填評分</h2>
    
    <form method="post" enctype="multipart/form-data" action='index.php'>
        <p id="desciptor"></p>
        
        <input type="hidden" name="hash" value="<?php echo $hash;?>">
        
        <table id="mark_items"></table>
        <p>平均分：<span id="avg">0</span>分</p>
        <p>評語</p>
        <textarea name="comment"></textarea>
        <br><br>
        
        <p id="text"></p>
    </form>
            </div>
        </div>
        </main>
    </div>
</body>
</html>
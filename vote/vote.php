<?php

require "../includes/helper.php";

if(!isLogin()){
    redirect("../login");
}

$ip = get_client_ip();
$voter_hash = getLoginUserHash();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $hash = $_POST["hash"];

    $submit = $db->select("submits","hash",$hash);

    $hash = $submit["hash"];
    $photo_type = $submit["photo_type"];
    $twf_name = $submit["twf_name"];
    $mission_id = $submit["mission_id"];
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
    <script src="vote.js"></script>
    
</head>

<body>
    
    <h2>作品評分</h2>
        
<!--    <img width="300px" src="../uploads/<?php echo $hash."/".$hash.".".$photo_type;?>"/>-->
    
    <p>作品名稱：<?php echo $twf_name;?></p>
    <p>作家編號：<?php echo $hash;?></p>
    
    <iframe src="<?php echo getGameUrl($mission_id);?>" width="610px" height="510px" style="border:0px;"></iframe>
    
    <hr>
    <h2>遊玩結束後請填評分</h2>
    
    <form method="post" enctype="multipart/form-data" action='index.php'>
        <p id="desciptor"></p>
        
        <input type="hidden" name="hash" value="<?php echo $hash;?>">
        
        <table id="mark_items"></table>
        
        <p>評語</p>
        <textarea name="comment"></textarea>
        <br><br>
    </form>
</body>
</html>
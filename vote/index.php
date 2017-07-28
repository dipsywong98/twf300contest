<!DOCTYPE HTML>
<html>
<head>
    <title>作品評分 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="vote.js"></script>
    
</head>

<body>
    <?php require 'vote.php'; ?>
    
    <h2>作品評分</h2>
        
    <img width="300px" src="../uploads/<?php echo $hash."/".$hash.".".$photo_type;?>"/>
    
    <p>作品名稱：<?php echo $twf_name;?></p>
    <p>作家編號：<?php echo $hash;?></p>
    
    <iframe src="<?php echo getGameUrl($mission_id);?>" width="610px" height="510px" style="border:0px;"></iframe>
    
    <hr>
    <h2>遊玩結束後請填評分</h2>
    
    <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
        <p id="desciptor"></p>
        
        <input type="hidden" name="hash" value="<?php echo $hash;?>">
        
        <table id="mark_items"></table>
        
        <p>評語</p>
        <textarea name="comment"></textarea>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
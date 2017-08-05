<?php
    require "submit.php";
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>報名 - 300容量挑戰賽</title>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/submit.js"></script>
    
</head>

<body>

    
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "../nav_bar.php";?>
        <main>
        <h2>300容量挑戰賽報名表</h2>
        <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
            <p>作品名稱:</p>
            <input type="text" name="twf_name" value="<?php echo $twf_name;?>">
            <br><br>

            
            <p>作品twf檔：</p>
            <input type="file" name="twf_file" id="twf_file" accept=".twf">

            <?php 
//            if($new_submit) echo '<input type="file" name="twf_file" id="twf_file" accept=".twf">';
//            else echo '<p>遞交後不能更改twf檔</p>';
            ?>
            <br><br>
            

            <p>作品圖片：</p>
            <img id="photo_preview" width="300px" 
                   <?php 
                   if(!$new_submit) 
                       echo "src='../uploads/".$hash."/".$hash.".".$photo_type."'";
                   ?>/><br>
            <input type="file" name="twf_photo" id="twf_photo" accept="image/*" >
            <br><br>
            
            <p>最短遊玩時間(秒):<br>作用：評分時，玩家過了這個秒數才可以遞交分數，請你慎重填寫(時間上限：600秒，即10分鐘)</p>
            <input type="number" name="time_min" min="0" max="600" value="<?php echo $time_min;?>">
            <br><br>
            
            <p>留言(不會被公佈，但依然需要遵守匿名等規則):</p> 
            <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
            <br><br>

            <input type="submit" name="submit" value="Submit">
        </form>
    </main>
</body>

</html>

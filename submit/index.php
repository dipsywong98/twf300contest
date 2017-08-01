<!DOCTYPE HTML>
<html>
<head>
    <title>報名 - 300容量挑戰賽</title>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/submit.js"></script>
    
</head>

<body>

    <?php
    require "submit.php";
?>

        <h2>300容量挑戰賽報名表</h2>
        <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
            <p>作品名稱:</p>
            <input type="text" name="twf_name" value="<?php echo $twf_name;?>">
            <br><br>

            
            <p>作品twf檔：</p>
            <?php 
            if($new_submit) echo '<input type="file" name="twf_file" id="twf_file" accept=".twf">';
            else echo '<p>遞交後不能更改twf檔</p>';
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
            
            <p>最短遊玩時間(秒):<br>作用：評分時，玩家過了這個秒數才可以遞交分數，請你慎重填寫</p>
            <input type="number" name="time_min" min="0" value="<?php echo $time_min;?>">
            <br><br>
            
            <p>留言(不會被公佈，但依然需要遵守匿名等規則):</p> 
            <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
            <br><br>

            <input type="submit" name="submit" value="Submit">
        </form>

</body>

</html>

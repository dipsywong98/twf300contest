<!DOCTYPE HTML>
<html>
<head>
    <title>300容量挑戰賽報名表</title>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/submit.js"></script>
<script src="js/fbservice.js"></script>
    
</head>

<body>

    <?php
    include("submit.php");
?>

        <h2>300容量挑戰賽報名表</h2>
        <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
            <p>作品名稱:</p>
            <input type="text" name="twf_name" value="<?php echo $twf_name;?>">
            <br><br>

            <p>作品twf檔：</p>
            <input type="file" name="twf_file" id="twf_file" accept=".twf">
            <br><br>

            <p>作品圖片：</p>
            <img id="photo_preview" width="300px" /><br>
            <input type="file" name="twf_photo" id="twf_photo" accept="image/*">
            <br><br>

            <p>嘎母帳號(防止匿名制下帳號被盜用)：</p>
            <input type="text" name="username" value="<?php echo $username;?>">
            <br><br> 
            
            <p>嘎母密碼(驗証身份，不會被儲存)：</p>
            <input type="password" name="password">
            <br><br> 
            
            <p>留言(不會被公佈):</p> 
            <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
            <br><br>

            <input type="submit" name="submit" value="Submit">
        </form>

</body>

</html>

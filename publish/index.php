<!DOCTYPE HTML>
<html>
<head>
    <title>公開作品 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/fbservice.js"></script>
    
    
</head>

<body>
    <?php require 'publish.php'; ?>

    <script>
    function download(url){
        var link = document.createElement('a');
        link.href = url;
        link.setAttribute('download','<?php echo $hash?>.'+url.split(".")[3]);
        link.click();
    }
    </script>
    
    <h2>公開作品</h2>
        
    <img width="300px" src="../uploads/<?php echo $hash."/".$hash.".".$photo_type;?>"/>
    
    <p>作品名稱：<?php echo $twf_name;?></p>
    <p>作家編號：<?php echo $hash;?></p>
    <p>留言：</p>
    <p><?php echo $comment;?></p>
    <p>需在<?php 
        $dt = new DateTime;
        $dt->setTimeStamp($db->select("publishing","hash",$hash)["expire"]);
        $dt->setTimeZone(new DateTimeZone("Asia/Hong_Kong"));
        echo " 香港時間".$dt->format('Y年m月d日 H:i:s (A)');
        ?>之前公開，否則會有下一名評審代為公開</p>
    <button onclick="download('<?php echo"../uploads/".$hash."/".$hash.".twf";?>')">下載twf檔</button>
    <button onclick="download('<?php echo"../uploads/".$hash."/".$hash.".".$photo_type;?>')">下載圖片檔</button>
    
    <hr>
    <h2>公開後請填寫此表</h2>
    
    <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
        
        <input type="hidden" name="hash">
        
        <p>任務代碼</p>
        <input id="input_pw" type="number" name="mission_id">
        <br><br> 
        
        <p>再輸入一次任務代碼</p>
        <input id="input_pw" type="number" name="mission_id_prove">
        <br><br> 
        
        <p>純文字檔</p>
        <input id="txt" type="file" name="txt_file" accept=".txt">
        <br><br>
        
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
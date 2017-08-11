 <?php require 'publish.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>公開作品 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/fbservice.js"></script>
    <style>
        .section{
            position: absolute;
        top:20%;
  width: 100%;
  text-align: center;
        }
        .section-text{
            display: inline-block;
            max-width: 800px;
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
    <iframe id="my_iframe" style="display:none;"></iframe>
    <script>
    function download(url){
    if(isIE){
        window.alert("不支援IE，請下載Chrome或Firefox");
    }
    if(isChrome==false){
        document.getElementById('my_iframe').src = url;    
    }
    
    var link = document.createElement('a');
        link.href = url;
    link.setAttribute('download','<?php echo $hash?>.'+url.split(".")[3]);
    link.click();
    }
    </script>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "../nav_bar.php";?>
        <main>
            <div class="section">
            <div class="section-text mdl-shadow--8dp">
                
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
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<?php
    require "submit.php";
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>報名 - 300容量挑戰賽</title>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/submit.js"></script>
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
        
.mdl-button--file input {
  cursor: pointer;
  height: 100%;
  right: 0;
  opacity: 0;
  position: absolute;
  top: 0;
  width: 300px;
  z-index: 4;
}

.mdl-textfield--file .mdl-textfield__input {
  box-sizing: border-box;
  width: calc(100% - 32px);
}
.mdl-textfield--file .mdl-button--file {
  right: 0;
}
}
    </style>
    
</head>

<body>

    
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "../nav_bar.php";?>
        <main>
            <div class="section">
            <div class="section-text mdl-shadow--8dp">
        <h2>300容量挑戰賽報名表</h2>
        <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
            
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="input_un" name="twf_name" value="<?php echo $twf_name;?>">
                <label class="mdl-textfield__label" for="input_un">作品名稱</label>
              </div>
            <br>
<div class="mdl-textfield mdl-js-textfield mdl-textfield--file">
    <input class="mdl-textfield__input" placeholder="作品twf檔" type="text" id="twf_uploadFile" readonly/>
    <div class="mdl-button mdl-button--primary mdl-button--icon mdl-button--file">
      <i class="material-icons">attach_file</i><input type="file" id="twf_file" name="twf_file" accept=".twf">
    </div>
  </div>
            <br><br>
            
<div class="mdl-textfield mdl-js-textfield mdl-textfield--file">
    <input class="mdl-textfield__input" placeholder="作品圖片" type="text" id="twf_uploadPhoto" readonly/>
    <div class="mdl-button mdl-button--primary mdl-button--icon mdl-button--file">
      <i class="material-icons">attach_file</i><input type="file" id="twf_photo" name="twf_photo" accept="image/*">
    </div>
  </div>
            <br>
            <img id="photo_preview" width="300px" 
                   <?php 
                   if(!$new_submit) 
                       echo "src='../uploads/".$hash."/".$hash.".".$photo_type."'";
                   ?>/><br>
            <br><br>
            
            <p>最短遊玩時間(秒):<br>作用：評分時，玩家過了這個秒數才可以遞交分數，請你慎重填寫</p>
            <input type="number" name="time_min" min="0" value="<?php echo $time_min;?>">
            <br><br>
            
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
  <textarea class="mdl-textfield__input" type="text" id="schools" name="comment" rows="1" cols="50"><?php echo $comment;?></textarea>
  <label class="mdl-textfield__label" for="schools">留言(不會被公佈，但依然需要遵守匿名等規則)</label>
</div>
            <br><br>
<input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit" name="submit" value="遞交">
        </form>
                </div></div>
    </main>
    </div>
</body>
<script>
    document.getElementById("twf_file").onchange = function () {
    document.getElementById("twf_uploadFile").value = this.files[0].name;
};
//    document.getElementById("twf_photo").onchange = function () {
//    document.getElementById("twf_uploadPhoto").value = this.files[0].name;
//};
    </script>
</html>

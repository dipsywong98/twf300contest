<?php require 'login.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>登入 - 300容量挑戰賽</title>
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
            max-width: 800px;
              margin-left: 25%;
              padding: 24px;
              text-align: left;
        }
    </style>
</head>

<body>
        
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "../nav_bar.php";?>
        <main>
            <div class="section">
                <div class="section-text mdl-shadow--8dp">
        <h2>登入</h2>
        <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>'>
            
            <p id="p_method">登入方式</p>
            <input type="radio" name="method" value="gamelet" checked id="rg"> <span value="gamelet" id="rg">Gamelet</span>
            <input type="radio" name="method" value="facebook" onclick="FBlogin()"> <span>Facebook</span>
            <br><br>
            
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text" id="input_un" name="username">
    <label class="mdl-textfield__label" for="input_un">gamelet id</label>
  </div>
         <br>   
<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="rg">
    <input class="mdl-textfield__input" type="text" id="input_pw" name="username">
    <label class="mdl-textfield__label" for="input_pw">gamelet password</label>
  </div>
            <br>
            <input type="hidden" name="from" value="<?php echo $from;?>">
            <input type="hidden" name="third_party_ac" value="<?php if(isset($third_part_ac))echo $third_party_ac;?>">
            <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit" name="submit" value="Submit">
        </form></div></div>
    </main></div>
</body>
</html>
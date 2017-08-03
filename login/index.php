<?php require 'login.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>登入 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/fbservice.js"></script>
</head>

<body>
        
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "../nav_bar.php";?>
        <main>
        <h2>登入</h2>
        <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>'>
            
            <p id="p_method">登入方式</p>
            <input type="radio" name="method" value="gamelet" checked> <span value="gamelet">Gamelet</span>
            <input type="radio" name="method" value="facebook" onclick="FBlogin()"> <span>Facebook</span>
            <br><br>
            
            <p>gamelet id</p>
            <input id="input_un" type="text" name="username">
            <br><br>

            <p id="pw">gamelet password</p>
            <input id="input_pw" type="password" name="password">
            <br><br> 
            
            <input type="hidden" name="from" value="<?php echo $from;?>">
            <input type="hidden" name="third_party_ac" value="<?php if(isset($third_part_ac))echo $third_party_ac;?>">
            <input type="submit" name="submit" value="Submit">
        </form>
    </main></div>
</body>
</html>
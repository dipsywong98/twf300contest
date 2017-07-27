<!DOCTYPE HTML>
<html>
<head>
    <title>登入 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/fbservice.js"></script>
    
    
</head>

<body>
        <?php require 'login.php'; ?>

        <h2>登入</h2>
        <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
            
            <p id="p_method">登入方式</p>
            <input type="radio" name="method" value="gamelet" checked> Gamelet
            <input type="radio" name="method" value="facebook" onclick="FBlogin()"> Facebook
            <br><br>
            
            <p>gamelet id</p>
            <input id="input_un" type="text" name="username">
            <br><br>

            <p>gamelet password</p>
            <input id="input_pw" type="password" name="password">
            <br><br> 

            <input type="submit" name="submit" value="Submit">
        </form>
</body>
</html>
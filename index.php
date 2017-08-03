<html>
<head>
<title>首頁 - 300容量挑戰賽</title>    
</head>
<body>
    這是首頁
    <?php 
    require "includes/helper.php";
    echo isLogin();
    ?>
    <p><a href="login/"> 登入 </a>|<a href="submit/"> 遞交 </a>|<a href="publish/"> 公開 </a>|<a href="vote/"> 評分 </a>|<a href="profile/"> 我的作品 | 我的評賞 </a>|<a href="control_panel.php"> 控制台 </a>|<a href="logout.php"> 登出 </a></p>
</body>
</html>
<html>
<head>
<title>首頁 - 300容量挑戰賽</title> 
    <style>
.demo-layout-transparent {
  background: url('../assets/demos/transparent.jpg') center / cover;
}
.demo-layout-transparent .mdl-layout__header,
.demo-layout-transparent .mdl-layout__drawer-button {
  /* This background is dark, so we set text to white. Use 87% black instead if
     your background is light. */
  color: white;
}
</style>
</head>
<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "nav_bar.php";?>
        <main>
    這是首頁
    <?php 
    require "includes/helper.php";
    echo isLogin();
    ?>
    <p><a href="login/"> 登入 </a>|<a href="submit/"> 遞交 </a>|<a href="publish/"> 公開 </a>|<a href="vote/"> 評分 </a>|<a href="profile/"> 我的作品 | 我的評賞 </a>|<a href="control_panel.php"> 控制台 </a>|<a href="logout.php"> 登出 </a></p>
    </main></div>
</body>
</html>
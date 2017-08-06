<?php
require "includes/helper.php";
?>

<html>
<head>
    <script src="js/jquery-3.2.1.min.js"></script>
<title>首頁 - 300容量挑戰賽</title> 
    <style>
.demo-layout-transparent {
  background: url("Cover.jpg") center / cover;
}
.demo-layout-transparent .mdl-layout__header,
.demo-layout-transparent .mdl-layout__drawer-button {
  color: white;
}
</style>
</head>
<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <?php require "nav_bar.php";?>
    <main>
        
      <img src="Cover.jpg" style="width:100%;height:90%;background-color:#009688">
        
<!--
        <a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="left:10%; top:90%; position: absolute">
  了解詳情
</a>
-->
            
    </main>
    </div>
</body>
</html>
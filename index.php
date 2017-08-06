<?php
require "includes/helper.php";
?>

<html>
<head>
    <script src="js/jquery-3.2.1.min.js"></script>
<title>首頁 - 300容量挑戰賽</title> 
    <style>
        .section{
  position: absolute;
  bottom: 0;
  width: 100%;
  text-align: center;
        }
        .section-text{
            max-width: 800px;
              margin-left: 25%;
              padding: 24px;
              text-align: left;
        }
.demo-card-square.mdl-card {
  width: 320px;
  height: 320px;
    margin:10px;
}
.demo-card-square > .mdl-card__title {
  color: #fff;
  background:
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    text-shadow: 1px 1px 3px #000000;
}
</style>
    <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/js/materialize.min.js"></script>
    <script>$(document).ready(function(){
      $('.carousel').carousel();
    });</script>
</head>
<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <?php require "nav_bar.php";?>
    <main>
        
        <!-- first section -->
      <img src="Cover.jpg" style="width:100%;height:90%;background-color:#009688">
        
<!--
        <a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="left:10%; top:90%; position: absolute">
  了解詳情
</a>
-->
        
        <!-- second section -->
        
        <div class="section" style="position:relative; width:100%;height:auto;
  background-color: #37474f;color:#FFFFFF">
        
            <div class="section-text"><h2>比賽引言</h2>
        <p>適逢同人陣即將步入5周年，同人技術研討中心計劃舉辦一場同人陣創作比賽。經歷了4年多的更新，小哈推出了很多幫助玩家省容量的措施，所以這場比賽有一個特別規則：只能使用基本容量，亦即是300容量，沒有音樂，沒有盟劍。另外，比賽採取匿名制，希望可以提攜一下新作家，或者不為人知的小作家。</p>
        </div>
        </div>
        
        
        <!-- Third section -->
            <div class="section" style="position:relative; background-color:#FFFFFF color:#000000;">
                
                <div class="section-text">
        <h2>比賽獎項</h2>
        <h6>主要參賽獎項(排名綜合各評分準則得分最高，包括大眾與評審團評分) </h6>

<div>第一名：點數500、頭銜 ：300容量挑戰賽冠軍</div>
<div>第二名：點數300、頭銜：300容量挑戰賽亞軍</div>
<div>第三名：點數100、頭銜 ：300容量挑戰賽季軍</div>

<h6>特別參賽獎項(只限未能獲得上面獎項)</h6>

<div>娛樂獎：娛樂性最高者，100點</div>
<div>技術獎：技術性最高者，100點</div>
<div>創意獎：最別樹一格者，100點</div>
                
                    </div>

        <div class="carousel">
            
    <div class="carousel-item">
    <div class="demo-card-square mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title mdl-card--expand" style="color: #fff;
  background:
    url('gold.png') 100% no-repeat #46B6AC;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    text-shadow: 1px 1px 3px #000000;">
        <h2 class="mdl-card__title-text">冠軍</h2>
        </div>
        <div class="mdl-card__supporting-text">
    第一名：點數500、300容量挑戰賽冠軍頭銜
  </div>
  </div>
    </div>
     <div class="carousel-item">
    <div class="demo-card-square mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title mdl-card--expand" style="color: #fff;
  background:
    url('silver.png') 100% no-repeat #46B6AC;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    text-shadow: 1px 1px 3px #000000;">
        <h2 class="mdl-card__title-text">亞軍</h2>
        </div>
        <div class="mdl-card__supporting-text">
    第二名：點數300、300容量挑戰賽亞軍頭銜
  </div>
  </div>
    </div>
    <div class="carousel-item">
    <div class="demo-card-square mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title mdl-card--expand" style="color: #fff;
  background:
    url('bronze.png') 100% no-repeat #46B6AC;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    text-shadow: 1px 1px 3px #000000;">
        <h2 class="mdl-card__title-text">季軍</h2>
        </div>
        <div class="mdl-card__supporting-text">
    第三名：點數100、300容量挑戰賽季軍頭銜
  </div>
  </div>  
 </div>
            
            <div class="carousel-item">
    <div class="demo-card-square mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title mdl-card--expand" style="color: #fff;
  background:
    url('entertain.png') 100% no-repeat #46B6AC;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    text-shadow: 1px 1px 3px #000000;">
        <h2 class="mdl-card__title-text">娛樂獎</h2>
        </div>
        <div class="mdl-card__supporting-text">
    娛樂性最高者，100點
  </div>
  </div>  
 </div>
            
            <div class="carousel-item">
    <div class="demo-card-square mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title mdl-card--expand" style="color: #fff;
  background:
    url('tech.png') 100% no-repeat #46B6AC;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    text-shadow: 1px 1px 3px #000000;">
        <h2 class="mdl-card__title-text">技術獎</h2>
        </div>
        <div class="mdl-card__supporting-text">
    技術性最高者，100點
  </div>
  </div>  
 </div>
            
            <div class="carousel-item">
    <div class="demo-card-square mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title mdl-card--expand" style="color: #fff;
  background:
    url('creative.png') 100% no-repeat #46B6AC;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    text-shadow: 1px 1px 3px #000000;">
        <h2 class="mdl-card__title-text">創意獎</h2>
        </div>
        <div class="mdl-card__supporting-text">
    最別樹一格者，100點
  </div>
  </div>  
 </div>
            
</div>
               
        </div>
        
        <!-- Forth section -->
        
    </main>
    </div>
</body>
</html>
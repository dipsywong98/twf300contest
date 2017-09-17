<?php require "includes/helper.php";?>
<html>
<head>
    <title>賽果 - 300容量挑戰賽</title>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/scheme_.js"></script>
    <script src="js/list.min.js"></script>
    <script src="js/sortable.min.js"></script>
    <script src="js/dialog-polyfill.js"></script>
    <link rel="stylesheet" href="css/dialog-polyfill.css" />
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-red.min.css" />
      <script src="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="result.js"></script>
<style>
.demo-card-square.mdl-card {
  width: 320px;
  height: 320px;
}
.demo-card-square > .mdl-card__title {
  color: #fff;
  background:
    url('../assets/demos/dog.png') 100% no-repeat #46B6AC;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    text-shadow: 1px 1px 3px #000000;
}
    body    {overflow-x:scroll;}
    .section{
    position: absolute;
        top:20%;
  width: 100%;
  text-align: center;
        }
        .section-text{
            padding:25px;
            display: inline-block;
              text-align: left;
        }
</style>
</head>
    <body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "nav_bar.php";?>
        
      <main class="mdl-layout__content">    
          <dialog class="mdl-dialog">
              <p id="dialog-content" style="word-wrap:break-word;"></p>
      <button type="button" class="mdl-button close">關閉</button>
  </dialog>
          <div class="section">
            <div class="section-text mdl-shadow--8dp">
                <h2>賽果</h2>
         <div id="d">
             <form action="#">
             <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                 <input class="mdl-textfield__input search" type="text" id="search">
                 <label class="mdl-textfield__label" for="search">搜尋</label>
                 </div>
             </form>
          <script>$.ajax({url: "get_marks.php?type=general", success: function(result){
                       console.log(result);
                       var marks = JSON.parse(result);
                        newTable($("#d")[0],marks,"marks")
                    }});</script>
                </div></div></div>
	  </main>
    </div>
   </body>
</html>
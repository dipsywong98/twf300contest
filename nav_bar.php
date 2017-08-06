<?php

require "includes/helper.php";

function print_nav_list(){
        
    if(!isLogin()){
        echo '<a class="mdl-navigation__link mdl-js-ripple-effect" href="'.getRoot().'login">登入</a>';
    }
    else{
        if(isThirdAuth()){
            echo '
    <a class="mdl-navigation__link mdl-js-ripple-effect" href="'.getRoot().'vote">評分</a>
    <a class="mdl-navigation__link mdl-js-ripple-effect" href="'.getRoot().'submit">投稿</a>
    <a class="mdl-navigation__link mdl-js-ripple-effect" href="'.getRoot().'profile">個人檔案</a>';
        if(isAdmin()){
            echo '
            <a class="mdl-navigation__link mdl-js-ripple-effect" href="'.getRoot().'publish">公開</a>
            <a class="mdl-navigation__link mdl-js-ripple-effect" href="'.getRoot().'control_panel.php">控制台</a>
            ';
        }
        }
        else{
            echo '<a class="mdl-navigation__link mdl-js-ripple-effect" href="'.getRoot().'login/auth.php">驗証</a>';
        }
      
    echo '<a class="mdl-navigation__link mdl-js-ripple-effect" href="'.getRoot().'logout.php">登出</a>';

    }
}

?>


<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-red.min.css">
<script src="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<header class="mdl-layout__header mdl-shadow--8dp">
    <div class="mdl-layout__header-row">
      <a class="mdl-layout-title mdl-navigation__link" href="<?php echo getRoot();?>index.php">300容量挑戰賽</a>
      <div class="mdl-layout-spacer"></div>
      <div class="mdl-navigation mdl-layout--large-screen-only">
        <?php print_nav_list()?>
      </div>
    </div>

</header>
<div class="mdl-layout__drawer mdl-layout--small-screen-only">
    <span class="mdl-layout-title">300容量挑戰賽</span>
    <nav class="mdl-navigation">
      <?php print_nav_list()?>
    </nav>
</div>


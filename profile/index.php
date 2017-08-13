<?php
require "../includes/helper.php";

$missions = $recieves = $votes = [];

if($db->numberOf("votes","voter_hash",getLoginUserHash())){
    $votes = $db->selectAll("votes","voter_hash",getLoginUserHash());
    foreach($votes as $vote){
        array_push($missions,$db->select("submits","hash",$vote["hash"]));
    }
}
if($db->numberOf("submits","hash",getLoginUserHash())){
    $submit = $db->select("submits","hash",getLoginUserHash());
    $recieves = $db->selectAll("votes","hash",getLoginUserHash());
//    print_r($recieves);
}
$_hash = getLoginUserHash();

?>

    <html>

    <head>
        <title>個人檔案 - 300容量挑戰賽</title>
        <script src="../js/jquery-3.2.1.min.js"></script>
        <script src="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js"></script>
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-red.min.css" />
        <!-- Material Design icon font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script src="../js/scheme_.js"></script>
        <script src="../js/list.min.js"></script>
        <script src="../js/sortable.min.js"></script>
        <script src="../js/helper.js"></script>
        <script src="../js/browser.js"></script>
        <script src="../js/dialog-polyfill.js"></script>
    <link rel="stylesheet" href="../css/dialog-polyfill.css" />
        <script>
            <?php
        
            $js_array = json_encode($votes);
            echo "var votes = ". $js_array . ";\n";
            $js_array = json_encode($missions);
            echo "var missions = ". $js_array . ";\n";
        
            
            
            $js_array = json_encode($recieves);
            echo "var recieves = ". $js_array . ";\n";
    
    ?>

            
        </script>
<style>
        
        .section{
            position: absolute;
        top:20%;
            width:100%;
  text-align: center;
        }
        .section-text{
            display: inline-block;
              text-align: left;
            padding:25px;
        }
    
    </style>
    </head>
        
        
    <body>
        <iframe id="my_iframe" style="display:none;"></iframe>
<script>
function Download() {
    var url = '../uploads/<?php echo $_hash;?>/<?php echo $_hash;?>.twf';
    if(isIE){
        window.alert("不支援IE，請下載Chrome或Firefox");
    }
    if(isChrome==false){
        document.getElementById('my_iframe').src = url;    
    }
    
    var link = document.createElement('a');
        link.href = url;
    link.setAttribute('download','<?php echo $_hash?>.'+url.split(".")[3]);
    link.click();
};
</script>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <?php require "../nav_bar.php";?>
            <dialog class="mdl-dialog">
              <p id="dialog-content" style="word-wrap:break-word;"></p>
      <button type="button" class="mdl-button close">關閉</button>
  </dialog>
    <main class="mdl-layout__content"> 
        <?php 
        if($db->numberOf("submits","hash",$_hash)==0){
            require "vote_only.php";
        }
        else{
            require "submit_vote.php";
        }
        ?>
	  </main>  
        </div>
    </body>


    </html>

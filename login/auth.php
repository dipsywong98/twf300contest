<?php

include "../includes/helper.php";

if(!isLogin()){
    redirect("index.php");
}
if(isThirdAuth()) redirect("../");

$type = $db->select("usr","username",getLoginUsername())["type"];


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($db->numberOf("usr","username",$_POST["username"]))
        if($db->select("usr","username",$_POST["username"])["type"]=="gamelet"){
            alert("你正企圖綁定一個已被綁定的嘎姆帳號");
            redirect("");
            return false;
        }
    if($db->numberOf("third_party_auth","username",$_POST["username"]))
        if($db->select("third_party_auth","username",$_POST["username"])["authentic_token"]=="success"){
            alert("你正企圖綁定一個已被綁定的嘎姆帳號");
            redirect("");
            die();
        }
    
    if(!isset($_POST["username"])){
        alert("請填上嘎姆帳號");
        redirect("");
        die();
    }
    
//    if(!str_contain($_POST["username"],"@".$type.".com")){
//        alert("嘎姆帳號必須含有 @".$type.".com");
//        redirect("");
//        die();
//    }
    
    $old_username = getLoginUsername();
    $third_party_ac = getLoginThirdPartyAc();
    
    $hash = $db->select("usr","username",$old_username)["hash"];
    
    $username = test_input($_POST["username"]);
//    echo $username;
    
    $sql = "UPDATE `usr` SET username = :username WHERE third_party_ac = :third_party_ac";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        "username"=>$username,
        "third_party_ac"=>$third_party_ac
    ]);
    $sql = "UPDATE `third_party_auth` SET username = :username WHERE third_party_ac = :third_party_ac";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        "username"=>$username,
        "third_party_ac"=>$third_party_ac
    ]);
     
    $_SESSION["usr"] = $username;
//    setcookie("third",encrypt_decrypt("encrypt",$GLOBALS["third_party_ac"],$username),-1,"/");
//    setcookie('login', null, -1, '/');
//    setcookie("ehash",encrypt_decrypt("encrypt",$hash,$username),-1,"/");
//    setcookie("usr",encrypt_decrypt("encrypt",$username,"fk is fucking handsome"),-1,"/");
    
    $user = $db->selectParams("third_party_auth",[
    "username"=>$username,
    "third_party_ac"=>getLoginThirdPartyAc(),
]);
}

else{
    $user = $db->selectParams("third_party_auth",[
    "username"=>getLoginUsername(),
    "third_party_ac"=>getLoginThirdPartyAc(),
]);
}


if(count($user)==0) {
    echo "error".getLoginUsername()."\n".getLoginThirdPartyAc();
//    alert($str);
    die();
}
$user = $user[0];

$username = $user["username"];
$third_party_ac = $user["third_party_ac"];
$token = $user["authentic_token"];
$time_min = $user["resend_time"];


if(isset($_GET["token"])){
    if($token==$_GET["token"]){
        $sql = "UPDATE `third_party_auth` SET authentic_token = 'success' WHERE username = :username AND third_party_ac = :third_party_ac";
        $stmt = $conn->prepare($sql);
        echo $stmt->execute([
            "username"=>$username,
            "third_party_ac"=>$third_party_ac
        ]);
        
        //把冒充者刪去
        $sql = "DELETE FROM `third_party_auth` WHERE username = :username AND third_party_ac != :third_party_ac";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            "username"=>$username,
            "third_party_ac"=>$third_party_ac
        ]);
        alert("成功驗証！");
        redirect("../");
        
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>

<html>
<head>
<title>綁定嘎姆 - 300容量挑戰賽</title>    
<script src="../js/jquery-3.2.1.min.js"></script>
    <script>
        function showBtn(){
    
    btn = document.createElement("a");
    btn.href = "token_resend.php";
    btn.value="重新發送";
    btn.textContent="重新發送";
    document.getElementById("text").appendChild(btn);
}
        function now(){return Math.floor(Date.now() / 1000);}
    function count(){
    window.setTimeout(function(){
        $("#text")[0].textContent = (time_min-now())+"秒後可以重新發送";
        if(time_min-now()>0){
            count();
        }else{
            $("#text")[0].textContent = "";
            showBtn();
        }
       },1000);
}
        start_time = <?php echo time();?>;
        time_min = <?php echo $time_min;?>;
        count();
    </script>
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
     <?php require "../nav_bar.php";?>
        <main>
            <div class="section">
                <div class="section-text mdl-shadow--8dp">
    <h2>你尚未綁定</h2>
    
    <p>嘎姆帳號：</p>
    <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="input_un" name="username" value="<?php echo $username;?>">
                <label class="mdl-textfield__label" for="input_un">gamelet id</label>
              </div><input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit" name="submit" value="修改">
    </form>
            請到<a href="http://tw.gamelet.com/user.do?username=<?php echo $username;?>">你的嘎姆個人網頁</a>點擊驗証網址完成驗証
            <p id="text"></p>
                </div>
            </div>
    </main>
</body>
</html>
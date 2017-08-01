<?php

include "../includes/helper.php";

if(!isLogin()){
    redirect("index.php");
}
if(isThirdAuth()) redirect("../");

$user = $db->selectParams("third_party_auth",[
    "username"=>getLoginUsername(),
    "third_party_ac"=>getLoginThirdPartyAc(),
]);

if(count($user)==0) {
    alert("error");
    die();
}
$user = $user[0];

$username = $user["username"];
$third_party_ac = $user["third_party_ac"];
$token = $user["authentic_token"];


?>

<html>
<head>
<title>綁定嘎姆 - 300容量挑戰賽</title>    
</head>
<body>
    <h2>你尚未綁定</h2>
    <p>嘎姆帳號：<?php echo $username;?></p>
    <p>第三方帳號：<?php echo $third_party_ac;?></p>
    <p>驗証碼：<?php echo $token;?></p>
    <p>用你的嘎姆帳號將驗証碼<strong>公開留言</strong>至<a href="http://tw.gamelet.com/user.do?username=twf300_2017">「300容量挑戰賽作品」</a><br>留言後請重新來到本頁，本頁將會自動驗証</p>
</body>
</html>
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
        
    setcookie("third",encrypt_decrypt("encrypt",$GLOBALS["third_party_ac"],$username),-1,"/");
    setcookie('login', null, -1, '/');
    setcookie("ehash",encrypt_decrypt("encrypt",$hash,$username),-1,"/");
    setcookie("usr",encrypt_decrypt("encrypt",$username,"fk is fucking handsome"),-1,"/");
    
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



//if the user have post the token in twf300_2017 profile page
if(tokenExist($username,$token)){
    $sql = "UPDATE `third_party_auth` SET authentic_token = 'success' WHERE username = :username AND third_party_ac = :third_party_ac";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
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

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function tokenExist($by, $tk){
//    echo $by." ".$tk."<br>";
    $url = 'http://tw.gamelet.com/user.do?username=twf300_2017';
    $index=0;
    $username="";
    $token="";
    $content = file($url);
    foreach ($content as $k=>$r){
        if(str_contain($r,'<div id="userComment')&&!str_contain($r,'<div id="userComments')&&!str_contain($content[$k+2],'悄悄話')){
            //start of comment
            //index + 2 會找到個資連結
            $username = explode('" title=',explode('?username=',$content[$k+2])[1])[0];
            $username = str_replace("%40","@",$username);
            echo "<br><br>".$username . " (".$k."<br>";

            $index=$k;

        }
        if(str_contain($r,'<div class="pContent"><span style="')&&str_contain($r,'</span></div>')){
            if($k<$index+9)
                $token = explode("</",explode(">",explode("><",$r)[1])[1])[0];
        }
        elseif(str_contain($r,'<div class="pContent">')&&str_contain($r,'</div>')){
            if($k<$index+9)
                $token = explode("<",explode('>',$r)[1])[0];
        }
//        echo $username." ".$token."<br>";
        if($by==$username && $token==$tk){
            return true;
        }

    }
    return false;
}
function str_contain($str1,$str2){
    if (strpos($str1, $str2) !== false) {
        return true;
    }
    return false;
}

?>

<html>
<head>
<title>綁定嘎姆 - 300容量挑戰賽</title>    
<script src="../js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <h2>你尚未綁定</h2>
    
    <p>嘎姆帳號：</p>
    <form method="post" enctype="multipart/form-data" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
        <input type="text" name="username" value="<?php echo $username;?>"><input type="submit" name="submit" value="修改">
    </form>
    <p>第三方帳號：<?php echo $third_party_ac;?></p>
    <p>驗証碼：<?php echo $token;?></p>
    <p>用你的嘎姆帳號將驗証碼<strong>公開留言</strong>至<a href="http://tw.gamelet.com/user.do?username=twf300_2017">「300容量挑戰賽作品」</a><br>留言後請重新來到本頁，本頁將會自動驗証</p>
</body>
</html>
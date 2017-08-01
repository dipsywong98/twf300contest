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

function tokenExist($by, $tk){
    $url = 'http://tw.gamelet.com/user.do?username=twf300_2017';
    $index=0;
    $username="";
    $token="";
    $content = file($url);
    foreach ($content as $k=>$r){
        if(str_contain($r,'<div id="userComment')&&!str_contain($r,'<div id="userComments')&&!str_contain($content[$k+2],'悄悄話')){
            //start of comment
            //index + 2 會找到個資連結
            $username = explode("_",explode('http://twstatic.gamelet.com/gamelet/users/',$content[$k+2])[1])[0];
//            echo "<br><br>".$username . " (".$k."<br>";

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
</head>
<body>
    <h2>你尚未綁定</h2>
    <p>嘎姆帳號：<?php echo $username;?></p>
    <p>第三方帳號：<?php echo $third_party_ac;?></p>
    <p>驗証碼：<?php echo $token;?></p>
    <p>用你的嘎姆帳號將驗証碼<strong>公開留言</strong>至<a href="http://tw.gamelet.com/user.do?username=twf300_2017">「300容量挑戰賽作品」</a><br>留言後請重新來到本頁，本頁將會自動驗証</p>
</body>
</html>
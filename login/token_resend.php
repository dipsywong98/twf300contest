<?php 
try{
include "../includes/helper.php";
include "../includes/auth.php";
}
catch(Exception $e){}

$username = getLoginUsername();

$auth = $db->select("third_party_auth","username",$username);
if($auth["authentic_token"]=="success"){
    alert("你已通過驗証");
    redirect("../index.php");
    die();
}
elseif($auth["resend_time"]>time()){
    alert(time()-$auth["resend_time"]."秒後才能再次發送");
    redirect("../index.php");
    die();
}
$token = md5(uniqid(rand(), true));
$sql = "UPDATE `third_party_auth` SET authentic_token = '".$token."' , resend_time = '".(time()+60*5)."' WHERE username = :username AND third_party_ac = :third_party_ac";
$stmt = $conn->prepare($sql);
$stmt->execute([
            "username"=>$username,
            "third_party_ac"=>getLoginThirdPartyAc()
        ]);
leave_msg($username,$token);
redirect("auth.php");

function leave_msg($username, $token){
    $url = getRoot()."login/auth.php?token=".$token;
    $msg = "感謝報名300容量挑戰賽，請到<a href='".$url."'>".$url."</a>確認。<br>如果這不是你，請無視本訊息";
    echo $msg;
    $msg = "7|0|9|http://tw.gamelet.com/gwt/com.liquable.lumix.gwt.user.User/|43790D39328D68AC0B320A9537E906C1|com.liquable.lumix.gwt.service.client.GwtUserService|postUserComment|java.lang.String/2004016611|com.liquable.lumix.model.UserCommentType/310705705|ST\!twf300_2017\!1502033206471\!131ab9cf3ba4f21a65578b1cbde5ae5e|".$msg."|".$username."|1|2|3|4|4|5|5|6|5|7|8|6|1|9|";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://tw.gamelet.com/gwtremoting/userService");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:text/x-gwt-rpc; charset=UTF-8'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);

    $server_output = curl_exec($ch);
    curl_close ($ch);
}
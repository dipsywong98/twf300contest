<?php
    require '../includes/helper.php';
    require '../includes/auth.php';
//    require '../includes/sql.php';

$from = "../index.php";

if (array_key_exists("from",$_GET)){
    $from = $_GET["from"];
}

if(isLogin()){
    if(!isThirdAuth()){
        redirect("auth.php");
    }
    redirect($from);
}

// define variables and set to empty values
$method = $username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //handle POST contents
    
    $method = test_input($_POST["method"]);
    if(isset($_POST["username"]))$username = test_input($_POST["username"]);
    if($method == "gamelet") $password = test_input($_POST["password"]);
    else $third_party_ac = test_input($_POST["third_party_ac"]);
    $from = test_input($_POST["from"]);
    
    $loginSuccess = false;
    
    if($method == "gamelet") $loginSuccess = loginByGamelet($db,$username,$password);
    else if($method == "facebook"){
        $loginSuccess = loginByFacebook();
//        setcookie("third",encrypt_decrypt("encrypt",$GLOBALS["third_party_ac"],$GLOBALS["username"]),-1,"/");
        $_SESSION["third"] = $GLOBALS["third_party_ac"];
    } 
    
    if($loginSuccess){
//        alert("sucessful login");
        $hash = $db->select("usr","username",$username)["hash"];
        
        
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['usr'] = $username;
        $_SESSION['hash'] = $hash;
//        setcookie("ehash",encrypt_decrypt("encrypt",$hash,$username),-1,"/");
//        setcookie("usr",encrypt_decrypt("encrypt",$username,"fk is fucking handsome"),-1,"/");
//        $_COOKIE["ehash"]=encrypt_decrypt("encrypt",get_client_ip(),$hash);
//        $_COOKIE["usr"]=encrypt_decrypt("encrypt",$username,get_client_ip());
        redirect($from);
    }
    else{
        alert("fail login");
    }
}

function loginByGamelet($db, $username, $password){
    
    $auth = new GameletLoginVerification($username, $password);
    
    if($auth->IsValid()){
        
        $hash = "";
        $newUser = $db->numberOf("usr","username",$username);
        
        if($newUser > 0){
            //not a new user
            
            $user =  $db->select("usr","username",$username);
//            echo $user["hash"];
            
            return true;
        }
        else{
            //this is new user
            
            
            $hash = md5(uniqid(rand(), true));
            $ip = get_client_ip();
//            $db->insert("usr",array("username","hash","ip","type"),array($username,$hash,$ip,"gamelet"));
            $db->insert("usr",[
                "username"=>$username,
                "hash"=>$hash,
                "ip"=>$ip,
                "type"=>"gamelet"
            ]);
            
            return true;
        }
    }
    else {
        return false;
    }
}

function loginByFacebook(){
    $db = $GLOBALS["db"];
    if($db->numberOf("third_party_auth","third_party_ac",$GLOBALS["third_party_ac"])){
        if($db->select("third_party_auth","third_party_ac",$GLOBALS["third_party_ac"])["authentic_token"]=="success"){
            //authented
            $GLOBALS["username"] = $db->select("usr","third_party_ac",$GLOBALS["third_party_ac"])["username"];
            return true;
        }
    }
    
    //not authented

    if($db->numberOf("usr","third_party_ac",$GLOBALS["third_party_ac"])==0){

        //totally new user

        //check if this user is using registered and authented ac
        if($db->numberOf("usr","username",$GLOBALS["username"]))
        if($db->select("usr","username",$GLOBALS["username"])["type"]=="gamelet"){
            alert("你正企圖綁定一個已被綁定的嘎姆帳號");
            return false;
        }
        if($db->numberOf("third_party_auth","username",$GLOBALS["username"]))
        if($db->select("third_party_auth","username",$GLOBALS["username"])["authentic_token"]=="success"){
            alert("你正企圖綁定一個已被綁定的嘎姆帳號");
            return false;
        }

        $hash = md5(uniqid(rand(), true));
        $ip = get_client_ip();
        $db->insert("usr",[
            "username"=>$GLOBALS["username"],
            "hash"=>$hash,
            "ip"=>$ip,
            "type"=>"facebook",
            "third_party_ac"=>$GLOBALS["third_party_ac"]
        ]);

        $token = md5(uniqid(rand(), true));
        
        $db->insert("third_party_auth",[
            "username"=>$GLOBALS["username"],
            "third_party_ac"=>$GLOBALS["third_party_ac"],
            "authentic_token"=>$token,
            "resend_time"=>time()-10
        ]);
        
        leave_msg($GLOBALS["username"],$token);

        $GLOBALS["from"]="auth.php";
        return true;
    }
    else{
        //old user, but haven't authented
        $GLOBALS["username"] = $db->select("usr","third_party_ac",$GLOBALS["third_party_ac"])["username"];
        $GLOBALS["from"]="auth.php";
        return true;
    }
    
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

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
?>
<?php


    require '../includes/auth.php';
//    require '../includes/sql.php';
    require '../includes/helper.php';

$from = "../index.php";

if (array_key_exists("from",$_GET)){
    $from = $_GET["from"];
}

if(isLogin()){
    redirect($from);
}

        
// define variables and set to empty values
$method = $username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //handle POST contents
    
    $method = test_input($_POST["method"]);
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    $from = test_input($_POST["from"]);
    
    $loginSuccess = false;
    
    if($method == "gamelet") $loginSuccess = loginByGamelet($db,$username,$password);
    else if($method == "facebook") $loginSuccess = loginByFacebook();
    
    if($loginSuccess){
        alert("sucessful login");
        $hash = $db->select("usr","username",$username)["hash"];
        setcookie('login', null, -1, '/');
//        $_COOKIE["login"]="yes";
        setcookie("ehash",encrypt_decrypt("encrypt",$hash,$username),-1,"/");
        setcookie("usr",encrypt_decrypt("encrypt",$username,"fk is fucking handsome"),-1,"/");
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

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
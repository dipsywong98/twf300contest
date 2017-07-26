<?php


    require '../includes/auth.php';
//    require '../includes/sql.php';
    require '../includes/helper.php';

if(isLogin()){
    header("Location: ../index.php");
    die();
}
        
// define variables and set to empty values
$method = $username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //handle POST contents
    
    $method = test_input($_POST["method"]);
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    
    $loginSuccess = false;
    
    if($method == "gamelet") $loginSuccess = loginByGamelet($db,$username,$password);
    else if($method == "facebook") $loginSuccess = loginByFacebook();
    
    if($loginSuccess){
        alert("sucessful login");
        $hash = $db->select("usr","username",$username)["hash"];
        setcookie('login', null, -1, '/');
//        $_COOKIE["login"]="yes";
        setcookie("ehash",encrypt_decrypt("encrypt",get_client_ip(),$hash),-1,"/");
        setcookie("usr",encrypt_decrypt("encrypt",$username,get_client_ip()),-1,"/");
//        $_COOKIE["ehash"]=encrypt_decrypt("encrypt",get_client_ip(),$hash);
//        $_COOKIE["usr"]=encrypt_decrypt("encrypt",$username,get_client_ip());
        header("Location: ../index.php");
        die();
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
            echo $user["hash"];
            
            return true;
        }
        else{
            //this is new user
            
            
            $hash = md5(uniqid(rand(), true));
            $ip = get_client_ip();
            $db->insert("usr",array("username","hash","ip","type"),array($username,$hash,$ip,"gamelet"));
            
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
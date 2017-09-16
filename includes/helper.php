<?php




if(!isset($helper_included)){
    $helper_included = true;

    ob_start();
session_start();
    header('Content-Type: text/html; charset=utf-8');
    
    require "sql.php";

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    function alert($txt){
        echo "<script>window.alert('".$txt."');</script>";
    }

    /**
     * simple method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     * copied from https://gist.github.com/joashp/a1ae9cb30fa533f4ad94
     * 
     * @param string $action: can be 'encrypt' or 'decrypt'
     * @param string $string: string to encrypt or decrypt
     *
     * @return string
     */
    function encrypt_decrypt($action, $string, $secret_key) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_iv = 'This is my secret iv';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    function getLoginThirdPartyAc(){
        return $_SESSION["third"];
//        return encrypt_decrypt("decrypt",$_COOKIE["third"],getLoginUsername());
    }
    
    function isThirdAuth(){
        $db = $GLOBALS["db"];
        if($db->select("usr","username",getLoginUsername())["type"]=="gamelet") return true;
        if($db->select("third_party_auth","username",getLoginUsername())["authentic_token"]=="success") return true;
        return false;
    }
    
    function isLogin(){
        return isset($_SESSION["valid"]);
//        if(count($_COOKIE)==0) return 0;
//    //    return $_COOKIE["login"]=="yes";
//        if(!isset($_COOKIE['usr'])||!isset($_COOKIE['ehash']))return 0;
//        return encrypt_decrypt("decrypt", $_COOKIE["ehash"], getLoginUsername())== $GLOBALS["db"]->select("usr","username",getLoginUsername())["hash"] ;
    }

    function getLoginUsername(){
        return $_SESSION["usr"];
//        if(!isset($_COOKIE['usr'])||!isset($_COOKIE['ehash']))return;
//        return encrypt_decrypt("decrypt",$_COOKIE["usr"],"fk is fucking handsome");
    }
    
    function getLoginUserHash(){
        return $_SESSION["hash"];
//        return $GLOBALS["db"]->select("usr","username",getLoginUsername())["hash"];
    }

    function isAdmin(){
        $admin=["twf300_2017","a230459446","ericgau22","100002331046844@facebook.com","100003919138920@facebook.com","100000913023977@facebook.com","100001619080761@facebook.com","money8888","facebookoffical"];
        return in_array(getLoginUsername(),$admin);
    }

    function rmdir_recursive($dir) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    function redirect($url){
        if(!str_contain($url,"?"))
            echo '
                <script>
                    var para = document.createElement("a");
                    para.href="'.$url.'?from='.getThisUrl().'";
                    para.click();
                </script>
            ';
        else
            echo '
            <script>
                var para = document.createElement("a");
                para.href="'.$url.'&from='.getThisUrl().'";
                para.click();
            </script>
        ';
    }

    function getRoot(){
        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
        if(!str_contain($root,"contest")){
            $root.="contest/";
        }
        return $root;
    }

    function str_contain($str1,$str2){
        if (strpos($str1, $str2) !== false) {
            return true;
        }
        return false;
    }
    
    function getThisUrl(){
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
    
    function getGameUrl($mission_id){
        return "http://tw.gamelet.com/gameContainer.do?code=csArena&gltParam=%7B'mode'%3A'userMission'%2C%20'id'%3A'".$mission_id."'%7D";
    }
    
}
?>
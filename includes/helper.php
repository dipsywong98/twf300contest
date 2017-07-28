<?php

if(!isset($helper_included)){
    $helper_included = true;

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

    function isLogin(){
        if(count($_COOKIE)==0) return 0;
    //    return $_COOKIE["login"]=="yes";
        if(!isset($_COOKIE['usr'])||!isset($_COOKIE['ehash']))return 0;
        return encrypt_decrypt("decrypt", $_COOKIE["ehash"], getLoginUsername())== $GLOBALS["db"]->select("usr","username",getLoginUsername())["hash"] ;
    }

    function getLoginUsername(){
        if(!isset($_COOKIE['usr'])||!isset($_COOKIE['ehash']))return;
        return encrypt_decrypt("decrypt",$_COOKIE["usr"],"fk is fucking handsome");
    }
    
    function getLoginUserHash(){
        return $GLOBALS["db"]->select("usr","username",getLoginUsername())["hash"];
    }

    function isAdmin(){
        $admin=["twf300_2017","facebookoffical","facebook_002"];
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
        echo '
            <script>
                var para = document.createElement("a");
                para.href="'.$url.'?from='.getThisUrl().'";
                para.click();
            </script>
        ';
    }

    function getThisUrl(){
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
    
    function getGameUrl($mission_id){
        return "http://tw.gamelet.com/gameContainer.do?code=csArena&gltParam=%7B'mode'%3A'userMission'%2C%20'id'%3A'".$mission_id."'%7D";
    }
    
}
?>
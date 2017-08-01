<?php

$url = 'http://tw.gamelet.com/user.do?username=twf300_2017';


$content = file($url);
foreach ($content as $k=>$r){
    if(str_contain($r,'<div id="userComment')&&!str_contain($r,'<div id="userComments')&&!str_contain($content[$k+2],'悄悄話')){
        //start of comment
        //index + 2 會找到個資連結
        $username = explode("_",explode('http://twstatic.gamelet.com/gamelet/users/',$content[$k+2])[1])[0];
        echo $username . " (".$k."<br>";
    }
}
//print_r($content);




function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function str_contain($str1,$str2){
    if (strpos($str1, $str2) !== false) {
        return true;
    }
    return false;
}
?>
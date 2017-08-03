<?php


function tokenExist($by, $tk){
    echo $by." ".$tk."<br>";
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
        echo $username." ".$token."<br>";
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
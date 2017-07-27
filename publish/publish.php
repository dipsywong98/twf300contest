<?php

require "../includes/helper.php";

//echo time();

if(!isLogin())
    redirect("../login");
else{
    if(!isAdmin()){
        alert("你未獲得授權");
        redirect("../");
        die();
    }
}

if($db->numberOf("submits","mission_id","-1")==0){
    alert("no submition need publish now");
    redirect("../");
}

//finding a submit to publish
$submit ="";

$record = $db->select("publishing","pic",getLoginUsername());
if($db->numberOf("publishing","pic",getLoginUsername())){
    //if user is pic for a publish event already, get his pic record
    $submit = $db->select("submits","hash",$record["hash"]);
//    echo "this guy have a publish record <br>";
}
else{
    //if user is not any pic
    //find all submits haven't publish
    $records = $db->selectAll("submits","mission_id","-1");
    foreach($records as $record){
        
        //if this submit do not have pic, be the pic
        if($db->numberOf("publishing","hash",$record["hash"])==0){
            $submit = $record;
//            echo "new";
            $db->insert("publishing",[
                "hash"=>$record["hash"],
                "pic"=>getLoginUsername(),
                "expire"=>time()+3600*24*1.5
            ]);
            break;
        }
        else{
            
            //if this submit have a pic and it is a freerider, take over his job
            $publish = $db->select("publishing","hash",$record["hash"]);
            if(isExpired($publish)){
//                echo "take over";
                $submit = $record;
                $db->update("publishing",$record["hash"],[
                    "pic"=>getLoginUsername(),
                    "expire"=>time()+3600*24*1.5
                ]);
                break;
            }
        }
        
        
    }
}

if($submit==""){
    alert("no submition need publish now");
    redirect("../");
}

$twf_name = $submit["twf_name"];
$hash = $submit["hash"];
$photo_type = $submit["photo_type"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if($db->numberOf("publishing","pic",getLoginUsername())==0){
        alert("代碼為".$_POST["hash"]."的作品已被公開");
        redirect("");
        die();
    }
    
    if($_POST["mission_id"]==""){
        alert("請輸入任務代碼");
        redirect("");
        die();
    }
    if($_POST["mission_id"]!=$_POST["mission_id_prove"]){
        alert("兩個任務代碼不相等");
        redirect("");
        die();
    }
    if($_FILES["txt_file"]["error"]==4){
        alert("請上載純文字檔");
        redirect("");
        die();
    }elseif($_FILES["txt_file"]["error"]!=0){
        alert("上載純文字檔時發生錯誤，代碼".$_FILES["txt_file"]["error"]);
        redirect("");
        die();
    }else if(!in_array(pathinfo($_FILES['txt_file']['name'], PATHINFO_EXTENSION),["txt"])){
        alert("請確保你上載的是文字檔");
        redirect("");
        die();
    }
    
    move_uploaded_file($_FILES["txt_file"]["tmp_name"],"../uploads/".$hash."/".$hash.".txt");
    
    $mission_id = $_POST["mission_id"];
    $db->update("submits",$hash,[
        "mission_id"=>$mission_id
    ]);
    $db->delete("publishing",$hash);
    
    alert("success!");
    redirect("../");
}

function isExpired($record){
    return time()>$record["expire"];
}

?>
<?php
require "../includes/helper.php";
        
// define variables and set to empty values
$twf_name = $comment = $twf_doc = $twf_file = $twf_photo = $hash = "";
$new_submit = true; $no_new_photo = false; $no_new_twf_file = false;

if(isLogin()){
    if(!isThirdAuth()) redirect("../login/auth.php");
    $username = getLoginUsername();
    $hash = $db->select("usr","username",$username)["hash"];
    $submition = $db->select("submits","hash",$hash);
    $new_submit = !$db->numberOf("submits","hash",$hash);
    if(!$new_submit){
        //retrive old data
        $twf_name = $submition["twf_name"];
        $comment = $submition["comment"];
        $photo_type = $submition["photo_type"];
        $ip = $submition["ip"];
        $comment = $submition["comment"];
        $time_min = $submition["time_min"];
    }
    else{
        $time_min = 0;
    }
}
else{
    redirect("../login");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //handle POST contents
    
    
    //error handling
    $error = "";
    $warning = "";
    
    $twf_name = test_input($_POST["twf_name"]);
    if($twf_name=="") $error .= "「任務名稱」欄不能為空<br>";
    
    $comment = test_input($_POST["comment"]);
    
    
    $allowed =  array('twf');
    
    if($new_submit){
        $tmp_twf_file = $_FILES["twf_file"];
        if($tmp_twf_file["error"]==4){
            if($new_submit){
                $error.="請於「作品twf檔」欄上載twf檔<br>";
            }
            else{
                $_FILES["twf_file"]["tmp_name"] = '../uploads/'.$hash."/".$hash.".twf";
                $no_new_twf_file = true;
            }
        } 
        else if(!in_array(pathinfo($_FILES['twf_file']['name'], PATHINFO_EXTENSION),$allowed)) $error.="請確保你於「作品twf檔」欄上載的是twf檔<br>";
        else if($tmp_twf_file["error"]!=0) $error.="twf作品上載時發生錯誤，代碼:".$tmp_twf_file["error"]."<br>";
    }else{
        $no_new_twf_file = true;
    }
    
    $tmp_twf_file = $_FILES["twf_photo"];
    if($tmp_twf_file["error"]==4) {
        if($new_submit){
            $error.="請於「作品圖片」欄上載圖片<br>";
        }
        else{
            $_FILES["twf_photo"]["tmp_name"] = '../uploads/'.$hash."/".$hash.".".$photo_type;
            $no_new_photo = true;
        }
    }
    else if($tmp_twf_file["error"]!=0) $error.="圖片上載時發生錯誤，代碼:".$tmp_twf_file["error"]."<br>";
    
    echo "<span>".$error."</span>";
//    echo "<script>window.alert('".$error."')</script>";
    
    if($error==""){
        
        $upload_success = save($hash);
        if(!$no_new_photo) $photo_type = $upload_success;
        if($no_new_photo)$upload_success = $photo_type;
        if($upload_success){
            if($db->numberOf("submits","hash",$hash)==0){
                $db->insert("submits",[
                    "hash"=>$hash,
                    "twf_name"=>$twf_name,
                    "comment"=>$comment,
                    "ip"=>get_client_ip(),
                    "photo_type"=>$upload_success,
                    "mission_id"=>-1,
                    "time_min"=>$_POST["time_min"]
                ]);
            }
            else {
                $db->update("submits",$hash, [
                    "twf_name"=>$twf_name,
                    "comment"=>$comment,
                    "ip"=>get_client_ip(),
                    "photo_type"=>$upload_success,
                    "time_min"=>$_POST["time_min"]
                ]);
            }
            redirect("");
        }
        
    }
    
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
    
function save($hash){
    
    $target_dir = "../uploads/".$hash;
//    if (file_exists($target_dir)) {
//        rmdir_recursive($target_dir);
//    }
    if($GLOBALS["new_submit"]) mkdir($target_dir, 0777, true);
    else{
        if($_FILES['twf_photo']['error']!=4){
            unlink("../uploads/".$hash."/".$hash.".".$GLOBALS["photo_type"]);
//            $GLOBALS["photo_type"] = pathinfo($_FILES['twf_photo']['name'], PATHINFO_EXTENSION);
        }
    }
    
    $target_dir .= "/";
    
    //twf file
    if($GLOBALS["new_submit"]){
    $target_file = $target_dir . basename($hash.".twf");
    move_uploaded_file($_FILES["twf_file"]["tmp_name"],$target_file);
//    echo $_FILES[$upload_tag]["error"];
    }
    //twf photo
    $photo_type = pathinfo($_FILES['twf_photo']['name'], PATHINFO_EXTENSION);
    $target_file = $target_dir . basename($hash.".".$photo_type);
    move_uploaded_file($_FILES["twf_photo"]["tmp_name"],$target_file);
//    echo $_FILES[$upload_tag]["error"];
    
    if($GLOBALS["no_new_photo"]||$_FILES["twf_photo"]["error"]==0){
        if($GLOBALS["no_new_twf_file"]||$_FILES["twf_file"]["error"]==0){
            echo "<script>window.alert('成功遞交')</script>";
            return $photo_type;
        }
    }
    
//    if($_FILES["twf_file"]["error"]==0 && $_FILES["twf_photo"]["error"]==0){
//        echo "<script>window.alert('成功遞交')</script>";
//        return $photo_type;
//    }
    else{
        echo "<script>window.alert('遞交失敗，代碼：'".$_FILES[$upload_tag]["error"].$_FILES[$upload_tag]["error"].")</script>";
        return false;
    }
    
}
    

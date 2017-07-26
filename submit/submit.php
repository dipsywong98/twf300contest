<?php
require "../includes/helper.php";
        
// define variables and set to empty values
$twf_name = $comment = $twf_doc = $twf_photo = $hash = "";
$new_submit = true;

if(isLogin()){
    $username = getLoginUsername();
    $hash = $db->select("usr","username",$username)["hash"];
    $submition = $db->select("submits","hash",$hash);
    $new_submit = count($submition);
    if(!$new_submit){
        //retrive old data
        $twf_name = $submition["twf_name"];
        $comment = $submition["comment"];
        $photo_type = $submition["photo_type"];
        $ip = $submition["ip"];
    }
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
    
    $tmp_twf_file = $_FILES["twf_file"];
    if($tmp_twf_file["error"]==4) $error.="請於「作品twf檔」欄上載twf檔<br>";
    else if(!in_array(pathinfo($_FILES['twf_file']['name'], PATHINFO_EXTENSION),$allowed)) $error.="請確保你於「作品twf檔」欄上載的是twf檔<br>";
    else if($tmp_twf_file["error"]!=0) $error.="twf作品上載時發生錯誤，代碼:".$tmp_twf_file["error"]."<br>";
    
    $tmp_twf_file = $_FILES["twf_photo"];
    if($tmp_twf_file["error"]==4) $error.="請於「作品圖片」欄上載圖片<br>";
    else if($tmp_twf_file["error"]!=0) $error.="圖片上載時發生錯誤，代碼:".$tmp_twf_file["error"]."<br>";
    
    echo "<span>".$error."</span>";
//    echo "<script>window.alert('".$error."')</script>";
    
    if(error==""){
        if($new_submit){
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
    
    $target_dir = "uploads/".$hash;
    if (file_exists($target_dir)) {
        rmdir_recursive($target_dir);
    }
    mkdir($target_dir, 0777, true);
    
    $target_dir .= "/";
    
    //twf file
    $upload_tag = "twf_file";
    $target_file = $target_dir . basename($hash.".twf");
    move_uploaded_file($_FILES[$upload_tag]["tmp_name"],$target_file);
//    echo $_FILES[$upload_tag]["error"];
    
    //twf photo
    $upload_tag = "twf_photo";
    $target_file = $target_dir . basename($hash.".".pathinfo($_FILES['twf_photo']['name'], PATHINFO_EXTENSION));
    move_uploaded_file($_FILES[$upload_tag]["tmp_name"],$target_file);
//    echo $_FILES[$upload_tag]["error"];
    
    if($_FILES["twf_file"]["error"]==0 && $_FILES["twf_photo"]["error"]==0){
        echo "<script>window.alert('成功遞交')</script>";
        
    }
    else{
        echo "<script>window.alert('遞交失敗，代碼：'".$_FILES[$upload_tag]["error"].$_FILES[$upload_tag]["error"].")</script>";
    }
    
}
    

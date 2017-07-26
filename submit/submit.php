<?php
require '../includes/auth.php';
    
    //SQL connections
$servername = "localhost";
$database = "jamiepha_twf";
$username = "jamiepha_twf";
$password = "twf1234";

$conn = new mysqli($servername, $username, $password,$database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
    
    
// define variables and set to empty values
$twf_name = $comment = $username = $twf_doc = $twf_photo = $password = "";
$new_entry = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //handle POST contents
    
    
    //error handling
    $error = "";
    $warning = "";
    
    $twf_name = test_input($_POST["twf_name"]);
    if($twf_name=="") $error .= "「任務名稱」欄不能為空<br>";
    
    //login with gamelet account
    $username = test_input($_POST["username"]);
    if($username=="") $error .= "「嘎姆帳號」欄不能為空<br>";
    else{
        $password = test_input($_POST["password"]);

        if($password=="") $error .= "「密碼」欄不能為空<br>";
        else{
            $auth = new GameletLoginVerification($username, $password);

            if($auth->IsValid()){
                echo "sccess";
            }
            else {
                echo "fail";
                $error .= "帳號或密碼錯誤<br>";
            }
        }
        
    }
    
    $comment = test_input($_POST["comment"]);
    
    
    $allowed =  array('twf');
    
    $tmp_twf_file = $_FILES["twf_file"];
    if($tmp_twf_file["error"]==4) $error.="請於「作品twf檔」欄上載twf檔<br>";
    else if(!in_array(pathinfo($_FILES['twf_file']['name'], PATHINFO_EXTENSION),$allowed)) $error.="請確保你於「作品twf檔」欄上載的是twf檔<br>";
    else if($tmp_twf_file["error"]!=0) $error.="twf作品上載時發生錯誤，代碼:".$tmp_twf_file["error"]."<br>";
    
    $tmp_twf_file = $_FILES["twf_photo"];
    if($tmp_twf_file["error"]==4) $error.="請於「作品圖片」欄上載圖片<br>";
    else if($tmp_twf_file["error"]!=0) $error.="圖片上載時發生錯誤，代碼:".$tmp_twf_file["error"]."<br>";
    
    echo $error;
//    echo "<script>window.alert('".$error."')</script>";
    
    
    //no error then authorized and enter submition process
    if($error==""){
        
        $sql = "SELECT * FROM `contestant` WHERE username='".$username."'";
        $result = $conn->query($sql);
        echo $result->num_rows;
        
        $hash = md5(uniqid(rand(), true));

        $ip = get_client_ip();
        
        if($result->num_rows ==0){
            $sql = "INSERT INTO `contestant` (`username`,`twf_name`,`comment`,`ip`,`hash`) VALUES ('".$username."','".$twf_name."','".$comment."','".$ip."','".$hash."')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else{
            $i = 0;
            while($row = $result->fetch_assoc()){
                $hash = $row["hash"];
                $sql = "UPDATE `contestant` SET `twf_name` = '".$twf_name."', comment = '".$comment."' WHERE username = '".$username."'";
                if ($conn->query($sql) === TRUE) {
                    echo "Updated Record";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
        
        save($hash);
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
    
function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
        else unlink("$dir/$file");
    }
    rmdir($dir);
}
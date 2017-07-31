<?php
require "../includes/helper.php";

$submit = $db->select("submits","hash",getLoginUserHash());
$votes = $db->selectAll("votes","hash",getLoginUserHash());

?>

<html>
<head>
    <title>我的作品 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
</head>
    <h2>作品資訊</h2>
<?php
    var_dump($votes);

    
    ?>
</html>
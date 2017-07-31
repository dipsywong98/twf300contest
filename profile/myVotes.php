<?php
require "../includes/helper.php";

$votes = $db->selectAll("votes","voter_hash",getLoginUserHash());

?>

<html>
<head>
    <title>我的投票 - 300容量挑戰賽</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
</head>
    <h2>作品資訊</h2>
<?php
    var_dump($votes);

    
    ?>
</html>
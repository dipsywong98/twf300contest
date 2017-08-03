<?php
$servername = "localhost";
$database = "jamiepha_twf";
$username = "jamiepha_twf";
$password = "twf1234";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
$dbConnection = new PDO('mysql:dbname=jamiepha_twf;host=localhost;charset=utf8', $username, $password);

$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn = $dbConnection;
?>
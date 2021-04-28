<?php
//establish connection info
$server = "sql211.epizy.com";
$userid = "epiz_27941844";
$pw = "qAA3UUc6P5";
$db = "epiz_27941844_jade_delight";

// Create connection
$conn = new mysqli($server, $userid, $pw);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

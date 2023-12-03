<?php
ob_start();
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = ""; //change pass or remove depends sa xampp server mo
$dbName = "phpschool";

$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

SESSION_START();
?>

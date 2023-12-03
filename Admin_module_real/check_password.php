<?php
require_once "checker.php";

$input_password = $_POST['password'];

 $sql_grade = "SELECT * FROM admin WHERE admin_id=?;";
 $stmt = mysqli_stmt_init($conn);
 mysqli_stmt_prepare($stmt, $sql_grade);
   mysqli_stmt_bind_param($stmt, "i", $_SESSION['admin_session_id']);
   mysqli_stmt_execute($stmt);
   $result_check = mysqli_stmt_get_result($stmt);
   $result = mysqli_fetch_assoc($result_check);
   $password = $result['password'];
   if(password_verify($input_password, $password)) {
     echo "true";
     exit();
   }
     echo "false";
     exit();

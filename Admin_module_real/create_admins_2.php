<?php
require_once "checker.php";

$id = $_POST['school_id'];
$N2 = count($id);

for($e=0; $e < $N2; $e++)
{
$school_id = htmlspecialchars($id[$e]);

 $sql_grade = "SELECT * FROM admin WHERE school_id=?;";
 $stmt = mysqli_stmt_init($conn);
 //Preparing the prepared statement
 mysqli_stmt_prepare($stmt, $sql_grade);
   //run sql
   mysqli_stmt_bind_param($stmt, "i", $school_id);
   mysqli_stmt_execute($stmt);
   $result_check = mysqli_stmt_get_result($stmt);
   if ($result_check->num_rows > 0) {
     echo "$school_id";
     exit();
   }
}
echo "none";

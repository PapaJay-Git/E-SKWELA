<?php
require_once "checker.php";


if (isset($_POST['class_id'])) {
$class_id = $_POST['class_id'];

 $sql_grade = "SELECT * FROM student WHERE class_id=?;";
 $stmt = mysqli_stmt_init($conn);
 //Preparing the prepared statement
 mysqli_stmt_prepare($stmt, $sql_grade);
   //run sql
   mysqli_stmt_bind_param($stmt, "i", $class_id);
   mysqli_stmt_execute($stmt);
   $result_check = mysqli_stmt_get_result($stmt);
   if ($result_check->num_rows > 0) {
     echo "<option value='' selected disabled hidden>List of students</option>";
     while ($result = mysqli_fetch_assoc($result_check)) {
       $school_id = $result['school_id'];
       $id = $result['student_id'];
       $name = $result['l_name'].", ".$result['f_name'];
       echo "<option value='$id'>LRN: $school_id - Name: $name </option>";
     }
     exit();
   }
echo "<option value='' selected disabled hidden>No Students</option>";
}

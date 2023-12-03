<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
$parent = $_GET['parent_id'];
if (isset($_GET['parent_student_id']) && isset($_GET['parent_id'])) {
  $parent_student = $_GET['parent_student_id'];

       $sql_grade = "SELECT * FROM parent_student WHERE parent_student_id =?;";
       $stmt = mysqli_stmt_init($conn);
       //Preparing the prepared statement
       if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
         $_SESSION['error']= "Error deleting parent connection";
         header("location: edit_parent.php?parent_id=$parent&success=error");
         exit();
       }
         //run sql
         mysqli_stmt_bind_param($stmt, "i", $parent_student);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result->num_rows < 1) {
              $_SESSION['error']= "This connection does not exist anymore";
              header("location: edit_parent.php?parent_id=$parent&success=error");
              exit();
            }
   $sql_grade = "DELETE FROM parent_student WHERE parent_student_id =?;";
   $stmt = mysqli_stmt_init($conn);
   //Preparing the prepared statement
     mysqli_stmt_prepare($stmt, $sql_grade);
     mysqli_stmt_bind_param($stmt, "i", $parent_student);
     if (mysqli_stmt_execute($stmt)) {
       $_SESSION['success']= "Parent connection deleted successfully!";
       header("location: edit_parent.php?parent_id=$parent&success=true");
       exit();
     }
     $_SESSION['error']= "Parent connection deletion failed!";
     header("location: edit_parent.php?parent_id=$parent&success=error");
     exit();

}else {
  $_SESSION['error']= "Please the button properly!";
  header("location: edit_parent.php?parent_id=$parent&notset");
  exit();
}

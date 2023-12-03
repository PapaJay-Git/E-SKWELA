<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';

if (isset($_POST['delete_grade7'])) {
  $id = $_POST['delete_grade7'];
  $f= count($id);
  $N = count($id);
  $num = 7;
  for($e=0; $e < $f; $e++)
  {
  $grade7_id = $id[$e];

  if (!is_numeric($grade7_id) || empty($grade7_id)) {
    $_SESSION['error']= "Error, your ID is either not a number or empty!";
    header("location: grade7.php?error=number");
    exit();
  }
  $sql_grade = "SELECT * FROM subjects WHERE subject_id =? AND grade =?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error deleting grade 7 subject!";
    echo $conn->error;
    header("location: grade7.php?success=sqlerror");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "ii", $grade7_id, $num);
       if(!mysqli_stmt_execute($stmt)){
         $_SESSION['error']= "Execution ERROR!";
         echo $conn->error;
         header("location: grade7.php?&success=error");
         exit();
       }
        $result = mysqli_stmt_get_result($stmt);
          if ($result->num_rows == 0) {
            //show the info
            $_SESSION['error']= "It looks like you are deleting an invalid grade 7 subject! $grade7_id";
            header("location: grade7.php?&success=error");
            exit();
          }
          $zero = 0;
          //Check if already available in teacher_class
          $sql_grade = "SELECT * FROM teacher_class WHERE subject_id =? AND teacher_id != ?;";
          $stmt = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "ii", $grade7_id, $zero) || !mysqli_stmt_execute($stmt)) {
            $_SESSION['error']= "Error deleting grade 7 subject!";
            header("location: grade7.php?success=sqlerror");
            exit();
          }$result = mysqli_stmt_get_result($stmt);
            if ($result->num_rows > 0) {
              $_SESSION['error']= "It looks like subject ID $grade7_id already have a data from sections, this subject cannot be deleted. We recommend just editing it based on your preference! ";
              header("location: grade7.php?&success=error");
              exit();
            }
  }
  for($i=0; $i < $N; $i++)
  {
   $grade7_id2 = $id[$i];

   $sql_grade = "DELETE FROM subjects WHERE subject_id =?;";
   $stmt = mysqli_stmt_init($conn);
   //Preparing the prepared statement
   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
     $_SESSION['error']= "Error deleting grade7";
     header("location: grade7.php?&success=error");
     exit();
   }
     //run sql
     mysqli_stmt_bind_param($stmt, "i", $grade7_id2);
        if(!mysqli_stmt_execute($stmt)){
          $_SESSION['error']= "Execution ERROR deleting grade 7 subject, $grade7_id2!";
          echo $conn->error;
          header("location: grade7.php?&success=error");
          exit();
        }

  }
    $_SESSION['success']= "Grade 7 subject deleted successfully!";
    header("location:grade7.php?success=true");
    exit();
}else {
  $_SESSION['error']= "Please check the checbox of the grade 7 subject you want to delete.";
  header("location: grade7.php?notset");
  exit();
}

<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
if (isset($_POST['delete_section_8'])) {
  $id = $_POST['delete_section_8'];
  $f= count($id);
  $N = count($id);
  for($e=0; $e < $f; $e++)
  {
  $section_8_id = $id[$e];

  if (!is_numeric($section_8_id) || empty($section_8_id)) {
    $_SESSION['error']= "Error, your ID is either not a number or empty!";
    header("location: section_8.php?error=number");
    exit();
  }
  $sql_grade = "SELECT * FROM class WHERE class_id =?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $section_8_id) || !mysqli_stmt_execute($stmt)) {
    $_SESSION['error']= "Error deleting grade 8 section!";
    echo $conn->error;
    header("location: section_8.php?success=sqlerror");
    exit();
  }$result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
      $_SESSION['error']= "It looks like you are deleting an invalid grade 8 section! ID $section_8_id";
      header("location: section_8.php?&success=error");
      exit();
    }
    //Check if already available in teacher_class
    $sql_grade = "SELECT * FROM teacher_class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $section_8_id) || !mysqli_stmt_execute($stmt)) {
      $_SESSION['error']= "Error deleting grade 8 section!";
      echo $conn->error;
      header("location: section_8.php?success=sqlerror");
      exit();
    }$result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        $_SESSION['error']= "It looks like section ID $section_8_id already have a data from subjects, this section cannot be deleted. We recommend just editing it based on your preference! ";
        header("location: section_8.php?&success=error");
        exit();
      }
      //check if already avaible in assignments
      $sql_grade = "SELECT * FROM student WHERE class_id =?;";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $section_8_id) || !mysqli_stmt_execute($stmt)) {
        $_SESSION['error']= "Error deleting grade 8 section!";
        echo $conn->error;
        header("location: section_8.php?success=sqlerror");
        exit();
      }$result = mysqli_stmt_get_result($stmt);
        if ($result->num_rows > 0) {
          $_SESSION['error']= "It looks like section ID $section_8_id already have a data from the students, this section cannot be deleted. We recommend just editing it based on your preference! ";
          header("location: section_8.php?&success=error");
          exit();
        }

  }
  for($i=0; $i < $N; $i++)
  {
    $section_8_id2 = $id[$i];

   $sql_grade = "DELETE FROM class WHERE class_id =?;";
   $stmt = mysqli_stmt_init($conn);
   //Preparing the prepared statement
   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
     $_SESSION['error']= "Error deletion!";
     header("location: section_8.php?&success=error");
     exit();
   }
     //run sql
     mysqli_stmt_bind_param($stmt, "i", $section_8_id2);
        if(!mysqli_stmt_execute($stmt)){
          $_SESSION['error']= "Execution ERROR deleting grade 8 section ID $section_8_id2!";
          echo $conn->error;
          header("location: section_8.php?&success=error");
          exit();
        }

  }
    $_SESSION['success']= "Grade 8 section deleted successfully!";
    header("location:section_8.php?success=true");
    exit();
}else {
  $_SESSION['error']= "Please check the checbox of the grade 8 section you want to delete.";
  header("location: section_8.php?notset");
  exit();
}

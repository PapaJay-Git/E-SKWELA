<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';

if (isset($_POST['delete_announcement_id'])) {
  $id2 = $_POST['delete_announcement_id'];
  $f= count($id2);
  $N = count($id2);
  $f3 = count($id2);
  for($e=0; $e < $f; $e++)
  {
  $id = $id2[$e];

  if (!is_numeric($id) || empty($id)) {
    $_SESSION['error']= "It looks like you are deleting an empty ID!";
    header("location: announcement.php?error=number");
    exit();
  }
  $sql_grade = "SELECT * FROM announcements WHERE announcement_id =?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  mysqli_stmt_prepare($stmt, $sql_grade);
    //run sql
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
          if ($result->num_rows == 0) {
            //show the info
            $_SESSION['error']= "It looks like this announcement ($id) you are deleting does not exist";
            header("location: announcement.php?&success=error");
            exit();
          }
  }
  for($i=0; $i < $N; $i++)
  {
   $announcement_id = $id2[$i];

   $sql_grade = "DELETE FROM announcements WHERE announcement_id =?;";
   $stmt = mysqli_stmt_init($conn);
   //Preparing the prepared statement
   mysqli_stmt_prepare($stmt, $sql_grade);
     //run sql
     mysqli_stmt_bind_param($stmt, "i", $announcement_id);
     mysqli_stmt_execute($stmt);
  }
    $_SESSION['success']= "$f3 announcement deleted successfully!";
    header("location:announcement.php?success=true");
    exit();
}else {
  $_SESSION['error']= "Please check the checbox of the announcement you want to delete.";
  header("location: announcement.php?notset");
  exit();
}

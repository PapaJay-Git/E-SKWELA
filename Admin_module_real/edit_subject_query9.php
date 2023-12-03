<?php
require_once "includes_profile_id_check.php";
if (isset($_POST['subject_id_9']) && isset($_POST['name_9']) && isset($_POST['update_9'])) {
  $name = strtoupper(ltrim(htmlspecialchars($_POST['name_9'])));
  $id = $_POST['subject_id_9'];
  if (empty($name)) {
    $_SESSION['error']= "Error, name cannot be empty";
    header("location: edit_grade9.php?subject_id=$id");
    exit();
  }
    $seven = 9;
    $title = $name." ".$seven;
    $sql_grade = "SELECT * FROM subjects WHERE subject_code =? AND grade = ? AND subject_id != ?;";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
      $_SESSION['error']= "Error adding subjects";
      header("location: edit_grade9.php?subject_id=$id&sqlerror");
      exit();
    }
      //run sql
      mysqli_stmt_bind_param($stmt, "sii", $name, $seven, $id);
      mysqli_stmt_execute($stmt);
      $result_check = mysqli_stmt_get_result($stmt);
      if ($result_check->num_rows > 0) {
          $_SESSION['error']= "It looks like $name is already been added before. You cannot duplicate subjects on the same grade!";
          header("location: edit_grade9.php?subject_id=$id");
          exit();
      }
 $sql_grade = "UPDATE subjects SET subject_code =?, subject_title=? WHERE subject_id =? AND grade =?";
 $stmt = mysqli_stmt_init($conn);
 //Preparing the prepared statement
 if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
   $_SESSION['error']= "Error updating subject";
   header("location: edit_grade9.php?subject_id=$id&success=sqlerror");
   exit();
 }
   //run sql
   mysqli_stmt_bind_param($stmt, "ssii", $name, $title, $id, $seven);
      if(!mysqli_stmt_execute($stmt)){
        $_SESSION['error']= "Execution ERROR!";
        echo $conn->error;
        header("location: edit_grade9.php?subject_id=$id&success=error");
        exit();
      }
      $_SESSION['success'] = "Subject Name is now Updated!";
      header("Location:  edit_grade9.php?subject_id=$id&update=success");
      exit();
}
else{
    $_SESSION['error'] = "Submission is not settled properly.";
    header("Location edit_grade9.php?subject_id=$id&button");
    exit();
}

<?php
require_once "checker.php";
require_once 'includes_profile_id_check.php';

if (isset($_GET['student_id'])) {
  $student_id = $_GET['student_id'];
  if (!is_numeric($student_id)) {
    $_SESSION['error'] = "Student ID is not an integer!";
    header("Location: students.php");
    exit();
  }
  $sql = "SELECT * FROM student WHERE student_id =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    $_SESSION['error'] = "SQL error!";
    header("location: students.php?sql=error");
    exit();
  }
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if ($result->num_rows == 0) {
      $_SESSION['error'] = "It looks like this student does not exist!";
      header("Location: students.php");
      exit();
    }
    if ($row['active_status'] == 1) {
      $active = 0;
    }else {
      $active = 1;
    }
    $sql = "UPDATE student SET active_status = ? WHERE student_id =?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error!";
      header("location: students.php?sql=error");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ii", $active, $student_id);
      if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "STUDENT $student_id ACTIVE STATUS IS NOW UPDATED!";
        header("Location: students.php");
        exit();
      }

}

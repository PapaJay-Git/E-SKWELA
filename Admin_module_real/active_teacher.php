<?php
require_once "checker.php";
require_once 'includes_profile_id_check.php';

if (isset($_GET['teacher_id'])) {
  $teacher_id = $_GET['teacher_id'];
  if (!is_numeric($teacher_id)) {
    $_SESSION['error'] = "teacher ID is not an integer!";
    header("Location: teachers.php");
    exit();
  }
  $sql = "SELECT * FROM teachers WHERE teacher_id =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    $_SESSION['error'] = "SQL error!";
    header("location: teachers.php?sql=error");
    exit();
  }
    mysqli_stmt_bind_param($stmt, "i", $teacher_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if ($result->num_rows == 0) {
      $_SESSION['error'] = "It looks like this teacher does not exist! ";
      header("Location: teachers.php");
      exit();
    }
    if ($row['active_status'] == 1) {
      $active = 0;
    }else {
      $active = 1;
    }
    $sql = "UPDATE teachers SET active_status = ? WHERE teacher_id =?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error!";
      header("location: teachers.php?sql=error");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ii", $active, $teacher_id);
      if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "TEACHER $teacher_id ACTIVE STATUS IS NOW UPDATED!";
        header("Location: teachers.php");
        exit();
      }

}

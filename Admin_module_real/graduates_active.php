<?php
require_once "checker.php";
require_once 'includes_profile_id_check.php';
$class = 1;
if (isset($_POST['active_status']) && isset($_POST['student_id'])) {
  $student_id1 = $_POST['student_id'];
  $N = count($student_id1);
for($i=0; $i < $N; $i++)
  {

  $student_id = $student_id1[$i];
  $active = 1;

  if (!is_numeric($student_id)) {
    $_SESSION['error'] = "Student ID is not an integer!";
    header("Location: students.php");
    exit();
  }
  $sql = "SELECT * FROM student WHERE student_id =? AND class_id =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    $_SESSION['error'] = "SQL error!";
    header("location: graduates.php?sql=error");
    exit();
  }
    mysqli_stmt_bind_param($stmt, "ii", $student_id, $class);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if ($result->num_rows == 0) {
      $_SESSION['error'] = "It looks like this student $student_id  does not exist as Graduate!";
      header("Location: graduates.php");
      exit();
    }

    $sql = "UPDATE student SET active_status = ? WHERE student_id =?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error!";
      header("location: students.php?sql=error");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ii", $active, $student_id);
      mysqli_stmt_execute($stmt);
    }
    $_SESSION['success'] = "$N graduates have been successfully activated!";
    header("Location: graduates.php");
    exit();

}
elseif(isset($_POST['inactive_status']) && isset($_POST['student_id'])) {
    $student_id1 = $_POST['student_id'];
    $N = count($student_id1);
  for($i=0; $i < $N; $i++)
    {

    $student_id = $student_id1[$i];
    $active = 0;

    if (!is_numeric($student_id)) {
      $_SESSION['error'] = "Student ID is not an integer!";
      header("Location: students.php");
      exit();
    }
    $sql = "SELECT * FROM student WHERE student_id =? AND class_id =?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error!";
      header("location: graduates.php?sql=error");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ii", $student_id, $class);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      if ($result->num_rows == 0) {
        $_SESSION['error'] = "It looks like this student $student_id  does not exist as Graduate!";
        header("Location: graduates.php");
        exit();
      }

      $sql = "UPDATE student SET active_status = ? WHERE student_id =?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['error'] = "SQL error!";
        header("location: students.php?sql=error");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "ii", $active, $student_id);
        mysqli_stmt_execute($stmt);
      }
      $_SESSION['success'] = "$N graduates have been successfully deactivated!";
      header("Location: graduates.php");
      exit();

}else {
  $_SESSION['error'] = "Form is not settled properly!";
  header("Location: graduates.php");
  exit();
}

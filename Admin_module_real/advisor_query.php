<?php
require_once "checker.php";
if (isset($_POST['class_id']) && isset($_POST['teacher_id'])) {
  $class = $_POST['class_id'];
  $teacher = $_POST['teacher_id'];
  $N = count($class);
  for($i=0; $i < $N; $i++)
  {
    $class_id = trim(htmlspecialchars($class[$i]));
    $teacher_id = trim(htmlspecialchars($teacher[$i]));

    $sql_grade = "SELECT * FROM advisory WHERE class_id=?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "i", $class_id);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows > 0) {
      $sql_grade = "UPDATE advisory SET teacher_id = ? WHERE class_id =?;";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql_grade);
      mysqli_stmt_bind_param($stmt, "ii", $teacher_id, $class_id);
      mysqli_stmt_execute($stmt);
    }else {
      $sql_grade = "INSERT INTO advisory (teacher_id, class_id) VALUE (?,?);";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql_grade);
      mysqli_stmt_bind_param($stmt, "ii", $teacher_id, $class_id);
      mysqli_stmt_execute($stmt);
    }
  }

  $_SESSION['success'] ="Update Success!";
  header("location: advisor.php");
  exit();
}else {
  $_SESSION['error'] ="Data are not settled properly";
  header("location: advisor.php");
  exit();
}

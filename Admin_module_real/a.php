<?php
require_once "checker.php";
$validation = 0;
$active = 1;
$check_section = "SELECT * FROM student where active_status = ? AND dropped = ? AND transferred =?;";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $check_section);
mysqli_stmt_bind_param($stmt, "iii", $active, $active, $active);
mysqli_stmt_execute($stmt);
$result_check = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result_check)) {
  $student_id = $row['student_id'];
  $section_id = $row['class_id'];
  $section2 = "SELECT * FROM class where class_id = ?;";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $section2);
  mysqli_stmt_bind_param($stmt, "i", $section_id);
  mysqli_stmt_execute($stmt);
  $check = mysqli_stmt_get_result($stmt);
  $class = mysqli_fetch_assoc($check);
  if ($class['grade'] != 100) {
    $grade = $class['grade'];
    if ($class['ste'] == 1) {
      $sql = "SELECT * FROM subjects where grade =? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $grade);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    else {
      $ste = 0;
      $sql = "SELECT * FROM subjects where grade =? AND ste = ? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "ii", $grade, $ste);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    $result44->data_seek(0);
    $myArr2 = [];
    while ($row1010 = mysqli_fetch_assoc($result44)) {
            $sql = "SELECT * FROM stu_grade where student_id =? AND subject_id =?";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $student_id, $row1010['subject_id']);
            mysqli_stmt_execute($stmt);
            $result46 = mysqli_stmt_get_result($stmt);
            if ($result46->num_rows > 0) {
              $row1111 = mysqli_fetch_assoc($result46);
              $teacher_id = $row1111['teacher_id'];
              array_push($myArr2, $row1111['final']);
            }else {
              array_push($myArr2, 0);
            }
    }
    if(min($myArr2) < 1) {
      $validation = 1;
    }
  }
}

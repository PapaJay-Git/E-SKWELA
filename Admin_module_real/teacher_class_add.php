<?php
//this gonna be used in admin page
require_once 'header.php';
if (isset($_POST['add_teacher_class'])) {
  $subject_id = $_POST['subject_id'];
  $class_id = $_POST['class_id'];
  //sub_id equivalent sub-code
  $sql_sub = "SELECT subject_code FROM subjects WHERE subject_id=$subject_id";
  $result_sub = $conn->query($sql_sub);
  $row_sub = $result_sub->fetch_assoc();
  //class_id equivalent class_name
  $sql_class = "SELECT class_name FROM class WHERE class_id=$class_id";
  $result_class = $conn->query($sql_class);
  $row_class = $result_class->fetch_assoc();
  $sql_stuid = "INSERT INTO teacher_class (teacher_id, class_id, subject_id, subject_code, class_name) VALUES (?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_stuid)) {
    header("location: index.php?sql=error");
    exit();
  } else {
    //run sql
    mysqli_stmt_bind_param($stmt, "iiiss", $_SESSION['session_id'], $class_id, $subject_id, $row_sub['subject_code'], $row_class['class_name']);
    mysqli_stmt_execute($stmt);
    $resultid = mysqli_stmt_get_result($stmt);
         $conn->close();
         header("location: index.php?added");
       }
}else{
  header("location: index.php?add=noset");
}

?>

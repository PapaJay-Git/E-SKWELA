<?php
require_once "../assets/db.php";

if (isset($_SESSION['admin_session_id']) && isset($_SESSION['admin_last_session_id'])) {
  $admin_id = $_SESSION['admin_session_id'];
  $sql = "SELECT * FROM admin where admin_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $admin_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        header("location: ../Admin_module_real/index.php");
        exit();
      }else {
        unset($_SESSION['admin_session_id']);
        unset($_SESSION['admin_last_session_id']);
      }
}elseif (isset($_SESSION['teacher_session_id']) && isset($_SESSION['teacher_last_session_id'])) {
  $teacher_id = $_SESSION['teacher_session_id'];
  $sql = "SELECT * FROM teachers where teacher_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $teacher_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
          header("location: ../teacher_module/index.php");
          exit();
      }else {
        unset($_SESSION['teacher_session_id']);
        unset($_SESSION['teacher_last_session_id']);
      }
}elseif (isset($_SESSION['parent_session_id']) && isset($_SESSION['parent_last_session_id'])) {
  $parent_id = $_SESSION['parent_session_id'];
  $sql = "SELECT * FROM parents where parent_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $parent_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        header("location: ../parent_module/index.php");
        exit();
      }else {
        unset($_SESSION['parent_session_id']);
        unset($_SESSION['parent_last_session_id']);
      }
}elseif (isset($_SESSION['student_session_id']) && isset($_SESSION['last_session_id'])) {
  $student_id = $_SESSION['student_session_id'];
  $last_session_id = $_SESSION['last_session_id'];
  $sql = "SELECT * FROM student where student_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $student_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
          $assoc = mysqli_fetch_assoc($result);
          if ($assoc['last_session_id'] == $last_session_id) {
            header("location: ../student_module/index.php");
            exit();
          }
      }else {
        unset($_SESSION['student_session_id']);
        unset($_SESSION['last_session_id']);
      }
}else {
  session_destroy();
}

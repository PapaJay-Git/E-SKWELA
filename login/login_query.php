<?php
require_once "../assets/db.php";
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
if (isset($_POST['teacher_id']) && isset($_POST['teacher_password'])) {
  $inputed_password = $_POST['teacher_password'];
  $ID = $_POST['teacher_id'];

  $sql = "SELECT * FROM teachers where teacher_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $ID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $old_password = $row['password'];
        $teacher_id = $row['teacher_id'];
      } else {
        echo "wrongid";
        exit();
      }
      $active = $row['active_status'];
      if ($active == 0 || $active != 1) {
        echo "inactive";
        exit();
      }
      if(password_verify($inputed_password, $old_password)) {
        $sql = "UPDATE teachers SET last_session_id = ? WHERE teacher_id =?";
        $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "si", $date, $teacher_id);
            mysqli_stmt_execute($stmt);
        $_SESSION['teacher_last_session_id'] = $date;
        $_SESSION['teacher_session_id'] = $teacher_id;
        echo "success";
        exit();
      }else {
        echo "wrongpassword";
        exit();
      }
}
elseif (isset($_POST['student_id']) && isset($_POST['student_password'])) {
  $inputed_password = $_POST['student_password'];
  $ID = $_POST['student_id'];

  $sql = "SELECT * FROM student where student_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $ID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $old_password = $row['password'];
        $student_id = $row['student_id'];
      } else {
        echo "wrongid2";
        exit();
      }
      $active = $row['active_status'];
      $drop = $row['dropped'];
      $transfer = $row['transferred'];
      if ($active == 0 || $active != 1 || $drop == 0 || $drop != 1 || $transfer == 0 || $transfer != 1 ) {
        echo "inactive";
        exit();
      }
      if(password_verify($inputed_password, $old_password)) {
        $sql = "UPDATE student SET last_session_id = ? WHERE student_id =?";
        $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "si", $date, $student_id);
            mysqli_stmt_execute($stmt);
        $_SESSION['last_session_id'] = $date;
        $_SESSION['student_session_id'] = $student_id;
        echo "success2";
        exit();
      }else {
        echo "wrongpassword2";
        exit();
      }
}  elseif (isset($_POST['parent_id']) && isset($_POST['parent_password'])) {
    $inputed_password = $_POST['parent_password'];
    $ID = $_POST['parent_id'];

    $sql = "SELECT * FROM parents where parent_id =?";
    $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "i", $ID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result->num_rows > 0) {
          $row = mysqli_fetch_assoc($result);
          $old_password = $row['password'];
          $parent_id = $row['parent_id'];
        } else {
          echo "wrongid3";
          exit();
        }
        if(password_verify($inputed_password, $old_password)) {
          $sql = "UPDATE parents SET last_session_id = ? WHERE parent_id =?";
          $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $sql);
              mysqli_stmt_bind_param($stmt, "si", $date, $parent_id);
              mysqli_stmt_execute($stmt);
          $_SESSION['parent_last_session_id'] = $date;
          $_SESSION['parent_session_id'] = $parent_id;
          echo "success3";
          exit();
        }else {
          echo "wrongpassword3";
          exit();
        }
  }
else{
    echo "notset";
    exit();
}

<?php
require_once "checker.php";
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

if(isset($_POST['section_id']) && isset($_POST['transfer_students'])) {
  $section_id = $_POST['section_id'];
  $students = $_POST['transfer_students'];
  $N = count($students);
  $N2 = count($students);
  $sql = "SELECT * FROM class where class_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $section_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows < 1) {
        $_SESSION['error'] = "It looks like the section you are transferring to does not exist!";
          header("location: previous_10.php");
          exit();
      }
      $row = mysqli_fetch_assoc($result);
      $class_name = $row['class_name'];
      for($i=0; $i < $N; $i++)
      {
        $student_id1 = $students[$i];
        $sql = "SELECT * FROM student where student_id =?;";
        $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "i", $student_id1);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result->num_rows == 0) {
                $_SESSION['error'] = "It looks like this student ID $student_id1 does not exist!";
                header("location: previous_10.php");
                exit();
            }
      }
      for($e=0; $e < $N2; $e++)
      {
        $student_id = $students[$e];
        $sql = "UPDATE student SET class_id =? where student_id =?;";
        $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $section_id, $student_id);
            mysqli_stmt_execute($stmt);
            $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
            $type_notif = "transfered";
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "iiiss",  $section_id, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
              mysqli_stmt_execute($stmt);
      }
        $_SESSION['success'] = "$N2 student Have been transfered to $class_name successfully!";
        header("location: previous_10.php");
        exit();
}else {
  $_SESSION['error'] = "Please check the checkbox of the student you want to change the details and the choose a section!";
    header("location: previous_10.php");
    exit();
}

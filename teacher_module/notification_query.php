<?php
require_once "checker.php";
require_once 'includes_profile_id_check.php';

if (isset($_POST['read']) && isset($_POST['notif_id']) ) {
  $fn = $_POST['notif_id'];
  $teacher_id = $_SESSION['teacher_session_id'];
  $N = count($fn);
  $N2 = count($fn);

  for($e=0; $e < $N2; $e++)
  {
  $notif_id = $fn[$e];
  $sql_grade = "SELECT * FROM teacher_notification WHERE id = ? AND teacher_id = ?;";
  $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "ii", $notif_id, $teacher_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
   if ($result->num_rows == 0) {
     $_SESSION['error']= "Invalid Notification ID!";
     header("location: teacher_notification.php?success=id_not_exist");
     exit();
   }
  }
  for($i=0; $i < $N2; $i++)
  {
  $read = "read";
  $notif_id = $fn[$i];
  $sql_grade = "UPDATE teacher_notification SET status = ? WHERE id =? AND teacher_id =?;";
  $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "sii", $read, $notif_id, $teacher_id);
    mysqli_stmt_execute($stmt);
  }

 $_SESSION['success']= "$N notification successfully marked as read!";
 header("location: teacher_notification.php?notset");
 exit();

}elseif (isset($_POST['delete']) && isset($_POST['notif_id']) ) {
  $fn = $_POST['notif_id'];
  $teacher_id = $_SESSION['teacher_session_id'];
  $N = count($fn);
  $N2 = count($fn);

  for($e=0; $e < $N2; $e++)
  {
  $notif_id = $fn[$e];
  $sql_grade = "SELECT * FROM teacher_notification WHERE id = ? AND teacher_id = ?;";
  $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "ii", $notif_id, $teacher_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
   if ($result->num_rows == 0) {
     $_SESSION['error']= "Invalid Notification ID!";
     header("location: teacher_notification.php?success=id_not_exist");
     exit();
   }
  }
  for($i=0; $i < $N2; $i++)
  {
  $read = "read";
  $notif_id3 = $fn[$i];
  $sql_grade = "DELETE FROM teacher_notification WHERE id =? AND teacher_id =?;";
  $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "ii", $notif_id3, $teacher_id);
    mysqli_stmt_execute($stmt);
  }

 $_SESSION['success']= "$N notification successfully deleted!";
 header("location: teacher_notification.php?notset");
 exit();
}elseif (isset($_POST['notif_id']) && !isset($_POST['delete']) && !isset($_POST['read']) ) {
  $notif_id = $_POST['notif_id'];
  $teacher_id = $_SESSION['teacher_session_id'];
  $read = "read";
  $sql_grade = "UPDATE teacher_notification SET status = ? WHERE id =? AND teacher_id =?;";
  $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "sii", $read, $notif_id, $teacher_id);
    mysqli_stmt_execute($stmt);
}else {
  $_SESSION['error']= "Invalid URL!";
 header("location: teacher_notification.php?notset");
 exit();
}

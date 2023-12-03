<?php
require_once 'checker.php';
require_once 'includes_exam_id_check.php';
require_once 'includes_exam_id_val.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
$id = $_GET['tc_id'];
$unread = "unread";
      if ($examrow['published'] == 1) {
        $zero = 0;
        $exam__id = $examrow['exam_id'];
        $update_published = "UPDATE exam SET published = 0 WHERE exam_id = $exam__id;";
        $conn->query($update_published);
        $update_published3 = "UPDATE student_exam SET published = 0 WHERE exam_id = $exam__id;";
        $conn->query($update_published3);
        $sql = "UPDATE student_notification SET published =?, date_given =? WHERE exam_id =?;";
        $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $sql);
              mysqli_stmt_bind_param($stmt, "isi", $zero, $date, $exam__id);
              mysqli_stmt_execute($stmt);
        $_SESSION['success'] = "Exam now Unpublished!";
        $conn->close();
        header("location: teacher_view_exam.php?tc_id=$id&success=true");
          exit();
      }else{
        $one = 1;
        $exam__id = $examrow['exam_id'];
        $update_published = "UPDATE exam SET published = 1 WHERE exam_id = $exam__id;";
        $conn->query($update_published);
        $update_published4 = "UPDATE student_exam SET published = 1 WHERE exam_id = $exam__id;";
        $conn->query($update_published4);
        $sql = "UPDATE student_notification SET published =?, date_given =?, status = ? WHERE exam_id =?;";
        $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $sql);
              mysqli_stmt_bind_param($stmt, "issi", $one, $date, $unread, $exam__id);
              mysqli_stmt_execute($stmt);
        $_SESSION['success'] = "Exam now Published!";
        $conn->close();
        header("location: teacher_view_exam.php?tc_id=$id&success=true");
          exit();
      }

<?php
require_once 'checker.php';
require_once 'includes_assignment_id_check.php';
require_once 'includes_assignment_id_val.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
$id = $_GET['tc_id'];
$unread = "unread";
      if ($assrow['published'] == 1) {
        $zero = 0;
        $ass__id = $assrow['teacher_assignment_id'];
        $update_published = "UPDATE teacher_assignments SET published = 0 WHERE teacher_assignment_id = $ass__id;";
        $conn->query($update_published);
        $sql = "UPDATE student_notification SET published =?, date_given =? WHERE assignment_id =?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "isi", $zero, $date, $ass__id);
        mysqli_stmt_execute($stmt);
        $_SESSION['success'] = "Assignment now Unpublished!";
        $conn->close();
        header("location: teacher_view_assignments.php?tc_id=$id&success=true");
          exit();
      }else{
        $one = 1;
        $ass__id = $assrow['teacher_assignment_id'];
        $update_published = "UPDATE teacher_assignments SET published = 1 WHERE teacher_assignment_id  = $ass__id;";
        $conn->query($update_published);
        $sql = "UPDATE student_notification SET published =?, date_given =?, status = ? WHERE assignment_id =?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "issi", $one, $date, $unread, $ass__id);
        mysqli_stmt_execute($stmt);
        $_SESSION['success'] = "Assignment now Published!";
        $conn->close();
        header("location: teacher_view_assignments.php?tc_id=$id&success=true");
          exit();
      }

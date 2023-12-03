<?php
require_once 'checker.php';
require_once 'includes_quiz_id_check.php';
require_once 'includes_quiz_id_val.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
$id = $_GET['tc_id'];
$unread = "unread";
      if ($quizrow['published'] == 1) {
        $zero = 0;
        $quiz__id = $quizrow['quiz_id'];
        $update_published = "UPDATE quiz SET published = 0 WHERE quiz_id = $quiz__id;";
        $conn->query($update_published);
        $update_published2 = "UPDATE student_quiz SET published = 0 WHERE quiz_id = $quiz__id;";
        $conn->query($update_published2);
        $sql = "UPDATE student_notification SET published =?, date_given =? WHERE quiz_id =?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "isi", $zero, $date, $quiz__id);
        mysqli_stmt_execute($stmt);
        $_SESSION['success'] = "Quiz now Unpublished!";
        $conn->close();
        header("location: teacher_view_quiz.php?tc_id=$id&success=true");
          exit();
      }else{
        $one = 1;
        $quiz__id = $quizrow['quiz_id'];
        $update_published = "UPDATE quiz SET published = 1 WHERE quiz_id = $quiz__id;";
        $conn->query($update_published);
        $update_published3 = "UPDATE student_quiz SET published = 1 WHERE quiz_id = $quiz__id;";
        $conn->query($update_published3);
        $sql = "UPDATE student_notification SET published =?, date_given =?, status=? WHERE quiz_id =?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "issi", $one, $date, $unread, $quiz__id);
        mysqli_stmt_execute($stmt);
        $_SESSION['success'] = "Quiz now Published!";
        $conn->close();
        header("location: teacher_view_quiz.php?tc_id=$id&success=true");
          exit();
      }

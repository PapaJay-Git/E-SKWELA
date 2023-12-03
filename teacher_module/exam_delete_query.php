<?php
require_once 'checker.php';
require_once 'includes_exam_id_check.php';

$id = $_GET['tc_id'];
$examid = $_GET['exam_id'];
$delete_query = "DELETE FROM exam WHERE exam_id=? AND teacher_class_id=? AND teacher_id=?;";
$stmt = mysqli_stmt_init($conn);
//Preparing the prepared statement
if(!mysqli_stmt_prepare($stmt, $delete_query)) {
    $_SESSION['error'] = "SQL error, deleting exam. Please contact tech support.";
    echo mysqli_error($conn);
    header("Location: teacher_view_exam.php?tc_id=$id&sql=error");
  exit();
}
  //run sql
  mysqli_stmt_bind_param($stmt, "iii", $examid, $id, $_SESSION['teacher_session_id']);
  mysqli_stmt_execute($stmt);
  $delete_query = "DELETE FROM exam_question WHERE exam_id=?";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $delete_query)) {
      $_SESSION['error'] = "SQL error, deleting exam questions. Please contact tech support.";
      echo mysqli_error($conn);
      header("Location: teacher_view_exam.php?tc_id=$id&sql=error");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "i", $examid);
    mysqli_stmt_execute($stmt);

    $delete_query = "DELETE FROM student_exam WHERE exam_id=? AND teacher_class_id=? AND teacher_id=?;";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $delete_query)) {
        $_SESSION['error'] = "SQL error, deleting student exam. Please contact tech support.";
        echo mysqli_error($conn);
        header("Location: teacher_view_exam.php?tc_id=$id&sql=error");
      exit();
    }
      //run sql
      mysqli_stmt_bind_param($stmt, "iii", $examid, $id, $_SESSION['teacher_session_id']);
      mysqli_stmt_execute($stmt);
      //delete answered questions
      $delete_query = "DELETE FROM student_exam_answer WHERE exam_id=?;";
      $stmt = mysqli_stmt_init($conn);
      //Preparing the prepared statement
      if(!mysqli_stmt_prepare($stmt, $delete_query)) {
          $_SESSION['error'] = "SQL error, deleting student exam answers. Please contact tech support.";
          echo mysqli_error($conn);
          header("Location: teacher_view_exam.php?tc_id=$id&sql=error");
        exit();
      }
        //run sql
        mysqli_stmt_bind_param($stmt, "i", $examid);
        mysqli_stmt_execute($stmt);
        $deleteQuery = "DELETE FROM student_notification WHERE exam_id=? AND teacher_id=?;";
        $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $deleteQuery);
          mysqli_stmt_bind_param($stmt, "ii", $examid, $_SESSION['teacher_session_id']);
          mysqli_stmt_execute($stmt);
         $conn->close();
        $_SESSION['success'] = "Exam Deleted successfully!";
        header("Location: teacher_view_exam.php?tc_id=$id&result=success");
        exit();

<?php
require_once 'checker.php';
require_once 'includes_quiz_id_check.php';

$id = $_GET['tc_id'];
$quizid = $_GET['quiz_id'];
$delete_query = "DELETE FROM quiz WHERE quiz_id=? AND teacher_class_id=? AND teacher_id=?;";
$stmt = mysqli_stmt_init($conn);
//Preparing the prepared statement
if(!mysqli_stmt_prepare($stmt, $delete_query)) {
    $_SESSION['error'] = "SQL error, please contact tech support.";
    echo mysqli_error($conn);
    header("Location: teacher_view_quiz.php?tc_id=$id&sql=error");
  exit();
}
  //run sql
  mysqli_stmt_bind_param($stmt, "iii", $quizid, $id, $_SESSION['teacher_session_id']);
  mysqli_stmt_execute($stmt);
  $delete_query = "DELETE FROM quiz_question WHERE quiz_id=?";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $delete_query)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
      header("Location: teacher_view_quiz.php?tc_id=$id&sql=error");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "i", $quizid);
    mysqli_stmt_execute($stmt);
    $delete_query = "DELETE FROM student_quiz WHERE quiz_id=? AND teacher_class_id=? AND teacher_id=?;";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $delete_query)) {
        $_SESSION['error'] = "SQL error, please contact tech support.";
        echo mysqli_error($conn);
        header("Location: teacher_view_quiz.php?tc_id=$id&sql=error");
      exit();
    }
      //run sql
      mysqli_stmt_bind_param($stmt, "iii", $quizid, $id, $_SESSION['teacher_session_id']);
      mysqli_stmt_execute($stmt);
      $deleteQuery = "DELETE FROM student_notification WHERE quiz_id=? AND teacher_id=?;";
      $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "ii", $quizid, $_SESSION['teacher_session_id']);
        mysqli_stmt_execute($stmt);
         $conn->close();
        $_SESSION['success'] = "Quiz Deleted successfully!";
        header("Location: teacher_view_quiz.php?tc_id=$id&result=success");
        exit();

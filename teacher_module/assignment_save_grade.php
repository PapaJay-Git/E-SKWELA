<?php
  require_once 'checker.php';
  require_once 'includes_assignment_id_check.php';
  require_once 'includes_assignment_id_val.php';
  require_once 'includes_assignment_student_id.php';
  date_default_timezone_set('Asia/Manila');
  $date = date('Y-m-d H:i:s');

  if (isset($_POST['save_ass']) && isset($_POST['student_assignment_id']) && isset($_POST['score'])) {
    $score = htmlspecialchars($_POST['score']);
    $student_ass = htmlspecialchars($_POST['student_assignment_id']);
    $tc_id = htmlspecialchars($_GET['tc_id']);
    $ass_id = htmlspecialchars($_GET['ass_id']);
    $student_id = htmlspecialchars($_GET['student_id']);

      if (!is_numeric($score)|| !is_numeric($student_ass) || !is_numeric($student_id) || !is_numeric($ass_id) || !is_numeric($tc_id)) {
        $_SESSION['error']= "Error, no blank or string please. Add Zero instead.";
        header("location: assignment_student_answer.php?tc_id=$tc_id&ass_id=$ass_id&student_id=$student_id&non_numeric");
        exit();
      }
     $sql_grade = "UPDATE student_assignment SET score=? WHERE student_id=? AND teacher_assignment_id =? AND student_assignment_id=? AND teacher_id=?;";
     $stmt = mysqli_stmt_init($conn);
     //Preparing the prepared statement
     if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
       $_SESSION['error']= "Error saving grade";
       header("location: assignment_student_answer.php?tc_id=$tc_id&ass_id=$ass_id&student_id=$student_id&success=sqlerror");
       exit();
     }
       //run sql
       mysqli_stmt_bind_param($stmt, "iiiii", $score, $student_id, $ass_id, $student_ass, $_SESSION['teacher_session_id']);
          if(!mysqli_stmt_execute($stmt)){
            $_SESSION['error']= "ERROR!";
            header("location: assignment_student_answer.php?tc_id=$tc_id&ass_id=$ass_id&student_id=$student_id&success=error");
            exit();
          }
          $notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, assignment_id, published) VALUES (?,?,?,?,?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "assignment_score";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiissii",  $assrow['class_id'], $student_id, $_SESSION['teacher_session_id'], $assrow['teacher_class_id'], $date, $type_notif, $ass_id, $assrow['published']);
            mysqli_stmt_execute($stmt);
      $_SESSION['success']= "SAVED!";
      header("location: assignment_student_answer.php?tc_id=$tc_id&ass_id=$ass_id&student_id=$student_id&success=true");
      exit();

   }else{
     $_SESSION['error']= "You cannot save an empty Grade!";
   header("location: assignment_student_answer.php?tc_id=$tc_id&ass_id=$ass_id&student_id=$student_id&notset");
   exit();
   }

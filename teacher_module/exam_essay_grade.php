<?php
  require_once 'checker.php';
  require_once 'includes_exam_id_check.php';
  require_once 'includes_exam_id_val.php';
  require_once 'includes_exam_student_id.php';
  date_default_timezone_set('Asia/Manila');
  // Then call the date functions
  //for minimun date deadline
  $date = date('Y-m-d H:i:s');

  $tc_id = htmlspecialchars($_GET['tc_id']);
  $exam_id = htmlspecialchars($_GET['exam_id']);
  $student_id = htmlspecialchars($_GET['student_id']);
  if (isset($_POST['save_essay']) && isset($_POST['essayScore']) && isset($_POST['question_id'])) {
    $score2 = $_POST['essayScore'];
    $question = $_POST['question_id'];
    $N = count($question);

    echo("You selected $N boxes ");
    //loop to on how man1y classes do the teacher want to add this exam. Based on the check boxes selected
    for($i=0; $i < $N; $i++)
    {
      $score = htmlspecialchars($score2[$i]);
      $question_id = htmlspecialchars($question[$i]);

      if (!is_numeric($score)|| !is_numeric($question_id) || !is_numeric($student_id) || !is_numeric($exam_id) || !is_numeric($tc_id)) {
        $_SESSION['error']= "Error, no blank or string please. Add Zero instead.";
        header("location: exam_student_answer.php?tc_id=$tc_id&exam_id=$exam_id&student_id=$student_id&non_numeric");
        exit();
      }
     $sql_grade = "UPDATE student_exam_answer SET essay_score=? WHERE student_id=? AND exam_id =? AND exam_question_id=?;";
     $stmt = mysqli_stmt_init($conn);
     //Preparing the prepared statement
     if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
       $_SESSION['error']= "Error saving grade";
       header("location: exam_student_answer.php?tc_id=$tc_id&exam_id=$exam_id&student_id=$student_id&success=sqlerror");
       exit();
     }
       //run sql
       mysqli_stmt_bind_param($stmt, "iiii", $score, $student_id, $exam_id, $question_id);
          if(!mysqli_stmt_execute($stmt)){
            $_SESSION['error']= "ERROR!";
            header("location: exam_student_answer.php?tc_id=$tc_id&exam_id=$exam_id&student_id=$student_id&success=error");
            exit();
          }

    }
    $notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, exam_id, published) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    $type_notif = "essay_score";
      mysqli_stmt_prepare($stmt, $notification);
      mysqli_stmt_bind_param($stmt, "iiiissii",  $examrow['class_id'], $student_id, $_SESSION['teacher_session_id'], $examrow['teacher_class_id'], $date, $type_notif, $exam_id, $examrow['published']);
      mysqli_stmt_execute($stmt);
      $_SESSION['success']= "SAVED!";
      header("location: exam_student_answer.php?tc_id=$tc_id&exam_id=$exam_id&student_id=$student_id&success=true");
      exit();

   }else{
     $_SESSION['error']= "You cannot save an empty Grade!";
   header("location: exam_student_answer.php?tc_id=$tc_id&exam_id=$exam_id&student_id=$student_id&notset");
   exit();
   }

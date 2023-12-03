<?php
require_once "includes_classes_id_check.php";
if (isset($_POST['save_all']) && isset($_POST['id_num']) && isset($_POST['first']) && isset($_POST['second'])
&& isset($_POST['third'])&& isset($_POST['fourth'])&& isset($_POST['final']) && isset($_POST['subject_id']) ) {
  $id1 = $_POST['id_num'];
  $first1 = $_POST['first'];
  $second1 = $_POST['second'];
  $third1 = $_POST['third'];
  $fourth1 = $_POST['fourth'];
  $final1 = $_POST['final'];
  $id = $_GET['tc_id'];
  $subject_id = htmlspecialchars($_POST['subject_id']);

  $N = count($id1);
  $N2 = count($id1);

  for($i1=0; $i1 < $N2; $i1++)
  {
    $first11 = htmlspecialchars($first1[$i1]);
    $second11 = htmlspecialchars($second1[$i1]);
    $third11 = htmlspecialchars($third1[$i1]);
    $fourth11 = htmlspecialchars($fourth1[$i1]);
    $final11 = htmlspecialchars($final1[$i1]);
    $student_id11 = htmlspecialchars($id1[$i1]);

    if (!is_numeric($subject_id) || !is_numeric($student_id11)) {
      $_SESSION['error']= "It looks like you're adding an invalid subject id or student id.";
      header("location: teacher_view_students.php?tc_id=".$id."&sqlerror");
      exit();
    }
      if (!is_numeric($first11)|| !is_numeric($second11) || !is_numeric($third11) || !is_numeric($fourth11) || !is_numeric($final11)) {
        $_SESSION['error']= "Error, no blank or string please. Add Zero instead.";
        header("location: teacher_view_students.php?tc_id=".$id."&sqlerror");
        exit();
      }
      if ($first11 > 100 || $second11 > 100 || $third11 > 100 || $fourth11 > 100 ||$final11 > 100) {
        $_SESSION['error']= "Sorry, no more than 100 please";
        header("location: teacher_view_students.php?tc_id=".$id."&sqlerror");
        exit();
      }

  }

  for($i=0; $i < $N; $i++)
  {
    $first = htmlspecialchars($first1[$i]);
    $second = htmlspecialchars($second1[$i]);
    $third = htmlspecialchars($third1[$i]);
    $fourth = htmlspecialchars($fourth1[$i]);
    $final = htmlspecialchars($final1[$i]);
    $student_id = htmlspecialchars($id1[$i]);
    //search if already exist
    $sql_grade = "SELECT * FROM stu_grade WHERE subject_id =? AND student_id=?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "ii", $subject_id, $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result->num_rows > 0){
      $sql_grade = "UPDATE stu_grade SET first=?, second=?, third=?, fourth=?, final=?, teacher_id=?, teacher_class_id=? WHERE subject_id = ? AND student_id=?;";
      $stmt = mysqli_stmt_init($conn);
      //Preparing the prepared statement
           if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
             $_SESSION['error']= "Error saving grade";
             echo $conn->error;
             //header("location: teacher_view_students.php?tc_id=".$id."&success=sqlerror");
             exit();
           }
        //run sql
           mysqli_stmt_bind_param($stmt, "dddddiiii", $first, $second, $third, $fourth, $final, $_SESSION['teacher_session_id'], $id, $subject_id, $student_id);
           if(!mysqli_stmt_execute($stmt)){
             $_SESSION['error']= "ERROR UPDATING STUDENT $student_id!";
             header("location: teacher_view_students.php?tc_id=".$id."&success=error");
             exit();
           }
    }else{
      $sql_grade = "INSERT INTO stu_grade (first, second, third, fourth, final, teacher_class_id, student_id, teacher_id, subject_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
      $stmt = mysqli_stmt_init($conn);
      //Preparing the prepared statement
           if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
             $_SESSION['error']= "Error saving grade";
             header("location: teacher_view_students.php?tc_id=".$id."&success=sqlerror");
             exit();
           }
        //run sql
           mysqli_stmt_bind_param($stmt, "dddddiiii", $first, $second, $third, $fourth, $final, $id, $student_id, $_SESSION['teacher_session_id'], $subject_id);
           if(!mysqli_stmt_execute($stmt)){
             $_SESSION['error']= "ERROR INSERTING STUDENT $student_id!";
             header("location: teacher_view_students.php?tc_id=".$id."&success=error");
             exit();
           }
         }
  }
    $_SESSION['success']= "SAVED!";
    header("location: teacher_view_students.php?tc_id=".$id."&success=true");
    exit();

 }else{
   $_SESSION['error']= "You cannot save an empty Grade!";
 header("location: teacher_view_students.php?tc_id=".$id."&notset");
 exit();
 }

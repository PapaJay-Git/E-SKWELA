<?php
require_once 'checker.php';
require_once 'includes_exam_id_check.php';
require_once 'includes_exam_id_val.php';
$exam_id = $_GET['exam_id'];
$tc_id = $_GET['tc_id'];
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
$allowedDate = date('Y-m-d H:i:s', strtotime('-59 minute'));
if(isset($_POST['add_one'])){
  $add_one = $_POST['add_one'];
}else {
  $add_one = 0;
}
if(isset($_POST['start_time'])){
  $start_time = $_POST['start_time'];
}else {
  $start_time = "Time Modified by student";
}
$student_id = $_SESSION['student_session_id'];
$sql333 = "SELECT used_attempt, deadline_date, max_attempt FROM student_exam where exam_id = $exam_id AND student_id = $student_id;";
$classNNN = $conn->query($sql333);
$classNN22 = mysqli_fetch_assoc($classNNN);
if($classNN22['deadline_date'] >= $allowedDate){
}else {
  $_SESSION['error'] = "Sorry, you cannot submit a quiz that is past its due.!";
  header("location: exam_open.php?tc_id=$tcid&exam_id=$exam_id&sql=error");
  exit();
}
if ($classNN22['used_attempt'] > $classNN22['max_attempt']) {
  $_SESSION['error'] = "Sorry, you have used all of your attempts. You cannot answer it again!";
  header("location: exam_open.php?tc_id=$tcid&exam_id=$exam_id&sql=error");
  exit();
}
if (isset($_POST['submit_exam'])) {
//Updating the questions
  if(isset($_POST['TF_id'])){
    $tf = $_POST['TF_id'];
    $N = count($tf);
    for($i=0; $i < $N; $i++)
    {
    $tf_answer = htmlspecialchars($_POST['TF'.$i]);
    $tf_id = $tf[$i];
    $sql = "SELECT * FROM exam_question WHERE exam_id=? AND exam_question_id =?";
    $stmt = mysqli_stmt_init($conn);
    $id = $_GET['tc_id'];
      if(!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_bind_param($stmt, "ii", $exam_id, $tf_id) || !mysqli_stmt_execute($stmt)) {
            $_SESSION['error'] = "SQL error";
            header("location: exam.php?sql=error");
            exit();
      }
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      $check1 = "SELECT exam_id, COUNT(*) AS count FROM student_exam_answer WHERE exam_question_id =? AND student_id =? GROUP BY answer_id";
      $stmt = mysqli_stmt_init($conn);
      $id = $_GET['tc_id'];
        if(!mysqli_stmt_prepare($stmt, $check1) || !mysqli_stmt_bind_param($stmt, "ii", $tf_id, $_SESSION['student_session_id']) || !mysqli_stmt_execute($stmt)) {
              $_SESSION['error'] = "SQL error";
              header("location: exam.php?sql=error");
              exit();
        }
        $result2 = mysqli_stmt_get_result($stmt);
        $type = 1;
        $row3 = mysqli_fetch_assoc($result2);
        $points_tf = $row['points_1'];
        if($tf_answer == $row['answer_1']){
          $score = $row['points_1'];
        }else {
          $score = 0;
        }
        if($row3['count'] == 0){
          $check2 = "INSERT INTO student_exam_answer (exam_question_id, student_id, exam_id, exam_type_id, answer_1, points_1, score) values (?, ?, ?, ?, ?, ?, ?);";
          $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $check2)){
                  $_SESSION['error'] = "SQL error";
                  header("location: exam.php?sql=error");
                  exit();
            }
            mysqli_stmt_bind_param($stmt, "iiiisii", $tf_id, $_SESSION['student_session_id'], $exam_id, $type, $tf_answer, $points_tf, $score);
            mysqli_stmt_execute($stmt);
        }else{
          $check2 = "UPDATE student_exam_answer SET answer_1= ?,points_1= ?, score = ? WHERE exam_question_id = ? AND student_id= ?";
          $stmt = mysqli_stmt_init($conn);
          $id = $_GET['tc_id'];
            if(!mysqli_stmt_prepare($stmt, $check2)){
                  $_SESSION['error'] = "SQL error";
                  header("location: exam.php?sql=error");
                  exit();
            }
            mysqli_stmt_bind_param($stmt, "siiii", $tf_answer, $points_tf, $score, $tf_id, $_SESSION['student_session_id']);
            mysqli_stmt_execute($stmt);
        }

    }
  }
  if(isset($_POST['multi_id'])){
    $multi = $_POST['multi_id'];
    $N = count($multi);
    for($i=0; $i < $N; $i++)
    {
    $multi_answer = htmlspecialchars($_POST['multi'.$i]);
    $multi_id = $multi[$i];
    $sql = "SELECT * FROM exam_question WHERE exam_id=? AND exam_question_id =?";
    $stmt = mysqli_stmt_init($conn);
    $id = $_GET['tc_id'];
      if(!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_bind_param($stmt, "ii", $exam_id, $multi_id) || !mysqli_stmt_execute($stmt)) {
            $_SESSION['error'] = "SQL error";
            header("location: exam.php?sql=error");
            exit();
      }
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      $check1 = "SELECT exam_id, COUNT(*) AS count FROM student_exam_answer WHERE exam_question_id =? AND student_id =? GROUP BY answer_id";
      $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $check1) || !mysqli_stmt_bind_param($stmt, "ii", $multi_id, $_SESSION['student_session_id']) || !mysqli_stmt_execute($stmt)) {
              $_SESSION['error'] = "SQL error";
              header("location: exam.php?sql=error");
              exit();
        }
        $result2 = mysqli_stmt_get_result($stmt);
        $type = 2;
        $row3 = mysqli_fetch_assoc($result2);
        $points_multi = $row['points_1'];
        if($multi_answer == $row['answer_1']){
          $score = $row['points_1'];
        }else {
          $score = 0;
        }
        if($row3['count'] == 0){
          $check2 = "INSERT INTO student_exam_answer (exam_question_id, student_id, exam_id, exam_type_id, answer_1, points_1, score) values (?, ?, ?, ?, ?, ?, ?);";
          $stmt = mysqli_stmt_init($conn);
          $id = $_GET['tc_id'];
            if(!mysqli_stmt_prepare($stmt, $check2)){
                  $_SESSION['error'] = "SQL error";
                  header("location: exam.php?sql=error");
                  exit();
            }
            mysqli_stmt_bind_param($stmt, "iiiisii", $multi_id, $_SESSION['student_session_id'], $exam_id, $type, $multi_answer, $points_multi, $score);
            mysqli_stmt_execute($stmt);
        }else{
          $check2 = "UPDATE student_exam_answer SET answer_1= ?,points_1= ?, score = ? WHERE exam_question_id = ? AND student_id= ? AND exam_id= ? ";
          $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $check2)){
                  $_SESSION['error'] = "SQL error";
                  header("location: exam.php?sql=error");
                  exit();
            }
            mysqli_stmt_bind_param($stmt, "siiiii", $multi_answer, $points_multi, $score, $multi_id, $_SESSION['student_session_id'], $exam_id);
            mysqli_stmt_execute($stmt);
        }
    }
  }
  if(isset($_POST['enum_id'])){
    $enum = $_POST['enum_id'];
    $N = count($enum);
    for($i=0; $i < $N; $i++)
    {
    $enum_id = $enum[$i];
    $sql = "SELECT * FROM exam_question WHERE exam_id=? AND exam_question_id =?";
    $stmt = mysqli_stmt_init($conn);
    $id = $_GET['tc_id'];
      if(!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_bind_param($stmt, "ii", $exam_id, $enum_id) || !mysqli_stmt_execute($stmt)) {
            $_SESSION['error'] = "SQL error";
            header("location: exam.php?sql=error");
            exit();
      }
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      $points_1 = $row['points_1'];
      $points_2 = $row['points_2'];
      $points_3 = $row['points_3'];
      $points_4 = $row['points_4'];
      $points_5 = $row['points_5'];
      $answer_1 = NULL; $answer_2 = NULL; $answer_3 = NULL; $answer_4 = NULL; $answer_5 = NULL;
      $score = 0;
      if ($row['case_sensitive'] == "yes") {
        if($row['enum_sum'] == 1){
          $answer_1 = trim(htmlspecialchars($_POST['answer_1'.$i]));
          $answerbank = array($row['answer_1']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1;}
        }
        elseif($row['enum_sum'] == 2){
          $answer_1 = trim(htmlspecialchars($_POST['answer_1'.$i]));
          $answer_2 = trim(htmlspecialchars($_POST['answer_a_2'.$i]));
          $answerbank = array($row['answer_1'], $row['answer_a_2']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1; $key = array_search($answer_1, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_2, $answerbank)){ $score += $points_2; $key = array_search($answer_2, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
        }
        elseif($row['enum_sum'] == 3){
          $answer_1 = trim(htmlspecialchars($_POST['answer_1'.$i]));
          $answer_2 = trim(htmlspecialchars($_POST['answer_a_2'.$i]));
          $answer_3 = trim(htmlspecialchars($_POST['answer_b_3'.$i]));
          $answerbank = array($row['answer_1'], $row['answer_a_2'], $row['answer_b_3']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1; $key = array_search($answer_1, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_2, $answerbank)){ $score += $points_2; $key = array_search($answer_2, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_3, $answerbank)){ $score += $points_3; $key = array_search($answer_3, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
        }
        elseif($row['enum_sum'] == 4){
          $answer_1 = trim(htmlspecialchars($_POST['answer_1'.$i]));
          $answer_2 = trim(htmlspecialchars($_POST['answer_a_2'.$i]));
          $answer_3 = trim(htmlspecialchars($_POST['answer_b_3'.$i]));
          $answer_4 = trim(htmlspecialchars($_POST['answer_c_4'.$i]));
          $answerbank = array($row['answer_1'], $row['answer_a_2'], $row['answer_b_3'], $row['answer_c_4']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1; $key = array_search($answer_1, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_2, $answerbank)){ $score += $points_2; $key = array_search($answer_2, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_3, $answerbank)){ $score += $points_3; $key = array_search($answer_3, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_4, $answerbank)){ $score += $points_4; $key = array_search($answer_4, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
        }
        elseif($row['enum_sum'] == 5){
          $answer_1 = trim(htmlspecialchars($_POST['answer_1'.$i]));
          $answer_2 = trim(htmlspecialchars($_POST['answer_a_2'.$i]));
          $answer_3 = trim(htmlspecialchars($_POST['answer_b_3'.$i]));
          $answer_4 = trim(htmlspecialchars($_POST['answer_c_4'.$i]));
          $answer_5 = trim(htmlspecialchars($_POST['answer_d_5'.$i]));
          $answerbank = array($row['answer_1'], $row['answer_a_2'], $row['answer_b_3'], $row['answer_c_4'], $row['answer_d_5']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1; $key = array_search($answer_1, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_2, $answerbank)){ $score += $points_2; $key = array_search($answer_2, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_3, $answerbank)){ $score += $points_3; $key = array_search($answer_3, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_4, $answerbank)){ $score += $points_4; $key = array_search($answer_4, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_5, $answerbank)){ $score += $points_5; $key = array_search($answer_5, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
        }
      }else {
        if($row['enum_sum'] == 1){
          $answer_1 = trim(strtolower(htmlspecialchars($_POST['answer_1'.$i])));
          $answerbank = array($row['answer_1']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1;}
        }
        elseif($row['enum_sum'] == 2){
          $answer_1 = trim(strtolower(htmlspecialchars($_POST['answer_1'.$i])));
          $answer_2 = trim(strtolower(htmlspecialchars($_POST['answer_a_2'.$i])));
          $answerbank = array($row['answer_1'], $row['answer_a_2']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1; $key = array_search($answer_1, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_2, $answerbank)){ $score += $points_2; $key = array_search($answer_2, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
        }
        elseif($row['enum_sum'] == 3){
          $answer_1 = trim(strtolower(htmlspecialchars($_POST['answer_1'.$i])));
          $answer_2 = trim(strtolower(htmlspecialchars($_POST['answer_a_2'.$i])));
          $answer_3 = trim(strtolower(htmlspecialchars($_POST['answer_b_3'.$i])));
          $answerbank = array($row['answer_1'], $row['answer_a_2'], $row['answer_b_3']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1; $key = array_search($answer_1, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_2, $answerbank)){ $score += $points_2; $key = array_search($answer_2, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_3, $answerbank)){ $score += $points_3; $key = array_search($answer_3, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
        }
        elseif($row['enum_sum'] == 4){
          $answer_1 = trim(strtolower(htmlspecialchars($_POST['answer_1'.$i])));
          $answer_2 = trim(strtolower(htmlspecialchars($_POST['answer_a_2'.$i])));
          $answer_3 = trim(strtolower(htmlspecialchars($_POST['answer_b_3'.$i])));
          $answer_4 = trim(strtolower(htmlspecialchars($_POST['answer_c_4'.$i])));
          $answerbank = array($row['answer_1'], $row['answer_a_2'], $row['answer_b_3'], $row['answer_c_4']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1; $key = array_search($answer_1, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_2, $answerbank)){ $score += $points_2; $key = array_search($answer_2, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_3, $answerbank)){ $score += $points_3; $key = array_search($answer_3, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_4, $answerbank)){ $score += $points_4; $key = array_search($answer_4, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
        }
        elseif($row['enum_sum'] == 5){
          $answer_1 = trim(strtolower(htmlspecialchars($_POST['answer_1'.$i])));
          $answer_2 = trim(strtolower(htmlspecialchars($_POST['answer_a_2'.$i])));
          $answer_3 = trim(strtolower(htmlspecialchars($_POST['answer_b_3'.$i])));
          $answer_4 = trim(strtolower(htmlspecialchars($_POST['answer_c_4'.$i])));
          $answer_5 = trim(strtolower(htmlspecialchars($_POST['answer_d_5'.$i])));
          $answerbank = array($row['answer_1'], $row['answer_a_2'], $row['answer_b_3'], $row['answer_c_4'], $row['answer_d_5']);
          if (in_array($answer_1, $answerbank)){ $score += $points_1; $key = array_search($answer_1, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_2, $answerbank)){ $score += $points_2; $key = array_search($answer_2, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_3, $answerbank)){ $score += $points_3; $key = array_search($answer_3, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_4, $answerbank)){ $score += $points_4; $key = array_search($answer_4, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
          if (in_array($answer_5, $answerbank)){ $score += $points_5; $key = array_search($answer_5, $answerbank); if ($key !== false) {unset($answerbank[$key]);}}
        }
      }

      $check1 = "SELECT exam_id, COUNT(*) AS count FROM student_exam_answer WHERE exam_question_id =? AND student_id =? GROUP BY answer_id";
      $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $check1) || !mysqli_stmt_bind_param($stmt, "ii", $enum_id, $_SESSION['student_session_id']) || !mysqli_stmt_execute($stmt)) {
              $_SESSION['error'] = "SQL error";
              header("location: exam.php?sql=error");
              exit();
        }
        $result2 = mysqli_stmt_get_result($stmt);
        $type = 3;
        $row3 = mysqli_fetch_assoc($result2);
        if($row3['count'] == 0){
          $check2 = "INSERT INTO student_exam_answer (exam_question_id, student_id, exam_id, exam_type_id, answer_1, answer_a_2,
            answer_b_3, answer_c_4, answer_d_5, points_1, points_2, points_3, points_4, points_5, score) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
          $stmt = mysqli_stmt_init($conn);
          $id = $_GET['tc_id'];
            if(!mysqli_stmt_prepare($stmt, $check2)){
                  $_SESSION['error'] = "SQL error";
                  header("location: exam.php?sql=error");
                  exit();
            }
            mysqli_stmt_bind_param($stmt, "siiisssssiiiiii", $enum_id, $_SESSION['student_session_id'], $exam_id, $type, $answer_1, $answer_2, $answer_3,
            $answer_4, $answer_5, $points_1, $points_2, $points_3, $points_4, $points_5, $score);
            mysqli_stmt_execute($stmt);
        }else{
          $check2 = "UPDATE student_exam_answer SET answer_1=?, answer_a_2=?, answer_b_3=?, answer_c_4=?, answer_d_5=?, points_1=?,
          points_2=?, points_3=?, points_4=?, points_5=?, score=? WHERE exam_question_id = ? AND student_id= ? AND exam_id= ? ";
          $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $check2)){
                  $_SESSION['error'] = "SQL error";
                  header("location: exam.php?sql=error");
                  exit();
            }
            mysqli_stmt_bind_param($stmt, "sssssiiiiiiiii", $answer_1, $answer_2, $answer_3, $answer_4, $answer_5, $points_1, $points_2, $points_3,
            $points_4, $points_5, $score, $enum_id, $_SESSION['student_session_id'], $exam_id);
            mysqli_stmt_execute($stmt);
        }
      }
    }
  if(isset($_POST['iden_id'])){
      $iden = $_POST['iden_id'];
      $answer = $_POST['iden'];
      $N = count($iden);
      for($i=0; $i < $N; $i++)
      {
      $iden_id = $iden[$i];
      $sql = "SELECT * FROM exam_question WHERE exam_id=? AND exam_question_id =?";
      $stmt = mysqli_stmt_init($conn);
      $id = $_GET['tc_id'];
        if(!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_bind_param($stmt, "ii", $exam_id, $iden_id) || !mysqli_stmt_execute($stmt)) {
              $_SESSION['error'] = "SQL error";
              header("location: exam.php?sql=error");
              exit();
        }
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row['case_sensitive'] == "yes") {
          $iden_answer = trim(htmlspecialchars($answer[$i]));
        }else {
          $iden_answer = trim(strtolower(htmlspecialchars($answer[$i])));
        }
        $check1 = "SELECT exam_id, COUNT(*) AS count FROM student_exam_answer WHERE exam_question_id =? AND student_id =? GROUP BY answer_id";
        $stmt = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt, $check1) || !mysqli_stmt_bind_param($stmt, "ii", $iden_id, $_SESSION['student_session_id']) || !mysqli_stmt_execute($stmt)) {
                $_SESSION['error'] = "SQL error";
                header("location: exam.php?sql=error");
                exit();
          }
          $result2 = mysqli_stmt_get_result($stmt);
          $type = 4;
          $row3 = mysqli_fetch_assoc($result2);
          $points_iden = $row['points_1'];
          if($iden_answer == $row['answer_1']){
            $score = $row['points_1'];
          }else {
            $score = 0;
          }
          if($row3['count'] == 0){
            $check2 = "INSERT INTO student_exam_answer (exam_question_id, student_id, exam_id, exam_type_id, answer_1, points_1, score) values (?, ?, ?, ?, ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
            $id = $_GET['tc_id'];
              if(!mysqli_stmt_prepare($stmt, $check2)){
                    $_SESSION['error'] = "SQL error";
                    header("location: exam.php?sql=error");
                    exit();
              }
              mysqli_stmt_bind_param($stmt, "iiiisii", $iden_id, $_SESSION['student_session_id'], $exam_id, $type, $iden_answer, $points_iden, $score);
              mysqli_stmt_execute($stmt);
          }else{
            $check2 = "UPDATE student_exam_answer SET answer_1= ?,points_1= ?, score = ? WHERE exam_question_id = ? AND student_id= ? AND exam_id= ? ";
            $stmt = mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt, $check2)){
                    $_SESSION['error'] = "SQL error";
                    header("location: exam.php?sql=error");
                    exit();
              }
              mysqli_stmt_bind_param($stmt, "siiiii", $iden_answer, $points_iden, $score, $iden_id, $_SESSION['student_session_id'], $exam_id);
              mysqli_stmt_execute($stmt);
          }
        }
      }
  if(isset($_POST['essay_id'])){
            $essay = $_POST['essay_id'];
            $answer = $_POST['essay'];
            $N = count($essay);
            for($i=0; $i < $N; $i++)
            {
            $essay_answer = strtolower(htmlspecialchars($answer[$i]));
            $essay_id = $essay[$i];
            $sql = "SELECT * FROM exam_question WHERE exam_id=? AND exam_question_id =?";
            $stmt = mysqli_stmt_init($conn);
            $id = $_GET['tc_id'];
              if(!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_bind_param($stmt, "ii", $exam_id, $essay_id) || !mysqli_stmt_execute($stmt)) {
                    $_SESSION['error'] = "SQL error";
                    header("location: exam.php?sql=error");
                    exit();
              }
              $result = mysqli_stmt_get_result($stmt);
              $row = mysqli_fetch_assoc($result);
              $check1 = "SELECT exam_id, COUNT(*) AS count FROM student_exam_answer WHERE exam_question_id =? AND student_id =? GROUP BY answer_id";
              $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $check1) || !mysqli_stmt_bind_param($stmt, "ii", $essay_id, $_SESSION['student_session_id']) || !mysqli_stmt_execute($stmt)) {
                      $_SESSION['error'] = "SQL error";
                      header("location: exam.php?sql=error");
                      exit();
                }
                $result2 = mysqli_stmt_get_result($stmt);
                $type = 5;
                $row3 = mysqli_fetch_assoc($result2);
                $points_essay = $row['points_1'];
                $score = 0;
                if($row3['count'] == 0){
                  $check2 = "INSERT INTO student_exam_answer (exam_question_id, student_id, exam_id, exam_type_id, answer_1, points_1, score) values (?, ?, ?, ?, ?, ?, ?);";
                  $stmt = mysqli_stmt_init($conn);
                  $id = $_GET['tc_id'];
                    if(!mysqli_stmt_prepare($stmt, $check2)){
                          $_SESSION['error'] = "SQL error";
                          header("location: exam.php?sql=error");
                          exit();
                    }
                    mysqli_stmt_bind_param($stmt, "iiiisii", $essay_id, $_SESSION['student_session_id'], $exam_id, $type, $essay_answer, $points_essay, $score);
                    mysqli_stmt_execute($stmt);
                }else{
                  $check2 = "UPDATE student_exam_answer SET answer_1= ?,points_1= ?, score = ? WHERE exam_question_id = ? AND student_id= ? AND exam_id= ? ";
                  $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $check2)){
                          $_SESSION['error'] = "SQL error";
                          header("location: exam.php?sql=error");
                          exit();
                    }
                    mysqli_stmt_bind_param($stmt, "siiiii", $essay_answer, $points_essay, $score, $essay_id, $_SESSION['student_session_id'], $exam_id);
                    mysqli_stmt_execute($stmt);
                }
              }
            }

//Updating the exam for students
  $sql = "SELECT * FROM student_exam_answer WHERE student_id=? AND exam_id =? AND exam_type_id != ?";
  $stmt = mysqli_stmt_init($conn);
  $essayt = 5;
    if(!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_bind_param($stmt, "iii", $_SESSION['student_session_id'], $exam_id, $essayt) || !mysqli_stmt_execute($stmt)) {
          $_SESSION['error'] = "SQL error";
          exit();
    }
    $result14 = mysqli_stmt_get_result($stmt);
    $question_score =0;
    while($row14 = mysqli_fetch_assoc($result14)){
      $question_score += $row14['score'];
    }

    $querrye = "SELECT * FROM student_exam WHERE student_id=? AND exam_id =?";
    $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $querrye) || !mysqli_stmt_bind_param($stmt, "ii", $_SESSION['student_session_id'], $exam_id) || !mysqli_stmt_execute($stmt)) {
            $_SESSION['error'] = "SQL error";
            exit();
      }
      $result15 = mysqli_stmt_get_result($stmt);
      $row15 = mysqli_fetch_assoc($result15 );
      if($add_one == 1){
        $attemptss = $row15['used_attempt'];
      }else {
        $attemptss = $row15['used_attempt']+1;
      }
      $sql = "UPDATE student_exam SET used_attempt=?, question_score=?, submit_date=?, start_time =? WHERE exam_id=? AND student_id =?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_bind_param($stmt, "iissii", $attemptss, $question_score, $date, $start_time, $exam_id, $_SESSION['student_session_id']) || !mysqli_stmt_execute($stmt)) {
            $_SESSION['error'] = "SQL error";
            exit();
      }
      $notification = "SELECT * FROM exam where exam_id =?; ";
      $stmt = mysqli_stmt_init($conn);
      //Preparing the prepared statement
        mysqli_stmt_prepare($stmt, $notification);
        mysqli_stmt_bind_param($stmt, "i", $exam_id);
        mysqli_stmt_execute($stmt);
        $teachers = mysqli_stmt_get_result($stmt);
        $teacherRes = mysqli_fetch_assoc($teachers);
        $teacher_id = $teacherRes['teacher_id'];

        $notification = "SELECT * FROM teacher_notification where exam_id =? AND teacher_id =?; ";
        $stmt = mysqli_stmt_init($conn);
        //Preparing the prepared statement
          mysqli_stmt_prepare($stmt, $notification);
          mysqli_stmt_bind_param($stmt, "ii", $exam_id, $teacher_id);
          mysqli_stmt_execute($stmt);
          $notif = mysqli_stmt_get_result($stmt);
          if ($notif->num_rows > 0) {
            $notifRes = mysqli_fetch_assoc($notif);
            $notif_id = $notifRes['id'];
            $notification = "UPDATE teacher_notification SET status = ?, date_given = ? WHERE id = ?";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
            $unread = "unread";
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "ssi", $unread, $date, $notif_id);
              mysqli_stmt_execute($stmt);
          }else {
            $notification = "INSERT INTO teacher_notification (teacher_id, teacher_class_id, date_given, type, exam_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
            $type_notif = "exam";
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "iissi",  $teacher_id, $tc_id, $date, $type_notif, $exam_id);
              mysqli_stmt_execute($stmt);
          }


      $_SESSION['success'] = "Submit Success! All non-essay questions are now been graded.";
      header("location: exam_open.php?tc_id=$tc_id&exam_id=$exam_id&success");
      exit();
}else {
  $_SESSION['error'] = "You cannot go here without submit button! Please click the submit button for your submissions!";
  header("location: exam_open.php?tc_id=$tc_id&exam_id=$exam_id&success");
  exit();
}
// $age = $_POST['question_id'];
// $age1 = $_POST['type'];
//
// $N = count($age);
// //loop to on how many classes do the teacher want to add this exam. Based on the check boxes selected
// for($i=0; $i < $N; $i++)
// {
//   echo $age[$i]." ".$age1[$i]."<br>";
//

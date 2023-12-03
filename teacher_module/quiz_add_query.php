<?php

require_once 'checker.php';
require_once 'includes_quiz_id_check.php';
require_once 'includes_quiz_id_val.php';
    $id = $_GET['tc_id'];
    $quizid = $_GET['quiz_id'];
    date_default_timezone_set('Asia/Manila');
// Then call the date functions
    $viewid = $_GET['view_id'];
    $dates = date('Y-m-d H:i:s');
    $null = NULL;
    if (isset($_POST['check'])) {
      $case_sensitive = "yes";
      function checkText($string){
      $string2 = trim(htmlspecialchars($string));
      return $string2;
      }
    }else {
      $case_sensitive = "no";
      function checkText($string){
      $string2 = trim(strtolower(htmlspecialchars($string)));
      return $string2;
      }
    }
//ADDING QUIZ questions of true or false
if (isset($_POST['TF_Submit'])) {
    $question = htmlspecialchars($_POST['TFQ']);
    $correctAns = htmlspecialchars($_POST['TFcorrect']);
    $points = htmlspecialchars($_POST['TFpoints']);
    $type = 1;
    $add_question = "INSERT INTO quiz_question
    (quiz_id, quiz_question_txt, quiz_type_id, date_added, date_edited, answer_1, points_1)
    VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $add_question)) {
        $_SESSION['error'] = "SQL error, please contact tech support.";
        echo mysqli_error($conn);
      header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
      exit();
    } else {
      //run sql
      mysqli_stmt_bind_param($stmt, "isisssi", $quizid, $question, $type, $dates, $dates, $correctAns, $points);
      mysqli_stmt_execute($stmt);
           $conn->close();
           $_SESSION['success'] = "Question added!";
           header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
           exit();
         }
}
//ADDING QUIZ questions of multiple choice
elseif(isset($_POST['Multi_Submit'])) {
    $question = htmlspecialchars($_POST['MCQ']);
    $correctAns = htmlspecialchars($_POST['multi_correct']);
    $a = htmlspecialchars($_POST['A']);
    $b = htmlspecialchars($_POST['B']);
    $c = htmlspecialchars($_POST['C']);
    $d = htmlspecialchars($_POST['D']);
    $points = htmlspecialchars($_POST['Multipoints']);
    $type = 2;
    $add_question = "INSERT INTO quiz_question
    (quiz_id, quiz_question_txt, quiz_type_id, date_added, date_edited, answer_1,
    answer_a_2, answer_b_3, answer_c_4, answer_d_5, points_1) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $add_question)) {
        $_SESSION['error'] = "SQL error, please contact tech support.";
        echo mysqli_error($conn);
      header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
      exit();
    } else {
      //run sql
      mysqli_stmt_bind_param($stmt, "isisssssssi", $quizid, $question, $type, $dates, $dates, $correctAns, $a, $b, $c, $d, $points);
      mysqli_stmt_execute($stmt);
           $conn->close();
           $_SESSION['success'] = "Question added!";
           header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
           exit();
         }
}
//ADDING QUIZ questions of Enumeration
elseif(isset($_POST['Enum_Submit'])) {
  $numSelected = htmlspecialchars($_POST['enumNumbers']);
  $question = htmlspecialchars($_POST['ENUMQ']);
  $a = checkText($_POST['A1']);
  $b = checkText($_POST['B2']);
  $c = checkText($_POST['C3']);
  $d = checkText($_POST['D4']);
  $e = checkText($_POST['E5']);
  $points_1 = htmlspecialchars($_POST['A1_Enumpoints']);
  $points_2 = htmlspecialchars($_POST['B2_Enumpoints']);
  $points_3 = htmlspecialchars($_POST['C3_Enumpoints']);
  $points_4 = htmlspecialchars($_POST['D4_Enumpoints']);
  $points_5 = htmlspecialchars($_POST['E5_Enumpoints']);
  $type = 3;

  $add_question = "INSERT INTO quiz_question
  (quiz_id, quiz_question_txt, quiz_type_id, date_added, date_edited, answer_1,
  answer_a_2, answer_b_3, answer_c_4, answer_d_5, points_1, points_2, points_3,
  points_4, points_5, enum_sum, case_sensitive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $add_question)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
    exit();
  } else {
    //check how many answer the teacher have added in emeration up to 5
    if($numSelected === "1"){
      $sum = 1;
        mysqli_stmt_bind_param($stmt, "isisssssssiiiiiis", $quizid, $question, $type, $dates, $dates, $a, $null, $null, $null, $null, $points_1, $null, $null, $null, $null, $sum, $case_sensitive);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Added successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }elseif($numSelected === "2"){
      $sum = 2;
      $array = array($a, $b);
      if(count($array) != count(array_unique($array))){
        $_SESSION['error'] = "Sorry you cannot have duplicate answers on Enumeration.";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&duplicate=error");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "isisssssssiiiiiis", $quizid, $question, $type, $dates, $dates, $a, $b, $null, $null, $null, $points_1, $points_2, $null, $null, $null, $sum, $case_sensitive);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Added successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }elseif($numSelected === "3"){
      $sum =3;
      $array = array($a, $b, $c);
      if(count($array) != count(array_unique($array))){
        $_SESSION['error'] = "Sorry you cannot have duplicate answers on Enumeration.";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&duplicate=error");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "isisssssssiiiiiis", $quizid, $question, $type, $dates, $dates, $a, $b, $c, $null, $null, $points_1, $points_2, $points_3, $null, $null, $sum, $case_sensitive);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Added successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }elseif($numSelected === "4"){
      $sum = 4;
      $array = array($a, $b, $c, $d);
      if(count($array) != count(array_unique($array))){
        $_SESSION['error'] = "Sorry you cannot have duplicate answers on Enumeration.";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&duplicate=error");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "isisssssssiiiiiis", $quizid, $question, $type, $dates, $dates, $a, $b, $c, $d, $null, $points_1, $points_2, $points_3, $points_4, $null, $sum, $case_sensitive);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Added successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }elseif($numSelected === "5"){
      $sum = 5;
      $array = array($a, $b, $c, $d, $e);
      if(count($array) != count(array_unique($array))){
        $_SESSION['error'] = "Sorry you cannot have duplicate answers on Enumeration.";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&duplicate=error");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "isisssssssiiiiiis", $quizid, $question, $type, $dates, $dates, $a, $b, $c, $d, $e, $points_1, $points_2, $points_3, $points_4, $points_5, $sum, $case_sensitive);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Added successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }else{
      $_SESSION['error'] = "Enumeration, no answer selected!";
      header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&upload=error");
      $conn->close();
      exit();
    }
  }
}
//ADDING QUIZ question of Identification
elseif(isset($_POST['Iden_Submit'])) {
    $question = htmlspecialchars($_POST['IDNQ']);
    $correctAns = checkText($_POST['answerIDN']);
    $points = htmlspecialchars($_POST['IDENpoints']);
    $type = 4;

    $add_question = "INSERT INTO quiz_question
    (quiz_id, quiz_question_txt, quiz_type_id, date_added, date_edited, answer_1, points_1, case_sensitive) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $add_question)) {
        $_SESSION['error'] = "SQL error, please contact tech support.";
        echo mysqli_error($conn);
      header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
      exit();
    } else {
      //run sql
      mysqli_stmt_bind_param($stmt, "isisssis", $quizid, $question, $type, $dates, $dates, $correctAns, $points, $case_sensitive);
      mysqli_stmt_execute($stmt);
           $conn->close();
           $_SESSION['success'] = "Question added!";
           header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
           exit();
         }
}
//SHARING QUIZ as a whole to the classes of the teacher.
elseif(isset($_POST['share_this_quiz'])) {
  $title = htmlspecialchars($_POST['title']);
  $description = htmlspecialchars($_POST['description']);
  $udate = htmlspecialchars($_POST['udate']);
  $ddate = htmlspecialchars($_POST['ddate']);
  $startd = htmlspecialchars($_POST['startd']);
  $max = htmlspecialchars($_POST['max']);
  $published = htmlspecialchars($_POST['published']);
  $share = $_POST['share'];
  $ssid = $_SESSION['teacher_session_id'];
  $m1 = htmlspecialchars($_POST['minutes']);
  $minutes = (int) $m1;
  if ($minutes == 0) {
    $_SESSION['error'] = "Minutes must be greater than 0";
    echo $minutes;
      header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
    exit();
  }
  if (!is_int($minutes)) {
    $_SESSION['error'] = "Minutes must be positive number only";
    echo $minutes;
    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
   exit();
  }
  //checking if the checkbox has value selected
  if(!strtotime($ddate) || !strtotime($startd)){
  $_SESSION['error'] = "Your date is not Valid";
  header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
  exit();
  }
  if(empty($share))
  {
    $_SESSION['error'] = "Please check atleast one class.";
    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
    exit();
  }
  else
  {
    $N = count($share);

    echo("You selected $N boxes ");
    //loop to on how many classes do the teacher want to add this quiz. Based on the check boxes selected
    for($i=0; $i < $N; $i++)
    {
      echo($share[$i] . " ");
        //getting the class_id of teacher_class to be added into the quiz info
          $checkClasses11 = "SELECT class_id FROM teacher_class WHERE teacher_class_id = $share[$i];";
          $output11 = $conn->query($checkClasses11);
          $arrayClasses11 = mysqli_fetch_assoc($output11);
          $class_id = $arrayClasses11['class_id'];
        //inserting the same quiz info except teacher class_id, teacher_id, and class_id
          $add_question = "INSERT INTO quiz (teacher_class_id, teacher_id, class_id, quiz_title,
          quiz_description, upload_date, deadline_date, max_attempt, published, timer, start_date) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?);";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          if(!mysqli_stmt_prepare($stmt, $add_question)) {
              $_SESSION['error'] = "SQL error, please contact tech support.";
              echo mysqli_error($conn);
            header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
            exit();
          }
            mysqli_stmt_bind_param($stmt, "iiissssiiis", $share[$i], $ssid, $class_id, $title, $description, $udate, $ddate, $max, $published, $minutes, $startd);
            mysqli_stmt_execute($stmt);
            $newid =  $conn->insert_id;
            //notifcation for students
            $notification = "SELECT * FROM student where class_id =?; ";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "i", $class_id);
              mysqli_stmt_execute($stmt);
              $students = mysqli_stmt_get_result($stmt);
              while ($student_row = mysqli_fetch_assoc($students)) {
                $notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, quiz_id, published) VALUES (?,?,?,?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                //Preparing the prepared statement
                $type_notif = "quiz";
                  mysqli_stmt_prepare($stmt, $notification);
                  mysqli_stmt_bind_param($stmt, "iiiissii",  $class_id, $student_row['student_id'], $_SESSION['teacher_session_id'], $share[$i], $udate, $type_notif, $newid, $published);
                  mysqli_stmt_execute($stmt);
              }
            //getting the questions from the quizzes to be added to the another quiz. Or copy the questions
              $checkClasses113 = "SELECT * FROM quiz_question WHERE quiz_id = $quizid;";
              $output113 = $conn->query($checkClasses113);
              if (mysqli_num_rows($output113) > 0) {
                while ($arrayClasses113 = mysqli_fetch_assoc($output113)) {
                  $copytxt = $arrayClasses113['quiz_question_txt']; $copytype = $arrayClasses113['quiz_type_id']; $copyadded = $arrayClasses113['date_added'];
                  $copyedited = $arrayClasses113['date_edited']; $copya1 = $arrayClasses113['answer_1']; $copya2 = $arrayClasses113['answer_a_2'];
                  $copya3= $arrayClasses113['answer_b_3']; $copya4 = $arrayClasses113['answer_c_4']; $copya5 = $arrayClasses113['answer_d_5'];
                  $copy1 = $arrayClasses113['points_1']; $copy2 = $arrayClasses113['points_2']; $copy3 = $arrayClasses113['points_3'];
                  $copy4 = $arrayClasses113['points_4']; $copy5 = $arrayClasses113['points_5']; $copysum = $arrayClasses113['enum_sum'];
                  $copy_case_sensitive = $arrayClasses113['case_sensitive'];
                  //copying the questions and adding it to the new quiz
                  $checkClasses114 = "INSERT INTO quiz_question
                  (quiz_id, quiz_question_txt, quiz_type_id, date_added, date_edited, answer_1,
                  answer_a_2, answer_b_3, answer_c_4, answer_d_5, points_1, points_2, points_3,
                  points_4, points_5, enum_sum, case_sensitive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                  $stmt = mysqli_stmt_init($conn);
                  //Preparing the prepared statement
                  if(!mysqli_stmt_prepare($stmt, $checkClasses114)) {
                      $_SESSION['error'] = "SQL error, please contact tech support.";
                      echo mysqli_error($conn);
                    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
                    exit();
                  } else {
                    mysqli_stmt_bind_param($stmt, "isisssssssiiiiiis", $newid, $copytxt, $copytype, $copyadded, $copyedited, $copya1, $copya2,
                    $copya3, $copya4, $copya5, $copy1, $copy2, $copy3, $copy4, $copy5, $copysum, $copy_case_sensitive);
                    mysqli_stmt_execute($stmt);

                  }
                }
              }
          }
      $_SESSION['success'] = "Quiz shared along with its questions!";
      header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&upload=success");
      $conn->close();
      exit();
  }
}
//UPDATE QUIZ questions of true or false
elseif (isset($_POST['TF_Update']) && isset($_POST['question_id'])) {
  $question_id = htmlspecialchars($_POST['question_id']);
  $question = htmlspecialchars($_POST['TFQ']);
  $correctAns = htmlspecialchars($_POST['TFcorrect']);
  $points = htmlspecialchars($_POST['TFpoints']);
  $type = 1;

  $update_question = "UPDATE quiz_question SET quiz_question_txt=?, date_edited=?,
  answer_1=?, points_1=? WHERE quiz_question_id=?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $update_question)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
    exit();
  } else {
    //run sql
    mysqli_stmt_bind_param($stmt, "sssii", $question, $dates, $correctAns, $points, $question_id);
    mysqli_stmt_execute($stmt);
         $conn->close();
         $_SESSION['success'] = "True or False Question Updated successfully!";
         header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
         exit();
       }
}
//UPDATE QUIZ questions of multiple choice
elseif (isset($_POST['Multi_Update']) && isset($_POST['question_id'])) {
  $question_id = htmlspecialchars($_POST['question_id']);
  $question = htmlspecialchars($_POST['MCQ']);
  $correctAns = htmlspecialchars($_POST['multi_correct']);
  $a = $_POST['A'];
  $b = $_POST['B'];
  $c = $_POST['C'];
  $d = $_POST['D'];
  $points = $_POST['Multipoints'];
  $add_question = "UPDATE quiz_question SET quiz_question_txt=?, date_edited=?, answer_1=?,
  answer_a_2=?, answer_b_3=?, answer_c_4=?, answer_d_5=?, points_1=? WHERE quiz_question_id=?";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $add_question)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
    exit();
  } else {
    //run sql
    mysqli_stmt_bind_param($stmt, "sssssssii", $question, $dates, $correctAns, $a, $b, $c, $d, $points, $question_id);
    mysqli_stmt_execute($stmt);
         $conn->close();
         $_SESSION['success'] = "Multiple Choice Question Updated Succesfully!";
         header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
         exit();
       }
}
//UPDATE QUIZ question of Enumeration
elseif (isset($_POST['Enum_Update']) && isset($_POST['question_id'])) {
  $question_id = htmlspecialchars($_POST['question_id']);
  $numSelected = htmlspecialchars($_POST['enumNumbers']);
  $question = htmlspecialchars($_POST['ENUMQ']);
  $a = checkText($_POST['A1']);
  $b = checkText($_POST['B2']);
  $c = checkText($_POST['C3']);
  $d = checkText($_POST['D4']);
  $e = checkText($_POST['E5']);
  $points_1 = htmlspecialchars($_POST['A1_Enumpoints']);
  $points_2 = htmlspecialchars($_POST['B2_Enumpoints']);
  $points_3 = htmlspecialchars($_POST['C3_Enumpoints']);
  $points_4 = htmlspecialchars($_POST['D4_Enumpoints']);
  $points_5 = htmlspecialchars($_POST['E5_Enumpoints']);
  $add_question = "UPDATE quiz_question SET quiz_question_txt=?, date_edited=?, answer_1=?,
  answer_a_2=?, answer_b_3=?, answer_c_4=?, answer_d_5=?, points_1=?, points_2=?, points_3=?,
  points_4=?, points_5=?, enum_sum=?, case_sensitive=? WHERE quiz_question_id=?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $add_question)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
    exit();
  } else {
    //check how many answer the teacher have added in emeration up to 5
    if($numSelected === "1"){
      $sum = 1;
        mysqli_stmt_bind_param($stmt, "sssssssiiiiiisi", $question, $dates, $a, $null, $null, $null, $null, $points_1,
        $null, $null, $null, $null, $sum, $case_sensitive, $question_id);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Updated successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }elseif($numSelected === "2"){
      $sum = 2;
      $array = array($a, $b);
      if(count($array) != count(array_unique($array))){
        $_SESSION['error'] = "Sorry you cannot have duplicate answers on Enumeration.";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&duplicate=error");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "sssssssiiiiiisi", $question, $dates, $a, $b, $null, $null,
        $null, $points_1, $points_2, $null, $null, $null, $sum, $case_sensitive, $question_id);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Updated successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }elseif($numSelected === "3"){
      $sum =3;
      $array = array($a, $b, $c);
      if(count($array) != count(array_unique($array))){
        $_SESSION['error'] = "Sorry you cannot have duplicate answers on Enumeration.";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&duplicate=error");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "sssssssiiiiiisi", $question, $dates, $a, $b, $c, $null, $null,
        $points_1, $points_2, $points_3, $null, $null, $sum, $case_sensitive, $question_id);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Updated successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }elseif($numSelected === "4"){
      $sum = 4;
      $array = array($a, $b, $c, $d);
      if(count($array) != count(array_unique($array))){
        $_SESSION['error'] = "Sorry you cannot have duplicate answers on Enumeration.";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&duplicate=error");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "sssssssiiiiiisi", $question, $dates, $a, $b, $c, $d, $null,
        $points_1, $points_2, $points_3, $points_4, $null, $sum, $case_sensitive, $question_id);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Updated successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }elseif($numSelected === "5"){
      $sum = 5;
      $array = array($a, $b, $c, $d, $e);
      if(count($array) != count(array_unique($array))){
        $_SESSION['error'] = "Sorry you cannot have duplicate answers on Enumeration.";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&duplicate=error");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "sssssssiiiiiisi", $question, $dates, $a, $b, $c, $d, $e,
        $points_1, $points_2, $points_3, $points_4, $points_5, $sum, $case_sensitive, $question_id);
        mysqli_stmt_execute($stmt);
        $conn->close();
        $_SESSION['success'] = "Enumeration Question Updated successfully!";
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
        exit();
    }else{
      $_SESSION['error'] = "Enumeration, no answer selected!";
      header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&upload=error");
      $conn->close();
      exit();
    }
  }
}
//UPDATE QUIZ question of identification
elseif (isset($_POST['Iden_Update']) && isset($_POST['question_id'])) {
  $question_id = htmlspecialchars($_POST['question_id']);
  $question = htmlspecialchars($_POST['IDNQ']);
  $correctAns = checkText($_POST['answerIDN']);
  $points = htmlspecialchars($_POST['IDENpoints']);

  $add_question = "UPDATE quiz_question SET quiz_question_txt=?, date_edited=?, answer_1=?, points_1=?, case_sensitive=? WHERE quiz_question_id=?";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $add_question)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
    exit();
  } else {
    //run sql
    mysqli_stmt_bind_param($stmt, "sssisi", $question, $dates, $correctAns, $points, $case_sensitive, $question_id);
    mysqli_stmt_execute($stmt);
         $conn->close();
         $_SESSION['success'] = "Indenfication Question Updated successfully";
         header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
         exit();
       }
}
//DELETE QUIZ questions of either types
elseif (isset($_GET['tc_id']) && isset($_GET['quiz_id']) && isset($_GET['question_iddd'])) {
  $question_id = $_GET['question_iddd'];
  $update_question = "DELETE FROM quiz_question WHERE quiz_question_id=? AND quiz_id=?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $update_question)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
      header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "ii", $question_id, $quizid);
    mysqli_stmt_execute($stmt);
            if($stmt -> affected_rows == 0){
              $_SESSION['error'] = "You do not have access on this question.";
              $conn->close();
              header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&resul3t=error");
              exit();
            }
            $delete_question = "DELETE FROM student_quiz_answer WHERE quiz_question_id=? AND quiz_id =?;";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
            if(!mysqli_stmt_prepare($stmt, $delete_question)) {
                $_SESSION['error'] = "SQL error, please contact tech support.";
                echo mysqli_error($conn);
                header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
              exit();
            }
              //run sql
              mysqli_stmt_bind_param($stmt, "ii", $question_id, $quizid);
              mysqli_stmt_execute($stmt);
                        $_SESSION['success'] = "Question Deleted successfully!";
                        $conn->close();
                        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
                        exit();

}
//UPDATE QUIZ DETAILS
elseif (isset($_POST['update_quiz'])) {
  $title = htmlspecialchars($_POST['quiz_title']);
  $desc = htmlspecialchars($_POST['quiz_description']);
  $date = htmlspecialchars($_POST['date']);
  $start = htmlspecialchars($_POST['start']);
  $max = htmlspecialchars($_POST['max_attempt']);
  $m1 = htmlspecialchars($_POST['minutes']);
  $minutes = (int) $m1;
    if ($minutes < 1) {
    $_SESSION['error'] = "Minutes must be greater than 0";
    echo $minutes;
    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
    exit();
  }
  if (!is_int($minutes)) {
    $_SESSION['error'] = "Minutes must be positive number only";
    echo $minutes;
   header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
   exit();
  }
  if(!strtotime($date)|| !strtotime($start)){
  $_SESSION['error'] = "Your date is not Valid";
  header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
  exit();
  }
  $update = "UPDATE quiz SET quiz_title = ?, quiz_description = ?, deadline_date = ?, start_date =?,  max_attempt = ?, timer = ? WHERE quiz_id = ?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $update)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
      header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "ssssiii", $title, $desc, $date, $start, $max, $minutes, $quizid);
    mysqli_stmt_execute($stmt);
    $update = "UPDATE student_quiz SET quiz_title = ?, quiz_description = ?, deadline_date = ?, start_date =?,  max_attempt = ?, timer = ? WHERE quiz_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $update)) {
        $_SESSION['error'] = "SQL error, please contact tech support.";
        echo mysqli_error($conn);
        header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&sql=error");
      exit();
    }
      //run sql
      mysqli_stmt_bind_param($stmt, "ssssiii", $title, $desc, $date, $start, $max, $minutes, $quizid);
      mysqli_stmt_execute($stmt);


         $conn->close();
         $_SESSION['success'] = "Quiz Details Updated Succesfully!";
       header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&result=success");
       exit();
}
//BACK NAVIGATION because of submit buttons indicated are not settled
else{
    $_SESSION['error'] = "Submit button not set.";
    header("Location: quiz_add_question.php?view_id=$viewid&quiz_id=$quizid&tc_id=$id&upload=error");
    exit();
}

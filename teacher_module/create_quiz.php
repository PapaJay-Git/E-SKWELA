<?php
//uploading assignment file to the folder location and database
require_once 'checker.php';
require_once 'includes_quiz_id_check.php';
    $id2 = $_GET['tc_id'];
if (isset($_POST['create_quiz']) && isset($_POST['quiz_title']) & isset($_POST['quiz_description']) & isset($_POST['date']) & isset($_POST['start'])
 & isset($_POST['max_attempt']) & isset($_POST['minutes'])) {
    $quiz_title = htmlspecialchars($_POST['quiz_title']);
    $quiz_desc =  htmlspecialchars($_POST['quiz_description']);
    $quiz_deadline = htmlspecialchars($_POST['date']);
    $start = htmlspecialchars($_POST['start']);
    $quiz_attempt = htmlspecialchars($_POST['max_attempt']);
    $m1 = htmlspecialchars($_POST['minutes']);
    $minutes = (int) $m1;
    if ($minutes < 1) {
      $_SESSION['error'] = "Minutes must be greater than 0";
      echo $minutes;
     header("Location: teacher_create_quiz.php?tc_id=$id2&error");
      exit();
    }
    if (!is_int($minutes)) {
      $_SESSION['error'] = "Minutes must be positive number only";
      echo $minutes;
     header("Location: teacher_create_quiz.php?tc_id=$id2&error");
     exit();
    }
    date_default_timezone_set('Asia/Manila');
    // Then call the date functions
    $date = date('Y-m-d H:i:s');
    $published = 0;
    if(!strtotime($quiz_deadline) || !strtotime($start)){
    $_SESSION['error'] = "Your date is not Valid";
    header("Location: teacher_create_quiz.php?tc_id=$id2&error");
    exit();
    }
    if (!is_numeric($quiz_attempt)) {
      $_SESSION['error'] = "Attempt must be numeric!";
     header("Location: teacher_create_quiz.php?tc_id=$id2&error");
     exit();
    }
    //add file assignments info to the database
    $add_quiz = "INSERT INTO quiz (teacher_class_id, teacher_id, class_id, quiz_description, quiz_title, upload_date, deadline_date, max_attempt, published, timer, start_date)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $add_quiz)) {
        $_SESSION['error'] = "SQL error, please contact tech support.";
        header("Location: teacher_create_quiz.php?tc_id=$id2&sql=error");
        exit();
    } else {
      //run sql
      mysqli_stmt_bind_param($stmt, "iiissssiiis", $row['teacher_class_id'], $row['teacher_id'], $row['class_id'], $quiz_desc,
      $quiz_title, $date, $quiz_deadline, $quiz_attempt, $published, $minutes, $start);
      mysqli_stmt_execute($stmt);
      $newid =  $conn->insert_id;
      $notification = "SELECT * FROM student where class_id =?; ";
      $stmt = mysqli_stmt_init($conn);
      //Preparing the prepared statement
        mysqli_stmt_prepare($stmt, $notification);
        mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
        mysqli_stmt_execute($stmt);
        $students = mysqli_stmt_get_result($stmt);

        while ($student_row = mysqli_fetch_assoc($students)) {
          $notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, quiz_id, published) VALUES (?,?,?,?,?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "quiz";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiissii",  $row['class_id'], $student_row['student_id'], $_SESSION['teacher_session_id'], $row['teacher_class_id'], $date, $type_notif, $newid, $published);
            mysqli_stmt_execute($stmt);
        }
        //admin_notification
        $notification = "SELECT * FROM admin; ";
        $admins = $conn->query($notification);
          while ($admin_row = mysqli_fetch_assoc($admins)) {
            $admin_id = $admin_row['admin_id'];
            $type_notif = 2;
            $status = 'unread';
            $notification2 = "SELECT * FROM admin_notification WHERE admin_id = $admin_id AND type = $type_notif;";
            $admin_notif = $conn->query($notification2);
            if ($admin_notif->num_rows > 0) {
            $admin_notif_id = mysqli_fetch_assoc($admin_notif);
            $notif_id = $admin_notif_id['id'];
            $notification = "UPDATE admin_notification SET date_given = ?, status = ? WHERE id =?";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "ssi", $date, $status, $notif_id);
            mysqli_stmt_execute($stmt);
            }else {
              $notification = "INSERT INTO admin_notification (admin_id, date_given, type) VALUES (?, ?, ?)";
              $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "isi", $admin_id, $date, $type_notif);
              mysqli_stmt_execute($stmt);
            }
          }

           $conn->close();
           $_SESSION['success'] = "Quiz Created! Please add questions";
           header("Location: quiz_add_question.php?quiz_id=$newid&tc_id=$id2&result=success");
           exit();
         }
}else{
    $_SESSION['error'] = "Submit button not set.";
    header("Location: teacher_create_quiz.php?tc_id=$id2&upload=error");
    exit();
}

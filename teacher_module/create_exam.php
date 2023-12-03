<?php
//uploading assignment file to the folder location and database
require_once 'checker.php';
require_once 'includes_exam_id_check.php';
    $id2 = $_GET['tc_id'];
if (isset($_POST['create_exam']) && isset($_POST['exam_title']) && isset($_POST['exam_description']) && isset($_POST['date']) && isset($_POST['start'])
&& isset($_POST['max_attempt']) && isset($_POST['minutes'])) {
    $exam_title = htmlspecialchars($_POST['exam_title']);
    $exam_desc =  htmlspecialchars($_POST['exam_description']);
    $exam_deadline = htmlspecialchars($_POST['date']);
    $start = htmlspecialchars($_POST['start']);
    $exam_attempt = htmlspecialchars($_POST['max_attempt']);
    $m1 = htmlspecialchars($_POST['minutes']);
    $minutes = (int) $m1;
    date_default_timezone_set('Asia/Manila');
    // Then call the date functions
    $date = date('Y-m-d H:i:s');
    $published = 0;
    if(!strtotime($exam_deadline) || !strtotime($start)){
    $_SESSION['error'] = "Your date is not Valid";
    header("Location: teacher_create_exam.php?tc_id=$id2&error=date");
    exit();
    }
    if (!is_numeric($exam_attempt)) {
      $_SESSION['error'] = "Attempt must be numeric!";
     header("Location: teacher_create_exam.php?tc_id=$id2&error");
     exit();
    }
    if ($minutes < 1) {
      $_SESSION['error'] = "Minutes must be greater than 0";
      echo $minutes;
       header("Location: teacher_create_exam.php?tc_id=$id2&error");
      exit();
    }
    if (!is_int($minutes)) {
      $_SESSION['error'] = "Minutes must be positive number only";
      echo $minutes;
     header("Location: teacher_create_exam.php?tc_id=$id2&error");
     exit();
    }
    //add file assignments info to the database
    $add_exam = "INSERT INTO exam (teacher_class_id, teacher_id, class_id, exam_description, exam_title, upload_date, deadline_date, max_attempt, published, timer, start_date)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $add_exam)) {
        $_SESSION['error'] = "SQL error, please contact tech support.";
        header("Location: teacher_create_exam.php?tc_id=$id2&sql=error");
        exit();
    }
      //run sql
      mysqli_stmt_bind_param($stmt, "iiissssiiis", $row['teacher_class_id'], $row['teacher_id'], $row['class_id'], $exam_desc,
      $exam_title, $date, $exam_deadline, $exam_attempt, $published, $minutes, $start);
      if(!mysqli_stmt_execute($stmt)){
      $_SESSION['error'] = "Exam creation cannot be executed. Contact tech support.";
      header("Location: exam_add_question.php?exam_id=$newid&tc_id=$id2&result=error");
      exit();
      }
      $newid =  $conn->insert_id;
      $notification = "SELECT * FROM student where class_id =?; ";
      $stmt = mysqli_stmt_init($conn);
      //Preparing the prepared statement
        mysqli_stmt_prepare($stmt, $notification);
        mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
        mysqli_stmt_execute($stmt);
        $students = mysqli_stmt_get_result($stmt);

        while ($student_row = mysqli_fetch_assoc($students)) {
          $notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, exam_id, published) VALUES (?,?,?,?,?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "exam";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiissii",  $row['class_id'], $student_row['student_id'], $_SESSION['teacher_session_id'], $row['teacher_class_id'], $date, $type_notif, $newid, $published);
            mysqli_stmt_execute($stmt);
        }

        //admin_notification
        $notification = "SELECT * FROM admin; ";
        $admins = $conn->query($notification);
          while ($admin_row = mysqli_fetch_assoc($admins)) {
            $admin_id = $admin_row['admin_id'];
            $type_notif = 1;
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
          $_SESSION['success'] = "Exam Created! Please add questions";
          header("Location: exam_add_question.php?exam_id=$newid&tc_id=$id2&result=success");
          exit();
}
else{
    $_SESSION['error'] = "Submit button not set.";
    header("Location: teacher_create_exam.php?tc_id=$id2&upload=error");
    exit();
}

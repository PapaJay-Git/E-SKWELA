<?php
require_once 'checker.php';
require_once 'includes_assignment_id_check.php';
require_once 'includes_assignment_id_val.php';
$ass_id = $_GET['ass_id'];
$tc_id = $_GET['tc_id'];
$zero = 0;
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
if (isset($_POST['ass_pass']) && isset($_POST['text']) && empty($_FILES['file']['tmp_name']) && !is_uploaded_file($_FILES['file']['tmp_name'])) {
  echo "no files";
  $text = htmlspecialchars($_POST['text']);
  if($assrow['deadline_date'] >= $date){
  }
  else {
  $_SESSION['error'] = "Sorry, you cannot submit an assignment that is past its due!";
  header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&error");
  exit();
  }
  $sql = "SELECT * FROM student_assignment WHERE teacher_class_id =? AND teacher_assignment_id=? AND student_id =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['error'] = "SQL error";
        header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&sql=error");
        exit();
  }
      mysqli_stmt_bind_param($stmt, "iii", $tcid, $ass_id, $_SESSION['student_session_id']);
      mysqli_stmt_execute($stmt);
      $result2 = mysqli_stmt_get_result($stmt);
        if ($result2->num_rows == 1) {
          $assrow2 = mysqli_fetch_assoc($result2);
          if ($assrow2['used_attempt'] >= $assrow['sub_attempt']) {
            $_SESSION['error'] = "Sorry, you cannot submit an assignment if you do not have valid attempts left!";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&error");
            exit();
          }
          $filepath2 = $assrow2['submission_file'];
          if($filepath2 != NULL || $filepath2 !=""){
            if (file_exists($filepath2)) {
                  unlink($filepath2);
                }
          }
          $used_attempt = $assrow2['used_attempt']+1;
          //update assignment
          $sql = "UPDATE student_assignment SET submit_date =?, submission_text=?, used_attempt=?, score=?, submission_file =? WHERE student_id=? AND teacher_assignment_id=?";
          $stmt = mysqli_stmt_init($conn);
          $null = NULL;
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                  $_SESSION['error'] = "SQL error";
                   echo("Error description: " . $conn -> error);
                  header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&sql=error");
                  exit();
            }
                mysqli_stmt_bind_param($stmt, "ssiisii", $date, $text,$used_attempt, $zero, $null, $_SESSION['student_session_id'], $ass_id);
                mysqli_stmt_execute($stmt);
                //notification
                $notification = "SELECT * FROM teacher_assignments where teacher_assignment_id =?; ";
                $stmt = mysqli_stmt_init($conn);
                //Preparing the prepared statement
                  mysqli_stmt_prepare($stmt, $notification);
                  mysqli_stmt_bind_param($stmt, "i", $ass_id);
                  mysqli_stmt_execute($stmt);
                  $teachers = mysqli_stmt_get_result($stmt);
                  $teacherRes = mysqli_fetch_assoc($teachers);
                  $teacher_id = $teacherRes['teacher_id'];

                  $notification = "SELECT * FROM teacher_notification where assignment_id =? AND teacher_id =?; ";
                  $stmt = mysqli_stmt_init($conn);
                  //Preparing the prepared statement
                    mysqli_stmt_prepare($stmt, $notification);
                    mysqli_stmt_bind_param($stmt, "ii", $ass_id, $teacher_id);
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
                      $notification = "INSERT INTO teacher_notification (teacher_id, teacher_class_id, date_given, type, assignment_id) VALUES (?, ?, ?, ?, ?)";
                      $stmt = mysqli_stmt_init($conn);
                      //Preparing the prepared statement
                      $type_notif = "assignment";
                        mysqli_stmt_prepare($stmt, $notification);
                        mysqli_stmt_bind_param($stmt, "iissi",  $teacher_id, $tc_id, $date, $type_notif, $ass_id);
                        mysqli_stmt_execute($stmt);
                    }
                //end
                $_SESSION['success'] = "Assignment Submission, Success";
                header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id");
                exit();
        } else if($result2->num_rows == 0){
          $used_attempt = 1;
          //update assignment
          $sql = "INSERT INTO student_assignment  (teacher_assignment_id, teacher_class_id, teacher_id, student_id, max_attempt,
            used_attempt, deadline_date, submit_date, assignment_title, assignment_description, score, submission_text, submission_file, start_date, max_score)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?);";
          $stmt = mysqli_stmt_init($conn);
          $null = NULL;
          $filepath2 = $assrow2['submission_file'];
          if($filepath2 != NULL || $filepath2 !=""){
            if (file_exists($filepath2)) {
                  unlink($filepath2);
                }
          }
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                  $_SESSION['error'] = "SQL fferror";
                  header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&sql=error");
                  exit();
            }
              mysqli_stmt_bind_param($stmt, "iiiiiissssisssi", $ass_id, $tcid, $assrow['teacher_id'], $_SESSION['student_session_id'], $assrow['sub_attempt'],
              $used_attempt, $assrow['deadline_date'], $date,  $assrow['ass_title'], $assrow['ass_desc'], $zero, $text, $null, $assrow['start_date'], $assrow['max_score']);
                mysqli_stmt_execute($stmt);
                //notification
                $notification = "SELECT * FROM teacher_assignments where teacher_assignment_id =?; ";
                $stmt = mysqli_stmt_init($conn);
                //Preparing the prepared statement
                  mysqli_stmt_prepare($stmt, $notification);
                  mysqli_stmt_bind_param($stmt, "i", $ass_id);
                  mysqli_stmt_execute($stmt);
                  $teachers = mysqli_stmt_get_result($stmt);
                  $teacherRes = mysqli_fetch_assoc($teachers);
                  $teacher_id = $teacherRes['teacher_id'];

                  $notification = "SELECT * FROM teacher_notification where assignment_id =? AND teacher_id =?; ";
                  $stmt = mysqli_stmt_init($conn);
                  //Preparing the prepared statement
                    mysqli_stmt_prepare($stmt, $notification);
                    mysqli_stmt_bind_param($stmt, "ii", $ass_id, $teacher_id);
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
                      $notification = "INSERT INTO teacher_notification (teacher_id, teacher_class_id, date_given, type, assignment_id) VALUES (?, ?, ?, ?, ?)";
                      $stmt = mysqli_stmt_init($conn);
                      //Preparing the prepared statement
                      $type_notif = "assignment";
                        mysqli_stmt_prepare($stmt, $notification);
                        mysqli_stmt_bind_param($stmt, "iissi",  $teacher_id, $tc_id, $date, $type_notif, $ass_id);
                        mysqli_stmt_execute($stmt);
                    }
                //end
                $_SESSION['success'] = "Assignment Submission, Success";
                header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id");
                exit();
        }
        // code...
}

elseif (isset($_POST['ass_pass']) && !empty($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])){
  echo "with file";
  $text = htmlspecialchars($_POST['text']);
  $fileass = $_FILE['file'];
if($assrow['deadline_date'] >= $date){
}else {
  $_SESSION['error'] = "Sorry, you cannot submit an assignment that is past its due!";
  header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&error");
  exit();
}
$sql = "SELECT * FROM student_assignment WHERE teacher_class_id =? AND teacher_assignment_id=? AND student_id =?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['error'] = "SQL error";
        header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&sql=error");
        exit();
  }
      mysqli_stmt_bind_param($stmt, "iii", $tcid, $ass_id, $_SESSION['student_session_id']);
      mysqli_stmt_execute($stmt);
      $result2 = mysqli_stmt_get_result($stmt);
        if ($result2->num_rows == 1) {
          $assrow2 = mysqli_fetch_assoc($result2);
          if ($assrow2['used_attempt'] >= $assrow['sub_attempt']) {
            $_SESSION['error'] = "Sorry, you cannot submit an assignment if you do not have valid attempts left!";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&error");
            exit();
          }
          $fileName = $_FILES['file']['name'];
          $fileTmpName = $_FILES['file']['tmp_name'];
          $fileSize = $_FILES['file']['size'];
          $fileError = $_FILES['file']['error'];
          $fileType = $_FILES['file']['type'];

          $fileExt = explode('.', $fileName);
          $fileActualExt = strtolower(end($fileExt));
          $hashed = md5($text);
          $hashed2 = md5($date);
          $allowed = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf', 'txt');
          if($fileSize == 0) {
              $_SESSION['error'] = "Cannot upload empty file";
              header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&invalid=nofileSelectedorFilenoSize");
              exit();
          }
          if (!in_array($fileActualExt, $allowed)) {
            $_SESSION['error'] = "Invalid File Type! Allowed types are jpg, jpeg, png, pdf, docx, pdf, txt";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&invalid=filetype");
            exit();
          }
          if (!$fileError === 0) {
            $_SESSION['error'] = "There was error in your file";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&file=error");
            exit();
          }
          if ($fileSize > 30000000) {
            $_SESSION['error'] = "File exceeds 25MB";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&file=toolarge");
            exit();
          }
          $fileNameNew = "Assignment_".$hashed2.$hashed.".".$fileActualExt;
          $fileDestination =  '../Admin_module/student_assignments/'.$fileNameNew;
          if(file_exists($fileDestination)){
            $_SESSION['error'] = "This file name already exist";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&already_exist=file");
            exit();
          }
          if(!move_uploaded_file($fileTmpName, $fileDestination)){
            $_SESSION['error'] = "Error uploading the file";
             header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&upload=error");
             exit();
          }

          $filepath2 = $assrow2['submission_file'];
          if($filepath2 != NULL || $filepath2 !=""){
            if (file_exists($filepath2)) {
                  unlink($filepath2);
                }
          }
          $used_attempt = $assrow2['used_attempt']+1;
          //update assignment
          $sql = "UPDATE student_assignment SET submit_date =?, submission_text=?, used_attempt=?, score=?, submission_file =? WHERE student_id=? AND teacher_assignment_id=?";
          $stmt = mysqli_stmt_init($conn);
          $null = NULL;
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                  $_SESSION['error'] = "SQL error";
                   echo("Error description: " . $conn -> error);
                  header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&sql=error");
                  exit();
            }
                mysqli_stmt_bind_param($stmt, "ssiisii", $date, $text,$used_attempt, $zero, $fileDestination, $_SESSION['student_session_id'], $ass_id);
                mysqli_stmt_execute($stmt);
                //notification
                $notification = "SELECT * FROM teacher_assignments where teacher_assignment_id =?; ";
                $stmt = mysqli_stmt_init($conn);
                //Preparing the prepared statement
                  mysqli_stmt_prepare($stmt, $notification);
                  mysqli_stmt_bind_param($stmt, "i", $ass_id);
                  mysqli_stmt_execute($stmt);
                  $teachers = mysqli_stmt_get_result($stmt);
                  $teacherRes = mysqli_fetch_assoc($teachers);
                  $teacher_id = $teacherRes['teacher_id'];

                  $notification = "SELECT * FROM teacher_notification where assignment_id =? AND teacher_id =?; ";
                  $stmt = mysqli_stmt_init($conn);
                  //Preparing the prepared statement
                    mysqli_stmt_prepare($stmt, $notification);
                    mysqli_stmt_bind_param($stmt, "ii", $ass_id, $teacher_id);
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
                      $notification = "INSERT INTO teacher_notification (teacher_id, teacher_class_id, date_given, type, assignment_id) VALUES (?, ?, ?, ?, ?)";
                      $stmt = mysqli_stmt_init($conn);
                      //Preparing the prepared statement
                      $type_notif = "assignment";
                        mysqli_stmt_prepare($stmt, $notification);
                        mysqli_stmt_bind_param($stmt, "iissi",  $teacher_id, $tc_id, $date, $type_notif, $ass_id);
                        mysqli_stmt_execute($stmt);
                    }
                //end
                $_SESSION['success'] = "Assignment Submission, Success";
                header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id");
                exit();
        } else if($result2->num_rows == 0){
          $fileName = $_FILES['file']['name'];
          $fileTmpName = $_FILES['file']['tmp_name'];
          $fileSize = $_FILES['file']['size'];
          $fileError = $_FILES['file']['error'];
          $fileType = $_FILES['file']['type'];

          $fileExt = explode('.', $fileName);
          $fileActualExt = strtolower(end($fileExt));
          $hashed = md5($text);
          $hashed2 = md5($date);
          $allowed = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf', 'txt');
          if($fileSize == 0) {
              $_SESSION['error'] = "Cannot upload empty file";
              header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&invalid=nofileSelectedorFilenoSize");
              exit();
          }
          if (!in_array($fileActualExt, $allowed)) {
            $_SESSION['error'] = "Invalid File Type";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&invalid=filetype");
            exit();
          }
          if (!$fileError === 0) {
            $_SESSION['error'] = "There was error in your file";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&file=error");
            exit();
          }
          if ($fileSize > 30000000) {
            $_SESSION['error'] = "File exceeds 25MB";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&file=toolarge");
            exit();
          }
          $fileNameNew = "Assignment_".$hashed2.$hashed.".".$fileActualExt;
          $fileDestination =  '../Admin_module/student_assignments/'.$fileNameNew;
          if(file_exists($fileDestination)){
            $_SESSION['error'] = "This file name already exist";
            header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&already_exist=file");
            exit();
          }
          if(!move_uploaded_file($fileTmpName, $fileDestination)){
            $_SESSION['error'] = "Error uploading the file";
             header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&upload=error");
             exit();
          }

          $filepath2 = $assrow2['submission_file'];
          if($filepath2 != NULL || $filepath2 != ""){
            if (file_exists($filepath2)) {
                  unlink($filepath2);
                }
          }
          $used_attempt = 1;
          //update assignment
          $sql = "INSERT INTO student_assignment  (teacher_assignment_id, teacher_class_id, teacher_id, student_id, max_attempt,
            used_attempt, deadline_date, submit_date, assignment_title, assignment_description, score, submission_text, submission_file, start_date, max_score)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?);";
          $stmt = mysqli_stmt_init($conn);
          $null = NULL;
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                  $_SESSION['error'] = "SQL fferror";
                  header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&sql=error");
                  exit();
            }
              mysqli_stmt_bind_param($stmt, "iiiiiissssisssi", $ass_id, $tcid, $assrow['teacher_id'], $_SESSION['student_session_id'], $assrow['sub_attempt'],
              $used_attempt, $assrow['deadline_date'], $date,  $assrow['ass_title'], $assrow['ass_desc'], $zero, $text, $fileDestination, $assrow['start_date'], $assrow['max_score']);
                mysqli_stmt_execute($stmt);
                //notification
                $notification = "SELECT * FROM teacher_assignments where teacher_assignment_id =?; ";
                $stmt = mysqli_stmt_init($conn);
                //Preparing the prepared statement
                  mysqli_stmt_prepare($stmt, $notification);
                  mysqli_stmt_bind_param($stmt, "i", $ass_id);
                  mysqli_stmt_execute($stmt);
                  $teachers = mysqli_stmt_get_result($stmt);
                  $teacherRes = mysqli_fetch_assoc($teachers);
                  $teacher_id = $teacherRes['teacher_id'];

                  $notification = "SELECT * FROM teacher_notification where assignment_id =? AND teacher_id =?; ";
                  $stmt = mysqli_stmt_init($conn);
                  //Preparing the prepared statement
                    mysqli_stmt_prepare($stmt, $notification);
                    mysqli_stmt_bind_param($stmt, "ii", $ass_id, $teacher_id);
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
                      $notification = "INSERT INTO teacher_notification (teacher_id, teacher_class_id, date_given, type, assignment_id) VALUES (?, ?, ?, ?, ?)";
                      $stmt = mysqli_stmt_init($conn);
                      //Preparing the prepared statement
                      $type_notif = "assignment";
                        mysqli_stmt_prepare($stmt, $notification);
                        mysqli_stmt_bind_param($stmt, "iissi",  $teacher_id, $tc_id, $date, $type_notif, $ass_id);
                        mysqli_stmt_execute($stmt);
                    }
                //end
                $_SESSION['success'] = "Assignment Submission, Success";
                header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id");
                exit();
        }
        // code...
}
else{
  $_SESSION['error'] = "You cannot go here without any submission!";
  header("location: assignment_open.php?tc_id=$tcid&ass_id=$ass_id&error");
  exit();
}

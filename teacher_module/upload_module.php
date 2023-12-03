<?php
//For uploading file modules to the folder location and database
require_once 'checker.php';
require_once 'includes_module_id_check.php';
$id = $_GET['tc_id'];
$limit = 3000;
//timezone
date_default_timezone_set('Asia/Manila');
// Then call the date functions
//for minimun date deadline
$date123 = date('Y-m-d H:i:s');
if (isset($_POST['submit_file']) && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $desc = htmlspecialchars($_POST['file_description']);
    $inputed_name = htmlspecialchars($_POST['file_name']);

    if(strlen($desc) >= $limit) {
      $_SESSION['error'] = "Please, no more than 3000 characters";
    header("Location: teacher_upload_modules.php?tc_id=$id&Description_exceeds_1300");
    exit();
    }

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $hashed = md5($inputed_name);
    $hashed2 = md5($date123);
    $allowed = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf', 'txt');
    if($fileSize == 0) {
        $_SESSION['error'] = "Cannot upload empty file";
        header("Location: teacher_upload_modules.php?tc_id=$id&invalid=nofileSelectedorFilenoSize");
        exit();
    }else{
      if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
          if ($fileSize < 30000000) {
              $fileNameNew = "Module_".$hashed2.$hashed.".".$fileActualExt;
              $fileDestination =  '../Admin_module/uploads/'.$fileNameNew;
              if(file_exists($fileDestination)){
                $_SESSION['error'] = "This file name already exist";
                header("Location: teacher_upload_modules.php?tc_id=$id&already_exist=file");
                exit();
              }else{
                if(move_uploaded_file($fileTmpName, $fileDestination)){
                  date_default_timezone_set('Asia/Manila');
                  // Then call the date functions
                  $date = date('Y-m-d H:i:s');
                  //adding the file module info to the database
                  $add_file = "INSERT INTO files (file_loc, file_date, teacher_class_id, class_id, teacher_id, file_name, uploaded_by, file_desc) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
                  $stmt = mysqli_stmt_init($conn);
                  //Preparing the prepared statement
                  if(!mysqli_stmt_prepare($stmt, $add_file)) {
                    $_SESSION['error'] = "SQL error.";
                    header("Location: teacher_upload_modules.php?tc_id=$id&upload_module=sqlerror");
                    exit();
                  } else {
                    //run sql
                    mysqli_stmt_bind_param($stmt, "ssiiisss", $fileDestination, $date, $row['teacher_class_id'], $row['class_id'], $_SESSION['teacher_session_id'], $inputed_name, $_SESSION['teacher_session_id'], $desc);
                        if(mysqli_stmt_execute($stmt)){
                              $new_module_id =  $conn->insert_id;
                              $notification = "SELECT * FROM student where class_id =?; ";
                              $stmt = mysqli_stmt_init($conn);
                              //Preparing the prepared statement
                                mysqli_stmt_prepare($stmt, $notification);
                                mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
                                mysqli_stmt_execute($stmt);
                                $students = mysqli_stmt_get_result($stmt);

                                while ($student_row = mysqli_fetch_assoc($students)) {
                                  $notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, module_id) VALUES (?,?,?,?,?,?,?)";
                                  $stmt = mysqli_stmt_init($conn);
                                  //Preparing the prepared statement
                                  $type_notif = "module";
                                    mysqli_stmt_prepare($stmt, $notification);
                                    mysqli_stmt_bind_param($stmt, "iiiissi",  $row['class_id'], $student_row['student_id'], $_SESSION['teacher_session_id'], $row['teacher_class_id'], $date, $type_notif, $new_module_id);
                                    mysqli_stmt_execute($stmt);
                                }
                                //admin_notification
                                $notification = "SELECT * FROM admin; ";
                                $admins = $conn->query($notification);
                                  while ($admin_row = mysqli_fetch_assoc($admins)) {
                                    $admin_id = $admin_row['admin_id'];
                                    $type_notif = 4;
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
                               $_SESSION['success'] = "Module uploaded succesfully!";
                               header("Location: teacher_upload_modules.php?tc_id=$id&upload=success");
                               exit();
                        }else {
                           $conn->close();
                           $_SESSION['error'] = "Module upload Failed!";
                           header("Location: teacher_upload_modules.php?tc_id=$id&upload=error");
                           exit();
                        }
                  }
                }else{
                  $_SESSION['error'] = "Error uploading the file";
                   header("Location: teacher_upload_modules.php?tc_id=$id&upload=error");
                   exit();
                }
              }
          }else {
            $_SESSION['error'] = "File exceeds 25MB";
            header("Location: teacher_upload_modules.php?tc_id=$id&file=toolarge");
            exit();
          }
        }else {
          $_SESSION['error'] = "There is error in your file";
          header("Location: teacher_upload_modules.php?tc_id=$id&file=error");
          exit();
        }
      }else {
        $_SESSION['error'] = "Invalid File Type! Allowed types are jpg, jpeg, png, pdf, docx, pdf, txt";
        header("Location: teacher_upload_modules.php?tc_id=$id&invalid=filetype");
        exit();
      }
    }
}else{
  $_SESSION['error'] = "Submit file not set";
  header("Location: teacher_upload_modules.php?tc_id=$id&submit_file=notset");
  exit();
}

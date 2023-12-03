<?php
require_once 'checker.php';
require_once 'includes_module_id_check.php';
require_once 'includes_module_id_val.php';
$tcid = $_GET['tc_id'];
$file_id = $_GET['file_id'];
$limit = 3000;
//timezone
date_default_timezone_set('Asia/Manila');
// Then call the date functions
//for minimun date deadline
  $date123 = date('Y-m-d H:i:s');
if(isset($_POST['update_text'])) {
  $title = htmlspecialchars($_POST['file_name']);
  $desc = htmlspecialchars($_POST['file_description']);
  $update = "UPDATE files SET file_name = ?, file_desc = ? WHERE file_id = ? AND teacher_id = ? AND teacher_class_id =?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $update)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
      header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&sql=error");
    exit();
  } else {
    //run sql
    mysqli_stmt_bind_param($stmt, "ssiii", $title, $desc, $file_id, $_SESSION['teacher_session_id'], $tcid);
    if(mysqli_stmt_execute($stmt)){
      $conn->close();
      $_SESSION['success'] = "Module TEXT Updated Succesfully!";
      header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&sql=success");
      exit();
    }else {
      $conn->close();
      $_SESSION['error'] = "Module TEXT Update Failed!";
      header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&sql=error");
      exit();
    }

  }
}
elseif (isset($_POST['update_file'])) {
      $file = $_FILES['file'];
      $desc = htmlspecialchars($_POST['file_description']);
      $inputed_name = htmlspecialchars($_POST['file_name']);

      if(strlen($desc) >= $limit) {
        $_SESSION['error'] = "Please, no more than 3000 characters";
      header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&Description_exceeds_1300");
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
          header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&invalid=nofileSelectedorFilenoSize");
          exit();
      }else{
        if (in_array($fileActualExt, $allowed)) {
          if ($fileError === 0) {
            if ($fileSize < 30000000) {
                $fileNameNew = "Module_".$hashed2.$hashed.".".$fileActualExt;
                $fileDestination =  '../Admin_module/uploads/'.$fileNameNew;
                if(file_exists($fileDestination)){
                  $_SESSION['error'] = "This file name already exist";
                  header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&already_exist=file");
                  exit();
                }else{
                  if(move_uploaded_file($fileTmpName, $fileDestination)){
                    $add_file = "UPDATE files SET file_name = ?, file_desc = ?, file_loc =? WHERE file_id = ? AND teacher_id = ? AND teacher_class_id =?;";
                    $stmt = mysqli_stmt_init($conn);
                    //Preparing the prepared statement
                    //deleting old file
                    if(!mysqli_stmt_prepare($stmt, $add_file)) {
                      $_SESSION['error'] = "SQL error.";
                      header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&update_module=sqlerror");
                      exit();
                    } else {
                      //run sql
                      mysqli_stmt_bind_param($stmt, "sssiii",  $inputed_name, $desc, $fileDestination, $file_id, $_SESSION['teacher_session_id'], $tcid);
                      if(mysqli_stmt_execute($stmt)){
                            $resultid = mysqli_stmt_get_result($stmt);
                            unlink($filepath);
                             $conn->close();
                             $_SESSION['success'] = "Module FILE updated succesfully!";
                             header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&update=success");
                             exit();
                      }else{
                             $conn->close();
                             $_SESSION['error'] = "Module FILE update Failed!";
                             header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&update=success");
                             exit();
                      }

                    }
                  }else{
                    $_SESSION['error'] = "Error updating the file";
                     header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&upload=error");
                     exit();
                  }
                }
            }else {
              $_SESSION['error'] = "File exceeds 25MB";
              header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&file=toolarge");
              exit();
            }
          }else {
            $_SESSION['error'] = "There was error in your file";
            header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&file=error");
            exit();
          }
        }else {
          $_SESSION['error'] = "Invalid File Type! Allowed types are jpg, jpeg, png, pdf, docx, pdf, txt";
          header("Location:module_edit.php?file_id=$file_id&tc_id=$tcid&invalid=filetype");
          exit();
        }
      }
}
elseif (isset($_POST['share_module']) && !empty($_POST['share'])){
  $title = htmlspecialchars($_POST['file_name']);
  $desc = htmlspecialchars($_POST['description']);
  $location = $_POST['file_loc'];
  $share = $_POST['share'];

  $s = count($share);
  //loop to on how many classes do the teacher want to add this quiz. Based on the check boxes selected
  for($i=0; $i < $s; $i++)
  {
  $sql33 = "SELECT class_id FROM teacher_class where teacher_class_id = $share[$i];";
  $classNN = $conn->query($sql33);
  $classNN2 = mysqli_fetch_assoc($classNN);

  $fileExt = explode('.', $location);
  $fileActualExt = strtolower(end($fileExt));
  $hashed_loc = md5($title);
  $hashed_date = md5($date123);
  $hashed_num = md5($i);
  $fileNameNew = "shared_".$hashed_loc.$hashed_date.$hashed_num.".".$fileActualExt;
  $fileDestination =  '../Admin_module/uploads/'.$fileNameNew;
  echo $fileDestination;
  $update = "INSERT INTO files (file_loc, teacher_class_id, class_id, file_date, teacher_id, file_name, file_desc, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $update)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
      header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&sql=error");
    exit();
  } else {
    if (!copy($location, $fileDestination)) {
      $_SESSION['error'] = "Cannot copy file";
      header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&sql=error");
      exit();
    }
    //run sql
    $classid = $classNN2['class_id'];
    mysqli_stmt_bind_param($stmt, "siisisss", $fileDestination, $share[$i], $classid, $date123, $_SESSION['teacher_session_id'], $title, $desc, $_SESSION['teacher_session_id']);
    if(mysqli_stmt_execute($stmt)){
      $new_module_id =  $conn->insert_id;
      $notification = "SELECT * FROM student where class_id =?; ";
      $stmt = mysqli_stmt_init($conn);
      //Preparing the prepared statement
        mysqli_stmt_prepare($stmt, $notification);
        mysqli_stmt_bind_param($stmt, "i", $classid);
        mysqli_stmt_execute($stmt);
        $students = mysqli_stmt_get_result($stmt);
        while ($student_row = mysqli_fetch_assoc($students)) {
          $notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, module_id) VALUES (?,?,?,?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "module";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiissi",  $classid, $student_row['student_id'], $_SESSION['teacher_session_id'], $share[$i], $date123, $type_notif, $new_module_id);
            mysqli_stmt_execute($stmt);
        }
    }else {
      echo mysqli_error($conn);
      $conn->close();
      $_SESSION['error'] = "Module Share Failed!";
      header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&sql=error");
      exit();
    }
   }
  }
  $conn->close();
  $_SESSION['success'] = "Module Shared successfully!";
  header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&success");
  exit();
}
else{
  $_SESSION['error'] = "Submit button is not settled properly.";
  header("Location: module_edit.php?file_id=$file_id&tc_id=$tcid&button=error");
}

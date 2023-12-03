<?php
require_once "includes_profile_id_check.php";
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
if (isset($_POST['update_student_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['student_id']) && !isset($_POST['update_student_name'])) {
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];
  $student_id = $_POST['student_id'];
  $length = strlen($new_password);
      if ($new_password == $confirm_password) {
        if ($length < 21 && $length > 5) {
            if (preg_match('/^\w+$/', $new_password)) {
                    $sql = "UPDATE student SET password = ? WHERE student_id =?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                      $_SESSION['error'] = "There was an error in SQL. Please contact tech support.";
                      header("Location: edit_student.php?stu_id=$student_id&usql=error");
                      exit();
                      } else {
                        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "si", $new_hashed, $student_id);
                        if(mysqli_stmt_execute($stmt)){
                          $_SESSION['success'] = "Password is now Updated!";
                          header("Location:  edit_student.php?stu_id=$student_id&update=success");
                          exit();
                        }else {
                          $_SESSION['error'] = "We cannot update your password right now. Please contact admin.";
                          header("Location: edit_student.php?stu_id=$student_id&update=error");
                          exit();
                        }
                      }
                }else {
                  $_SESSION['error'] = "Only letters (either case), numbers, and the underscore; 6 to 20 character";
                  header("Location: edit_student.php?stu_id=$student_id&match_the_allowed_pattern");
                  exit();
                }
              }else{
                $_SESSION['error'] = "Length error, input username between 6 to 20 characters only.";
                  header("Location: edit_student.php?stu_id=$student_id&match_the_allowed_pattern");
                  exit();
                }
          }else{
          $_SESSION['error'] = "Your new password do not match. Please type it correctly";
          header("Location: edit_student.php?stu_id=$student_id&match_the_allowed_pattern");
          exit();
          }
}elseif (isset($_POST['update_student_name']) && isset($_POST['first']) && isset($_POST['last']) && isset($_POST['student_id']) && isset($_POST['school_id']) && isset($_POST['section']) && !isset($_POST['update_student_password'])) {
  $first_name = trim(htmlspecialchars($_POST['first']));
  $last_name = trim(htmlspecialchars($_POST['last']));
  $student_id = $_POST['student_id'];
  $class_id = $_POST['section'];
  $school_id = trim($_POST['school_id']);

  if (!is_numeric($school_id)) {
    $_SESSION['error']= "Your student ID is not Numberic! Please input numeric input only.";
    header("location: edit_student.php?stu_id=$student_id&success=error");
    exit();
  }
  $sql_grade = "SELECT * FROM student WHERE school_id=? AND student_id != ?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "ii", $school_id, $student_id);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows > 0) {
        $_SESSION['error']= "It looks like $school_id is already been added before. You cannot duplicate school IDs!";
        header("location: edit_student.php?stu_id=$student_id&success=error");
        exit();
    }
    $sql_grade = "SELECT * FROM student WHERE student_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
      mysqli_stmt_prepare($stmt, $sql_grade);
      mysqli_stmt_bind_param($stmt, "i", $student_id);
      mysqli_stmt_execute($stmt);
      $result_check4 = mysqli_stmt_get_result($stmt);
      if ($result_check4->num_rows < 1) {
          $_SESSION['error']= "It looks like this student does not exist anymore!";
          header("location: edit_student.php?stu_id=$student_id&success=error");
          exit();
      }
  //output for the section
  $student_exist = mysqli_fetch_assoc($result_check4);
  $sql_grade = "SELECT * FROM class WHERE class_id=?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error updating student";
    header("location: edit_student.php?stu_id=$student_id&success=sqlerror");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "i", $class_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
      $_SESSION['error']= "Invalid Section ID!";
      header("location: edit_student.php?stu_id=$student_id&success=error");
      exit();
    }
 $result_section = mysqli_fetch_assoc($result);
 if ($class_id != $student_exist['class_id']){
     $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
     $stmt = mysqli_stmt_init($conn);
     //Preparing the prepared statement
     $type_notif = "changed_section";
       mysqli_stmt_prepare($stmt, $notification);
       mysqli_stmt_bind_param($stmt, "iiiss",  $class_id, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
       mysqli_stmt_execute($stmt);
 }
 $sql_grade = "UPDATE student SET f_name =?, l_name=?, class_id=?, school_id=? WHERE student_id =?;";
 $stmt = mysqli_stmt_init($conn);
 //Preparing the prepared statement
 if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
   $_SESSION['error']= "Error updating student";
   header("location: edit_student.php?stu_id=$student_id&success=sqlerror");
   exit();
 }
   //run sql
   mysqli_stmt_bind_param($stmt, "ssiii", $first_name, $last_name, $class_id, $school_id, $student_id);
      if(!mysqli_stmt_execute($stmt)){
        $_SESSION['error']= "Execution ERROR!";
        echo $conn->error;
        header("location:edit_student.php?stu_id=$student_id&success=error");
        exit();
      }
      $_SESSION['success'] = "Student Name is now Updated!";
      header("Location:  edit_student.php?stu_id=$student_id&update=success");
      exit();
}
else{
    $_SESSION['error'] = "Submit button is not settled properly.";
    header("Location edit_student.php?stu_id=$student_id&button");
    exit();
}

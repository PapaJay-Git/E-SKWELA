<?php
require_once "includes_profile_id_check.php";
if (isset($_POST['update_teacher_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['teacher_id']) && !isset($_POST['update_teacher_name'])) {
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];
  $teacher_id = $_POST['teacher_id'];
  $length = strlen($new_password);
      if ($new_password == $confirm_password) {
        if ($length < 21 && $length > 5) {
            if (preg_match('/^\w+$/', $new_password)) {
                    $sql = "UPDATE teachers SET password = ? WHERE teacher_id =?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                      $_SESSION['error'] = "There was an error in SQL. Please contact tech support.";
                      header("Location: edit_teacher.php?teacher_id=$teacher_id&usql=error");
                      exit();
                      } else {
                        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "si", $new_hashed, $teacher_id);
                        if(mysqli_stmt_execute($stmt)){
                          $_SESSION['success'] = "Password is now Updated!";
                          header("Location:  edit_teacher.php?teacher_id=$teacher_id&update=success");
                          exit();
                        }else {
                          $_SESSION['error'] = "We cannot update your password right now. Please contact admin.";
                          header("Location: edit_teacher.php?teacher_id=$teacher_id&update=error");
                          exit();
                        }
                      }
                }else {
                  $_SESSION['error'] = "Only letters (either case), numbers, and the underscore; 6 to 20 character";
                  header("Location: edit_teacher.php?teacher_id=$teacher_id&match_the_allowed_pattern");
                  exit();
                }
              }else{
                $_SESSION['error'] = "Length error, input username between 6 to 20 characters only.";
                  header("Location: edit_teacher.php?teacher_id=$teacher_id&match_the_allowed_pattern");
                  exit();
                }
          }else{
          $_SESSION['error'] = "Your new password do not match. Please type it correctly";
          header("Location: edit_teacher.php?teacher_id=$teacher_id&match_the_allowed_pattern");
          exit();
          }
}elseif (isset($_POST['update_teacher_name']) && isset($_POST['first']) && isset($_POST['last']) && isset($_POST['school_id']) && !isset($_POST['update_teacher_password'])) {
  $first_name = trim(htmlspecialchars($_POST['first']));
  $last_name = trim(htmlspecialchars($_POST['last']));
  $teacher_id = $_POST['teacher_id'];
  $school_id = trim($_POST['school_id']);

  if (!is_numeric($school_id)) {
      $_SESSION['error']= "IDs can only be numeric";
      header("location: edit_teacher.php?teacher_id=$teacher_id");
      exit();
  }
  $sql_grade = "SELECT * FROM teachers WHERE school_id=? AND teacher_id != ?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error updating Teacher";
  header("location: edit_teacher.php?teacher_id=$teacher_id");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "ii", $school_id, $teacher_id);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows > 0) {
        $_SESSION['error']= "It looks like $school_id is already been added before. You cannot duplicate school IDs!";
        header("location: edit_teacher.php?teacher_id=$teacher_id");
        exit();
    }
 $sql_grade = "UPDATE teachers SET f_name =?, l_name=?, school_id=? WHERE teacher_id =?;";
 $stmt = mysqli_stmt_init($conn);
 //Preparing the prepared statement
 if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
   $_SESSION['error']= "Error updating teacher";
   header("location: edit_teacher.php?teacher_id=$teacher_id&success=sqlerror");
   exit();
 }
   //run sql
   mysqli_stmt_bind_param($stmt, "ssii", $first_name, $last_name, $school_id, $teacher_id);
      if(!mysqli_stmt_execute($stmt)){
        $_SESSION['error']= "Execution ERROR!";
        echo $conn->error;
        header("location:edit_teacher.php?teacher_id=$teacher_id&success=error");
        exit();
      }
      $_SESSION['success'] = "Teacher Name is now Updated!";
      header("Location:  edit_teacher.php?teacher_id=$teacher_id&update=success");
      exit();
}
else{
    $_SESSION['error'] = "Submit button is not settled properly.";
    header("Location edit_teacher.php?teacher_id=$teacher_id&button");
    exit();
}

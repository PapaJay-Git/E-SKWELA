<?php
require_once "includes_profile_id_check.php";

if (isset($_POST['update_admin_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['admin_id']) && !isset($_POST['update_admin_name'])) {
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];
  $admin_id = $_POST['admin_id'];
  if ($admin_id == $_SESSION['admin_session_id']) {
    $_SESSION['error'] = "You cannot edit the currently logged in Admin account!";
    header("Location: edit_admin.php?admin_id=$admin_id&usql=error");
    exit();
  }
  $length = strlen($new_password);
      if ($new_password == $confirm_password) {
        if ($length < 21 && $length > 5) {
            if (preg_match('/^\w+$/', $new_password)) {
                    $sql = "UPDATE admin SET password = ? WHERE admin_id =?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                      $_SESSION['error'] = "There was an error in SQL. Please contact tech support.";
                      header("Location: edit_admin.php?admin_id=$admin_id&usql=error");
                      exit();
                      } else {
                        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "si", $new_hashed, $admin_id);
                        if(mysqli_stmt_execute($stmt)){
                          $_SESSION['success'] = "Password is now Updated!";
                          header("Location:  edit_admin.php?admin_id=$admin_id&update=success");
                          exit();
                        }else {
                          $_SESSION['error'] = "We cannot update your password right now. Please contact admin.";
                          header("Location: edit_admin.php?admin_id=$admin_id&update=error");
                          exit();
                        }
                      }
                }else {
                  $_SESSION['error'] = "Only letters (either case), numbers, and the underscore; 6 to 20 character";
                  header("Location: edit_admin.php?admin_id=$admin_id&match_the_allowed_pattern");
                  exit();
                }
              }else{
                $_SESSION['error'] = "Length error, input username between 6 to 20 characters only.";
                  header("Location: edit_admin.php?admin_id=$admin_id&match_the_allowed_pattern");
                  exit();
                }
          }else{
          $_SESSION['error'] = "Your new password do not match. Please type it correctly";
          header("Location: edit_admin.php?admin_id=$admin_id&match_the_allowed_pattern");
          exit();
          }
}elseif (isset($_POST['update_admin_name']) && isset($_POST['first']) && isset($_POST['last']) && isset($_POST['school_id']) && !isset($_POST['update_admin_password'])) {
  $first_name = trim(htmlspecialchars($_POST['first']));
  $last_name = trim(htmlspecialchars($_POST['last']));
  $admin_id = $_POST['admin_id'];
  $school_id = trim($_POST['school_id']);
  if (!is_numeric($school_id)) {
    $_SESSION['error'] = "IDs can only be numeric!";
    header("Location: edit_admin.php?admin_id=$admin_id");
    exit();
  }
  $sql_grade = "SELECT * FROM admin WHERE school_id=? AND admin_id != ?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error updating Admin";
    header("Location: edit_admin.php?admin_id=$admin_id");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "ii", $school_id, $admin_id);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows > 0) {
        $_SESSION['error']= "It looks like $school_id is already been added before. You cannot duplicate school IDs!";
        header("Location: edit_admin.php?admin_id=$admin_id");
        exit();
    }
  if ($admin_id == $_SESSION['admin_session_id']) {
    $_SESSION['error'] = "You cannot edit the currently logged in Admin account!";
    header("Location: edit_admin.php?admin_id=$admin_id&usql=error");
    exit();
  }
 $sql_grade = "UPDATE admin SET f_name =?, l_name=?, school_id=? WHERE admin_id =?;";
 $stmt = mysqli_stmt_init($conn);
 //Preparing the prepared statement
 if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
   $_SESSION['error']= "Error updating admin";
   header("location: edit_admin.php?admin_id=$admin_id&success=sqlerror");
   exit();
 }
   //run sql
   mysqli_stmt_bind_param($stmt, "ssii", $first_name, $last_name, $school_id, $admin_id);
      if(!mysqli_stmt_execute($stmt)){
        $_SESSION['error']= "Execution ERROR!";
        echo $conn->error;
        header("location:edit_admin.php?admin_id=$admin_id&success=error");
        exit();
      }
      $_SESSION['success'] = "Admin Name is now Updated!";
      header("Location:  edit_admin.php?admin_id=$admin_id&update=success");
      exit();
}
else{
    $_SESSION['error'] = "Submit button is not settled properly.";
    header("Location edit_admin.php?admin_id=$admin_id&button");
    exit();
}

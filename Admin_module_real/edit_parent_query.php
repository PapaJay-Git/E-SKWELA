<?php
require_once "includes_profile_id_check.php";
if (isset($_POST['update_parent_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['parent_id']) && !isset($_POST['update_parent_name'])) {
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];
  $parent_id = $_POST['parent_id'];
  $length = strlen($new_password);
      if ($new_password == $confirm_password) {
        if ($length < 21 && $length > 5) {
            if (preg_match('/^\w+$/', $new_password)) {
                    $sql = "UPDATE parents SET password = ? WHERE parent_id =?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                      $_SESSION['error'] = "There was an error in SQL. Please contact tech support.";
                      header("Location: edit_parent.php?parent_id=$parent_id&usql=error");
                      exit();
                      } else {
                        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "si", $new_hashed, $parent_id);
                        if(mysqli_stmt_execute($stmt)){
                          $_SESSION['success'] = "Password is now Updated!";
                          header("Location:  edit_parent.php?parent_id=$parent_id&update=success");
                          exit();
                        }else {
                          $_SESSION['error'] = "We cannot update your password right now. Please contact admin.";
                          header("Location: edit_parent.php?parent_id=$parent_id&update=error");
                          exit();
                        }
                      }
                }else {
                  $_SESSION['error'] = "Only letters (either case), numbers, and the underscore; 6 to 20 character";
                  header("Location: edit_parent.php?parent_id=$parent_id&match_the_allowed_pattern");
                  exit();
                }
              }else{
                $_SESSION['error'] = "Length error, input username between 6 to 20 characters only.";
                  header("Location: edit_parent.php?parent_id=$parent_id&match_the_allowed_pattern");
                  exit();
                }
          }else{
          $_SESSION['error'] = "Your new password do not match. Please type it correctly";
          header("Location: edit_parent.php?parent_id=$parent_id&match_the_allowed_pattern");
          exit();
          }
}elseif (isset($_POST['update_parent_name']) && isset($_POST['first']) && isset($_POST['last']) && !isset($_POST['update_parent_password'])) {
  $first_name = trim(htmlspecialchars($_POST['first']));
  $last_name = trim(htmlspecialchars($_POST['last']));
  $parent_id = $_POST['parent_id'];

 $sql_grade = "UPDATE parents SET f_name =?, l_name=? WHERE parent_id =?;";
 $stmt = mysqli_stmt_init($conn);
 //Preparing the prepared statement
 if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
   $_SESSION['error']= "Error updating parent";
   header("location: edit_parent.php?parent_id=$parent_id&success=sqlerror");
   exit();
 }
   //run sql
   mysqli_stmt_bind_param($stmt, "ssi", $first_name, $last_name, $parent_id);
      if(!mysqli_stmt_execute($stmt)){
        $_SESSION['error']= "Execution ERROR!";
        echo $conn->error;
        header("location: edit_parent.php?parent_id=$parent_id&success=error");
        exit();
      }
      $_SESSION['success'] = "Parent Name is now Updated!";
      header("Location:  edit_parent.php?parent_id=$parent_id&update=success");
      exit();
}elseif (isset($_POST['update_parent_student']) && isset($_POST['student_id']) && isset($_POST['parent_id'])) {
  $student_id = $_POST['student_id'];
  $parent_id = $_POST['parent_id'];
  //check the parent
  $sql_grade = "SELECT * FROM parents WHERE parent_id=?;";
  $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "i", $parent_id);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows < 1) {
        $_SESSION['error']= "It looks like parent ID $parent_id does not exist!";
      header("Location: edit_parent.php?parent_id=$parent_id&button");
        exit();
    }
  //check if already exist
  $sql_grade = "SELECT * FROM parent_student WHERE student_id=? AND parent_id=?;";
  $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
    mysqli_stmt_bind_param($stmt, "ii", $student_id, $parent_id);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows > 0) {
        $_SESSION['error']= "It looks like this connection already exist!";
      header("Location: edit_parent.php?parent_id=$parent_id");
        exit();
    }
//Check the student
    $sql_grade = "SELECT * FROM student WHERE student_id=?;";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    mysqli_stmt_prepare($stmt, $sql_grade);
      //run sql
      mysqli_stmt_bind_param($stmt, "i", $student_id);
      mysqli_stmt_execute($stmt);
      $result_check = mysqli_stmt_get_result($stmt);
      if ($result_check->num_rows < 1) {
        $_SESSION['error']= "It looks like this student does not exist exist!";
        header("Location: edit_parent.php?parent_id=$parent_id");
        exit();
      }
      $row = mysqli_fetch_assoc($result_check);
    //insert
   $sql_grade = "INSERT INTO parent_student (parent_id, student_id) VALUES (?,?);";
   $stmt = mysqli_stmt_init($conn);
   //Preparing the prepared statement
   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
     $_SESSION['error']= "Error adding teacher";
     header("Location: edit_parent.php?parent_id=$parent_id");
     exit();
   }
     //run sql
     mysqli_stmt_bind_param($stmt, "ii", $parent_id, $row['student_id']);
     mysqli_stmt_execute($stmt);

    $_SESSION['success']= "Assigned successfully!";
    header("Location: edit_parent.php?parent_id=$parent_id&button");
    exit();
}
else{
    $parent_id = $_POST['parent_id'];
    $_SESSION['error'] = "Submit button is not settled properly.";
    header("Location: edit_parent.php?parent_id=$parent_id&button");
    exit();
}

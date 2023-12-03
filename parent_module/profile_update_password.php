<?php
require_once "includes_profile_id_check.php";
  $viewid = 1;
if (isset($_POST['update_password'])) {
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];
  $old_password = $_POST['old_password'];
  $length = strlen($new_password);
      if ($new_password == $confirm_password) {
        if ($length < 21 && $length > 5) {
            if (preg_match('/^\w+$/', $new_password)) {
                  $ee = $_SESSION['parent_session_id'];
                  $queryT = "SELECT password FROM parents where parent_id = $ee;";
                  $parentCheck = $conn->query($queryT);
                  $parent = mysqli_fetch_assoc($parentCheck);
                  $password = $parent['password'];
                  if(password_verify($old_password, $password)) {
                    $sql = "UPDATE parents SET password = ? WHERE parent_id =?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                      $_SESSION['error'] = "There was an error in SQL. Please contact tech support.";
                      header("Location: profile_password.php?view_id=$viewid&usql=error");
                      exit();
                      } else {
                        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "si", $new_hashed, $_SESSION['parent_session_id']);
                        if(mysqli_stmt_execute($stmt)){
                          $_SESSION['success'] = "Password is now Updated!";
                          header("Location: profile.php?view_id=$viewid&update=success");
                          exit();
                        }else {
                          $_SESSION['error'] = "We cannot update your password right now. Please contact admin.";
                          header("Location: profile_password.php?view_id=$viewid&update=error");
                          exit();
                        }
                      }
                  }else {
                    $_SESSION['error'] = "Please enter your old password correctly.";
                    header("Location: profile_password.php?view_id=$viewid&password=error");
                    exit();
                  }
                }else {
                  $_SESSION['error'] = "Only letters (either case), numbers, and the underscore; 6 to 20 character";
                  header("Location: profile_password.php?view_id=$viewid&match_the_allowed_pattern");
                  exit();
                }
              }else{
                $_SESSION['error'] = "Length error, input username between 6 to 20 characters only.";
                  header("Location: profile_password.php?view_id=$viewid&match_the_allowed_pattern");
                  exit();
                }
          }else{
          $_SESSION['error'] = "Your new password do not match. Please type it correctly";
          header("Location: profile_password.php?view_id=$viewid&match_the_allowed_pattern");
          exit();
          }
  }
else{
    $_SESSION['error'] = "Submit button is not settled properly.";
    header("Location: profile_password.php?button");
    exit();
}

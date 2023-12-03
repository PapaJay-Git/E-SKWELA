<?php
require_once 'checker.php';
require_once 'includes_assignment_id_check.php';
require_once 'includes_assignment_id_val.php';
$tcid = $_GET['tc_id'];
$assid = $_GET['ass_id'];
$null = NULL;
if (file_exists($filepath)) {
      if (unlink($filepath)) {
        $deleteQuery = "UPDATE teacher_assignments SET ass_loc = ? WHERE teacher_assignment_id=? AND teacher_id=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $deleteQuery)) {
            $_SESSION['error'] = "SQL error, please contact tech support.";
          header("location: assignment_edit.php?delete=failed&tc_id=$tcid&ass_id=$assid");
            exit();
        } else {
          mysqli_stmt_bind_param($stmt, "sii", $null, $assid, $_SESSION['teacher_session_id']);
          if(mysqli_stmt_execute($stmt)){
              $_SESSION['success'] = "File deleted successfully!";
            header("location: assignment_edit.php?delete=success&tc_id=$tcid&ass_id=$assid");
              exit();
          }else{
              $_SESSION['error'] = "Delete failed!";
          header("location: assignment_edit.php?delete=failed&tc_id=$tcid");
            exit();
          }
        }
      }else{
          $_SESSION['error'] = "Error, problem deleting actual file.";
        header("location: assignment_edit.php?missing=file&tc_id=$tci&ass_id=$assid");
          exit();
      }

}else{
  $_SESSION['error'] = "Error, cannot delete a missing file.";
    header("location: assignment_edit.php?file=didnotexist&tc_id=$tcid&ass_id=$assid");
      exit();
}

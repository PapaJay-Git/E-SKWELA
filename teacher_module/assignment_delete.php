<?php
require_once 'checker.php';
require_once 'includes_assignment_id_check.php';
require_once 'includes_assignment_id_val.php';
$tcid = $_GET['tc_id'];
$assid = $_GET['ass_id'];
$deleteQuery = "SELECT ass_loc FROM teacher_assignments WHERE teacher_assignment_id=? AND teacher_id=?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $deleteQuery)) {
    $_SESSION['error'] = "SQL error, please contact tech support.";
    header("location: teacher_view_assignments.php?delete=failed&tc_id=$tcid");
    exit();
} else {
  mysqli_stmt_bind_param($stmt, "ii", $assid, $_SESSION['teacher_session_id']);
  if(mysqli_stmt_execute($stmt)){
      $result1233 = mysqli_stmt_get_result($stmt);
       $nullOrNot = mysqli_fetch_assoc($result1233);
  }else{
      $_SESSION['error'] = "Delete failed!";
      header("location: teacher_view_assignments.php?delete=failed&tc_id=$tcid");
      exit();
  }
}
if($nullOrNot['ass_loc'] == NULL){
  $sql_grade = "SELECT * FROM student_assignment WHERE teacher_assignment_id=? AND teacher_id=?;";
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error deleting student";
    header("location: students.php?&success=error");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "ii", $assid, $_SESSION['teacher_session_id']);
       if(!mysqli_stmt_execute($stmt)){
         $_SESSION['error']= "Execution ERROR deleting student $student_id2!";
         echo $conn->error;
         header("location: teacher_view_assignments.php?delete=failed&tc_id=$tcid");
         exit();
       }
       $result = mysqli_stmt_get_result($stmt);
  $deleteQuery = 	$sql = "DELETE FROM teacher_assignments WHERE teacher_assignment_id=? AND teacher_id=?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $deleteQuery)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
    header("location: teacher_view_assignments.php?delete=failed&tc_id=$tcid");
      exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ii", $assid, $_SESSION['teacher_session_id']);
    if(mysqli_stmt_execute($stmt)){
      while($row = mysqli_fetch_assoc($result)){
        if ($row['submission_file'] != NULL && $row['submission_file'] != 0 || $row['submission_file'] !="") {
          $subpath = $row['submission_file'];
          if (file_exists($subpath)) {
                unlink($subpath);
          }
        }
      }
      $deleteQuery = "DELETE FROM student_notification WHERE assignment_id=? AND teacher_id=?;";
      $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "ii", $assid, $_SESSION['teacher_session_id']);
        mysqli_stmt_execute($stmt);
      $_SESSION['success'] = "Assignment with file deleted successfully!";
      header("location: teacher_view_assignments.php?delete=success&tc_id=$tcid");
        exit();
    }else{
        $_SESSION['error'] = "Delete failed!";
    header("location: teacher_view_assignments.php?delete=failed&tc_id=$tcid");
      exit();
    }
  }
}else{
if (file_exists($filepath)) {
  $sql_grade = "SELECT * FROM student_assignment WHERE teacher_assignment_id=? AND teacher_id=?;";
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error deleting student";
    header("location: students.php?&success=error");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "ii", $assid, $_SESSION['teacher_session_id']);
       if(!mysqli_stmt_execute($stmt)){
         $_SESSION['error']= "Execution ERROR deleting student $student_id2!";
         echo $conn->error;
         header("location: teacher_view_assignments.php?delete=failed&tc_id=$tcid");
         exit();
       }
       $result = mysqli_stmt_get_result($stmt);
      if (unlink($filepath)) {
        $deleteQuery = 	$sql = "DELETE FROM teacher_assignments WHERE teacher_assignment_id=? AND teacher_id=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $deleteQuery)) {
            $_SESSION['error'] = "SQL error, please contact tech support.";
          header("location: teacher_view_assignments.php?delete=failed&tc_id=$tcid");
            exit();
        } else {
          mysqli_stmt_bind_param($stmt, "ii", $assid, $_SESSION['teacher_session_id']);
          if(mysqli_stmt_execute($stmt)){
            while($row = mysqli_fetch_assoc($result)){
              if ($row['submission_file'] != NULL && $row['submission_file'] != 0 || $row['submission_file'] !="") {
                $subpath = $row['submission_file'];
                if (file_exists($subpath)) {
                      unlink($subpath);
                }
              }
            }
            $deleteQuery = "DELETE FROM student_notification WHERE assignment_id=? AND teacher_id=?;";
            $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $deleteQuery);
              mysqli_stmt_bind_param($stmt, "ii", $assid, $_SESSION['teacher_session_id']);
              mysqli_stmt_execute($stmt);
              $_SESSION['success'] = "Assignment with file deleted successfully!";
            header("location: teacher_view_assignments.php?delete=success&tc_id=$tcid");
              exit();
          }else{
              $_SESSION['error'] = "Delete failed!";
          header("location: teacher_view_assignments.php?delete=failed&tc_id=$tcid");
            exit();
          }
        }
      }else{
          $_SESSION['error'] = "Error, problem deleting actual file.";
        header("location: teacher_view_assignments.php?missing=file&tc_id=$tci");
          exit();
      }

}else{
  $_SESSION['error'] = "Error, cannot delete a missing file.";
    header("location: teacher_view_assignments.php?file=didnotexist&tc_id=$tcid");
      exit();
    }
}

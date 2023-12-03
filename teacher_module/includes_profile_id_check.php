<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
  require_once 'checker.php';

  $sql = "SELECT * FROM teachers where teacher_id =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: profile.php?view=failed");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $_SESSION['teacher_session_id']);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        if (file_exists($row['profile'])) {
          $profile_pic = $row['profile'];
        } else {
          $profile_pic = "../assets/subj_pics/profile.png";
        }
        $filepath = $row['profile'];
        $numberOFF = $result->num_rows;
    } else {
      $_SESSION['error'] = "Failed, viewing profile.";
        header("location: ../login/index.php?view=failed");
        exit();

    }
  }
?>

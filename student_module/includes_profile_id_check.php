<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
  require_once 'checker.php';

  $sql = "SELECT * FROM student where student_id =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: index.php?view=failed");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $_SESSION['student_session_id']);
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
        $sec = $row['class_id'];
        $sec2 = "SELECT class_name FROM class where class_id = $sec;";
        $sec22 = $conn->query($sec2);
        if ($sec22->num_rows > 0) {
          $sec22 = mysqli_fetch_assoc($sec22);
          $section = $sec22['class_name'];
          $filepath = $row['profile'];
        }else {
        $section = "Missing section - Contact your teacher";
        }

    } else {
      $_SESSION['error'] = "Failed, viewing profile.";
        header("location: ../login/index.php?view=failed");
        exit();

    }
  }
?>

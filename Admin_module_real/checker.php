<?php
require_once "../assets/db.php";

if (isset($_SESSION['admin_session_id']) && isset($_SESSION['admin_last_session_id'])) {
  $admin_id = $_SESSION['admin_session_id'];
  $last_session_id = $_SESSION['admin_last_session_id'];
  $sql = "SELECT * FROM admin where admin_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $admin_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        $assoc = mysqli_fetch_assoc($result);
        if ($assoc['last_session_id'] == $last_session_id)
        {}else {
          unset($_SESSION['admin_session_id']);
          unset($_SESSION['admin_last_session_id']);
          $_SESSION['notify'] = 100;
          header("location: ../login/index.php");
          exit();
        }
      }else{
        unset($_SESSION['admin_session_id']);
        unset($_SESSION['admin_last_session_id']);
        header("location: ../login/index.php");
      }
}else{
  header("location: ../login/index.php");
  exit();
}

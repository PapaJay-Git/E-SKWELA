<?php
require_once "checker.php";
require_once 'includes_profile_id_check.php';

if (isset($_GET['admin_id'])) {
  $admin_id = $_GET['admin_id'];
  if (!is_numeric($admin_id)) {
    $_SESSION['error'] = "admin ID is not an integer!";
    header("Location: admins.php");
    exit();
  }
  $sql = "SELECT * FROM admin WHERE admin_id =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    $_SESSION['error'] = "SQL error!";
    header("location: admins.php?sql=error");
    exit();
  }
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if ($result->num_rows == 0) {
      $_SESSION['error'] = "It looks like this admin does not exist!";
      header("Location: admins.php");
      exit();
    }
    if ($row['active_status'] == 1) {
      $active = 0;
    }else {
      $active = 1;
    }
    $sql = "UPDATE admin SET active_status = ? WHERE admin_id =?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error!";
      header("location: admins.php?sql=error");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ii", $active, $admin_id);
      if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "ADMIN $admin_id ACTIVE STATUS IS NOW UPDATED!";
        header("Location: admins.php");
        exit();
      }

}

<?php
require_once "../assets/db.php";
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
if (isset($_POST['admin_id']) && isset($_POST['admin_password'])) {
  $inputed_password = $_POST['admin_password'];
  $ID = $_POST['admin_id'];
  $sql = "SELECT * FROM admin where admin_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $ID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $old_password = $row['password'];
        $admin_id = $row['admin_id'];
      } else {
        echo "wrongid";
        exit();
      }
      $active = $row['active_status'];
      if ($active == 0 || $active != 1) {
        echo "inactive";
        exit();
      }
      if(password_verify($inputed_password, $old_password)) {
        $sql = "UPDATE admin SET last_session_id = ? WHERE admin_id =?";
        $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "si", $date, $admin_id);
            mysqli_stmt_execute($stmt);
        $_SESSION['admin_last_session_id'] = $date;
        $_SESSION['admin_session_id'] = $admin_id;
        echo "success";
        exit();
      }else {
        echo "wrongpassword";
        exit();
      }
}
else{
    echo "notset";
    exit();
}

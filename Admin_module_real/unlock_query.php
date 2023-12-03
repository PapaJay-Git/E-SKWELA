<?php
require_once "checker.php";
if (!isset($_GET['id'])) {
  $_SESSION['error'] = "Not settled ID";
  header("location: unlock.php");
  exit();
}else {
  $id = $_GET['id'];
  $locked = "locked";
  $unlocked = "unlocked";
  $sql = "SELECT * FROM grading WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows == 0) {
        $_SESSION['error'] = "Invalid ID";
        header("location: unlock.php");
        exit();
      }
      $output = mysqli_fetch_assoc($result);
      $quarter = $output['quarter'];
      if ($output['status']== "unlocked") {
        $sql = "UPDATE grading SET status = ? WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "si", $locked, $id);
            mysqli_stmt_execute($stmt);
            $_SESSION['success'] = "$quarter Quarter locked successfully!";
            header("location: unlock.php");
            exit();
      }else {
        $sql = "UPDATE grading SET status = ? WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "si", $unlocked, $id);
            mysqli_stmt_execute($stmt);
            $_SESSION['success'] = "$quarter Quarter unlocked successfully!";
            header("location: unlock.php");
            exit();
      }
}

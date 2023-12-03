<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
date_default_timezone_set('Asia/Manila');
// Then call the date functions
$date = date('Y-m-d H:i:s');

if (!isset($_POST['add_announcement']) || !isset($_POST['title']) || !isset($_POST['text']) ||!isset($_POST['date'])) {
    $_SESSION['error']= "Please use the button to for creation!";
   header("location: create_announcement.php?notset");
   exit();
 }else{
   $title = htmlspecialchars($_POST['title']);
   $text = htmlspecialchars($_POST['text']);
   $deadline = htmlspecialchars($_POST['date']);

   if (!strtotime($deadline)) {
     $_SESSION['error']= "Error, it looks like you're adding an announcement with invalid time";
     header("location: create_announcement.php?error=number");
     exit();
   }
   $sql_grade = "INSERT INTO announcements (title, texts, upload, deadline, admin_id) VALUES(?, ?, ?, ?, ?);";
   $stmt = mysqli_stmt_init($conn);
   mysqli_stmt_prepare($stmt, $sql_grade);
     //run sql
     mysqli_stmt_bind_param($stmt, "ssssi", $title, $text, $date, $deadline, $_SESSION['admin_session_id']);
     mysqli_stmt_execute($stmt);
     $_SESSION['success']= "Announcement created successfully!";
     header("location: create_announcement.php?success=true");
     exit();
 }

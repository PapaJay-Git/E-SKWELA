<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
$id = $_POST['edit_announcement'];
if (!isset($_POST['edit_announcement']) || !isset($_POST['title']) || !isset($_POST['text']) ||!isset($_POST['date'])) {
    $_SESSION['error']= "Please use the button for submitting your edit!";
   header("location: edit_announcement.php?id=$id&notset");
   exit();
 }else{
   $title = htmlspecialchars($_POST['title']);
   $text = htmlspecialchars($_POST['text']);
   $deadline = htmlspecialchars($_POST['date']);
   $sql_grade = "SELECT * FROM announcements WHERE announcement_id=?;";
   $stmt = mysqli_stmt_init($conn);
   mysqli_stmt_prepare($stmt, $sql_grade);
     //run sql
     mysqli_stmt_bind_param($stmt, "i", $id);
     mysqli_stmt_execute($stmt);
     $result = mysqli_stmt_get_result($stmt);
     if ($result->num_rows < 1) {
       $_SESSION['error']= "It looks like you are editing an announcement that does not exist!";
       header("location: edit_announcement.php?id=$id&success=false");
       exit();
     }

   if (!strtotime($deadline)) {
     $_SESSION['error']= "Error, it looks like you're editing an announcement with invalid time";
     header("location: edit_announcement.php?id=$id&error=number");
     exit();
   }
   $sql_grade = "UPDATE announcements SET title=?, texts=?, deadline=? WHERE announcement_id=?;";
   $stmt = mysqli_stmt_init($conn);
   mysqli_stmt_prepare($stmt, $sql_grade);
     //run sql
     mysqli_stmt_bind_param($stmt, "sssi", $title, $text, $deadline, $id);
     mysqli_stmt_execute($stmt);
     $_SESSION['success']= "Announcement edited successfully!";
     header("location: edit_announcement.php?id=$id&success=true");
     exit();
 }

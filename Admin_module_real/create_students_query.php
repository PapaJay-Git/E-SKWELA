<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
if (!isset($_POST['add_student']) || !isset($_POST['first_name']) || !isset($_POST['last_name']) ||!isset($_POST['password']) ||!isset($_POST['section']) || !isset($_POST['school_id'])) {

    $_SESSION['error']= "You cannot add an empty name or password!";
   header("location: create_students.php?notset");
   exit();
 }else{
   $fn = $_POST['first_name'];
   $ln = $_POST['last_name'];
   $pass= $_POST['password'];
   $id = $_POST['school_id'];
   $section_id = htmlspecialchars($_POST['section']);
   $N = count($fn);
   $N2 = count($fn);

   for($e=0; $e < $N2; $e++)
   {
   $length = strlen($pass[$e]);
   $school_id = trim(htmlspecialchars($id[$e]));
   $password = trim(htmlspecialchars($pass[$e]));
   $first_name2 = trim(htmlspecialchars($fn[$e]));
   $last_name2 = trim(htmlspecialchars($ln[$e]));
   $lrn_len = strlen($school_id);
   if ($lrn_len != 12) {
     $_SESSION['error'] ="Invalid LRN. LRN should only be a 12 digit number.";
     header("location: create_students.php?error=number");
     exit();
   }
   //loop to on how man1y classes do the student want to add this exam. Based on the check boxes selected
   if ($length < 21 && $length > 5) {
     //nothing
   }else {
     $_SESSION['error'] ="Please 6 to 20 characters of passwords only.";
     header("location: create_students.php?error=number");
     exit();
   }
   if (preg_match('/^\w+$/', $password)) {
     //nothing
   }else {
     $_SESSION['error']="Please passwords can only be letters (either case), numbers, and the underscore; 6 to 20 characters. ";
     header("location: create_students.php?error=number");
     exit();
   }

   if (preg_match('~[0-9]+~', $first_name2) || preg_match('~[0-9]+~', $last_name2)) {
     $_SESSION['error']= "Error, names are not allowed to have a number!";
     header("location: create_students.php?error=number");
     exit();
  }
   if (!is_numeric($school_id)|| !is_numeric($section_id)) {
     $_SESSION['error']= "Error, LRN or section can only be numbers!";
     header("location: create_students.php?error=number");
     exit();
   }
   if (empty($first_name2) || empty($last_name2) || empty($section_id) || empty($school_id)) {
     $_SESSION['error']= "Error, fields cannot be empty";
     header("location: create_students.php?error=number");
     exit();
   }
   $sql_grade = "SELECT * FROM class WHERE class_id = ?;";
   $stmt = mysqli_stmt_init($conn);
     mysqli_stmt_prepare($stmt, $sql_grade);
     mysqli_stmt_bind_param($stmt, "i", $section_id);
     mysqli_stmt_execute($stmt);
     $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 0) {
      $_SESSION['error']= "Invalid section!";
      header("location: create_students.php?success=section_not_exist");
      exit();
    }
    $sql_grade = "SELECT * FROM student WHERE school_id=?;";
    $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql_grade);
      mysqli_stmt_bind_param($stmt, "i", $school_id);
      mysqli_stmt_execute($stmt);
      $result_check = mysqli_stmt_get_result($stmt);
      if ($result_check->num_rows > 0) {
          $_SESSION['error']= "It looks like $school_id is already been added before. You cannot duplicate LRNs!";
          header("location: create_students.php?error=number");
          exit();
      }
   }
   for($i=0; $i < $N; $i++)
   {
     $school_id2 = trim(htmlspecialchars($id[$i]));
     $first_name = trim(htmlspecialchars($fn[$i]));
     $last_name = trim(htmlspecialchars($ln[$i]));
     $password2 = trim($pass[$i]);

     $sql_grade = "SELECT * FROM student WHERE school_id=?;";
     $stmt = mysqli_stmt_init($conn);
       mysqli_stmt_prepare($stmt, $sql_grade);
       mysqli_stmt_bind_param($stmt, "i", $school_id2);
       mysqli_stmt_execute($stmt);
       $result_check = mysqli_stmt_get_result($stmt);
       if ($result_check->num_rows > 0) {
           $_SESSION['error']= "It looks like $school_id2 is already been added before. You cannot duplicate LRNs!";
           header("location: create_students.php?error=number");
           exit();
       }

    $new_hashed = password_hash($password2, PASSWORD_DEFAULT);
    $sql_grade = "INSERT INTO student (school_id, f_name, l_name, class_id, password, date_promoted) VALUE (?, ?, ?,?,?, ?);";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql_grade);
      //run sql
      mysqli_stmt_bind_param($stmt, "ississ", $school_id2, $first_name, $last_name, $section_id, $new_hashed, $date);
         if(!mysqli_stmt_execute($stmt)){
           $_SESSION['error']= "Execution ERROR!";
           echo $conn->error;
           header("location: create_students.php?&success=error");
           exit();
         }
             $newid =  $conn->insert_id;
             $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?, ?,?,?)";
             $stmt = mysqli_stmt_init($conn);
             //Preparing the prepared statement
             $type_notif = "enrolled";
               mysqli_stmt_prepare($stmt, $notification);
               mysqli_stmt_bind_param($stmt, "iiiss",  $section_id, $newid, $_SESSION['admin_session_id'], $date, $type_notif);
               mysqli_stmt_execute($stmt);
   }
     $_SESSION['success']= "$N student account added successfully!";
     header("location: create_students.php?success=true");
     exit();
 }

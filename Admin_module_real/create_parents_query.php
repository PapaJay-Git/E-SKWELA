<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';

if (!isset($_POST['add_parent']) || !isset($_POST['first_name']) || !isset($_POST['last_name']) ||!isset($_POST['password'])) {

    $_SESSION['error']= "You cannot add an empty name or password!";
   header("location: create_parents.php?notset");
   exit();
 }else{
   $fn = $_POST['first_name'];
   $ln = $_POST['last_name'];
   $pass= $_POST['password'];
   $N = count($fn);
   $N2 = count($fn);

   for($e=0; $e < $N2; $e++)
   {
   $length = strlen($pass[$e]);
   $password = trim(htmlspecialchars($pass[$e]));
   $first_name2 = trim(htmlspecialchars($fn[$e]));
   $last_name2 = trim(htmlspecialchars($ln[$e]));
   //loop to on how man1y classes do the parent want to add this exam. Based on the check boxes selected
   if ($length < 21 && $length > 5) {
     //nothing
   }else {
     $_SESSION['error'] ="Please 6 to 20 characters of passwords only.";
     header("location: create_parents.php?error=number");
     exit();
   }
   if (preg_match('/^\w+$/', $password)) {
     //nothing
   }else {
     $_SESSION['error']="Please passwords can only be letters (either case), numbers, and the underscore; 6 to 20 characters. ";
     header("location: create_parents.php?error=number");
     exit();
   }
   if (preg_match('~[0-9]+~', $first_name2) || preg_match('~[0-9]+~', $last_name2)) {
     $_SESSION['error']= "Error, names are not allowed to have a number!";
     header("location: create_parents.php?error=number");
     exit();
  }
   if (empty($first_name2) || empty($last_name2)) {
     $_SESSION['error']= "Error, name cannot be empty";
     header("location: create_parents.php?error=number");
     exit();
   }
   }
   for($i=0; $i < $N; $i++)
   {
     $first_name = trim(htmlspecialchars($fn[$i]));
     $last_name = trim(htmlspecialchars($ln[$i]));
     $password2 = trim($pass[$i]);

    $new_hashed = password_hash($password2, PASSWORD_DEFAULT);
    $sql_grade = "INSERT INTO parents (f_name, l_name, password) VALUE (?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
      $_SESSION['error']= "Error adding parent";
      header("location: create_parents.php?success=sqlerror");
      exit();
    }
      //run sql
      mysqli_stmt_bind_param($stmt, "sss", $first_name, $last_name, $new_hashed);
         if(!mysqli_stmt_execute($stmt)){
           $_SESSION['error']= "Execution ERROR!";
           echo $conn->error;
           header("location: create_parents.php?&success=error");
           exit();
         }

   }
     $_SESSION['success']= "$N parent account added successfully!";
     header("location: create_parents.php?success=true");
     exit();
 }

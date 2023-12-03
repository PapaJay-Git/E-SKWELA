<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';

if (isset($_POST['add_grade10']) && isset($_POST['subject_name']) && !isset($_POST['STE'])) {
   $s = $_POST['subject_name'];
   $N = count($s);
   $N2 = count($s);

   for($e=0; $e < $N2; $e++)
   {
   $subject = strtoupper(ltrim(htmlspecialchars($s[$e])));
   if (empty($subject)) {
     $_SESSION['error']= "Error, name cannot be empty";
     header("location: create_grade10.php?error=number");
     exit();
   }
     $seven = 10;
     $sql_grade = "SELECT * FROM subjects WHERE subject_code =? AND grade = ?;";
     $stmt = mysqli_stmt_init($conn);
     //Preparing the prepared statement
     if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
       $_SESSION['error']= "Error adding subjects";
       header("location: create_grade10.php?success=sqlerror");
       exit();
     }
       //run sql
       mysqli_stmt_bind_param($stmt, "si", $subject, $seven);
       mysqli_stmt_execute($stmt);
       $result_check = mysqli_stmt_get_result($stmt);
       if ($result_check->num_rows > 0) {
           $_SESSION['error']= "It looks like $subject is already been added before. You cannot duplicate subjects on the same grade!";
           header("location: create_grade10.php?success=sqlerror");
           exit();
       }
   }
   for($i=0; $i < $N; $i++)
   {
     $subject2 = strtoupper(ltrim(htmlspecialchars($s[$i])));
     $seven = 10;
     $sql_grade = "SELECT * FROM subjects WHERE subject_code =? AND grade = ?;";
     $stmt = mysqli_stmt_init($conn);
     //Preparing the prepared statement
     if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
       $_SESSION['error']= "Error adding subjects";
       header("location: create_grade10.php?success=sqlerror");
       exit();
     }
       //run sql
       mysqli_stmt_bind_param($stmt, "si", $subject2, $seven);
       mysqli_stmt_execute($stmt);
       $result_check = mysqli_stmt_get_result($stmt);
       if ($result_check->num_rows > 0) {
           $_SESSION['error']= "It looks like you have duplicate in your entry! Only one $subject2 have been inserted!";
           header("location: create_grade10.php?success=sqlerror");
           exit();
       }
    $title = $subject2." ".$seven;
    $sql_grade = "INSERT INTO subjects (subject_code, subject_title, grade) VALUE (?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
      $_SESSION['error']= "Error adding subjects";
      header("location: create_grade10.php?success=sqlerror");
      exit();
    }
      //run sql
      mysqli_stmt_bind_param($stmt, "ssi", $subject2, $title, $seven);
         if(!mysqli_stmt_execute($stmt)){
           $_SESSION['error']= "Execution ERROR!";
           echo $conn->error;
           header("location: create_grade10.php?&success=error");
           exit();
         }

   }
     $_SESSION['success']= "$N Grade 10 subject added successfully!";
     header("location: create_grade10.php?success=true");
     exit();
 }elseif (isset($_POST['add_grade10']) && isset($_POST['subject_name']) && isset($_POST['STE'])) {
   $s = $_POST['subject_name'];
   $N = count($s);
   $N2 = count($s);

   for($e=0; $e < $N2; $e++)
   {
   $subject = strtoupper(ltrim(htmlspecialchars($s[$e])));
   if (empty($subject)) {
     $_SESSION['error']= "Error, name cannot be empty";
     header("location: create_grade10.php?error=number");
     exit();
   }
    $ste = 1;
     $seven = 10;
     $sql_grade = "SELECT * FROM subjects WHERE ste =? AND grade = ?;";
     $stmt = mysqli_stmt_init($conn);
     //Preparing the prepared statement
     if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
       $_SESSION['error']= "Error adding subjects";
       header("location: create_grade10.php?success=sqlerror");
       exit();
     }
       //run sql
       mysqli_stmt_bind_param($stmt, "si", $ste, $seven);
       mysqli_stmt_execute($stmt);
       $result_check = mysqli_stmt_get_result($stmt);
       if ($result_check->num_rows > 0) {
           $_SESSION['error']= "It looks like there is already an STE additional subject for grade 10. Only 1 STE additional subject is valid. If you wish to change, just edit the current grade 10 STE additional subjects name!";
           header("location: create_grade10.php?success=sqlerror");
           exit();
       }
       $sql_grade = "SELECT * FROM subjects WHERE subject_code =? AND grade = ?;";
       $stmt = mysqli_stmt_init($conn);
       //Preparing the prepared statement
       if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
         $_SESSION['error']= "Error adding subjects";
         header("location: create_grade10.php?success=sqlerror");
         exit();
       }
         //run sql
         mysqli_stmt_bind_param($stmt, "si", $subject, $seven);
         mysqli_stmt_execute($stmt);
         $result_check = mysqli_stmt_get_result($stmt);
         if ($result_check->num_rows > 0) {
             $_SESSION['error']= "It looks like $subject is already been added before. You cannot duplicate subjects on the same grade!";
             header("location: create_grade10.php?success=sqlerror");
             exit();
         }
   }
   for($i=0; $i < $N; $i++)
   {
     $subject2 = strtoupper(ltrim(htmlspecialchars($s[$i])));
      $ste = 1;
      $seven = 10;
      $sql_grade = "SELECT * FROM subjects WHERE ste =? AND grade = ?;";
      $stmt = mysqli_stmt_init($conn);
      //Preparing the prepared statement
      if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
        $_SESSION['error']= "Error adding subjects";
        header("location: create_grade10.php?success=sqlerror");
        exit();
      }
        //run sql
        mysqli_stmt_bind_param($stmt, "si", $ste, $seven);
        mysqli_stmt_execute($stmt);
        $result_check = mysqli_stmt_get_result($stmt);
        if ($result_check->num_rows > 0) {
            $_SESSION['error']= "It looks like there is already an STE additional subject for grade 10. Only 1 STE additional subject is valid. If you wish to change, just edit the current grade 10 STE additional subjects name!";
            header("location: create_grade10.php?success=sqlerror");
            exit();
        }
    $title = $subject2." ".$seven;
    $sql_grade = "INSERT INTO subjects (subject_code, subject_title, grade, ste) VALUE (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    //Preparing the prepared statement
    if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
      $_SESSION['error']= "Error adding subjects";
      header("location: create_grade10.php?success=sqlerror");
      exit();
    }

      mysqli_stmt_bind_param($stmt, "ssii", $subject2, $title, $seven, $ste);
         if(!mysqli_stmt_execute($stmt)){
           $_SESSION['error']= "Execution ERROR!";
           echo $conn->error;
           header("location: create_grade10.php?&success=error");
           exit();
         }

   }
     $_SESSION['success']= "Additional STE Grade 10 subject added successfully!";
     header("location: create_grade10.php?success=true");
     exit();
 }else{
     $_SESSION['error']=  "You cannot add an empty subject name!";
    header("location: create_grade10.php?notset");
    exit();
  }

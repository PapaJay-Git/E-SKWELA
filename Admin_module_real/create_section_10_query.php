<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';

if (!isset($_POST['add_section_10']) || !isset($_POST['section_name_10'])) {

  $_SESSION['error']= "You cannot add an empty section name!";
   header("location: create_section_10.php?notset");
   exit();
 }else{
   $s = $_POST['section_name_10'];
   $N = count($s);
   $N2 = count($s);

   for($e=0; $e < $N2; $e++)
   {
   $section = strtoupper(ltrim(htmlspecialchars($s[$e])));
   if (empty($section)) {
     $_SESSION['error']= "Error, name cannot be empty";
     header("location: create_section_10.php?error=number");
     exit();
   }
     $seven = 10;
     $sql_grade = "SELECT * FROM class WHERE section_code =? AND grade = ?;";
     $stmt = mysqli_stmt_init($conn);
     //Preparing the prepared statement
     if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
       $_SESSION['error']= "Error adding sections";
       header("location: create_section_10.php?success=sqlerror");
       exit();
     }
       //run sql
       mysqli_stmt_bind_param($stmt, "si", $section, $seven);
       mysqli_stmt_execute($stmt);
       $result_check = mysqli_stmt_get_result($stmt);
       if ($result_check->num_rows > 0) {
           $_SESSION['error']= "It looks like $section is already been added before. You cannot duplicate sections on the same grade!";
           header("location: create_section_10.php?success=sqlerror");
           exit();
       }
              if (preg_replace("/\s+/", "", $section) == "STE") {
                $ste = 1;
                $seven = 10;
                $sql_grade = "SELECT * FROM class WHERE ste =? AND grade = ?;";
                $stmt = mysqli_stmt_init($conn);
                //Preparing the prepared statement
                if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                  $_SESSION['error']= "Error adding sections";
                  header("location: create_section_10.php?success=sqlerror");
                  exit();
                }
                  //run sql
                  mysqli_stmt_bind_param($stmt, "si", $ste, $seven);
                  mysqli_stmt_execute($stmt);
                  $result_check = mysqli_stmt_get_result($stmt);
                  if ($result_check->num_rows > 0) {
                      $_SESSION['error']= "It looks like there is already an STE section assigned. Only 1 STE section is allowed, if you wish to change, you can edit the current one!";
                      header("location: create_section_10.php?success=sqlerror");
                      exit();
                  }
              }
   }
   for($i=0; $i < $N; $i++)
   {
     $section2 = strtoupper(ltrim(htmlspecialchars($s[$i])));

     $seven = 10;
     $sql_grade = "SELECT * FROM class WHERE section_code =? AND grade = ?;";
     $stmt = mysqli_stmt_init($conn);
     //Preparing the prepared statement
     if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
       $_SESSION['error']= "Error adding sections";
       header("location: create_section_10.php?success=sqlerror");
       exit();
     }
       //run sql
       mysqli_stmt_bind_param($stmt, "si", $section2, $seven);
       mysqli_stmt_execute($stmt);
       $result_check = mysqli_stmt_get_result($stmt);
       if ($result_check->num_rows > 0) {
           $_SESSION['error']= "It looks like you have duplicate in your entry! Only one $section2 have been inserted!";
           header("location: create_section_10.php?success=sqlerror");
           exit();
       }
       if (preg_replace("/\s+/", "", $section) == "STE") {
         $ste = 1;
         $sql_grade = "SELECT * FROM class WHERE ste =? AND grade = ?;";
         $stmt = mysqli_stmt_init($conn);
         //Preparing the prepared statement
         if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
           $_SESSION['error']= "Error adding sections";
           header("location: create_section_10.php?success=sqlerror");
           exit();
         }
           //run sql
           mysqli_stmt_bind_param($stmt, "si", $ste, $seven);
           mysqli_stmt_execute($stmt);
           $result_check = mysqli_stmt_get_result($stmt);
           if ($result_check->num_rows > 0) {
               $_SESSION['error']= "It looks like there is already an STE section assigned. Only 1 STE section is allowed, if you wish to change, you can edit the current one!";
               header("location: create_section_10.php?success=sqlerror");
               exit();
           }
       }
       if (preg_replace("/\s+/", "", $section) == "STE") {
         $secs = preg_replace("/\s+/", "", $section2);
         $title = $secs." ".$seven;
         $sql_grade = "INSERT INTO class (section_code, class_name, grade, ste) VALUE (?,?,?,?);";
         $stmt = mysqli_stmt_init($conn);
         //Preparing the prepared statement
         if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
           $_SESSION['error']= "Error adding sections";
           header("location: create_section_10.php?success=sqlerror");
           exit();
         }
           //run sql
           mysqli_stmt_bind_param($stmt, "ssii", $secs, $title, $seven, $ste);
              if(!mysqli_stmt_execute($stmt)){
                $_SESSION['error']= "Execution ERROR!";
                echo $conn->error;
                header("location: create_section_10.php?&success=error");
                exit();
              }
       }else{
         $title = $section2." ".$seven;
         $sql_grade = "INSERT INTO class (section_code, class_name, grade) VALUE (?,?,?);";
         $stmt = mysqli_stmt_init($conn);
         //Preparing the prepared statement
         if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
           $_SESSION['error']= "Error adding sections";
           header("location: create_section_10.php?success=sqlerror");
           exit();
         }
           //run sql
           mysqli_stmt_bind_param($stmt, "ssi", $section2, $title, $seven);
              if(!mysqli_stmt_execute($stmt)){
                $_SESSION['error']= "Execution ERROR!";
                echo $conn->error;
                header("location: create_section_10.php?&success=error");
                exit();
              }
       }
   }
     $_SESSION['success']= "$N Grade 10 section added successfully!";
     header("location: create_section_10.php?success=true");
     exit();
 }

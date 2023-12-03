<?php
require_once 'includes_profile_id_check.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
if (isset($_FILES['csv_file']) && isset($_POST['section'])) {
  $section_id = $_POST['section'];
  // Allowed mime types
  $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
  // Validate whether selected file is a CSV file
  if(empty($_FILES['csv_file']['name'])){
    $_SESSION['error']= "It looks like you are trying to proceed without a file or with an empty file.";
    header("location: create_students.php");
    exit();
  }
  if(!in_array($_FILES['csv_file']['type'], $csvMimes)){
    $_SESSION['error']= "Invalid file type. Only CSV files are allowed!";
    header("location: create_students.php");
    exit();
  }
  // If the file is uploaded
  if(!is_uploaded_file($_FILES['csv_file']['tmp_name'])){
    $_SESSION['error']= "It looks like your file is not uploaded properly. Please try again!";
    header("location: create_students.php");
    exit();
  }
  function removeBOM($s){
    if(substr($s,0,3)==chr(hexdec('EF')).chr(hexdec('BB')).chr(hexdec('BF'))){
            return substr($s,3);
    }else{
            return $s;
    }
  }

  // Open uploaded CSV file with read-only mode
    $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
    $csvFile2 = fopen($_FILES['csv_file']['tmp_name'], 'r');
    $line2 = fgetcsv($csvFile2);
    $line = fgetcsv($csvFile);
    if (!isset($line[0])) {
      $_SESSION['error']= "It looks like (LRN header) is not settled properply. ";
      header("location: create_students.php");
      exit();
    }
    if (!isset($line[1])) {
      $_SESSION['error']= "It looks like (First Name header) is not settled properply.";
      header("location: create_students.php");
      exit();
    }
    if (!isset($line[2])) {
      $_SESSION['error']= "It looks like (Last Name header) is not settled properply.";
      header("location: create_students.php");
      exit();
    }
    if (!isset($line[3])) {
      $_SESSION['error']= "It looks like (Password header) is not settled properply.";
      header("location: create_students.php");
      exit();
    }
    $lrn = trim(removeBOM(strtolower($line[0])));
    $first_name = trim(removeBOM(strtolower($line[1])));
    $last_name = trim(removeBOM(strtolower($line[2])));
    $password = trim(removeBOM(strtolower($line[3])));
    if ($lrn != "lrn") {
      $_SESSION['error']= "This header ($lrn) is not recognized. Use this (LRN) header in the first index instead.";
      header("location: create_students.php");
      exit();
    }
    if ($first_name != "first name") {
        $_SESSION['error']= "This header ($first_name) is not recognized. Use this (First Name) header in the second index instead.";
        header("location: create_students.php");
        exit();
    }
    if ($last_name != "last name") {
        $_SESSION['error']= "This header ($last_name) is not recognized. Use this (Last Name) header in the third index instead.";
        header("location: create_students.php");
        exit();
    }
    if ($password != "password") {
        $_SESSION['error']= "This header ($password) is not recognized. Use this (Password) header in the fourth index instead.";
        header("location: create_students.php");
        exit();
    }
    //checker
    function space($string){
      if (empty($string)) {
        $string = 0;
        return $string;
      }else {
        return $string;
      }
    }
    $counter = 1;
    $duplicate = [];
    while(($row = fgetcsv($csvFile)) !== FALSE){
              $counter++;
              if (!is_numeric(trim($row[0]))) {
                $_SESSION['error']= "There is non integer in Line ($counter). Please no spaces and only numerics are allowed for lrn.";
                header("location: create_students.php");
                exit();
              }
              // Get row data
              $lrn2   = str_replace(" ", "", floor(space(trim($row[0]))*100)/100);
              $first_name2  = trim(htmlspecialchars($row[1]));
              $last_name2  = trim(htmlspecialchars($row[2]));
              $password2 = trim(htmlspecialchars($row[3]));
              $length = strlen($password2);
              $lrn_len = strlen($lrn2);
              if ($lrn_len != 12) {
                $_SESSION['error'] ="Invalid LRN in Line ($counter). LRN should only be a 12 digit number.";
                header("location: create_students.php?error=number");
                exit();
              }
              if ($length < 21 && $length > 5) {
                //nothing
              }else {
                $_SESSION['error'] ="Password is invalid in Line ($counter). Please 6 to 20 characters of passwords only.";
                header("location: create_students.php");
                exit();
              }
              if (preg_match('/^\w+$/', $password2)) {
                //nothing
              }else {
                $_SESSION['error']="Password is invalid in Line ($counter). Please passwords can only be letters (either case), numbers, and the underscore; 6 to 20 characters. ";
                header("location: create_students.php");
                exit();
              }
              if (preg_match('~[0-9]+~', $first_name2) || preg_match('~[0-9]+~', $last_name2)) {
                $_SESSION['error']= "Invalid name in Line ($counter). Names are not allowed to have a number!";
                header("location: create_students.php?error=number");
                exit();
             }
              if (!is_numeric($lrn2)) {
                $_SESSION['error']= "Error, LRN can only be numbers!";
                header("location: create_students.php?error=number");
                exit();
              }
              if (empty($first_name2) || empty($last_name2) || empty($lrn2)) {
                $_SESSION['error']= "Empty field(s). One or more fields in Line ($counter) are empty.";
                header("location: create_students.php?error=number");
                exit();
              }
              if (empty($duplicate)) {
                array_push($duplicate, $lrn2);
              }else {
                if (in_array($lrn2, $duplicate)) {
                   $_SESSION['error'] = "It looks like this ($lrn2) LRN has duplicate in line ($counter).";
                  header("location: create_students.php");
                  exit();
                }else {
                  array_push($duplicate, $lrn2);
                }
              }
              $sql_grade = "SELECT * FROM class WHERE class_id = ?;";
              $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sql_grade);
                mysqli_stmt_bind_param($stmt, "i", $section_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
               if ($result->num_rows == 0) {
                 $_SESSION['error']= "Invalid section!";
                 header("location: create_students.php");
                 exit();
               }
               $sql_grade = "SELECT * FROM student WHERE school_id=?;";
               $stmt = mysqli_stmt_init($conn);
                 mysqli_stmt_prepare($stmt, $sql_grade);
                 mysqli_stmt_bind_param($stmt, "i", $lrn2);
                 mysqli_stmt_execute($stmt);
                 $result_check = mysqli_stmt_get_result($stmt);
                 if ($result_check->num_rows > 0) {
                     $_SESSION['error']= "It looks like this ($lrn2) LRN in line ($counter) is already been added before. You cannot duplicate LRNs!";
                     header("location: create_students.php");
                     exit();
                 }
    }
    $counter2 = 1;
    $N = 0;
    while(($row = fgetcsv($csvFile2)) !== FALSE){
              $counter2++;
              $N++;
              if (!is_numeric(trim($row[0]))) {
                $_SESSION['error']= "There is non integer in Line ($counter2). Please no spaces and only numerics are allowed for lrn.";
                header("location: create_students.php");
                exit();
              }
              // Get row data
              $lrn2   = str_replace(" ", "", floor(space(trim($row[0]))*100)/100);
              $first_name2  = trim(htmlspecialchars($row[1]));
              $last_name2  = trim(htmlspecialchars($row[2]));
              $password2 = trim(htmlspecialchars($row[3]));
              $sql_grade = "SELECT * FROM student WHERE school_id=?;";
              $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sql_grade);
                mysqli_stmt_bind_param($stmt, "i", $lrn2);
                mysqli_stmt_execute($stmt);
                $result_check = mysqli_stmt_get_result($stmt);
                if ($result_check->num_rows > 0) {
                    $_SESSION['error']= "It looks like $lrn2 is already been added before. You cannot duplicate LRNs!";
                    header("location: create_students.php?error=number");
                    exit();
                }

             $new_hashed = password_hash($password2, PASSWORD_DEFAULT);
             $sql_grade = "INSERT INTO student (school_id, f_name, l_name, class_id, password, date_promoted) VALUE (?, ?, ?,?,?, ?);";
             $stmt = mysqli_stmt_init($conn);
             mysqli_stmt_prepare($stmt, $sql_grade);
               //run sql
               mysqli_stmt_bind_param($stmt, "ississ", $lrn2, $first_name2, $last_name2, $section_id, $new_hashed, $date);
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
}else {
  $_SESSION['error'] ="Please fill up the Form.";
  header("location: create_students.php");
  exit();
}

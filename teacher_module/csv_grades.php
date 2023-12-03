<?php
  require_once "includes_classes_id_check.php";
  $tc_id = $_GET['tc_id'];
  $status = "unlocked";
  $sql = "SELECT * FROM grading WHERE status = ?;";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
  mysqli_stmt_bind_param($stmt, "s", $status);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if ($result->num_rows == 0) {
    $_SESSION['error']= "No quarter unlocked at the moment!";
    header("location: teacher_view_students.php?tc_id=".$tc_id);
    exit();
  }
  $quarters = [];
  $quarters2 = NULL;
  while ($open = mysqli_fetch_assoc($result)) {
    array_push($quarters, strtolower($open['quarter']));
    $quarters2 .= $open['quarter']." ";
  }
  if (isset($_FILES['file'])) {
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    // Validate whether selected file is a CSV file
    if(empty($_FILES['file']['name'])){
      $_SESSION['error']= "It looks like you are trying to proceed without a file or with an empty file.";
      header("location: teacher_view_students.php?aa&tc_id=".$tc_id);
      exit();
    }
    if(!in_array($_FILES['file']['type'], $csvMimes)){
      $_SESSION['error']= "Invalid file type. Only CSV files are allowed! Please check the question mark above (Upload Now) button for more info.";
      header("location: teacher_view_students.php?aa&tc_id=".$tc_id);
      exit();
    }
    // If the file is uploaded
    if(!is_uploaded_file($_FILES['file']['tmp_name'])){
      $_SESSION['error']= "It looks like your file is not uploaded properly. Please try again!";
      header("location: teacher_view_students.php?tc_id=".$tc_id);
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
      $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
      $csvFile2 = fopen($_FILES['file']['tmp_name'], 'r');
      $line2 = fgetcsv($csvFile2);
      $line = fgetcsv($csvFile);
      if (!isset($line[0])) {
        $_SESSION['error']= "It looks like (LRN header) is not settled properply. Please check the question mark above (Upload Now) button for the formats.";
        header("location: teacher_view_students.php?tc_id=".$tc_id);
        exit();
      }
      if (!isset($line[1])) {
        $_SESSION['error']= "It looks like (First header) is not settled properply. Please check the question mark above (Upload Now) button for the formats.";
        header("location: teacher_view_students.php?tc_id=".$tc_id);
        exit();
      }
      if (!isset($line[2])) {
        $_SESSION['error']= "It looks like (Second header) is not settled properply. Please check the question mark above (Upload Now) button for the formats.";
        header("location: teacher_view_students.php?tc_id=".$tc_id);
        exit();
      }
      if (!isset($line[3])) {
        $_SESSION['error']= "It looks like (Third header) is not settled properply.Please check the question mark above (Upload Now) button for the formats.";
        header("location: teacher_view_students.php?tc_id=".$tc_id);
        exit();
      }
      if (!isset($line[4])) {
        $_SESSION['error']= "It looks like (Fourth header) is not settled properply. Please check the question mark above (Upload Now) button for the formats.";
        header("location: teacher_view_students.php?tc_id=".$tc_id);
        exit();
      }
      if (!isset($line[5])) {
        $_SESSION['error']= "It looks like (Final) is not settled properply. Please check the question mark above (Upload Now) button for the formats.";
        header("location: teacher_view_students.php?tc_id=".$tc_id);
        exit();
      }
      $lrn1 = trim(removeBOM(strtolower($line[0])));
      $first1 = trim(removeBOM(strtolower($line[1])));
      $second1 = trim(removeBOM(strtolower($line[2])));
      $third1 = trim(removeBOM(strtolower($line[3])));
      $fourth1 = trim(removeBOM(strtolower($line[4])));
      $final1 = trim(removeBOM(strtolower($line[5])));
      if ($lrn1 != "lrn") {
        $_SESSION['error']= "This header ($lrn1) is not recognized. Use this (LRN) header in the first index instead. Please check the question mark above (Upload Now) button for more info.";
        header("location: teacher_view_students.php?tc_id=".$tc_id);
        exit();
      }
      if ($first1 != "first") {
          $_SESSION['error']= "This header ($first1) is not recognized. Use this (First) header in the second index instead. Please check the question mark above (Upload Now) button for more info.";
          header("location: teacher_view_students.php?tc_id=".$tc_id);
          exit();
      }
      if ($second1 != "second") {
          $_SESSION['error']= "This header ($second1) is not recognized. Use this (Second) header in the third index instead. Please check the question mark above (Upload Now) button for more info.";
          header("location: teacher_view_students.php?tc_id=".$tc_id);
          exit();
      }
      if ($third1 != "third") {
          $_SESSION['error']= "This header ($third1) is not recognized. Use this (Third) header in the fourth index instead. Please check the question mark above (Upload Now) button for more info.";
          header("location: teacher_view_students.php?tc_id=".$tc_id);
          exit();
      }
      if ($fourth1 != "fourth") {
          $_SESSION['error']= "This header ($fourth1) is not recognized. Use this (Fourth) header in the fifth index instead. Please check the question mark above (Upload Now) button for more info.";
          header("location: teacher_view_students.php?tc_id=".$tc_id);
          exit();
      }
      if ($final1 != "final") {
          $_SESSION['error']= "This header ($final1) is not recognized. Use this (Final) header in the sixth index instead. Please check the question mark above (Upload Now) button for more info.";
          header("location: teacher_view_students.php?tc_id=".$tc_id);
          exit();
      }
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
                if (!is_numeric($row[0])) {
                  $_SESSION['error']= "There is non integer in Line ($counter). Please no spaces and only numerics are allowed for lrn and grade. Please check the question mark above (Upload Now) button for more info.";
                  header("location: teacher_view_students.php?tc_id=".$tc_id);
                  exit();
                }
                // Get row data
                $lrn   = floor(space($row[0])*100)/100;
                $first  = space($row[1]);
                $second  = space($row[2]);
                $third = space($row[3]);
                $fourth = space($row[4]);
                $final = space($row[5]);
                if (empty($duplicate)) {
                  array_push($duplicate, $lrn);
                }else {
                  if (in_array($lrn, $duplicate)) {
                     $_SESSION['error'] = "It looks like this LRN ($lrn) has duplicate in line ($counter). Please check the question mark above (Upload Now) button for more info.";
                    header("location: teacher_view_students.php?tc_id=".$tc_id);
                    exit();
                  }else {
                    array_push($duplicate, $lrn);
                  }
                }
                //check if input is numbers
                if (!is_numeric(str_replace(" ", "", $lrn)) || !is_numeric(str_replace(" ", "", $first)) || !is_numeric(str_replace(" ", "", $second)) || !is_numeric(str_replace(" ", "", $third))
                 || !is_numeric(str_replace(" ", "", $fourth)) || !is_numeric(str_replace(" ", "", $final))) {
                   $_SESSION['error']= "There is non integer in Line ($counter). Please no spaces and only numerics are allowed for lrn and grade. Please check the question mark above (Upload Now) button for more info.";
                   header("location: teacher_view_students.php?tc_id=".$tc_id);
                   exit();
                }
                if ($first> 100 || $second > 100 || $third > 100 || $fourth > 100 || $final > 100) {
                  $_SESSION['error']= "Grades are not allowed to be greater than 100. Please check your csv file in line ($counter).  Please check the question mark above (Upload Now) button for more info.";
                  header("location: teacher_view_students.php?tc_id=".$tc_id);
                  exit();
                }
                $check_lrn = "SELECT * FROM student WHERE school_id = ? AND class_id = ?;";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $check_lrn);
                mysqli_stmt_bind_param($stmt, "ii", $lrn, $csv_class_id);
                mysqli_stmt_execute($stmt);
                $results = mysqli_stmt_get_result($stmt);
                if ($results->num_rows < 1) {
                  $_SESSION['error']= "It looks like this ($lrn) LRN in line ($counter) does not exist in this section. If this LRN is equals to Zero (0), then it means it does not exist in your file, meaning you have a whitespace in line ($counter) in your cell that has been converted into Zero (0). Please remove all the cells that has no LRN.";
                  header("location: teacher_view_students.php?tc_id=".$tc_id);
                  exit();
                }
      }
      $numbered = 0;
      while(($row2 = fgetcsv($csvFile2)) !== FALSE){
        $numbered++;
        // Get row data
        $lrn33   = floor(space($row2[0])*100)/100;
        $first33  = space($row2[1]);
        $second33  = space($row2[2]);
        $third33 = space($row2[3]);
        $fourth33 = space($row2[4]);
        $final33 = space($row2[5]);

        $check_id = "SELECT * FROM student WHERE school_id = ? AND class_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $check_id);
        mysqli_stmt_bind_param($stmt, "ii", $lrn33, $csv_class_id);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $student_id01 = mysqli_fetch_assoc($results);
        $student_id02 = $student_id01['student_id'];
        //search if already exist
        $sql_grade = "SELECT * FROM stu_grade WHERE subject_id=? AND student_id=?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql_grade);
        mysqli_stmt_bind_param($stmt, "ii", $csv_subject_id, $student_id02);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (in_array("first", $quarters)) {
          if($result->num_rows > 0){
            $sql_grade = "UPDATE stu_grade SET first=?, teacher_id=?, teacher_class_id=? WHERE subject_id=? AND student_id=?;";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
                 if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                   $_SESSION['error']= "Error saving grade.";
                   header("location: teacher_view_students.php?tc_id=".$tc_id);
                   exit();
                 }
              //run sql
                 mysqli_stmt_bind_param($stmt, "diiii", $first33, $_SESSION['teacher_session_id'], $tc_id, $csv_subject_id, $student_id02);
                 if(!mysqli_stmt_execute($stmt)){
                   $_SESSION['error']= "Error saving grade";
                   header("location: teacher_view_students.php?tc_id=".$tc_id);
                   exit();
                 }
          }else{
              //verification
            $sql_grade12345 = "SELECT * FROM stu_grade WHERE subject_id=? AND student_id=?;";
            $stmt123 = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt123, $sql_grade12345);
            mysqli_stmt_bind_param($stmt123, "ii", $csv_subject_id, $student_id02);
            mysqli_stmt_execute($stmt123);
            $result12345 = mysqli_stmt_get_result($stmt123);
            if ($result12345->num_rows > 0) {
              $sql_grade = "UPDATE stu_grade SET first=?, teacher_id=?, teacher_class_id=? WHERE subject_id=? AND student_id=?;";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
                   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                     $_SESSION['error']= "Error saving grade.";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                //run sql
                   mysqli_stmt_bind_param($stmt, "diiii", $first33, $_SESSION['teacher_session_id'], $tc_id, $csv_subject_id, $student_id02);
                   if(!mysqli_stmt_execute($stmt)){
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
            }else {
              $sql_grade = "INSERT INTO stu_grade (first, teacher_class_id, student_id, teacher_id, subject_id) VALUES (?, ?, ?, ?, ?);";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
                   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                //run sql
                   mysqli_stmt_bind_param($stmt, "diiii", $first33, $tc_id, $student_id02, $_SESSION['teacher_session_id'], $csv_subject_id);
                   if(!mysqli_stmt_execute($stmt)){
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
            }


               }
        }
        if (in_array("second", $quarters)) {
          if($result->num_rows > 0){
            $sql_grade = "UPDATE stu_grade SET second=?, teacher_id=?, teacher_class_id=? WHERE subject_id=? AND student_id=?;";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
                 if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                   $_SESSION['error']= "Error saving grade";
                   header("location: teacher_view_students.php?tc_id=".$tc_id);
                   exit();
                 }
              //run sql
                 mysqli_stmt_bind_param($stmt, "diiii", $second33, $_SESSION['teacher_session_id'], $tc_id, $csv_subject_id, $student_id02);
                 if(!mysqli_stmt_execute($stmt)){
                   $_SESSION['error']= "Error saving grade";
                   header("location: teacher_view_students.php?tc_id=".$tc_id);
                   exit();
                 }
          }else{
              //verification
            $sql_grade12345 = "SELECT * FROM stu_grade WHERE subject_id=? AND student_id=?;";
            $stmt123 = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt123, $sql_grade12345);
            mysqli_stmt_bind_param($stmt123, "ii", $csv_subject_id, $student_id02);
            mysqli_stmt_execute($stmt123);
            $result12345 = mysqli_stmt_get_result($stmt123);
            if ($result12345->num_rows > 0) {
              $sql_grade = "UPDATE stu_grade SET second=?, teacher_id=?, teacher_class_id=? WHERE subject_id=? AND student_id=?;";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
                   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                //run sql
                   mysqli_stmt_bind_param($stmt, "diiii", $second33, $_SESSION['teacher_session_id'], $tc_id, $csv_subject_id, $student_id02);
                   if(!mysqli_stmt_execute($stmt)){
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
            }else {
              $sql_grade = "INSERT INTO stu_grade (second, teacher_class_id, student_id, teacher_id, subject_id) VALUES (?, ?, ?, ?, ?);";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
                   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                //run sql
                   mysqli_stmt_bind_param($stmt, "diiii", $second33, $tc_id, $student_id02, $_SESSION['teacher_session_id'], $csv_subject_id);
                   if(!mysqli_stmt_execute($stmt)){
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
            }

               }
        }
        if (in_array("third", $quarters)) {
          if($result->num_rows > 0){
            $sql_grade = "UPDATE stu_grade SET third=?, teacher_id=?, teacher_class_id=? WHERE subject_id=? AND student_id=?;";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
                 if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                   $_SESSION['error']= "Error saving grade";
                   header("location: teacher_view_students.php?tc_id=".$tc_id);
                   exit();
                 }
              //run sql
                 mysqli_stmt_bind_param($stmt, "diiii", $third33, $_SESSION['teacher_session_id'], $tc_id, $csv_subject_id, $student_id02);
                 if(!mysqli_stmt_execute($stmt)){
                   $_SESSION['error']= "Error saving grade";
                   header("location: teacher_view_students.php?tc_id=".$tc_id);
                   exit();
                 }
          }else{
            //verification
            $sql_grade12345 = "SELECT * FROM stu_grade WHERE subject_id=? AND student_id=?;";
            $stmt123 = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt123, $sql_grade12345);
            mysqli_stmt_bind_param($stmt123, "ii", $csv_subject_id, $student_id02);
            mysqli_stmt_execute($stmt123);
            $result12345 = mysqli_stmt_get_result($stmt123);
            if ($result12345->num_rows > 0) {
              $sql_grade = "UPDATE stu_grade SET third=?, teacher_id=?, teacher_class_id=? WHERE subject_id=? AND student_id=?;";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
                   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                //run sql
                   mysqli_stmt_bind_param($stmt, "diiii", $third33, $_SESSION['teacher_session_id'], $tc_id, $csv_subject_id, $student_id02);
                   if(!mysqli_stmt_execute($stmt)){
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
            }else {
              $sql_grade = "INSERT INTO stu_grade (third, teacher_class_id, student_id, teacher_id, subject_id) VALUES (?, ?, ?, ?, ?);";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
                   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                //run sql
                   mysqli_stmt_bind_param($stmt, "diiii", $third33, $tc_id, $student_id02, $_SESSION['teacher_session_id'], $csv_subject_id);
                   if(!mysqli_stmt_execute($stmt)){
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                 }
            }

        }
        if (in_array("fourth", $quarters)) {
          if($result->num_rows > 0){
            $sql_grade = "UPDATE stu_grade SET fourth=?, final=?, teacher_id=?, teacher_class_id=? WHERE subject_id=? AND student_id=?;";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
                 if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                   $_SESSION['error']= "Error saving grade";
                   header("location: teacher_view_students.php?tc_id=".$tc_id);
                   exit();
                 }
              //run sql
                 mysqli_stmt_bind_param($stmt, "ddiiii", $fourth33, $final33, $_SESSION['teacher_session_id'], $tc_id, $csv_subject_id, $student_id02);
                 if(!mysqli_stmt_execute($stmt)){
                   $_SESSION['error']= "Error saving grade";
                   header("location: teacher_view_students.php?tc_id=".$tc_id);
                   exit();
                 }
          }else{
            //verification
            $sql_grade12345 = "SELECT * FROM stu_grade WHERE subject_id=? AND student_id=?;";
            $stmt123 = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt123, $sql_grade12345);
            mysqli_stmt_bind_param($stmt123, "ii", $csv_subject_id, $student_id02);
            mysqli_stmt_execute($stmt123);
            $result12345 = mysqli_stmt_get_result($stmt123);
            if ($result12345->num_rows > 0) {
              $sql_grade = "UPDATE stu_grade SET fourth=?, final=?, teacher_id=?, teacher_class_id=? WHERE subject_id=? AND student_id=?;";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
                   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                //run sql
                   mysqli_stmt_bind_param($stmt, "ddiiii", $fourth33, $final33, $_SESSION['teacher_session_id'], $tc_id, $csv_subject_id, $student_id02);
                   if(!mysqli_stmt_execute($stmt)){
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
            }else {
              $sql_grade = "INSERT INTO stu_grade (fourth, final, teacher_class_id, student_id, teacher_id, subject_id) VALUES (?, ?, ?, ?, ?, ?);";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
                   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                //run sql
                   mysqli_stmt_bind_param($stmt, "ddiiii", $fourth33, $final33, $tc_id, $student_id02, $_SESSION['teacher_session_id'], $csv_subject_id);
                   if(!mysqli_stmt_execute($stmt)){
                     $_SESSION['error']= "Error saving grade";
                     header("location: teacher_view_students.php?tc_id=".$tc_id);
                     exit();
                   }
                 }
            }

        }

      }
      if ($numbered > 1) {
        $_SESSION['success']= "Unlocked ($quarters2) quarter grades for ($numbered) students are now been saved!";
        header("location: teacher_view_students.php?tc_id=".$tc_id);
        exit();
      }else {
        $_SESSION['success']= "Unlocked ($quarters2) quarter grades for ($numbered) student are now been saved!";
        header("location: teacher_view_students.php?tc_id=".$tc_id);
        exit();
      }
  }else {
    $_SESSION['error']= "It looks like your csv file is not propely submitted";
    header("location: teacher_view_students.php?tc_id=".$tc_id);
    exit();
  }

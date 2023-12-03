<?php
require_once "checker.php";
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
$seven = 7;
$eight = 8;
$nine = 9;
$ten = 10;
$one2 = 1;
if (isset($_POST['old_7']) && isset($_POST['old_8']) && isset($_POST['old_9']) && isset($_POST['section_8']) && isset($_POST['section_9']) && isset($_POST['section_10'])) {
  $old_7 = $_POST['old_7'];
  $old_8 = $_POST['old_8'];
  $old_9 = $_POST['old_9'];
  $section_8 = $_POST['section_8'];
  $section_9 = $_POST['section_9'];
  $section_10 = $_POST['section_10'];
  //count
  $count_old_7 = count($old_7);
  $count_old_8 = count($old_8);
  $count_old_9 = count($old_9);
  $count_section_8 = count($section_8);
  $count_section_9 = count($section_9);
  $count_section_10 = count($section_10);
  //existing old 7 and section_8
  for($e=0; $e < $count_old_7; $e++)
  {
    $old_7_02 = $old_7[$e];
    $section_8_02 = $section_8[$e];
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $old_7_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows < 1) {
      $_SESSION['error'] = "It looks there is a missing Data from your promotion. Please fill the form correctly!";
      header("location: promote_all.php");
      exit();
      exit();
    }
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $section_8_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows < 1) {
      $_SESSION['error'] = "It looks there is a missing Data from your promotion. Please fill the form correctly!";
      header("location: promote_all.php");
      exit();
      exit();
    }
  }
  //existing old 8 and section_9
  for($e=0; $e < $count_old_8; $e++){
    $old_8_02 = $old_8[$e];
    $section_9_02 = $section_9[$e];
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $old_8_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows < 1) {
      $_SESSION['error'] = "It looks there is a missing Data from your promotion. Please fill the form correctly!";
      header("location: promote_all.php");
      exit();
      exit();
    }
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $section_9_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows < 1) {
      $_SESSION['error'] = "It looks there is a missing Data from your promotion. Please fill the form correctly!";
      header("location: promote_all.php");
      exit();
      exit();
    }
  }
  //existing old 9 and section_10
  for($e=0; $e < $count_old_9; $e++){
    $old_9_02 = $old_9[$e];
    $section_10_02 = $section_10[$e];
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $old_9_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows < 1) {
      $_SESSION['error'] = "It looks there is a missing Data from your promotion. Please fill the form correctly!";
      header("location: promote_all.php");
      exit();
      exit();
    }
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $section_10_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    if ($result_check->num_rows < 1) {
      $_SESSION['error'] = "It looks there is a missing Data from your promotion. Please fill the form correctly!";
      header("location: promote_all.php");
      exit();
      exit();
    }
  }
  //delete all notifcations. teacher and students
  $zero = 0;
  $delete_notif = "DELETE FROM student_notification WHERE id != ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $delete_notif);
  mysqli_stmt_bind_param($stmt, "i", $zero);
  mysqli_stmt_execute($stmt);
  $delete_notif = "DELETE FROM teacher_notification WHERE id != ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $delete_notif);
  mysqli_stmt_bind_param($stmt, "i", $zero);
  mysqli_stmt_execute($stmt);
  //Update all student repeater as NOT
  $zero = 0;
  $update = "UPDATE student SET repeater = ?;";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $update);
  mysqli_stmt_bind_param($stmt, "i", $zero);
  mysqli_stmt_execute($stmt);
  //Update all student previous STE
  $update = "UPDATE student SET previous_ste = ? WHERE dropped = ? AND transferred = ?;";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $update);
  mysqli_stmt_bind_param($stmt, "iii", $zero, $one2, $one2);
  mysqli_stmt_execute($stmt);
  //checking all grade 10 classes
  $check_section10 = "SELECT * FROM class WHERE grade =?;";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $check_section10);
  mysqli_stmt_bind_param($stmt, "i", $ten);
  mysqli_stmt_execute($stmt);
  $result_check78 = mysqli_stmt_get_result($stmt);
  //promote or repeater for grade 10
  while ($row_old_10 = mysqli_fetch_assoc($result_check78)) {
    $old_10_02 = $row_old_10['class_id'];
    $section_11_02 = 1;
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $old_10_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result_check);
    //Check if ste
    if ($row['ste'] == 1) {
      $sql = "SELECT * FROM subjects where grade =? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $ten);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    else {
      $ste = 0;
      $sql = "SELECT * FROM subjects where grade =? AND ste = ? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "ii", $ten, $ste);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    $sql = "SELECT * FROM student WHERE class_id = ? AND dropped = ? AND transferred =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $old_10_02, $one2, $one2);
    mysqli_stmt_execute($stmt);
    $result_010 = mysqli_stmt_get_result($stmt);
    $counter = 0;
    while ($students = mysqli_fetch_assoc($result_010)) {
      $student_id = $students['student_id'];
      $result44->data_seek(0);
      $myArr = [];
      while ($row1010 = mysqli_fetch_assoc($result44)) {
              $sql = "SELECT * FROM stu_grade where student_id =? AND subject_id =?";
              $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $sql);
              mysqli_stmt_bind_param($stmt, "ii", $student_id, $row1010['subject_id']);
              mysqli_stmt_execute($stmt);
              $result46 = mysqli_stmt_get_result($stmt);
              if ($result46->num_rows > 0) {
                $row1111 = mysqli_fetch_assoc($result46);
                array_push($myArr, $row1111['final']);
                if ($row1111['final'] < 75) {
                  $counter++;
                }
              }else {
                array_push($myArr, 0);
                $counter++;
              }
      }
      if ($row['ste'] == 1) {
        $sum = array_sum($myArr);
        $countNum = count($myArr);
        $general_average = $sum/$countNum;
        if ($general_average == 85 || $general_average > 85) {
          $zero = 0;
          $update2 = "UPDATE student SET ten =?, repeater = ?, class_id =?, date_promoted =? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "iiisi", $old_10_02, $zero, $section_11_02, $date, $student_id);
          mysqli_stmt_execute($stmt);
          //notification
          $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "promoted";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiss",  $section_11_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
            mysqli_stmt_execute($stmt);
        }else {
          if($counter > 2) {
            $one = 1;
            $update2 = "UPDATE student SET repeater = ? WHERE student_id = ?;";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $update2);
            mysqli_stmt_bind_param($stmt, "ii", $one, $student_id);
            mysqli_stmt_execute($stmt);
          }else {
            $zero = 0;
            $update2 = "UPDATE student SET ten=?, repeater = ?, class_id =?, date_promoted =? WHERE student_id = ?;";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $update2);
            mysqli_stmt_bind_param($stmt, "iiisi", $old_10_02, $zero, $section_11_02, $date, $student_id);
            mysqli_stmt_execute($stmt);
            //notification
            $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
            $type_notif = "promoted";
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "iiiss",  $section_11_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
              mysqli_stmt_execute($stmt);
          }
        }
      }else {
        if($counter > 2) {
          $one = 1;
          $update2 = "UPDATE student SET repeater = ? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "ii", $one, $student_id);
          mysqli_stmt_execute($stmt);
        }else {
          $zero = 0;
          $update2 = "UPDATE student SET ten=?, repeater = ?, class_id =?, date_promoted =? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "iiisi", $old_10_02, $zero, $section_11_02, $date, $student_id);
          mysqli_stmt_execute($stmt);
          //notification
          $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "promoted";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiss",  $section_11_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
            mysqli_stmt_execute($stmt);
        }
      }
      $counter = 0;
    }
  }
  //promote or repeater for grade 9
  for($e=0; $e < $count_old_9; $e++){
    $old_9_02 = $old_9[$e];
    $section_10_02 = $section_10[$e];
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $old_9_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result_check);
    //Check if ste
    if ($row['ste'] == 1) {
      $sql = "SELECT * FROM subjects where grade =? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $nine);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    else {
      $ste = 0;
      $sql = "SELECT * FROM subjects where grade =? AND ste = ? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "ii", $nine, $ste);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    $sql = "SELECT * FROM student WHERE class_id = ? AND dropped = ? AND transferred =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $old_9_02, $one2, $one2);
    mysqli_stmt_execute($stmt);
    $result_09 = mysqli_stmt_get_result($stmt);
    $counter = 0;
    while ($students = mysqli_fetch_assoc($result_09)) {
      $student_id = $students['student_id'];
      $result44->data_seek(0);
      $myArr = [];
      while ($row99 = mysqli_fetch_assoc($result44)) {
              $sql = "SELECT * FROM stu_grade where student_id =? AND subject_id =?";
              $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $sql);
              mysqli_stmt_bind_param($stmt, "ii", $student_id, $row99['subject_id']);
              mysqli_stmt_execute($stmt);
              $result46 = mysqli_stmt_get_result($stmt);
              if ($result46->num_rows > 0) {
                $row1010 = mysqli_fetch_assoc($result46);
                array_push($myArr, $row1010['final']);
                if ($row1010['final'] < 75) {
                  $counter++;
                }
              }else {
                array_push($myArr, 0);
                $counter++;
              }
      }
      if ($row['ste'] == 1) {
        $sum = array_sum($myArr);
        $countNum = count($myArr);
        $general_average = $sum/$countNum;
        if ($general_average == 85 || $general_average > 85) {
          $zero = 0;
          $update2 = "UPDATE student SET nine=?, repeater = ?, class_id =?, date_promoted =? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "iiisi", $old_9_02, $zero, $section_10_02, $date, $student_id);
          mysqli_stmt_execute($stmt);
          //notification
          $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "promoted";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiss",  $section_10_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
            mysqli_stmt_execute($stmt);
        }else {
          if($counter > 2) {
            $one = 1;
            $update2 = "UPDATE student SET repeater = ? WHERE student_id = ?;";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $update2);
            mysqli_stmt_bind_param($stmt, "ii", $one, $student_id);
            mysqli_stmt_execute($stmt);
          }else {
            $zero = 0;
            $sql5 = "SELECT class_id FROM class where ste = $zero AND grade = $ten;";
            $classN = $conn->query($sql5);
            $classN2 = mysqli_fetch_assoc($classN);
            $ste_to_normal = $classN2['class_id'];
            $update2 = "UPDATE student SET nine=?, repeater = ?, class_id =?, date_promoted =?, previous_ste=? WHERE student_id = ?;";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $update2);
            mysqli_stmt_bind_param($stmt, "iiisii", $old_9_02, $zero, $ste_to_normal, $date, $old_9_02, $student_id);
            mysqli_stmt_execute($stmt);
            //notification
            $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
            $type_notif = "promoted";
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "iiiss",  $section_10_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
              mysqli_stmt_execute($stmt);
          }
        }
      }else {
        if($counter > 2) {
          $one = 1;
          $update2 = "UPDATE student SET repeater = ? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "ii", $one, $student_id);
          mysqli_stmt_execute($stmt);
        }else {
          $zero = 0;
          $update2 = "UPDATE student SET nine=?, repeater = ?, class_id =?, date_promoted =? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "iiisi", $old_9_02, $zero, $section_10_02, $date, $student_id);
          mysqli_stmt_execute($stmt);
          //notification
          $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "promoted";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiss",  $section_10_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
            mysqli_stmt_execute($stmt);
        }
      }
      $counter = 0;
    }
  }
  //promote or repeater for grade 8
  for($e=0; $e < $count_old_8; $e++){
    $old_8_02 = $old_8[$e];
    $section_9_02 = $section_9[$e];
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $old_8_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result_check);
    //Check if ste
    if ($row['ste'] == 1) {
      $sql = "SELECT * FROM subjects where grade =? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $eight);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    else {
      $ste = 0;
      $sql = "SELECT * FROM subjects where grade =? AND ste = ? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "ii", $eight, $ste);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    $sql = "SELECT * FROM student WHERE class_id = ? AND dropped = ? AND transferred =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $old_8_02, $one2, $one2);
    mysqli_stmt_execute($stmt);
    $result_08 = mysqli_stmt_get_result($stmt);
    $counter = 0;
    while ($students = mysqli_fetch_assoc($result_08)) {
      $student_id = $students['student_id'];
      $result44->data_seek(0);
      $myArr = [];
      while ($row88 = mysqli_fetch_assoc($result44)) {
              $sql = "SELECT * FROM stu_grade where student_id =? AND subject_id =?";
              $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $sql);
              mysqli_stmt_bind_param($stmt, "ii", $student_id, $row88['subject_id']);
              mysqli_stmt_execute($stmt);
              $result46 = mysqli_stmt_get_result($stmt);
              if ($result46->num_rows > 0) {
                $row99 = mysqli_fetch_assoc($result46);
                array_push($myArr, $row99['final']);
                if ($row99['final'] < 75) {
                  $counter++;
                }
              }else {
                array_push($myArr, 0);
                $counter++;
              }
      }
      if ($row['ste'] == 1) {
        $sum = array_sum($myArr);
        $countNum = count($myArr);
        $general_average = $sum/$countNum;
        if ($general_average == 85 || $general_average > 85) {
          $zero = 0;
          $update2 = "UPDATE student SET eight=?, repeater = ?, class_id =?, date_promoted =? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "iiisi", $old_8_02,$zero, $section_9_02, $date, $student_id);
          mysqli_stmt_execute($stmt);
          //notification
          $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "promoted";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiss",  $section_9_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
            mysqli_stmt_execute($stmt);
        }else {
          if($counter > 2) {
            $one = 1;
            $update2 = "UPDATE student SET repeater = ? WHERE student_id = ?;";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $update2);
            mysqli_stmt_bind_param($stmt, "ii", $one, $student_id);
            mysqli_stmt_execute($stmt);
          }else {
            $zero = 0;
            $sql5 = "SELECT class_id FROM class where ste = $zero AND grade = $nine;";
            $classN = $conn->query($sql5);
            $classN2 = mysqli_fetch_assoc($classN);
            $ste_to_normal = $classN2['class_id'];
            $update2 = "UPDATE student SET eight=?, repeater = ?, class_id =?, date_promoted =?, previous_ste=? WHERE student_id = ?;";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $update2);
            mysqli_stmt_bind_param($stmt, "iiisii", $old_8_02,$zero, $ste_to_normal, $date, $old_8_02, $student_id);
            mysqli_stmt_execute($stmt);
            //notification
            $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
            $type_notif = "promoted";
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "iiiss",  $section_9_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
              mysqli_stmt_execute($stmt);
          }
        }
      }else {
        if($counter > 2) {
          $one = 1;
          $update2 = "UPDATE student SET repeater = ? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "ii", $one, $student_id);
          mysqli_stmt_execute($stmt);
        }else {
          $zero = 0;
          $update2 = "UPDATE student SET eight=?, repeater = ?, class_id =?, date_promoted =? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "iiisi", $old_8_02, $zero, $section_9_02, $date, $student_id);
          mysqli_stmt_execute($stmt);
          //notification
          $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "promoted";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiss",  $section_9_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
            mysqli_stmt_execute($stmt);
        }
      }
      $counter = 0;
    }
  }
  //promote or repeater for grade 7
  for($e=0; $e < $count_old_7; $e++){
    $old_7_02 = $old_7[$e];
    $section_8_02 = $section_8[$e];
    $check_section = "SELECT * FROM class WHERE class_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $check_section);
    mysqli_stmt_bind_param($stmt, "i", $old_7_02);
    mysqli_stmt_execute($stmt);
    $result_check = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result_check);
    //Check if ste
    if ($row['ste'] == 1) {
      $sql = "SELECT * FROM subjects where grade =? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $seven);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    else {
      $ste = 0;
      $sql = "SELECT * FROM subjects where grade =? AND ste = ? ORDER BY subject_id ASC";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "ii", $seven, $ste);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
    }
    $sql = "SELECT * FROM student WHERE class_id = ? AND dropped = ? AND transferred =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $old_7_02, $one2, $one2);
    mysqli_stmt_execute($stmt);
    $result_07 = mysqli_stmt_get_result($stmt);
    $counter = 0;
    while ($students = mysqli_fetch_assoc($result_07)) {
      $student_id = $students['student_id'];
      $result44->data_seek(0);
      $myArr = [];
      while ($row77 = mysqli_fetch_assoc($result44)) {
              $sql = "SELECT * FROM stu_grade where student_id =? AND subject_id =?";
              $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $sql);
              mysqli_stmt_bind_param($stmt, "ii", $student_id, $row77['subject_id']);
              mysqli_stmt_execute($stmt);
              $result46 = mysqli_stmt_get_result($stmt);
              if ($result46->num_rows > 0) {
                $row99 = mysqli_fetch_assoc($result46);
                array_push($myArr, $row99['final']);
                if ($row99['final'] < 75) {
                  $counter++;
                }
              }else {
                array_push($myArr, 0);
                $counter++;
              }
      }

      if ($row['ste'] == 1) {
        $sum = array_sum($myArr);
        $countNum = count($myArr);
        $general_average = $sum/$countNum;
        if ($general_average == 85 || $general_average > 85) {
          $zero = 0;
          $update2 = "UPDATE student SET seven=?, repeater = ?, class_id =?, date_promoted =? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "iiisi", $old_7_02, $zero, $section_8_02, $date, $student_id);
          mysqli_stmt_execute($stmt);
          //notification
          $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "promoted";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiss",  $section_8_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
            mysqli_stmt_execute($stmt);
        }else {
          if($counter > 2) {
            $one = 1;
            $update2 = "UPDATE student SET repeater = ? WHERE student_id = ?;";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $update2);
            mysqli_stmt_bind_param($stmt, "ii", $one, $student_id);
            mysqli_stmt_execute($stmt);
          }else {
            $zero = 0;
            $sql5 = "SELECT class_id FROM class where ste = $zero AND grade = $eight;";
            $classN = $conn->query($sql5);
            $classN2 = mysqli_fetch_assoc($classN);
            $ste_to_normal = $classN2['class_id'];
            $update2 = "UPDATE student SET seven=?, repeater = ?, class_id =?, date_promoted =?, previous_ste=? WHERE student_id = ?;";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $update2);
            mysqli_stmt_bind_param($stmt, "iiisii", $old_7_02, $zero, $ste_to_normal, $date, $old_7_02, $student_id);
            mysqli_stmt_execute($stmt);
            //notification
            $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
            $type_notif = "promoted";
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "iiiss",  $section_8_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
              mysqli_stmt_execute($stmt);
          }
        }
      }else {
        if($counter > 2) {
          $one = 1;
          $update2 = "UPDATE student SET repeater = ? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "ii", $one, $student_id);
          mysqli_stmt_execute($stmt);
        }else {
          $zero = 0;
          $update2 = "UPDATE student SET seven=?, repeater = ?, class_id =?, date_promoted =? WHERE student_id = ?;";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $update2);
          mysqli_stmt_bind_param($stmt, "iiisi", $old_7_02, $zero, $section_8_02, $date, $student_id);
          mysqli_stmt_execute($stmt);
          //notification
          $notification = "INSERT INTO student_notification (class_id, student_id, admin_id, date_given, type) VALUES (?, ?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          //Preparing the prepared statement
          $type_notif = "promoted";
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iiiss",  $section_8_02, $student_id, $_SESSION['admin_session_id'], $date, $type_notif);
            mysqli_stmt_execute($stmt);
        }
      }
      $counter = 0;

    }
  }
//deleting
  $ass = "SELECT * FROM teacher_assignments";
  $query_ass = $conn->query($ass);
  while ($ass_row = mysqli_fetch_assoc($query_ass)) {
    $filepath = $ass_row['ass_loc'];
    $ass_id = $ass_row['teacher_assignment_id'];
    @unlink($filepath);
    $ass_answer = "SELECT * FROM student_assignment";
    $ans_ass = $conn->query($ass_answer);
    while ($ass_row2 = mysqli_fetch_assoc($ans_ass)) {
      $filepath2 = $ass_row2['submission_file'];
      $ans_id = $ass_row2['student_assignment_id'];
      @unlink($filepath2);
    }
  }
  $ass4 = "SELECT * FROM files";
  $query_ass4 = $conn->query($ass4);
  while ($ass_row4 = mysqli_fetch_assoc($query_ass4)) {
    $filepath4 = $ass_row4['file_loc'];
    @unlink($filepath4);
  }
  $delete_exams = "DELETE FROM exam";
  $query = $conn->query($delete_exams);
  $delete_quiz = "DELETE FROM quiz";
  $query = $conn->query($delete_quiz);
  $delete_ass = "DELETE FROM teacher_assignments";
  $query = $conn->query($delete_ass);
  $delete_ass2 = "DELETE FROM student_assignment";
  $query = $conn->query($delete_ass2);
  $delete_files = "DELETE FROM files";
  $query = $conn->query($delete_files);
  //remove teacher connections
  $zzzero = 0;
  $years = "UPDATE teacher_class SET teacher_id = ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $years);
  mysqli_stmt_bind_param($stmt, "i", $zzzero);
  mysqli_stmt_execute($stmt);
  //DELETE GRADES OF REPEATERS
  $one= 1;
  $delete_grade = "SELECT * FROM student where repeater = ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $delete_grade);
  mysqli_stmt_bind_param($stmt, "i", $one);
  mysqli_stmt_execute($stmt);
  $delete_grade_res = mysqli_stmt_get_result($stmt);
  while ($res1 = mysqli_fetch_assoc($delete_grade_res)) {
    $student_id100 = $res1['student_id'];
    $section_id = $res1['class_id'];
    $delete_grade5 = "SELECT * FROM class where class_id = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $delete_grade5);
    mysqli_stmt_bind_param($stmt, "i", $section_id);
    mysqli_stmt_execute($stmt);
    $section = mysqli_stmt_get_result($stmt);
    while ($section1 = mysqli_fetch_assoc($section)) {
      $grade = $section1['grade'];
      $delete_grade6 = "SELECT * FROM subjects where grade = ?";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $delete_grade6);
      mysqli_stmt_bind_param($stmt, "i", $grade);
      mysqli_stmt_execute($stmt);
      $subject = mysqli_stmt_get_result($stmt);
      while ($subject1 = mysqli_fetch_assoc($subject)) {
        $subject_id100 = $subject1['subject_id'];
        $delete_grade7 = "DELETE FROM stu_grade WHERE student_id = ? AND subject_id = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $delete_grade7);
        mysqli_stmt_bind_param($stmt, "ii", $student_id100, $subject_id100);
        mysqli_stmt_execute($stmt);
      }
    }
  }
  //DELETE GRADES OF DROPPED
  $zero2= 0;
  $delete_grade = "SELECT * FROM student where dropped = ? OR transferred = ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $delete_grade);
  mysqli_stmt_bind_param($stmt, "ii", $zero2, $zero2);
  mysqli_stmt_execute($stmt);
  $delete_grade_res = mysqli_stmt_get_result($stmt);
  while ($res1 = mysqli_fetch_assoc($delete_grade_res)) {
    $student_id100 = $res1['student_id'];
    $section_id = $res1['class_id'];
    $delete_grade5 = "SELECT * FROM class where class_id = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $delete_grade5);
    mysqli_stmt_bind_param($stmt, "i", $section_id);
    mysqli_stmt_execute($stmt);
    $section = mysqli_stmt_get_result($stmt);
    while ($section1 = mysqli_fetch_assoc($section)) {
      $grade = $section1['grade'];
      $delete_grade6 = "SELECT * FROM subjects where grade = ?";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $delete_grade6);
      mysqli_stmt_bind_param($stmt, "i", $grade);
      mysqli_stmt_execute($stmt);
      $subject = mysqli_stmt_get_result($stmt);
      while ($subject1 = mysqli_fetch_assoc($subject)) {
        $subject_id100 = $subject1['subject_id'];
        $delete_grade7 = "DELETE FROM stu_grade WHERE student_id = ? AND subject_id = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $delete_grade7);
        mysqli_stmt_bind_param($stmt, "ii", $student_id100, $subject_id100);
        mysqli_stmt_execute($stmt);
      }
    }
  }
  $_SESSION['success'] = "Promotion Success!!";
  header("location: promote_all.php");
  exit();
}else {
  $_SESSION['error'] = "Your promotion Information are not settled properly!";
  header("location: promote_all.php");
  exit();
}

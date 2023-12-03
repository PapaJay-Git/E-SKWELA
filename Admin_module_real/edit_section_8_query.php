<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
$section_id = $_POST['class_id_8'];
if (isset($_POST['class_id_8']) && isset($_POST['update_section_8']) && isset($_POST['section_name_8']) && isset($_POST['subject_id_8']) && isset($_POST['teacher_id_8'])) {
  $section_code =  strtoupper(ltrim(htmlspecialchars($_POST['section_name_8'])));
  $num = 8;
  $section_name = $section_code." ".$num;
  $subjects = $_POST['subject_id_8'];
  $teachers = $_POST['teacher_id_8'];
  $N = count($subjects);
  $N2 = count($subjects);

  for($e=0; $e < $N2; $e++)
  {
  $subject_id1 = htmlspecialchars($subjects[$e]);
  $teacher_id1 = htmlspecialchars($teachers[$e]);
  //loop to on how man1y classes do the admin want to add this exam. Based on the check boxes selected

    if (!is_numeric($subject_id1)|| !is_numeric($teacher_id1)) {
    $_SESSION['error']= "Error, IDs are not numeric!";
    header("location:edit_section_8.php?section_id=$section_id&error=number");
    exit();
    }
    if (empty($subject_id1) || empty($teacher_id1)) {
    $_SESSION['error']= "You cannot save an empty subject or teacher";
    header("location: edit_section_8.php?section_id=$section_id&error=number");
    exit();
    }
    $sql = "SELECT * FROM class WHERE section_code = ? AND grade = ? AND class_id !=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['error'] = "SQL error";
        echo $conn->error;
        header("location: edit_section_8.php?section_id=$section_id");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "ssi", $section_code, $num, $section_id);
        mysqli_stmt_execute($stmt);
        $result1 = mysqli_stmt_get_result($stmt);
        if ($result1->num_rows > 0) {
          $_SESSION['error']= "It looks like $section_code is already exist in grade 8 section!";
         header("location: edit_section_8.php?section_id=$section_id");
         exit();
        }
  }
  $sql = "UPDATE class SET section_code = ?, class_name = ? WHERE class_id =?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error";
      echo $conn->error;
      header("location: edit_section_8.php?section_id=$section_id");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ssi", $section_code, $section_name, $section_id);
      if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error']= "Cannot update subject section name !";
       header("location: edit_section_8.php?section_id=$section_id");
       exit();
      }
  for($i=0; $i < $N; $i++)
  {
  $subject_id = htmlspecialchars($subjects[$i]);
  $teacher_id = htmlspecialchars($teachers[$i]);
  $sql = "SELECT * FROM teacher_class WHERE class_id = ? AND subject_id =?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error";
      header("location: edit_section_8.php?section_id=$section_id");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ii", $section_id, $subject_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        $my_result = mysqli_fetch_assoc($result);
        $teacher_class_id = $my_result['teacher_class_id'];
        $class_id_44 = $my_result['class_id'];
        $subject_id_44 = $my_result['subject_id'];
        $sql = "UPDATE teacher_class SET teacher_id = ? WHERE class_id = ? AND subject_id =?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['error'] = "SQL error";
            header("location: edit_section_8.php?section_id=$section_id");
            exit();
          }
            mysqli_stmt_bind_param($stmt, "iii", $teacher_id, $section_id, $subject_id);
            if (!mysqli_stmt_execute($stmt)) {
              $_SESSION['error']= "Cannot update subject $subject_id !";
             header("location: edit_section_8.php?section_id=$section_id");
             exit();
            }

            $notification = "SELECT * FROM teacher_notification where teacher_id =? AND teacher_class_id=? AND subject_id=? AND class_id =?; ";
            $stmt = mysqli_stmt_init($conn);
            //Preparing the prepared statement
              mysqli_stmt_prepare($stmt, $notification);
              mysqli_stmt_bind_param($stmt, "iiii", $teacher_id, $teacher_class_id, $subject_id_44, $class_id_44);
              mysqli_stmt_execute($stmt);
              $notif = mysqli_stmt_get_result($stmt);
              if ($notif->num_rows < 1) {
                $type_notif = "assigned";
                $notification = "INSERT INTO teacher_notification (teacher_id, teacher_class_id, date_given, class_id, subject_id, type, admin_id) VALUES (?, ?, ?, ?, ?, ?,?)";
                $stmt = mysqli_stmt_init($conn);
                  mysqli_stmt_prepare($stmt, $notification);
                  mysqli_stmt_bind_param($stmt, "iisiisi", $teacher_id, $teacher_class_id, $date, $class_id_44, $subject_id_44, $type_notif, $_SESSION['admin_session_id']);
                  mysqli_stmt_execute($stmt);
              }
    } else {
      $sql = "INSERT INTO teacher_class (teacher_id, class_id, subject_id) VALUES (?,?,?);";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
          $_SESSION['error'] = "SQL error";
          header("location: edit_section_8.php?section_id=$section_id");
          exit();
        }
          mysqli_stmt_bind_param($stmt, "iii", $teacher_id, $section_id, $subject_id);
          if (!mysqli_stmt_execute($stmt)) {
            $_SESSION['error']= "Cannot insert subject $subject_id !";
           header("location: edit_section_8.php?section_id=$section_id");
           exit();
         }
          $newid =  $conn->insert_id;
          $type_notif = "assigned";
          $notification = "INSERT INTO teacher_notification (teacher_id, teacher_class_id, date_given, class_id, subject_id, type, admin_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $notification);
            mysqli_stmt_bind_param($stmt, "iisiisi", $teacher_id, $newid, $date, $section_id, $subject_id, $type_notif, $_SESSION['admin_session_id']);
            mysqli_stmt_execute($stmt);
    }
  }
  $_SESSION['success']= "Updated successfully!";
 header("location: edit_section_8.php?section_id=$section_id");
 exit();
}
else {
  $_SESSION['error']= "Submission not settled properly!";
 header("location: edit_section_8.php?section_id=$section_id&notset");
 exit();
}

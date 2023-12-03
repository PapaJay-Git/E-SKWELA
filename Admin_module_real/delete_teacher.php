<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
if (isset($_POST['delete_teachers'])) {
  $id = $_POST['delete_teachers'];
  $f = count($id);
  $N = count($id);
  for($e=0; $e < $f; $e++)
  {
  $teacher_id = $id[$e];

  if (!is_numeric($teacher_id) || empty($teacher_id)) {
    $_SESSION['error']= "Error, your ID is either not a number or empty!";
    header("location: teachers.php?error=number");
    exit();
  }
  $sql_grade = "SELECT * FROM teachers WHERE teacher_id =?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error delete teacher";
    echo $conn->error;
    header("location: teachers.php?success=sqlerror");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "i", $teacher_id);
       if(!mysqli_stmt_execute($stmt)){
         $_SESSION['error']= "Execution ERROR!";
         echo $conn->error;
         header("location: teachers.php?&success=error");
         exit();
       }
        $result = mysqli_stmt_get_result($stmt);
          if ($result->num_rows == 0) {
            //show the info
            $_SESSION['error']= "It looks like you are deleting an invalid teacher! $teacher_id";
            header("location: teachers.php?&success=error");
            exit();
          }
          //Check if already available in sections
          $sql_grade = "SELECT * FROM teacher_class WHERE teacher_id =?;";
          $stmt = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $teacher_id) || !mysqli_stmt_execute($stmt)) {
            $_SESSION['error']= "Error deleting teacher";
            header("location: teachers.php?success=sqlerror");
            exit();
          }$result = mysqli_stmt_get_result($stmt);
            if ($result->num_rows > 0) {
              $_SESSION['error']= "It looks like teacher ID $teacher_id already have been assigned on sections. We recommend just removing em from those sections and try again or just set em as an inactive teacher! ";
              header("location: teachers.php?&success=error");
              exit();
            }
            //check if already availble in teacher grades
            $sql_grade = "SELECT * FROM stu_grade WHERE teacher_id =?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $teacher_id) || !mysqli_stmt_execute($stmt)) {
              $_SESSION['error']= "Error deleting teacher";
              header("location: teachers.php?success=sqlerror");
              exit();
            }$result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                $_SESSION['error']= "It looks like teacher ID $teacher_id already have a data from student grades. We recommend just setting him or her as an inactive teacher! ";
                header("location: teachers.php?&success=error");
                exit();
              }
              //check if already availble in teacher exams
              $sql_grade = "SELECT * FROM exam WHERE teacher_id =?;";
              $stmt = mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $teacher_id) || !mysqli_stmt_execute($stmt)) {
                $_SESSION['error']= "Error deleting teacher";
                header("location: teachers.php?success=sqlerror");
                exit();
              }$result = mysqli_stmt_get_result($stmt);
                if ($result->num_rows > 0) {
                  $_SESSION['error']= "It looks like teacher ID $teacher_id already have a data from teacher exams. We recommend just setting him or her as an inactive teacher! ";
                  header("location: teachers.php?&success=error");
                  exit();
                }
                //check if already availble in teacher assignments
                $sql_grade = "SELECT * FROM teacher_assignments WHERE teacher_id =?;";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $teacher_id) || !mysqli_stmt_execute($stmt)) {
                  $_SESSION['error']= "Error deleting teacher";
                  header("location: teachers.php?success=sqlerror");
                  exit();
                }$result = mysqli_stmt_get_result($stmt);
                  if ($result->num_rows > 0) {
                    $_SESSION['error']= "It looks like teacher ID $teacher_id already have a data from teacher assignments. We recommend just setting him or her as an inactive teacher! ";
                    header("location: teachers.php?&success=error");
                    exit();
                  }
                  //check if already availble in teacher quiz
                  $sql_grade = "SELECT * FROM quiz WHERE teacher_id =?;";
                  $stmt = mysqli_stmt_init($conn);
                  if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $teacher_id) || !mysqli_stmt_execute($stmt)) {
                    $_SESSION['error']= "Error deleting teacher";
                    header("location: teachers.php?success=sqlerror");
                    exit();
                  }$result = mysqli_stmt_get_result($stmt);
                    if ($result->num_rows > 0) {
                      $_SESSION['error']= "It looks like teacher ID $teacher_id already have a data from teacher quizzes. We recommend just setting him or her as an inactive teacher! ";
                      header("location: teachers.php?&success=error");
                      exit();
                    }
                    //check if already availble in teacher modules
                    $sql_grade = "SELECT * FROM files WHERE teacher_id =?;";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $teacher_id) || !mysqli_stmt_execute($stmt)) {
                      $_SESSION['error']= "Error deleting teacher";
                      header("location: teachers.php?success=sqlerror");
                      exit();
                    }$result = mysqli_stmt_get_result($stmt);
                      if ($result->num_rows > 0) {
                        $_SESSION['error']= "It looks like teacher ID $teacher_id have already uploaded modules for the students. We recommend just setting him or her as an inactive teacher! ";
                        header("location: teachers.php?&success=error");
                        exit();
                      }
  }
  for($i=0; $i < $N; $i++)
  {
    $teacher_id2 = $id[$i];

      //checking if there was a profile picture
       $sql_grade = "SELECT * FROM teachers WHERE teacher_id =?;";
       $stmt = mysqli_stmt_init($conn);
       //Preparing the prepared statement
       if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
         $_SESSION['error']= "Error deleting teacher";
         header("location: teachers.php?&success=error");
         exit();
       }
         //run sql
         mysqli_stmt_bind_param($stmt, "i", $teacher_id2);
            if(!mysqli_stmt_execute($stmt)){
              $_SESSION['error']= "Execution ERROR deleting teacher $teacher_id2!";
              echo $conn->error;
              header("location: teachers.php?&success=error");
              exit();
            }
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if ($row['profile'] == NULL || $row['profile'] == 0 || $row['profile'] == "") {
              //
            }else {
              //deleting profile picture
              $profilepath = $row['profile'];
              if (file_exists($profilepath)) {
                    unlink($profilepath);
              }
            }
   $sql_grade = "DELETE FROM teachers WHERE teacher_id =?;";
   $stmt = mysqli_stmt_init($conn);
   //Preparing the prepared statement
   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
     $_SESSION['error']= "Error deleting teacher";
     header("location: teachers.php?&success=error");
     exit();
   }
     //run sql
     mysqli_stmt_bind_param($stmt, "i", $teacher_id2);
        if(!mysqli_stmt_execute($stmt)){
          $_SESSION['error']= "Execution ERROR deleting teacher $teacher_id2!";
          echo $conn->error;
          header("location: teachers.php?&success=error");
          exit();
        }

  }
    $_SESSION['success']= "teachers deleted successfully!";
    header("location:teachers.php?success=true");
    exit();
}else {
  $_SESSION['error']= "Please check the checbox of the teacher account you want to delete.";
  header("location: teachers.php?notset");
  exit();
}

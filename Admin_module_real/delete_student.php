<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
if (isset($_POST['delete_students'])) {
  $id = $_POST['delete_students'];
  $f= count($id);
  $N = count($id);
  for($e=0; $e < $f; $e++)
  {
  $student_id = $id[$e];

  if (!is_numeric($student_id) || empty($student_id)) {
    $_SESSION['error']= "Error, your ID is either not a number or empty!";
    header("location: students.php?error=number");
    exit();
  }
  $sql_grade = "SELECT * FROM student WHERE student_id =?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error delete student";
    echo $conn->error;
    header("location: students.php?success=sqlerror");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "i", $student_id);
       if(!mysqli_stmt_execute($stmt)){
         $_SESSION['error']= "Execution ERROR!";
         echo $conn->error;
         header("location: students.php?&success=error");
         exit();
       }
        $result = mysqli_stmt_get_result($stmt);
          if ($result->num_rows == 0) {
            //show the info
            $_SESSION['error']= "It looks like you are deleting an invalid student! $student_id";
            header("location: students.php?&success=error");
            exit();
          }
          //Check if already available in grades
          $sql_grade = "SELECT * FROM stu_grade WHERE student_id =?;";
          $stmt = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $student_id) || !mysqli_stmt_execute($stmt)) {
            $_SESSION['error']= "Error deleting student!";
            header("location: students.php?success=sqlerror");
            exit();
          }$result = mysqli_stmt_get_result($stmt);
            if ($result->num_rows > 0) {
              $_SESSION['error']= "It looks like student ID $student_id already have a data from grades, this student cannot be deleted. We recommend just making him or her as an inactive student! ";
              header("location: students.php?&success=error");
              exit();
            }
            //Check if already available in quizzes
            $sql_grade = "SELECT * FROM student_quiz WHERE student_id =?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $student_id) || !mysqli_stmt_execute($stmt)) {
              $_SESSION['error']= "Error deleting student!";
              header("location: students.php?success=sqlerror");
              exit();
            }$result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                $_SESSION['error']= "It looks like student ID $student_id already have a data from quizzes, this student cannot be deleted. We recommend just making him or her as an inactive student! ";
                header("location: students.php?&success=error");
                exit();
              }
              //Check if already available in assignments
              $sql_grade = "SELECT * FROM student_assignment WHERE student_id =?;";
              $stmt = mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $student_id) || !mysqli_stmt_execute($stmt)) {
                $_SESSION['error']= "Error deleting student!";
                header("location: students.php?success=sqlerror");
                exit();
              }$result = mysqli_stmt_get_result($stmt);
                if ($result->num_rows > 0) {
                  $_SESSION['error']= "It looks like student ID $student_id already have a data from assignments, this student cannot be deleted. We recommend just making him or her as an inactive student! ";
                  header("location: students.php?&success=error");
                  exit();
                }
                //Check if already available in exams
                $sql_grade = "SELECT * FROM student_exam WHERE student_id =?;";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql_grade) || !mysqli_stmt_bind_param($stmt, "i", $student_id) || !mysqli_stmt_execute($stmt)) {
                  $_SESSION['error']= "Error deleting student!";
                  header("location: students.php?success=sqlerror");
                  exit();
                }$result = mysqli_stmt_get_result($stmt);
                  if ($result->num_rows > 0) {
                    $_SESSION['error']= "It looks like student ID $student_id already have a data from exams, this student cannot be deleted. We recommend just making him or her as an inactive student! ";
                    header("location: students.php?&success=error");
                    exit();
                  }
  }
  $count = 0;
  for($i=0; $i < $N; $i++)
  {
    $count++;
    $student_id2 = $id[$i];

       $sql_grade = "SELECT * FROM student WHERE student_id =?;";
       $stmt = mysqli_stmt_init($conn);
       //Preparing the prepared statement
       if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
         $_SESSION['error']= "Error deleting student";
         header("location: students.php?&success=error");
         exit();
       }
         //run sql
         mysqli_stmt_bind_param($stmt, "i", $student_id2);
            if(!mysqli_stmt_execute($stmt)){
              $_SESSION['error']= "Execution ERROR deleting student $student_id2!";
              echo $conn->error;
              header("location: students.php?&success=error");
              exit();
            }
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if ($row['profile'] == NULL || $row['profile'] == 0 || $row['profile'] == "") {
              echo "nothing";
            }else {
              //deleting profile picture
              $profilepath = $row['profile'];
              if (file_exists($profilepath)) {
                    unlink($profilepath);
              }
            }
   $sql_grade = "DELETE FROM student WHERE student_id =?;";
   $stmt = mysqli_stmt_init($conn);
   //Preparing the prepared statement
   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
     $_SESSION['error']= "Error deleting student";
     header("location: students.php?&success=error");
     exit();
   }
     //run sql
     mysqli_stmt_bind_param($stmt, "i", $student_id2);
        if(!mysqli_stmt_execute($stmt)){
          $_SESSION['error']= "Execution ERROR deleting student $student_id2!";
          echo $conn->error;
          header("location: students.php?&success=error");
          exit();
        }

  }
    $_SESSION['success']= "$count students deleted successfully!";
    header("location:students.php?success=true");
    exit();
}else {
  $_SESSION['error']= "Please check the checbox of the student account you want to delete.";
  header("location: students.php?notset");
  exit();
}

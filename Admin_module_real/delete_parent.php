<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
if (isset($_POST['delete_parents'])) {
  $id = $_POST['delete_parents'];
  $f= count($id);
  $N = count($id);
  for($e=0; $e < $f; $e++)
  {
  $parent_id = $id[$e];

  if (!is_numeric($parent_id) || empty($parent_id)) {
    $_SESSION['error']= "Error, your ID is either not a number or empty!";
    header("location: parents.php?error=number");
    exit();
  }
  $sql_grade = "SELECT * FROM parents WHERE parent_id =?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error delete parent";
    echo $conn->error;
    header("location: parents.php?success=sqlerror");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "i", $parent_id);
       if(!mysqli_stmt_execute($stmt)){
         $_SESSION['error']= "Execution ERROR!";
         echo $conn->error;
         header("location: parents.php?&success=error");
         exit();
       }
        $result = mysqli_stmt_get_result($stmt);
          if ($result->num_rows == 0) {
            //show the info
            $_SESSION['error']= "It looks like you are deleting an invalid parent! $parent_id";
            header("location: parents.php?&success=error");
            exit();
          }
  }
  for($i=0; $i < $N; $i++)
  {
    $parent_id2 = $id[$i];

       $sql_grade = "SELECT * FROM parents WHERE parent_id =?;";
       $stmt = mysqli_stmt_init($conn);
       //Preparing the prepared statement
       if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
         $_SESSION['error']= "Error deleting parent";
         header("location: parents.php?&success=error");
         exit();
       }
         //run sql
         mysqli_stmt_bind_param($stmt, "i", $parent_id2);
            if(!mysqli_stmt_execute($stmt)){
              $_SESSION['error']= "Execution ERROR deleting parent $parent_id2!";
              echo $conn->error;
              header("location: parents.php?&success=error");
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
   $sql_grade = "DELETE FROM parents WHERE parent_id =?;";
   $stmt = mysqli_stmt_init($conn);
   //Preparing the prepared statement
   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
     $_SESSION['error']= "Error deleting parent";
     header("location: parents.php?&success=error");
     exit();
   }
     //run sql
     mysqli_stmt_bind_param($stmt, "i", $parent_id2);
        if(!mysqli_stmt_execute($stmt)){
          $_SESSION['error']= "Execution ERROR deleting parent $parent_id2!";
          echo $conn->error;
          header("location: parents.php?&success=error");
          exit();
        }

  }
    $_SESSION['success']= "Parents deleted successfully!";
    header("location:parents.php?success=true");
    exit();
}else {
  $_SESSION['error']= "Please check the checbox of the parent account you want to delete.";
  header("location: parents.php?notset");
  exit();
}

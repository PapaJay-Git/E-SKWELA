<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';

if (isset($_POST['delete_admins'])) {
  $id = $_POST['delete_admins'];
  $f= count($id);
  $N = count($id);
  for($e=0; $e < $f; $e++)
  {
  $admin_id = $id[$e];

  if ($admin_id == $_SESSION['admin_session_id']) {
    $_SESSION['error']= "You cannot delete the currently logged ADMIN account!";
    header("location: admins.php?error=number");
    exit();
  }
  if (!is_numeric($admin_id) || empty($admin_id)) {
    $_SESSION['error']= "Error, your ID is either not a number or empty!";
    header("location: admins.php?error=number");
    exit();
  }
  $sql_grade = "SELECT * FROM admin WHERE admin_id =?;";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
    $_SESSION['error']= "Error delete admin";
    echo $conn->error;
    //header("location: admins.php?success=sqlerror");
    exit();
  }
    //run sql
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
       if(!mysqli_stmt_execute($stmt)){
         $_SESSION['error']= "Execution ERROR!";
         echo $conn->error;
         header("location: admins.php?&success=error");
         exit();
       }
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
          if ($result->num_rows == 0) {
            //show the info
            $_SESSION['error']= "It looks like you are deleting an invalid admin! $admin_id";
            header("location: admins.php?&success=error");
            exit();
          }
          if ($row['last_log_in'] != NULL || $row['last_log_in'] != 0 || $row['last_log_in'] != "" ) {
            $_SESSION['error']= "It looks like you are deleting an admin account that have already made changes on this system! ".
            "We cannot allow this account to be deleted, we recommend just changing this accounts information or setting it as an inactive account. Account ID - $admin_id";
            header("location: admins.php?&success=error");
            exit();
          }
  }
  for($i=0; $i < $N; $i++)
  {
    $admin_id2 = $id[$i];
    if ($admin_id2 == $_SESSION['admin_session_id']) {
      $_SESSION['error']= "You cannot delete the currently logged in ADMIN account!";
      header("location: admins.php?error=number");
      exit();
    }
       $sql_grade = "SELECT * FROM admin WHERE admin_id =?;";
       $stmt = mysqli_stmt_init($conn);
       //Preparing the prepared statement
       if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
         $_SESSION['error']= "Error deleting admin";
         header("location: admins.php?&success=error");
         exit();
       }
         //run sql
         mysqli_stmt_bind_param($stmt, "i", $admin_id2);
            if(!mysqli_stmt_execute($stmt)){
              $_SESSION['error']= "Execution ERROR deleting admin $admin_id2!";
              echo $conn->error;
              header("location: admins.php?&success=error");
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
   $sql_grade = "DELETE FROM admin WHERE admin_id =?;";
   $stmt = mysqli_stmt_init($conn);
   //Preparing the prepared statement
   if(!mysqli_stmt_prepare($stmt, $sql_grade)) {
     $_SESSION['error']= "Error deleting admin";
     header("location: admins.php?&success=error");
     exit();
   }
     //run sql
     mysqli_stmt_bind_param($stmt, "i", $admin_id2);
        if(!mysqli_stmt_execute($stmt)){
          $_SESSION['error']= "Execution ERROR deleting admin $admin_id2!";
          echo $conn->error;
          header("location: admins.php?&success=error");
          exit();
        }

  }
    $_SESSION['success']= "Admin deleted successfully!";
    header("location:admins.php?success=true");
    exit();
}else {
  $_SESSION['error']= "Please check the checbox of the admin account you want to delete.";
  header("location: admins.php?notset");
  exit();
}

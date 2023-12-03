<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
require_once "checker.php";
//Check the teacher and teacher class id or tc_id if available and valid to show specific subject and section
//for checking if tc_id has and session_id or teacher_class_id is valid
          	if (!isset($_GET['class_id']) || !is_numeric($_GET['class_id'])){
          			$_SESSION['error'] = "Web ID is empty";
          			header("location: advisory.php");
          			exit();
          		}else{
                $sql = "SELECT * FROM advisory WHERE teacher_id=? AND class_id=?;";
          			$stmt = mysqli_stmt_init($conn);
          			$id = $_GET['class_id'];
          		    if(!mysqli_stmt_prepare($stmt, $sql)) {
          							$_SESSION['error'] = "SQL error";
          				      header("location: advisory.php");
                        exit();
          			  } else {
              				mysqli_stmt_bind_param($stmt, "ii", $_SESSION['teacher_session_id'], $id);
          				    mysqli_stmt_execute($stmt);
                      $result = mysqli_stmt_get_result($stmt);
                        if ($result->num_rows > 0) {
                          //show the info as $row
          								//this can be use by another file if imported
                          $row = mysqli_fetch_assoc($result);
                          //error in url id is missing go back to homepage
                        } else if($result->num_rows == 0){
          								$_SESSION['error'] = "Your web ID has no match";
                          header("location: advisory.php");
          								exit();
          			        }
                      }
          		     }



 ?>

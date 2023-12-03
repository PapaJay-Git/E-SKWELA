<?php
require_once "checker.php";
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
$tcid = $_GET['tc_id'];
	if (!isset($_GET['ass_id']) || !is_numeric($_GET['ass_id'])){
        $_SESSION['error'] = "Web ID is empty.";
		header("location: teacher_view_assignments.php?tc_id=$tcid&exam_id=notset");
		  exit();
    //echo "not set";
		}else{
			//checking if the parameters are valid
      $sql = "SELECT * FROM teacher_assignments WHERE teacher_assignment_id=? AND teacher_id=? AND teacher_class_id=?;";
			$stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
              $_SESSION['error'] = "SQL error, please contact tech support.";
				      header("location: teacher_view_assignments.php?tc_id=$tcid&sql=error");
              exit();
			  } else {
          $assid = $_GET['ass_id'];
    				mysqli_stmt_bind_param($stmt, "iii", $assid, $_SESSION['teacher_session_id'], $tcid);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                //show the info
               $assrow = mysqli_fetch_assoc($result);
               $filepath = $assrow['ass_loc'];
              //  echo "works";
                //error in url id is missing go back to homepage
              } else if($result->num_rows == 0){
                $_SESSION['error'] = "Access DENIED! Please do not change the URL!";
                header("location: teacher_view_assignments.php?tc_id=$tcid&examid=no_match");
								exit();
                //echo "no equal data";
			        }
            }
		     }
 ?>

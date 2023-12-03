<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};

$tcid = $_GET['tc_id'];
$ass_id = $_GET['ass_id'];
//for checking if tc_id has and session_id or teacher_class_id is valid
	if (!isset($_GET['ass_id']) || !is_numeric($_GET['ass_id'])){
			$_SESSION['error'] = "Assignment ID is empty";
			header("location: assignment_view.php?tc_id=$tcid&assignment_empty");
			exit();
		}else{
      $sql = "SELECT * FROM teacher_assignments WHERE teacher_class_id =? AND class_id =? AND teacher_assignment_id=? AND published =?";
			$stmt = mysqli_stmt_init($conn);
		    if(!mysqli_stmt_prepare($stmt, $sql)) {
							$_SESSION['error'] = "SQL error";
               echo "Error description: " . $stmt -> error;
				      header("location: assignment_view.php?tc_id=$tcid&sql=error");
              exit();
			  } else {
					$published = 1;
    				mysqli_stmt_bind_param($stmt, "iiii", $tcid, $row_includes['class_id'], $ass_id, $published);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                //show the info as $row
								//this can be use by another file if imported
                $assrow = mysqli_fetch_assoc($result);
                $filepath = $assrow['ass_loc'];
                //error in url id is missing go back to homepage
              } else if($result->num_rows == 0){
								$_SESSION['error'] ="It looks like you do not have access on this assignment. Reasons are being deleted, not yet published, or you are tring to access this assignment via invalid URL.";
                header("location: assignment_view.php?tc_id=$tcid&id_url=no_match");
								exit();
			        }
            }
		     }

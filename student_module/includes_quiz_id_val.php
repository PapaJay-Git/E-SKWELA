<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};

$tcid = $_GET['tc_id'];
$quiz_id = $_GET['quiz_id'];
//for checking if tc_id has and session_id or teacher_class_id is valid
	if (!isset($_GET['quiz_id']) || !is_numeric($_GET['quiz_id'])){
			$_SESSION['error'] = "Quiz ID is empty";
			header("location: quiz_view.php?tc_id=$tcid&quiz_empty");
			exit();
		}else{
      $sql = "SELECT * FROM quiz WHERE teacher_class_id =? AND class_id =? AND quiz_id=? AND published =?";
			$stmt = mysqli_stmt_init($conn);
		    if(!mysqli_stmt_prepare($stmt, $sql)) {
							$_SESSION['error'] = "SQL error";
				      header("location: quiz_view.php?tc_id=$tcid&sql=error");
              exit();
			  } else {
					$published = 1;
    				mysqli_stmt_bind_param($stmt, "iiii", $tcid, $row_includes['class_id'], $quiz_id, $published);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                //show the info as $row
								//this can be use by another file if imported
                $quizrow = mysqli_fetch_assoc($result);
                //error in url id is missing go back to homepage
              } else if($result->num_rows == 0){
								$_SESSION['error'] = "It looks like you do not have access on this on quiz. Reasons are being deleted, not yet published, or you are tring to access this quiz via invalid URL.";
                header("location: quiz_view.php?tc_id=$tcid&id_url=no_match");
								exit();
			        }
            }
		     }

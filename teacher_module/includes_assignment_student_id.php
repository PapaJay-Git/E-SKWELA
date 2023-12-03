<?php
require_once "checker.php";
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
$id = $_GET['tc_id'];
$ass = $_GET['ass_id'];
	if (!isset($_GET['student_id']) || !is_numeric($_GET['student_id'])){
        $_SESSION['error'] = "Web ID is not valid. Please do not change the URL.";
				header("location: assignment_submissions.php?tc_id=$id&ass_id=$ass&notset");
		  	exit();
    //echo "not set";
		}else{
			//checking if the parameters are valid
      $sqls = "SELECT * FROM student_assignment WHERE teacher_assignment_id=? AND teacher_id=? AND student_id =?;";
			$stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sqls)) {
              $_SESSION['error'] = "SQL error, please contact tech support.";
				      header("location: assignment_submissions.php?tc_id=$id&ass_id=$ass&sql=error");
              exit();
			  } else {
          $student_id = $_GET['student_id'];
    				mysqli_stmt_bind_param($stmt, "iii", $assid, $_SESSION['teacher_session_id'], $student_id);
				    mysqli_stmt_execute($stmt);
            $result_stu = mysqli_stmt_get_result($stmt);
              if ($result_stu->num_rows > 0) {
                //show the info
               $student_sub = mysqli_fetch_assoc($result_stu);
							 $filepath45 = $student_sub['submission_file'];
                //error in url id is missing go back to homepage
              } else if($result_stu->num_rows == 0){
                $_SESSION['error'] = "Access on student submissions, Denied!";
                header("location: assignment_submissions.php?tc_id=$id&ass_id=$ass&assid=no_match");
								exit();
                //echo "no equal data";
			        }
            }
		     }
 ?>

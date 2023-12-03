<?php
require_once "checker.php";
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
$id = $_GET['tc_id'];
$quiz = $_GET['quiz_id'];
	if (!isset($_GET['student_id']) || !is_numeric($_GET['student_id'])){
        $_SESSION['error'] = "Web ID is not valid. Do not change the URL.";
		header("location: quiz_submissions.php?tc_id=$id&quiz_id=$quiz&notset");
		  exit();
    //echo "not set";
		}else{
			//checking if the parameters are valid
      $sqls = "SELECT * FROM student_quiz WHERE quiz_id=? AND teacher_id=? AND student_id =?;";
			$stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sqls)) {
              $_SESSION['error'] = "SQL error, please contact tech support.";
				      header("location: quiz_submissions.php?tc_id=$id&quiz_id=$quiz&sql=error");
              exit();
			  } else {
          $student_id = $_GET['student_id'];
    				mysqli_stmt_bind_param($stmt, "iii", $quizid, $_SESSION['teacher_session_id'], $student_id);
				    mysqli_stmt_execute($stmt);
            $result_stu = mysqli_stmt_get_result($stmt);
              if ($result_stu->num_rows > 0) {
                //show the info
               $student_sub = mysqli_fetch_assoc($result_stu);
                //error in url id is missing go back to homepage
              } else if($result_stu->num_rows == 0){
                $_SESSION['error'] = "Access on student submissions, Denied!";
                header("location: quiz_submissions.php?tc_id=$id&quiz_id=$quiz&quizid=no_match");
								exit();
                //echo "no equal data";
			        }
            }
		     }
 ?>

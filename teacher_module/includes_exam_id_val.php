<?php
require_once "checker.php";
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
$id = $_GET['tc_id'];
	if (!isset($_GET['exam_id']) || !is_numeric($_GET['exam_id'])){
        $_SESSION['error'] = "Web ID is empty.";
		header("location: teacher_view_exam.php?tc_id=$id&exam_id=notset");
		  exit();
    //echo "not set";
		}else{
			//checking if the parameters are valid
      $sql = "SELECT * FROM exam WHERE exam_id=? AND teacher_id=? AND teacher_class_id =?;";
			$stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
              $_SESSION['error'] = "SQL error, please contact tech support.";
				      header("location: teacher_view_exam.php?tc_id=$id&sql=error");
              exit();
			  } else {
            $examid = $_GET['exam_id'];
    				mysqli_stmt_bind_param($stmt, "iii", $examid, $_SESSION['teacher_session_id'], $id);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                //show the info
               $examrow = mysqli_fetch_assoc($result);
                //echo "works";
                //error in url id is missing go back to homepage
              } else if($result->num_rows == 0){
                $_SESSION['error'] = "Access DENIED! Please do not change the URL!";
                header("location: teacher_view_exam.php?tc_id=$id&examid=no_match");
								exit();
                //echo "no equal data";
			        }
            }
		     }
 ?>

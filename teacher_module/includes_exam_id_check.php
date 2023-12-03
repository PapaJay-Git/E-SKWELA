<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
	if (!isset($_GET['tc_id']) || !is_numeric($_GET['tc_id'])){
		  $_SESSION['error'] = "Web ID is empty.";
		header("location: teacher_exam.php?tc_id=notset");
      exit();
    //echo "not set";
		}else{
			//checking if the parameters are valid
      $sql = "SELECT * FROM teacher_class WHERE teacher_class_id=? AND teacher_id=?;";
			$stmt = mysqli_stmt_init($conn);
			$id = $_GET['tc_id'];
		    if(!mysqli_stmt_prepare($stmt, $sql)) {
					  $_SESSION['error'] = "SQL error, please contact tech support.";
				      header("location: teacher_exam.php?sql=error");
              exit();
			  } else {
    				mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['teacher_session_id']);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                //show the info
                $row = mysqli_fetch_assoc($result);
                //echo "works";
                //error in url id is missing go back to homepage
              } else if($result->num_rows == 0){
								$_SESSION['error'] = "Access on Exams, Denied!";
                header("location: teacher_exam.php?id_url=no_match");
                exit();
                //echo "no equal data";
			        }
            }
		     }
 ?>

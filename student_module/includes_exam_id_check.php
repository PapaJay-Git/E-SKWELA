<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
$sql = "SELECT * FROM student where student_id =?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    $_SESSION['error'] = "SQL error, viewing profile.";
    header("location: index.php?view=failed");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['student_session_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows > 0) {
      // output data of each row
      $row_includes = mysqli_fetch_assoc($result);

  } else {
      header("location: ../login/index.php?view=failed");
      exit();

  }
}
//for checking if tc_id has and session_id or teacher_class_id is valid
	if (!isset($_GET['tc_id']) || !is_numeric($_GET['tc_id'])){
			$_SESSION['error'] = "Web ID is empty";
			header("location: exam.php?tc_id=empty");
			exit();
		}else{
      $sql = "SELECT * FROM teacher_class WHERE teacher_class_id=? AND class_id =?";
			$stmt = mysqli_stmt_init($conn);
			$id = $_GET['tc_id'];
		    if(!mysqli_stmt_prepare($stmt, $sql)) {
							$_SESSION['error'] = "SQL error";
				      header("location: exam.php?sql=error");
              exit();
			  } else {
    				mysqli_stmt_bind_param($stmt, "ii", $id, $row_includes['class_id']);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                //show the info as $row
								//this can be use by another file if imported
                $row = mysqli_fetch_assoc($result);
                //error in url id is missing go back to homepage
              } else if($result->num_rows == 0){
								$_SESSION['error'] = "Your web ID has no match";
                header("location: exam.php?id_url=no_match");
								exit();
			        }
            }
		     }
 ?>

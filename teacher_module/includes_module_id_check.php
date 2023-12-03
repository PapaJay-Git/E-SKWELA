<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
//for checking if tc_id has and session_id or teacher_class_id is valid
	if (!isset($_GET['tc_id']) || !is_numeric($_GET['tc_id'])){
			$_SESSION['error'] = "Web ID is empty";
			header("location: teacher_modules.php?tc_id=empty");
			exit();
		}else{
      $sql = "SELECT * FROM teacher_class WHERE teacher_class_id=? AND teacher_id=?;";
			$stmt = mysqli_stmt_init($conn);
			$id = $_GET['tc_id'];
		    if(!mysqli_stmt_prepare($stmt, $sql)) {
							$_SESSION['error'] = "SQL error";
				      header("location: teacher_modules.php?sql=error");
              exit();
			  } else {
    				mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['teacher_session_id']);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                //show the info as $row
								//this can be use by another file if imported
                $row = mysqli_fetch_assoc($result);
                //error in url id is missing go back to homepage
              } else if($result->num_rows == 0){
								$_SESSION['error'] = "Your web ID has no match";
                header("location: teacher_modules.php?id_url=no_match");
								exit();
			        }
            }
		     }
 ?>

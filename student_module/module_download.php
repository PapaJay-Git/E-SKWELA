<?php
require_once 'checker.php';
require_once 'includes_module_id_check.php';
$tcid = $_GET['tc_id'];
$id = $_GET['file_id'];
	if (!isset($_GET['file_id']) && empty($_GET['file_id'])){
				$_SESSION['error'] = "IDs are empty, please redirect using download button.";
			header("location: view_modules.php?file_id=notset&tc_id=$tcid");
			exit();
		}else{
			//Checking if the file that is being downloaded is being accessed the teacher who really uploadedd it
      $sql = "SELECT * FROM files WHERE file_id=? AND class_id=?;";
			$stmt = mysqli_stmt_init($conn);
		    if(!mysqli_stmt_prepare($stmt, $sql)) {
							$_SESSION['error'] = "SQL error, please contact tech support";
				      header("location: teacher_view_modules.php?sql=error&tc_id=$tcid");
              exit();
			  } else {
    				mysqli_stmt_bind_param($stmt, "ii", $id, $row['class_id']);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
						//If the file that is being deleted is accessed by the current teacher, then we throw an error
						//Saying thdt she doesnt have access on this file to be downloaded
						//if not, we proceed
              if ($result->num_rows > 0) {
                $row_files = mysqli_fetch_assoc($result);
                //will be used by different modules script
                $filepath = $row_files['file_loc'];
                //error in url id is missing go back to homepage
								//or teacher has no access on this file
              } else if($result->num_rows == 0){
								$_SESSION['error'] = "Sorry, you do not have access on this file.";
                header("location: view_modules.php?you_dont_have_access_on_this_file&tc_id=$tcid");
								  exit();
			        }
            }
		     }

								//checking if the actually exist on our path to be deleted
								//If file doesnt exist, then we throw an error
                if (file_exists($filepath)) {
                      header('Content-Description: File Transfer');
                      header('Content-Type: application/octet-stream');
                      header('Content-Disposition: attachment; filename=' . basename($filepath));
                      header('Expires: 0');
                      header('Cache-Control: must-revalidate');
                      header('Pragma: public');
                      header('Content-Length: ' . filesize($filepath));
                      readfile($filepath);

                      // Now update downloads count
                      $newCount = $row_files['downloads'] + 1;
                      $updateQuery = "UPDATE files SET downloads=$newCount WHERE file_id=$id";
                      mysqli_query($conn, $updateQuery);
                      exit;
                }else{
									$_SESSION['error'] = "File is missing";
                  header("location: teacher_view_modules.php?file=missing&tc_id=$tcid");
									  exit();
                }

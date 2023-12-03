<?php
require_once 'checker.php';
require_once 'includes_module_id_check.php';
require_once 'includes_module_id_val.php';
$tcid = $_GET['tc_id'];
								//checking if the actually exist on our path to be deleted
								//If file doesnt exist, then we throw an error
                if (file_exists($filepath)) {
                      if (unlink($filepath)) {
                        $deleteQuery = "DELETE FROM files WHERE file_id=? AND teacher_id=?;";
                  			$stmt = mysqli_stmt_init($conn);
                  			if(!mysqli_stmt_prepare($stmt, $deleteQuery)) {
													  $_SESSION['error'] = "SQL error, please contact tech support.";
                  				header("location: teacher_view_modules.php?delete=failed&tc_id=".$tcid);
													  exit();
                  			} else {
                  				mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['teacher_session_id']);
                          if(mysqli_stmt_execute($stmt)){
                            $deleteQuery = "DELETE FROM student_notification WHERE module_id=? AND teacher_id=?;";
                            $stmt = mysqli_stmt_init($conn);
                              mysqli_stmt_prepare($stmt, $deleteQuery);
                              mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['teacher_session_id']);
                              mysqli_stmt_execute($stmt);
														  $_SESSION['success'] = "File deleted successfully!";
                              header("location: teacher_view_modules.php?delete=success&tc_id=".$tcid);
														  exit();
                          }else{
														  $_SESSION['error'] = "Delete failed!";
                          header("location: teacher_view_modules.php?delete=failed&tc_id=".$tcid);
													  exit();
                          }
                  			}
                  		}else{
												  $_SESSION['error'] = "Error, problem deleting actual file.";
                  			header("location: teacher_view_modules.php?missing=file&tc_id=".$tcid);
												  exit();
                      }

                }else{
									$_SESSION['error'] = "Error, cannot delete a missing file.";
            				header("location: teacher_view_modules.php?file=didnotexist&tc_id=".$tcid);
										  exit();
                }

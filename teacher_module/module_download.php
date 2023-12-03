<?php
require_once 'checker.php';
require_once 'includes_module_id_check.php';
require_once 'includes_module_id_val.php';
$tcid = $_GET['tc_id'];
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

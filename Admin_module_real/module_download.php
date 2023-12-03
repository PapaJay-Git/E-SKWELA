<?php
require_once 'checker.php';
require_once 'includes_profile_id_check.php';
$file_id = $_GET['id'];
	if (!isset($_GET['id']) && empty($_GET['id'])){
				$_SESSION['error'] = "File ID is empty, please redirect using download button.";
			header("location: modules.php");
			exit();
		}else{
      $sql = "SELECT * FROM files WHERE file_id =?;";
			$stmt = mysqli_stmt_init($conn);
		    if(!mysqli_stmt_prepare($stmt, $sql)) {
							$_SESSION['error'] = "You have inputed wrong data";
				      header("location: modules.php");
              exit();
			  } else {
    				mysqli_stmt_bind_param($stmt, "i", $file_id);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                $row_files = mysqli_fetch_assoc($result);
                //will be used by different modules script
                $filepath = $row_files['file_loc'];
                //error in url id is missing go back to homepage
								//or teacher has no access on this file
              } else if($result->num_rows == 0){
								$_SESSION['error'] = "Sorry, this module does not exist anymore.";
                header("location: modules.php");
								  exit();
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
                }else{
									$_SESSION['error'] = "It looks like this file is missing";
                  header("location: modules.php");
									  exit();
                }
}

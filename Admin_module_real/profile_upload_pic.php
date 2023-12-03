
<?php
  require_once 'checker.php';
  require_once 'includes_profile_id_check.php';
  date_default_timezone_set('Asia/Manila');
  // Then call the date functions
  //for minimun date deadline
  $date123 = date('Y-m-d H:i:s');

if(isset($_POST['change_profile'])) {
      $file = $_FILES['file'];

      $fileName = $_FILES['file']['name'];
      $fileTmpName = $_FILES['file']['tmp_name'];
      $fileSize = $_FILES['file']['size'];
      $fileError = $_FILES['file']['error'];
      $fileType = $_FILES['file']['type'];

      if (!exif_imagetype($fileTmpName)) {
        $_SESSION['error'] = "Only jpg, jpeg, png and gif are allowed.";
        header("Location:profile_pic_change.php?file_id=&tc_id=&invalid=filetype");
        exit();
      }

      $fileExt = explode('.', $fileName);
      $fileActualExt = strtolower(end($fileExt));
      $allowed = array('jpg', 'jpeg', 'png', 'gif');
      $hashed = md5($fileName);
      $hashedDate = md5($date123);
      if($fileSize == 0) {
          $_SESSION['error'] = "Cannot upload empty file";
          header("Location: profile_pic_change.php?file_id=&tc_id=&invalid=nofileSelectedorFilenoSize");
          exit();
      }else{
        if (in_array($fileActualExt, $allowed)) {
          if ($fileError === 0) {
            if ($fileSize < 30000000) {
                $fileNameNew = "admin_profile_".$hashed."$hashedDate".".".$fileActualExt;
                $fileDestination =  '../Admin_module/profile_pics/'.$fileNameNew;
                if(file_exists($fileDestination)){
                  $_SESSION['error'] = "This file name already exist";
                  header("Location: profile_pic_change.php?file_id=&tc_id=&already_exist=file");
                  exit();
                }else{
                  if(move_uploaded_file($fileTmpName, $fileDestination)){
                    $add_file = "UPDATE admin SET profile = ? WHERE admin_id =?;";
                    $stmt = mysqli_stmt_init($conn);
                    //Preparing the prepared statement
                    //deleting old file
                    if(!mysqli_stmt_prepare($stmt, $add_file)) {
                      $_SESSION['error'] = "SQL error.";
                      header("Location: profile_pic_change.php?file_id=&tc_id=&update_module=sqlerror");
                      exit();
                    } else {
                      //run sql
                      mysqli_stmt_bind_param($stmt, "si",  $fileDestination, $row['admin_id']);
                      if(mysqli_stmt_execute($stmt)){
                        $resultid = mysqli_stmt_get_result($stmt);
                        unlink($filepath);
                            $conn->close();
                            $_SESSION['success'] = "Porfile picture updated succesfully!";
                            header("Location: profile_pic_change.php?file_id=&tc_id=&update=success");
                            exit();
                      }else{
                            $conn->close();
                            $_SESSION['error'] = "Porfile picture update Failed!";
                            header("Location: profile_pic_change.php?file_id=&tc_id=&update=fail");
                            exit();;
                      }
                    }
                  }else{
                    $_SESSION['error'] = "Error updating the file";
                     header("Location: profile_pic_change.php?file_id=&tc_id=&upload=error");
                     exit();
                  }
                }
            }else {
              $_SESSION['error'] = "File exceeds 25MB";
              header("Location: profile_pic_change.php?file_id=&tc_id=&file=toolarge");
              exit();
            }
          }else {
            $_SESSION['error'] = "There was error in your file";
            header("Location: profile_pic_change.php?file_id=&tc_id=&file=error");
            exit();
          }
        }else {
          $_SESSION['error'] = "Invalid File type! Only jpg, jpeg, png and gifs are allowed.";
          header("Location:profile_pic_change.php?file_id=&tc_id=&invalid=filetype");
          exit();
        }
      }
}else{
  $_SESSION['error'] = "Submit button is not settled properly.";
  header("Location: profile_pic_change.php?file_id=&tc_id=&button=error");
}

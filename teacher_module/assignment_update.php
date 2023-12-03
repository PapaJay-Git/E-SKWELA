<?php
require_once 'checker.php';
require_once 'includes_assignment_id_check.php';
require_once 'includes_assignment_id_val.php';
$id = $_GET['tc_id'];
$assid = $_GET['ass_id'];
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
$date123 = date('Y-m-d H:i:s');
if (isset($_POST['submit_assignment']) && empty($_FILES['assignment']['tmp_name']) && !is_uploaded_file($_FILES['assignment']['tmp_name'])) {
	$ass_desc =  htmlspecialchars($_POST['ass_description']);
	$ass_title = htmlspecialchars($_POST['ass_name']);
	$ass_date = htmlspecialchars($_POST['date']);
	$start = htmlspecialchars($_POST['start']);
	$ass_attempt = htmlspecialchars($_POST['max_attempt']);
	$max_score = htmlspecialchars($_POST['max_score']);


	if (!is_numeric($ass_attempt) || !is_numeric($max_score)) {
		$_SESSION['error'] = "Attempt and score must be numeric!";
	 header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&ERROR");
	 exit();
	}

	if(!strtotime($ass_date)){
	$_SESSION['error'] = "Your date is not Valid";
	header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&ERROR");
	exit();
	}

	//add file assignments info to the database
	$add_ass = "UPDATE teacher_assignments SET ass_desc=?, ass_title=?, deadline_date=?, start_date =?, sub_attempt=?, max_score =? WHERE teacher_id=? AND teacher_assignment_id=?";
	$stmt = mysqli_stmt_init($conn);
	//Preparing the prepared statement
	if(!mysqli_stmt_prepare($stmt, $add_ass)) {
		 $_SESSION['error'] = "SQL error";
		header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&sql=error");
		exit();
	}
		//run sql
		mysqli_stmt_bind_param($stmt, "ssssiiii", $ass_desc, $ass_title, $ass_date, $start, $ass_attempt, $max_score, $_SESSION['teacher_session_id'], $assid);
		mysqli_stmt_execute($stmt);
		//update student answers
		$add_ass = "UPDATE student_assignment SET assignment_description=?, assignment_title=?, deadline_date=?, start_date=?, max_attempt=?, max_score =? WHERE teacher_id=? AND teacher_assignment_id=?";
		$stmt = mysqli_stmt_init($conn);
		//Preparing the prepared statement
		if(!mysqli_stmt_prepare($stmt, $add_ass)) {
			 $_SESSION['error'] = "SQL error";
			 header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&sql=error");
			exit();
		}
			//run sql
			mysqli_stmt_bind_param($stmt, "ssssiiii", $ass_desc, $ass_title, $ass_date, $start, $ass_attempt, $max_score, $_SESSION['teacher_session_id'], $assid);
			mysqli_stmt_execute($stmt);
				 $conn->close();
				 $_SESSION['success'] = "Assignment updated successfully!";
				 header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&success");
					 exit();
}
elseif (isset($_POST['submit_assignment']) && !empty($_FILES['assignment']['tmp_name']) && is_uploaded_file($_FILES['assignment']['tmp_name'])) {
    $file = $_FILES['assignment'];
    $ass_desc =  htmlspecialchars($_POST['ass_description']);
    $ass_title = htmlspecialchars($_POST['ass_name']);
    $ass_date = htmlspecialchars($_POST['date']);
		$start = htmlspecialchars($_POST['start']);
    $ass_attempt = htmlspecialchars($_POST['max_attempt']);
		$max_score = htmlspecialchars($_POST['max_score']);


		if (!is_numeric($ass_attempt) || !is_numeric($max_score)) {
			$_SESSION['error'] = "Attempt and score must be numeric!";
		 header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&ERROR");
		 exit();
		}

		if(!strtotime($ass_date) || !strtotime($start)){
		$_SESSION['error'] = "Your date is not Valid!";
		header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&ERROR");
		exit();
		}

    $fileName = $_FILES['assignment']['name'];
    $fileTmpName = $_FILES['assignment']['tmp_name'];
    $fileSize = $_FILES['assignment']['size'];
    $fileError = $_FILES['assignment']['error'];
    $fileType = $_FILES['assignment']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $hashed = md5($ass_title);
    $hashed2 = md5($date123);
    $allowed = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf', 'txt');
    if($fileSize == 0) {
        $_SESSION['error'] = "File is empty";
        header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&invalid=nofileSelected");
				exit();
    }else{
      if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
          if ($fileSize < 30000000) {
              $fileNameNew = "Assignment_".$hashed2.$hashed.".".$fileActualExt;
              $fileDestination =  '../Admin_module/teacher_assignments/'.$fileNameNew;
              if(file_exists($fileDestination)){
                $_SESSION['error'] = "File already exist, please change its name";
                header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&already_exist=file");
								exit();
              }else{
                if(move_uploaded_file($fileTmpName, $fileDestination)){
									//add file assignments info to the database
									$add_ass = "UPDATE teacher_assignments SET ass_desc=?, ass_title=?, ass_loc=?, deadline_date=?, sub_attempt=?, start_date=?, max_score=? WHERE teacher_id=? AND teacher_assignment_id=?";
									$stmt = mysqli_stmt_init($conn);
									//Preparing the prepared statement
									if(!mysqli_stmt_prepare($stmt, $add_ass)) {
									   $_SESSION['error'] = "SQL error";
									  header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&sql=error");
									  exit();
									}
									  //run sql
									  mysqli_stmt_bind_param($stmt, "ssssisiii", $ass_desc, $ass_title, $fileDestination, $ass_date, $ass_attempt, $start, $max_score, $_SESSION['teacher_session_id'], $assid);
									  mysqli_stmt_execute($stmt);
                    unlink($filepath);
										//add file assignments info to the database
										$add_ass = "UPDATE student_assignment SET assignment_description=?, assignment_title=?, deadline_date=?, max_attempt=?, start_date=?, max_score=? WHERE teacher_id=? AND teacher_assignment_id=?";
										$stmt = mysqli_stmt_init($conn);
										//Preparing the prepared statement
										if(!mysqli_stmt_prepare($stmt, $add_ass)) {
											 $_SESSION['error'] = "SQL error";
											 echo $conn->error;
											//header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&sql=error");
											exit();
										}
											//run sql
											mysqli_stmt_bind_param($stmt, "sssisiii", $ass_desc, $ass_title, $ass_date, $ass_attempt, $start, $max_score, $_SESSION['teacher_session_id'], $assid);
											mysqli_stmt_execute($stmt);
									       $conn->close();
									       $_SESSION['success'] = "File uploaded successfully!";
									       header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&success");
									         exit();
                //  require_once 'includes_add_assignment_query.php';
                  //header("Location: teacher_modules.php?success");
                    //  echo $fileActualExt;
                    //    echo $ass_desc;
                }else{
                    $_SESSION['error'] = "Upload error";
                   header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&upload=error");
									 exit();
                }
              }
          }else {
              $_SESSION['error'] = "File is more than 25mb.";
            header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&file=toolarge");
						exit();
          }
        }else {
            $_SESSION['error'] = "Your file has error";
          header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&file=error");
					exit();
        }
      }else {
        $_SESSION['error'] = "Invalid File Type! Allowed types are jpg, jpeg, png, pdf, docx, pdf, txt";
        header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&invalid=file");
				exit();
      }
    }
}
elseif (isset($_POST['share_assignment']) && !empty($_POST['share'])) {
	$share = $_POST['share'];
	$s = count($share);
	if ($assrow['ass_loc']==NULL) {
		for($i=0; $i < $s; $i++)
	  {
	  $sql33 = "SELECT class_id FROM teacher_class where teacher_class_id = $share[$i];";
	  $classNN = $conn->query($sql33);
	  $classNN2 = mysqli_fetch_assoc($classNN);

	  $update = "INSERT INTO teacher_assignments (teacher_class_id, class_id, upload_date, deadline_date, start_date, sub_attempt, teacher_id, ass_desc, ass_title, published, max_score)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	  $stmt = mysqli_stmt_init($conn);
	  //Preparing the prepared statement
	  if(!mysqli_stmt_prepare($stmt, $update)) {
	      $_SESSION['error'] = "SQL error, please contact tech support.";
	      echo mysqli_error($conn);
	      header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&sql=error");
	    exit();
	  } else {
	    //run sql
	    $classid = $classNN2['class_id'];
	    mysqli_stmt_bind_param($stmt, "iisssiissii", $share[$i], $classNN2['class_id'], $assrow['upload_date'], $assrow['deadline_date'], $assrow['start_date'],
			$assrow['sub_attempt'], $_SESSION['teacher_session_id'], $assrow['ass_desc'], $assrow['ass_title'], $assrow['published'], $assrow['max_score']);
	    if(mysqli_stmt_execute($stmt)){
	      //success
				$newid =  $conn->insert_id;
				//notifcation for students
				$notification = "SELECT * FROM student where class_id =?; ";
				$stmt = mysqli_stmt_init($conn);
				//Preparing the prepared statement
					mysqli_stmt_prepare($stmt, $notification);
					mysqli_stmt_bind_param($stmt, "i", $classNN2['class_id']);
					mysqli_stmt_execute($stmt);
					$students = mysqli_stmt_get_result($stmt);
					while ($student_row = mysqli_fetch_assoc($students)) {
						$notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, assignment_id, published) VALUES (?,?,?,?,?,?,?,?)";
						$stmt = mysqli_stmt_init($conn);
						//Preparing the prepared statement
						$type_notif = "assignment";
							mysqli_stmt_prepare($stmt, $notification);
							mysqli_stmt_bind_param($stmt, "iiiissii",  $classNN2['class_id'], $student_row['student_id'], $_SESSION['teacher_session_id'], $share[$i], $assrow['upload_date'], $type_notif, $newid, $assrow['published']);
							mysqli_stmt_execute($stmt);
					}
	    }else {
	      echo mysqli_error($conn);
	      $conn->close();
	      $_SESSION['error'] = "Sharing assignment with no file, Failed!";
	      header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&share_failed");
	      exit();
	    }
	   }
	  }
		echo mysqli_error($conn);
		$conn->close();
		$_SESSION['success'] = "Sharing assignment with no file, Success!";
		header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&share_success");
		exit();
	}else {
  //loop to on how many classes do the teacher want to add this quiz. Based on the check boxes selected
  for($i=0; $i < $s; $i++)
  {
  $sql33 = "SELECT class_id FROM teacher_class where teacher_class_id = $share[$i];";
  $classNN = $conn->query($sql33);
  $classNN2 = mysqli_fetch_assoc($classNN);

  $fileExt = explode('.', $assrow['ass_loc']);
  $fileActualExt = strtolower(end($fileExt));
  $hashed_loc = md5($assrow['ass_title']);
  $hashed_date = md5($date123);
  $hashed_num = md5($i);
  $fileNameNew = "shared_".$hashed_loc.$hashed_date.$hashed_num.".".$fileActualExt;
  $fileDestination =  '../Admin_module/teacher_assignments/'.$fileNameNew;
  echo $fileDestination;
  $update = "INSERT INTO teacher_assignments (ass_loc, teacher_class_id, class_id, upload_date, deadline_date, start_date, sub_attempt, teacher_id, ass_desc, ass_title, published, max_score)
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  //Preparing the prepared statement
  if(!mysqli_stmt_prepare($stmt, $update)) {
      $_SESSION['error'] = "SQL error, please contact tech support.";
      echo mysqli_error($conn);
      header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&sql=error");
    exit();
  } else {
    if (!copy($assrow['ass_loc'], $fileDestination)) {
      $_SESSION['error'] = "Cannot copy file";
      header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&error");
      exit();
    }
    //run sql
    $classid = $classNN2['class_id'];
    mysqli_stmt_bind_param($stmt, "siisssiissi", $fileDestination, $share[$i], $classNN2['class_id'], $assrow['upload_date'], $assrow['deadline_date'], $assrow['start_date'],
		$assrow['sub_attempt'], $_SESSION['teacher_session_id'], $assrow['ass_desc'], $assrow['ass_title'], $assrow['published'], $assrow['max_score']);
    if(mysqli_stmt_execute($stmt)){
      //success
			$newid =  $conn->insert_id;
			//notifcation for students
			$notification = "SELECT * FROM student where class_id =?; ";
			$stmt = mysqli_stmt_init($conn);
			//Preparing the prepared statement
				mysqli_stmt_prepare($stmt, $notification);
				mysqli_stmt_bind_param($stmt, "i", $classNN2['class_id']);
				mysqli_stmt_execute($stmt);
				$students = mysqli_stmt_get_result($stmt);
				while ($student_row = mysqli_fetch_assoc($students)) {
					$notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, assignment_id, published) VALUES (?,?,?,?,?,?,?,?)";
					$stmt = mysqli_stmt_init($conn);
					//Preparing the prepared statement
					$type_notif = "assignment";
						mysqli_stmt_prepare($stmt, $notification);
						mysqli_stmt_bind_param($stmt, "iiiissii",  $classNN2['class_id'], $student_row['student_id'], $_SESSION['teacher_session_id'], $share[$i], $assrow['upload_date'], $type_notif, $newid, $assrow['published']);
						mysqli_stmt_execute($stmt);
				}
    }else {
      echo mysqli_error($conn);
      $conn->close();
      $_SESSION['error'] = "Sharing assignment with a file, Failed!";
      header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&share_failed");
      exit();
    }
   }
  }
	echo mysqli_error($conn);
	$conn->close();
	$_SESSION['success'] = "Sharing assignment with a file, Success!";
	header("Location: assignment_edit.php?ass_id=$assid&tc_id=$id&share_success");
	exit();
	}
}
else{
    $_SESSION['error'] = "Submit button is not settled.";
  header("Location:  assignment_edit.php?ass_id=$assid&tc_id=$id&submit_file=notset");
	exit();
}

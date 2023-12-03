<?php
//uploading assignment file to the folder location and database
require_once 'checker.php';
require_once 'includes_assignment_id_check.php';
date_default_timezone_set('Asia/Manila');
	$id = $_GET['tc_id'];
// Then call the date functions
//for minimun date deadline
date_default_timezone_set('Asia/Manila');
// Then call the date functions
$date = date('Y-m-d H:i:s');
$date123 = date('Y-m-d H:i:s');
if (isset($_POST['submit_assignment']) && empty($_FILES['assignment']['tmp_name']) && !is_uploaded_file($_FILES['assignment']['tmp_name'])) {
	$ass_desc = htmlspecialchars($_POST['ass_description']);
	$ass_title = htmlspecialchars($_POST['ass_name']);
	$ass_date = htmlspecialchars($_POST['date']);
	$start = htmlspecialchars($_POST['start']);
	$ass_attempt = htmlspecialchars($_POST['max_attempt']);
	$max_score = htmlspecialchars($_POST['max_score']);

	if (!is_numeric($ass_attempt) || !is_numeric($max_score)) {
		$_SESSION['error'] = "Attempt and score must be numeric!";
	 header("Location: teacher_upload_assignments.php?tc_id=$id&ERROR");
	 exit();
	}
	if(!strtotime($ass_date) || !strtotime($start)){
	$_SESSION['error'] = "Your date is not Valid!";
	header("Location: teacher_upload_assignments.php?tc_id=$id&invalid=date");
	exit();
	}
	//add file assignments info to the database
	$add_ass = "INSERT INTO teacher_assignments (teacher_class_id, teacher_id, class_id, ass_desc, ass_title, upload_date, deadline_date, sub_attempt, start_date, max_score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = mysqli_stmt_init($conn);
	//Preparing the prepared statement
	if(!mysqli_stmt_prepare($stmt, $add_ass)) {
		 $_SESSION['error'] = "SQL error";
		header("Location: teacher_upload_assignments.php?tc_id=$id&sql=error");
		exit();
	} else {
		//run sql
		mysqli_stmt_bind_param($stmt, "iiissssisi", $row['teacher_class_id'], $row['teacher_id'], $row['class_id'], $ass_desc, $ass_title, $date, $ass_date, $ass_attempt, $start, $max_score);
		mysqli_stmt_execute($stmt);
		$newid =  $conn->insert_id;
		$notification = "SELECT * FROM student where class_id =?; ";
		$stmt = mysqli_stmt_init($conn);
		//Preparing the prepared statement
			mysqli_stmt_prepare($stmt, $notification);
			mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
			mysqli_stmt_execute($stmt);
			$students = mysqli_stmt_get_result($stmt);

			while ($student_row = mysqli_fetch_assoc($students)) {
				$notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, assignment_id, published) VALUES (?,?,?,?,?,?,?,?)";
				$stmt = mysqli_stmt_init($conn);
				//Preparing the prepared statement
				$published = 0;
				$type_notif = "assignment";
					mysqli_stmt_prepare($stmt, $notification);
					mysqli_stmt_bind_param($stmt, "iiiissii",  $row['class_id'], $student_row['student_id'], $_SESSION['teacher_session_id'], $row['teacher_class_id'], $date, $type_notif, $newid, $published);
					mysqli_stmt_execute($stmt);
			}
			//admin_notification
			$notification = "SELECT * FROM admin; ";
			$admins = $conn->query($notification);
				while ($admin_row = mysqli_fetch_assoc($admins)) {
					$admin_id = $admin_row['admin_id'];
					$type_notif = 3;
					$status = 'unread';
					$notification2 = "SELECT * FROM admin_notification WHERE admin_id = $admin_id AND type = $type_notif;";
					$admin_notif = $conn->query($notification2);
					if ($admin_notif->num_rows > 0) {
					$admin_notif_id = mysqli_fetch_assoc($admin_notif);
					$notif_id = $admin_notif_id['id'];
					$notification = "UPDATE admin_notification SET date_given = ?, status = ? WHERE id =?";
					$stmt = mysqli_stmt_init($conn);
					mysqli_stmt_prepare($stmt, $notification);
					mysqli_stmt_bind_param($stmt, "ssi", $date, $status, $notif_id);
					mysqli_stmt_execute($stmt);
					}else {
						$notification = "INSERT INTO admin_notification (admin_id, date_given, type) VALUES (?, ?, ?)";
						$stmt = mysqli_stmt_init($conn);
						mysqli_stmt_prepare($stmt, $notification);
						mysqli_stmt_bind_param($stmt, "isi", $admin_id, $date, $type_notif);
						mysqli_stmt_execute($stmt);
					}
				}
				 $conn->close();
					 $_SESSION['success'] = "Assignment created successfully!";
				 header("Location: teacher_upload_assignments.php?tc_id=$id&success");
					 exit();
		}
}
elseif (isset($_POST['submit_assignment']) && !empty($_FILES['assignment']['tmp_name']) && is_uploaded_file($_FILES['assignment']['tmp_name'])) {
    $file = $_FILES['assignment'];
    $ass_desc = htmlspecialchars($_POST['ass_description']);
    $ass_title = htmlspecialchars($_POST['ass_name']);
    $ass_date = htmlspecialchars($_POST['date']);
		$start = htmlspecialchars($_POST['start']);
    $ass_attempt = htmlspecialchars($_POST['max_attempt']);
		$max_score = htmlspecialchars($_POST['max_score']);

		if (!is_numeric($ass_attempt) || !is_numeric($max_score)) {
			$_SESSION['error'] = "Attempt and score must be numeric!";
		 header("Location: teacher_upload_assignments.php?tc_id=$id&ERROR");
		 exit();
		}

		if(!strtotime($ass_date) || !strtotime($start)){
		$_SESSION['error'] = "Your date is not Valid!";
		header("Location: teacher_upload_assignments.php?tc_id=$id&invalid=date");
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
        header("Location: teacher_upload_assignments.php?tc_id=$id&invalid=nofileSelected");
				exit();
    }else{
      if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
          if ($fileSize < 30000000) {
              $fileNameNew = "Assignment_".$hashed2.$hashed.".".$fileActualExt;
              $fileDestination =  '../Admin_module/teacher_assignments/'.$fileNameNew;
              if(file_exists($fileDestination)){
                $_SESSION['error'] = "File already exist, please change its name";
                header("Location: teacher_upload_assignments.php?tc_id=$id&already_exist=file");
								exit();
              }else{
                if(move_uploaded_file($fileTmpName, $fileDestination)){
									//add file assignments info to the database
									$add_ass = "INSERT INTO teacher_assignments (teacher_class_id, teacher_id, class_id, ass_loc, ass_desc, ass_title, upload_date, deadline_date, sub_attempt, start_date, max_score)
									VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
									$stmt = mysqli_stmt_init($conn);
									//Preparing the prepared statement
									if(!mysqli_stmt_prepare($stmt, $add_ass)) {
									   $_SESSION['error'] = "SQL error";
									  header("Location: teacher_upload_assignments.php?tc_id=$id&sql=error");
									  exit();
									} else {
									  //run sql
									  mysqli_stmt_bind_param($stmt, "iiisssssisi", $row['teacher_class_id'], $row['teacher_id'], $row['class_id'], $fileDestination, $ass_desc, $ass_title, $date, $ass_date, $ass_attempt, $start, $max_score);
									  mysqli_stmt_execute($stmt);
										$newid =  $conn->insert_id;
										$notification = "SELECT * FROM student where class_id =?; ";
										$stmt = mysqli_stmt_init($conn);
										//Preparing the prepared statement
											mysqli_stmt_prepare($stmt, $notification);
											mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
											mysqli_stmt_execute($stmt);
											$students = mysqli_stmt_get_result($stmt);

											while ($student_row = mysqli_fetch_assoc($students)) {
												$notification = "INSERT INTO student_notification (class_id, student_id, teacher_id, teacher_class_id, date_given, type, assignment_id, published) VALUES (?,?,?,?,?,?,?,?)";
												$stmt = mysqli_stmt_init($conn);
												//Preparing the prepared statement
												$published = 0;
												$type_notif = "assignment";
													mysqli_stmt_prepare($stmt, $notification);
													mysqli_stmt_bind_param($stmt, "iiiissii",  $row['class_id'], $student_row['student_id'], $_SESSION['teacher_session_id'], $row['teacher_class_id'], $date, $type_notif, $newid, $published);
													mysqli_stmt_execute($stmt);
											}
											//admin_notification
											$notification = "SELECT * FROM admin; ";
											$admins = $conn->query($notification);
												while ($admin_row = mysqli_fetch_assoc($admins)) {
													$admin_id = $admin_row['admin_id'];
													$type_notif = 3;
													$status = 'unread';
													$notification2 = "SELECT * FROM admin_notification WHERE admin_id = $admin_id AND type = $type_notif;";
													$admin_notif = $conn->query($notification2);
													if ($admin_notif->num_rows > 0) {
													$admin_notif_id = mysqli_fetch_assoc($admin_notif);
													$notif_id = $admin_notif_id['id'];
													$notification = "UPDATE admin_notification SET date_given = ?, status = ? WHERE id =?";
													$stmt = mysqli_stmt_init($conn);
													mysqli_stmt_prepare($stmt, $notification);
													mysqli_stmt_bind_param($stmt, "ssi", $date, $status, $notif_id);
													mysqli_stmt_execute($stmt);
													}else {
														$notification = "INSERT INTO admin_notification (admin_id, date_given, type) VALUES (?, ?, ?)";
														$stmt = mysqli_stmt_init($conn);
														mysqli_stmt_prepare($stmt, $notification);
														mysqli_stmt_bind_param($stmt, "isi", $admin_id, $date, $type_notif);
														mysqli_stmt_execute($stmt);
													}
												}
									       $conn->close();
									         $_SESSION['success'] = "Assignment uploaded successfully!";
									       header("Location: teacher_upload_assignments.php?tc_id=$id&success");
									         exit();
									     }
                //  require_once 'includes_add_assignment_query.php';
                  //header("Location: teacher_modules.php?success");
                    //  echo $fileActualExt;
                    //    echo $ass_desc;
                }else{
                    $_SESSION['error'] = "Upload error";
                   header("Location: teacher_upload_assignments.php?tc_id=$id&upload=error");
									 exit();
                }
              }
          }else {
              $_SESSION['error'] = "File is more than 25mb.";
            header("Location: teacher_upload_assignments.php?tc_id=$id&file=toolarge");
						exit();
          }
        }else {
            $_SESSION['error'] = "Your file has error";
          header("Location: teacher_upload_assignments.php?tc_id=$id&file=error");
					exit();
        }
      }else {
        $_SESSION['error'] = "Invalid File Type! Allowed types are jpg, jpeg, png, pdf, docx, pdf, txt";
        header("Location: teacher_upload_assignments.php?tc_id=$id&invalid=file");
				exit();
      }
    }
}else{
    $_SESSION['error'] = "Submit button is not settled.";
  header("Location: teacher_upload_assignments.php?tc_id=$id&submit_file=notset");
	exit();
}

<?php
require_once 'checker.php';
require_once 'includes_assignment_id_check.php';
require_once 'includes_assignment_id_val.php';
require_once 'includes_assignment_student_id.php';
$tcid = $_GET['tc_id'];
$assid = $_GET['ass_id'];
//checking if the actually exist on our path to be deleted
//If file doesnt exist, then we throw an error
if (file_exists($filepath45)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . basename($filepath45));
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($filepath45));
      readfile($filepath45);
      exit;
}else{
  $_SESSION['error'] = "File is missing";
  header("location: teacher_assignment_view.php?file=missing&ass_id=$assid&tc_id=$tcid");
    exit();
}

<?php
 require_once "includes_advisory.php";
 date_default_timezone_set('Asia/Manila');
 $date = date('Y');
 $date2 = date('m');
 //school_year
 if ($date2 >= 6) {
 	$math = $date+1;
 	$school_year = $date."-".$math;
 }else {
 	$math = $date-1;
 	$school_year = $math."-".$date;
 }
  $ee = $row['class_id'];

if (!isset($_GET['student_id']) || !is_numeric($_GET['student_id'])) {
  $_SESSION['error'] = "ID is empty";
  header("location: advisory_view.php?class_id=$ee");
  exit();
}
$student_id = $_GET['student_id'];
 //searching for class_name of class_id
 $sql5 = "SELECT * FROM class where class_id = $ee;";
 $classN = $conn->query($sql5);
 $class_info = mysqli_fetch_assoc($classN);
 $sql = "SELECT * FROM student WHERE class_id=? AND student_id = ?;";
 $stmt = mysqli_stmt_init($conn);
   mysqli_stmt_prepare($stmt, $sql);
   mysqli_stmt_bind_param($stmt, "ii", $row['class_id'], $student_id);
   mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows > 0) {
      $student = mysqli_fetch_assoc($result);
    }else {
      $_SESSION['error'] = "ID $student_id does not exist in this section";
      header("location: advisory_view.php?class_id=$ee");
      exit();
    }
    //Teacher_name
    $sql = "SELECT * FROM teachers WHERE teacher_id =?;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['teacher_session_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $teacher_info = mysqli_fetch_assoc($result);

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>
  <table id="employee_data" class="table table-striped table-bordered">
          <?php
          if ($class_info['grade'] == 7) {
          ?>
          <tr>
            <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
          </tr>
										<tr>
											<td colspan="4">School: Sto. Cristo Integrated School</td>
											<td colspan="3">School ID: 500557</td>
                      <td colspan="4">District: Tarlac Central District-A</td>
                      <td colspan="3">Division: Tarlac City</td>
                      <td colspan="3">Region: III</td>
										</tr>
										<tr>
                      <td colspan="3">Classified as Grade: <?php echo $class_info['grade']; ?> </td>
											<td colspan="3">Section: <?php echo $class_info['section_code']; ?></td>
											<td colspan="3">School Year: <?php echo $school_year; ?> </td>
                      <td colspan="5">Name of Adviser/Teacher: <?php echo $teacher_info['f_name']." ".$teacher_info['l_name']; ?></td>
                      <td colspan="2">Signature: </td>
										</tr>
                    <tr>
                      <td colspan="5">Student Name: <?php echo $student['l_name'].", ".$student['f_name']; ?></td>
                      <td colspan="3">LRN: <?php echo $student['school_id']; ?></td>
                    </tr>
										<tr>
											<th colspan="3" rowspan="2">LEARNING AREAS</th>
                      <th colspan="4">Quarterly Rating</th>
                      <th colspan="2" rowspan="2">FINAL RATING</th>
                      <th colspan="4" rowspan="2">REMARKS</th>
										</tr>
                    <tr>
                      <td>1</td>
                      <td>2</td>
                      <td>3</td>
                      <td>4</td>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
                    $stmt = mysqli_stmt_init($conn);
                      mysqli_stmt_prepare($stmt, $sql);
                      mysqli_stmt_bind_param($stmt, "i", $ee);
                      mysqli_stmt_execute($stmt);
                      $result_2 = mysqli_stmt_get_result($stmt);
                      while ($row_2 = mysqli_fetch_assoc($result_2)) {
                        $teacher_id = $row_2['teacher_id'];
                        $subject_code_check = $row_2['subject_id'];
                        $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_id;";
                        $output11 = $conn->query($checkClasses11);
                        if ($output11->num_rows > 0) {
                          $arrayClasses11 = mysqli_fetch_assoc($output11);
                          $teacher_fname = $arrayClasses11['f_name'];
                          $teacher_lname = $arrayClasses11['l_name'];
                        }else {
                          $teacher_fname = "DELETED";
                          $teacher_lname = "TEACHER";
                        }
                        //
                        $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
                        $output112 = $conn->query($checkClasses112);
                        if ($output112->num_rows > 0) {
                          $arrayClasses112 = mysqli_fetch_assoc($output112);
                          $subject_code = $arrayClasses112['subject_title'];
                        }else {
                          $subject_code = "DELETED SUBJECT";
                        }
                        $teacher_class_id = $row_2['teacher_class_id'];
                        $grade = "SELECT * FROM stu_grade where student_id = $student_id AND subject_id = $subject_code_check;";
                        $gradeoutput = $conn->query($grade);
                        if ($gradeoutput->num_rows > 0) {
                          $view_grade = mysqli_fetch_assoc($gradeoutput);
                          $one = $view_grade['first'];
                          $two = $view_grade['second'];
                          $three =  $view_grade['third'];
                          $four = $view_grade['fourth'];
                          $five = $view_grade['final'];
                        }else {
                          $one = 0;
                          $two = 0;
                          $three = 0;
                          $four = 0;
                          $five = 0;
                        }
                        ?>
                        <tr>
                          <td colspan="3"><?php echo  $subject_code;?></td>
                          <td><?php echo $one; ?></td>
                          <td><?php echo $two; ?></td>
                          <td><?php echo $three;?></td>
                          <td><?php echo $four; ?></td>
                          <td colspan="2"><?php echo $five; ?></td>
                          <?php if ($five >= 75) {
                            $remarks = "Passed";
                          }else {
                            $remarks = "Failed";
                          } ?>
                          <td colspan="4"><?php echo $remarks; ?></td>
                        </tr>
                        <?php
                      }
          }elseif($student['seven'] > 0) {
            //searching for class_name of class_id
            $id_search = $student['seven'];
            $sql55 = "SELECT * FROM class where class_id = $id_search;";
            $classN10 = $conn->query($sql55);
            $class_info10 = mysqli_fetch_assoc($classN10);
            //searching for advisory of class_id
            $sql555 = "SELECT * FROM advisory where class_id = $id_search;";
            $classN101 = $conn->query($sql555);
            $class_info11 = mysqli_fetch_assoc($classN101);
            $teach_id = $class_info11['teacher_id'];
            //searching for advisory of class_id
            $sql555 = "SELECT * FROM teachers where teacher_id = $teach_id;";
            $classN101 = $conn->query($sql555);
            $teacher_name = mysqli_fetch_assoc($classN101);
            ?>
            <tr>
              <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
            </tr>
                      <tr>
                        <td colspan="4">School: Sto. Cristo Integrated School</td>
                        <td colspan="3">School ID: 500557</td>
                        <td colspan="4">District: Tarlac Central District-A</td>
                        <td colspan="3">Division: Tarlac City</td>
                        <td colspan="3">Region: III</td>
                      </tr>
                      <tr>
                        <td colspan="3">Classified as Grade: <?php echo $class_info10['grade']; ?> </td>
                        <td colspan="3">Section: <?php echo $class_info10['section_code']; ?></td>
                        <td colspan="3">School Year: <?php echo $school_year; ?> </td>
                        <td colspan="5">Name of Adviser/Teacher: <?php echo $teacher_name['f_name']." ".$teacher_name['l_name']; ?></td>
                        <td colspan="2">Signature: </td>
                      </tr>
                      <tr>
                        <td colspan="5">Student Name: <?php echo $student['l_name'].", ".$student['f_name']; ?></td>
                        <td colspan="3">LRN: <?php echo $student['school_id']; ?></td>
                      </tr>
                      <tr>
                        <th colspan="3" rowspan="2">LEARNING AREAS</th>
                        <th colspan="4">Quarterly Rating</th>
                        <th colspan="2" rowspan="2">FINAL RATING</th>
                        <th colspan="4" rowspan="2">REMARKS</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                      </tr>
                      <?php
                      $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
                      $stmt = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $class_info10['class_id']);
                        mysqli_stmt_execute($stmt);
                        $result_2 = mysqli_stmt_get_result($stmt);
                        while ($row_2 = mysqli_fetch_assoc($result_2)) {
                          $teacher_id = $row_2['teacher_id'];
                          $subject_code_check = $row_2['subject_id'];
                          $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_id;";
                          $output11 = $conn->query($checkClasses11);
                          if ($output11->num_rows > 0) {
                            $arrayClasses11 = mysqli_fetch_assoc($output11);
                            $teacher_fname = $arrayClasses11['f_name'];
                            $teacher_lname = $arrayClasses11['l_name'];
                          }else {
                            $teacher_fname = "DELETED";
                            $teacher_lname = "TEACHER";
                          }
                          //
                          $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
                          $output112 = $conn->query($checkClasses112);
                          if ($output112->num_rows > 0) {
                            $arrayClasses112 = mysqli_fetch_assoc($output112);
                            $subject_code = $arrayClasses112['subject_title'];
                          }else {
                            $subject_code = "DELETED SUBJECT";
                          }
                          $teacher_class_id = $row_2['teacher_class_id'];
                          $grade = "SELECT * FROM stu_grade where student_id = $student_id AND subject_id = $subject_code_check;";
                          $gradeoutput = $conn->query($grade);
                          if ($gradeoutput->num_rows > 0) {
                            $view_grade = mysqli_fetch_assoc($gradeoutput);
                            $one = $view_grade['first'];
                            $two = $view_grade['second'];
                            $three =  $view_grade['third'];
                            $four = $view_grade['fourth'];
                            $five = $view_grade['final'];
                          }else {
                            $one = 0;
                            $two = 0;
                            $three = 0;
                            $four = 0;
                            $five = 0;
                          }
                          ?>
                          <tr>
                            <td colspan="3"><?php echo  $subject_code;?></td>
                            <td><?php echo $one; ?></td>
                            <td><?php echo $two; ?></td>
                            <td><?php echo $three;?></td>
                            <td><?php echo $four; ?></td>
                            <td colspan="2"><?php echo $five; ?></td>
                            <?php if ($five >= 75) {
                              $remarks = "Passed";
                            }else {
                              $remarks = "Failed";
                            } ?>
                            <td colspan="4"><?php echo $remarks; ?></td>
                          </tr>
                          <?php
                        }
          }else {
            ?>
            <tr>
              <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
            </tr>
            <tr>
              <td colspan="4">School: Sto. Cristo Integrated School</td>
              <td colspan="3">School ID: 500557</td>
              <td colspan="4">District: Tarlac Central District-A</td>
              <td colspan="3">Division: Tarlac City</td>
              <td colspan="3">Region: III</td>
            </tr>
            <tr>
              <td colspan="3">Classified as Grade: 7 </td>
              <td colspan="3">Section: </td>
              <td colspan="3">School Year: <?php echo $school_year; ?> </td>
              <td colspan="5">Name of Adviser/Teacher: </td>
              <td colspan="2">Signature: </td>
            </tr>
            <tr>
              <td colspan="5">Student Name: </td>
              <td colspan="3">LRN: </td>
            </tr>
            <tr>
              <th colspan="3" rowspan="2">LEARNING AREAS</th>
              <th colspan="4">Quarterly Rating</th>
              <th colspan="2" rowspan="2">FINAL RATING</th>
              <th colspan="4" rowspan="2">REMARKS</th>
            </tr>
            <tr>
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
            <?php
          }
          if ($class_info['grade'] == 8) {
            ?>
              <tr>
              </tr>
              <tr>
                <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
              </tr>
  										<tr>
  											<td colspan="4">School: Sto. Cristo Integrated School</td>
  											<td colspan="3">School ID: 500557</td>
                        <td colspan="4">District: Tarlac Central District-A</td>
                        <td colspan="3">Division: Tarlac City</td>
                        <td colspan="3">Region: III</td>
  										</tr>
  										<tr>
                        <td colspan="3">Classified as Grade: <?php echo $class_info['grade']; ?> </td>
  											<td colspan="3">Section: <?php echo $class_info['section_code']; ?></td>
  											<td colspan="3">School Year: <?php echo $school_year; ?> </td>
                        <td colspan="5">Name of Adviser/Teacher: <?php echo $teacher_info['f_name']." ".$teacher_info['l_name']; ?></td>
                        <td colspan="2">Signature: </td>
  										</tr>
                      <tr>
                        <td colspan="5">Student Name: <?php echo $student['l_name'].", ".$student['f_name']; ?></td>
                        <td colspan="3">LRN: <?php echo $student['school_id']; ?></td>
                      </tr>
  										<tr>
  											<th colspan="3" rowspan="2">LEARNING AREAS</th>
                        <th colspan="4">Quarterly Rating</th>
                        <th colspan="2" rowspan="2">FINAL RATING</th>
                        <th colspan="4" rowspan="2">REMARKS</th>
  										</tr>
                      <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                      </tr>
                      <?php
                      $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
                      $stmt = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $ee);
                        mysqli_stmt_execute($stmt);
                        $result_2 = mysqli_stmt_get_result($stmt);
                        while ($row_2 = mysqli_fetch_assoc($result_2)) {
                          $teacher_id = $row_2['teacher_id'];
                          $subject_code_check = $row_2['subject_id'];
                          $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_id;";
                          $output11 = $conn->query($checkClasses11);
                          if ($output11->num_rows > 0) {
                            $arrayClasses11 = mysqli_fetch_assoc($output11);
                            $teacher_fname = $arrayClasses11['f_name'];
                            $teacher_lname = $arrayClasses11['l_name'];
                          }else {
                            $teacher_fname = "DELETED";
                            $teacher_lname = "TEACHER";
                          }
                          //
                          $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
                          $output112 = $conn->query($checkClasses112);
                          if ($output112->num_rows > 0) {
                            $arrayClasses112 = mysqli_fetch_assoc($output112);
                            $subject_code = $arrayClasses112['subject_title'];
                          }else {
                            $subject_code = "DELETED SUBJECT";
                          }
                          $teacher_class_id = $row_2['teacher_class_id'];
                          $grade = "SELECT * FROM stu_grade where student_id = $student_id AND subject_id = $subject_code_check;";
                          $gradeoutput = $conn->query($grade);
                          if ($gradeoutput->num_rows > 0) {
                            $view_grade = mysqli_fetch_assoc($gradeoutput);
                            $one = $view_grade['first'];
                            $two = $view_grade['second'];
                            $three =  $view_grade['third'];
                            $four = $view_grade['fourth'];
                            $five = $view_grade['final'];
                          }else {
                            $one = 0;
                            $two = 0;
                            $three = 0;
                            $four = 0;
                            $five = 0;
                          }
                          ?>
                          <tr>
                            <td colspan="3"><?php echo  $subject_code;?></td>
                            <td><?php echo $one; ?></td>
                            <td><?php echo $two; ?></td>
                            <td><?php echo $three;?></td>
                            <td><?php echo $four; ?></td>
                            <td colspan="2"><?php echo $five; ?></td>
                            <?php if ($five >= 75) {
                              $remarks = "Passed";
                            }else {
                              $remarks = "Failed";
                            } ?>
                            <td colspan="4"><?php echo $remarks; ?></td>
                          </tr>
                          <?php
                        }
          }elseif($student['eight'] > 0) {
            //searching for class_name of class_id
            $id_search = $student['eight'];
            $sql55 = "SELECT * FROM class where class_id = $id_search;";
            $classN10 = $conn->query($sql55);
            $class_info10 = mysqli_fetch_assoc($classN10);
            //searching for advisory of class_id
            $sql555 = "SELECT * FROM advisory where class_id = $id_search;";
            $classN101 = $conn->query($sql555);
            $class_info11 = mysqli_fetch_assoc($classN101);
            $teach_id = $class_info11['teacher_id'];
            //searching for advisory of class_id
            $sql555 = "SELECT * FROM teachers where teacher_id = $teach_id;";
            $classN101 = $conn->query($sql555);
            $teacher_name = mysqli_fetch_assoc($classN101);
            ?>
            <tr>
            </tr>
            <tr>
              <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
            </tr>
                      <tr>
                        <td colspan="4">School: Sto. Cristo Integrated School</td>
                        <td colspan="3">School ID: 500557</td>
                        <td colspan="4">District: Tarlac Central District-A</td>
                        <td colspan="3">Division: Tarlac City</td>
                        <td colspan="3">Region: III</td>
                      </tr>
                      <tr>
                        <td colspan="3">Classified as Grade: <?php echo $class_info10['grade']; ?> </td>
                        <td colspan="3">Section: <?php echo $class_info10['section_code']; ?></td>
                        <td colspan="3">School Year: <?php echo $school_year; ?> </td>
                        <td colspan="5">Name of Adviser/Teacher: <?php echo $teacher_name['f_name']." ".$teacher_name['l_name']; ?></td>
                        <td colspan="2">Signature: </td>
                      </tr>
                      <tr>
                        <td colspan="5">Student Name: <?php echo $student['l_name'].", ".$student['f_name']; ?></td>
                        <td colspan="3">LRN: <?php echo $student['school_id']; ?></td>
                      </tr>
                      <tr>
                        <th colspan="3" rowspan="2">LEARNING AREAS</th>
                        <th colspan="4">Quarterly Rating</th>
                        <th colspan="2" rowspan="2">FINAL RATING</th>
                        <th colspan="4" rowspan="2">REMARKS</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                      </tr>
                      <?php
                      $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
                      $stmt = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $class_info10['class_id']);
                        mysqli_stmt_execute($stmt);
                        $result_2 = mysqli_stmt_get_result($stmt);
                        while ($row_2 = mysqli_fetch_assoc($result_2)) {
                          $teacher_id = $row_2['teacher_id'];
                          $subject_code_check = $row_2['subject_id'];
                          $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_id;";
                          $output11 = $conn->query($checkClasses11);
                          if ($output11->num_rows > 0) {
                            $arrayClasses11 = mysqli_fetch_assoc($output11);
                            $teacher_fname = $arrayClasses11['f_name'];
                            $teacher_lname = $arrayClasses11['l_name'];
                          }else {
                            $teacher_fname = "DELETED";
                            $teacher_lname = "TEACHER";
                          }
                          //
                          $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
                          $output112 = $conn->query($checkClasses112);
                          if ($output112->num_rows > 0) {
                            $arrayClasses112 = mysqli_fetch_assoc($output112);
                            $subject_code = $arrayClasses112['subject_title'];
                          }else {
                            $subject_code = "DELETED SUBJECT";
                          }
                          $teacher_class_id = $row_2['teacher_class_id'];
                          $grade = "SELECT * FROM stu_grade where student_id = $student_id AND subject_id = $subject_code_check;";
                          $gradeoutput = $conn->query($grade);
                          if ($gradeoutput->num_rows > 0) {
                            $view_grade = mysqli_fetch_assoc($gradeoutput);
                            $one = $view_grade['first'];
                            $two = $view_grade['second'];
                            $three =  $view_grade['third'];
                            $four = $view_grade['fourth'];
                            $five = $view_grade['final'];
                          }else {
                            $one = 0;
                            $two = 0;
                            $three = 0;
                            $four = 0;
                            $five = 0;
                          }
                          ?>
                          <tr>
                            <td colspan="3"><?php echo  $subject_code;?></td>
                            <td><?php echo $one; ?></td>
                            <td><?php echo $two; ?></td>
                            <td><?php echo $three;?></td>
                            <td><?php echo $four; ?></td>
                            <td colspan="2"><?php echo $five; ?></td>
                            <?php if ($five >= 75) {
                              $remarks = "Passed";
                            }else {
                              $remarks = "Failed";
                            } ?>
                            <td colspan="4"><?php echo $remarks; ?></td>
                          </tr>
                          <?php
                        }
          }else {
            ?>
            <tr>
            </tr>
            <tr>
              <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
            </tr>
            <tr>
              <td colspan="4">School: Sto. Cristo Integrated School</td>
              <td colspan="3">School ID: 500557</td>
              <td colspan="4">District: Tarlac Central District-A</td>
              <td colspan="3">Division: Tarlac City</td>
              <td colspan="3">Region: III</td>
            </tr>
            <tr>
              <td colspan="3">Classified as Grade: 8 </td>
              <td colspan="3">Section: </td>
              <td colspan="3">School Year: <?php echo $school_year; ?> </td>
              <td colspan="5">Name of Adviser/Teacher: </td>
              <td colspan="2">Signature: </td>
            </tr>
            <tr>
              <td colspan="5">Student Name: </td>
              <td colspan="3">LRN: </td>
            </tr>
            <tr>
              <th colspan="3" rowspan="2">LEARNING AREAS</th>
              <th colspan="4">Quarterly Rating</th>
              <th colspan="2" rowspan="2">FINAL RATING</th>
              <th colspan="4" rowspan="2">REMARKS</th>
            </tr>
            <tr>
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
            <?php
          }

          if ($class_info['grade'] == 9) {
            ?>
              <tr>
              </tr>
              <tr>
                <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
              </tr>
  										<tr>
  											<td colspan="4">School: Sto. Cristo Integrated School</td>
  											<td colspan="3">School ID: 500557</td>
                        <td colspan="4">District: Tarlac Central District-A</td>
                        <td colspan="3">Division: Tarlac City</td>
                        <td colspan="3">Region: III</td>
  										</tr>
  										<tr>
                        <td colspan="3">Classified as Grade: <?php echo $class_info['grade']; ?> </td>
  											<td colspan="3">Section: <?php echo $class_info['section_code']; ?></td>
  											<td colspan="3">School Year: <?php echo $school_year; ?> </td>
                        <td colspan="5">Name of Adviser/Teacher: <?php echo $teacher_info['f_name']." ".$teacher_info['l_name']; ?></td>
                        <td colspan="2">Signature: </td>
  										</tr>
                      <tr>
                        <td colspan="5">Student Name: <?php echo $student['l_name'].", ".$student['f_name']; ?></td>
                        <td colspan="3">LRN: <?php echo $student['school_id']; ?></td>
                      </tr>
  										<tr>
  											<th colspan="3" rowspan="2">LEARNING AREAS</th>
                        <th colspan="4">Quarterly Rating</th>
                        <th colspan="2" rowspan="2">FINAL RATING</th>
                        <th colspan="4" rowspan="2">REMARKS</th>
  										</tr>
                      <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                      </tr>
                      <?php
                      $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
                      $stmt = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $ee);
                        mysqli_stmt_execute($stmt);
                        $result_2 = mysqli_stmt_get_result($stmt);
                        while ($row_2 = mysqli_fetch_assoc($result_2)) {
                          $teacher_id = $row_2['teacher_id'];
                          $subject_code_check = $row_2['subject_id'];
                          $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_id;";
                          $output11 = $conn->query($checkClasses11);
                          if ($output11->num_rows > 0) {
                            $arrayClasses11 = mysqli_fetch_assoc($output11);
                            $teacher_fname = $arrayClasses11['f_name'];
                            $teacher_lname = $arrayClasses11['l_name'];
                          }else {
                            $teacher_fname = "DELETED";
                            $teacher_lname = "TEACHER";
                          }
                          //
                          $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
                          $output112 = $conn->query($checkClasses112);
                          if ($output112->num_rows > 0) {
                            $arrayClasses112 = mysqli_fetch_assoc($output112);
                            $subject_code = $arrayClasses112['subject_title'];
                          }else {
                            $subject_code = "DELETED SUBJECT";
                          }
                          $teacher_class_id = $row_2['teacher_class_id'];
                          $grade = "SELECT * FROM stu_grade where student_id = $student_id AND subject_id = $subject_code_check;";
                          $gradeoutput = $conn->query($grade);
                          if ($gradeoutput->num_rows > 0) {
                            $view_grade = mysqli_fetch_assoc($gradeoutput);
                            $one = $view_grade['first'];
                            $two = $view_grade['second'];
                            $three =  $view_grade['third'];
                            $four = $view_grade['fourth'];
                            $five = $view_grade['final'];
                          }else {
                            $one = 0;
                            $two = 0;
                            $three = 0;
                            $four = 0;
                            $five = 0;
                          }
                          ?>
                          <tr>
                            <td colspan="3"><?php echo  $subject_code;?></td>
                            <td><?php echo $one; ?></td>
                            <td><?php echo $two; ?></td>
                            <td><?php echo $three;?></td>
                            <td><?php echo $four; ?></td>
                            <td colspan="2"><?php echo $five; ?></td>
                            <?php if ($five >= 75) {
                              $remarks = "Passed";
                            }else {
                              $remarks = "Failed";
                            } ?>
                            <td colspan="4"><?php echo $remarks; ?></td>
                          </tr>
                          <?php
                        }
          }elseif($student['nine'] > 0) {
            //searching for class_name of class_id
            $id_search = $student['nine'];
            $sql55 = "SELECT * FROM class where class_id = $id_search;";
            $classN10 = $conn->query($sql55);
            $class_info10 = mysqli_fetch_assoc($classN10);
            //searching for advisory of class_id
            $sql555 = "SELECT * FROM advisory where class_id = $id_search;";
            $classN101 = $conn->query($sql555);
            $class_info11 = mysqli_fetch_assoc($classN101);
            $teach_id = $class_info11['teacher_id'];
            //searching for advisory of class_id
            $sql555 = "SELECT * FROM teachers where teacher_id = $teach_id;";
            $classN101 = $conn->query($sql555);
            $teacher_name = mysqli_fetch_assoc($classN101);
            ?>
            <tr>
            </tr>
            <tr>
              <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
            </tr>
                      <tr>
                        <td colspan="4">School: Sto. Cristo Integrated School</td>
                        <td colspan="3">School ID: 500557</td>
                        <td colspan="4">District: Tarlac Central District-A</td>
                        <td colspan="3">Division: Tarlac City</td>
                        <td colspan="3">Region: III</td>
                      </tr>
                      <tr>
                        <td colspan="3">Classified as Grade: <?php echo $class_info10['grade']; ?> </td>
                        <td colspan="3">Section: <?php echo $class_info10['section_code']; ?></td>
                        <td colspan="3">School Year: <?php echo $school_year; ?> </td>
                        <td colspan="5">Name of Adviser/Teacher: <?php echo $teacher_name['f_name']." ".$teacher_name['l_name']; ?></td>
                        <td colspan="2">Signature: </td>
                      </tr>
                      <tr>
                        <td colspan="5">Student Name: <?php echo $student['l_name'].", ".$student['f_name']; ?></td>
                        <td colspan="3">LRN: <?php echo $student['school_id']; ?></td>
                      </tr>
                      <tr>
                        <th colspan="3" rowspan="2">LEARNING AREAS</th>
                        <th colspan="4">Quarterly Rating</th>
                        <th colspan="2" rowspan="2">FINAL RATING</th>
                        <th colspan="4" rowspan="2">REMARKS</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                      </tr>
                      <?php
                      $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
                      $stmt = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $class_info10['class_id']);
                        mysqli_stmt_execute($stmt);
                        $result_2 = mysqli_stmt_get_result($stmt);
                        while ($row_2 = mysqli_fetch_assoc($result_2)) {
                          $teacher_id = $row_2['teacher_id'];
                          $subject_code_check = $row_2['subject_id'];
                          $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_id;";
                          $output11 = $conn->query($checkClasses11);
                          if ($output11->num_rows > 0) {
                            $arrayClasses11 = mysqli_fetch_assoc($output11);
                            $teacher_fname = $arrayClasses11['f_name'];
                            $teacher_lname = $arrayClasses11['l_name'];
                          }else {
                            $teacher_fname = "DELETED";
                            $teacher_lname = "TEACHER";
                          }
                          //
                          $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
                          $output112 = $conn->query($checkClasses112);
                          if ($output112->num_rows > 0) {
                            $arrayClasses112 = mysqli_fetch_assoc($output112);
                            $subject_code = $arrayClasses112['subject_title'];
                          }else {
                            $subject_code = "DELETED SUBJECT";
                          }
                          $teacher_class_id = $row_2['teacher_class_id'];
                          $grade = "SELECT * FROM stu_grade where student_id = $student_id AND subject_id = $subject_code_check;";
                          $gradeoutput = $conn->query($grade);
                          if ($gradeoutput->num_rows > 0) {
                            $view_grade = mysqli_fetch_assoc($gradeoutput);
                            $one = $view_grade['first'];
                            $two = $view_grade['second'];
                            $three =  $view_grade['third'];
                            $four = $view_grade['fourth'];
                            $five = $view_grade['final'];
                          }else {
                            $one = 0;
                            $two = 0;
                            $three = 0;
                            $four = 0;
                            $five = 0;
                          }
                          ?>
                          <tr>
                            <td colspan="3"><?php echo  $subject_code;?></td>
                            <td><?php echo $one; ?></td>
                            <td><?php echo $two; ?></td>
                            <td><?php echo $three;?></td>
                            <td><?php echo $four; ?></td>
                            <td colspan="2"><?php echo $five; ?></td>
                            <?php if ($five >= 75) {
                              $remarks = "Passed";
                            }else {
                              $remarks = "Failed";
                            } ?>
                            <td colspan="4"><?php echo $remarks; ?></td>
                          </tr>
                          <?php
                        }
            }else {
              ?>
              <tr>
              </tr>
              <tr>
                <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
              </tr>
              <tr>
                <td colspan="4">School: Sto. Cristo Integrated School</td>
                <td colspan="3">School ID: 500557</td>
                <td colspan="4">District: Tarlac Central District-A</td>
                <td colspan="3">Division: Tarlac City</td>
                <td colspan="3">Region: III</td>
              </tr>
              <tr>
                <td colspan="3">Classified as Grade: 9 </td>
                <td colspan="3">Section: </td>
                <td colspan="3">School Year: <?php echo $school_year; ?> </td>
                <td colspan="5">Name of Adviser/Teacher: </td>
                <td colspan="2">Signature: </td>
              </tr>
              <tr>
                <td colspan="5">Student Name: </td>
                <td colspan="3">LRN: </td>
              </tr>
              <tr>
                <th colspan="3" rowspan="2">LEARNING AREAS</th>
                <th colspan="4">Quarterly Rating</th>
                <th colspan="2" rowspan="2">FINAL RATING</th>
                <th colspan="4" rowspan="2">REMARKS</th>
              </tr>
              <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
              <?php
            }
            if ($class_info['grade'] == 10) {
              ?>
                <tr>
                </tr>
                <tr>
                  <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
                </tr>
    										<tr>
    											<td colspan="4">School: Sto. Cristo Integrated School</td>
    											<td colspan="3">School ID: 500557</td>
                          <td colspan="4">District: Tarlac Central District-A</td>
                          <td colspan="3">Division: Tarlac City</td>
                          <td colspan="3">Region: III</td>
    										</tr>
    										<tr>
                          <td colspan="3">Classified as Grade: <?php echo $class_info['grade']; ?> </td>
    											<td colspan="3">Section: <?php echo $class_info['section_code']; ?></td>
    											<td colspan="3">School Year: <?php echo $school_year; ?> </td>
                          <td colspan="5">Name of Adviser/Teacher: <?php echo $teacher_info['f_name']." ".$teacher_info['l_name']; ?></td>
                          <td colspan="2">Signature: </td>
    										</tr>
                        <tr>
                          <td colspan="5">Student Name: <?php echo $student['l_name'].", ".$student['f_name']; ?></td>
                          <td colspan="3">LRN: <?php echo $student['school_id']; ?></td>
                        </tr>
    										<tr>
    											<th colspan="3" rowspan="2">LEARNING AREAS</th>
                          <th colspan="4">Quarterly Rating</th>
                          <th colspan="2" rowspan="2">FINAL RATING</th>
                          <th colspan="4" rowspan="2">REMARKS</th>
    										</tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
                        $stmt = mysqli_stmt_init($conn);
                          mysqli_stmt_prepare($stmt, $sql);
                          mysqli_stmt_bind_param($stmt, "i", $ee);
                          mysqli_stmt_execute($stmt);
                          $result_2 = mysqli_stmt_get_result($stmt);
                          while ($row_2 = mysqli_fetch_assoc($result_2)) {
                            $teacher_id = $row_2['teacher_id'];
                            $subject_code_check = $row_2['subject_id'];
                            $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_id;";
                            $output11 = $conn->query($checkClasses11);
                            if ($output11->num_rows > 0) {
                              $arrayClasses11 = mysqli_fetch_assoc($output11);
                              $teacher_fname = $arrayClasses11['f_name'];
                              $teacher_lname = $arrayClasses11['l_name'];
                            }else {
                              $teacher_fname = "DELETED";
                              $teacher_lname = "TEACHER";
                            }
                            //
                            $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
                            $output112 = $conn->query($checkClasses112);
                            if ($output112->num_rows > 0) {
                              $arrayClasses112 = mysqli_fetch_assoc($output112);
                              $subject_code = $arrayClasses112['subject_title'];
                            }else {
                              $subject_code = "DELETED SUBJECT";
                            }
                            $teacher_class_id = $row_2['teacher_class_id'];
                            $grade = "SELECT * FROM stu_grade where student_id = $student_id AND subject_id = $subject_code_check;";
                            $gradeoutput = $conn->query($grade);
                            if ($gradeoutput->num_rows > 0) {
                              $view_grade = mysqli_fetch_assoc($gradeoutput);
                              $one = $view_grade['first'];
                              $two = $view_grade['second'];
                              $three =  $view_grade['third'];
                              $four = $view_grade['fourth'];
                              $five = $view_grade['final'];
                            }else {
                              $one = 0;
                              $two = 0;
                              $three = 0;
                              $four = 0;
                              $five = 0;
                            }
                            ?>
                            <tr>
                              <td colspan="3"><?php echo  $subject_code;?></td>
                              <td><?php echo $one; ?></td>
                              <td><?php echo $two; ?></td>
                              <td><?php echo $three;?></td>
                              <td><?php echo $four; ?></td>
                              <td colspan="2"><?php echo $five; ?></td>
                              <?php if ($five >= 75) {
                                $remarks = "Passed";
                              }else {
                                $remarks = "Failed";
                              } ?>
                              <td colspan="4"><?php echo $remarks; ?></td>
                            </tr>
                            <?php
                          }
            }elseif($student['ten'] > 0) {
              //searching for class_name of class_id
              $id_search = $student['ten'];
              $sql55 = "SELECT * FROM class where class_id = $id_search;";
              $classN10 = $conn->query($sql55);
              $class_info10 = mysqli_fetch_assoc($classN10);
              //searching for advisory of class_id
              $sql555 = "SELECT * FROM advisory where class_id = $id_search;";
              $classN101 = $conn->query($sql555);
              $class_info11 = mysqli_fetch_assoc($classN101);
              $teach_id = $class_info11['teacher_id'];
              //searching for advisory of class_id
              $sql555 = "SELECT * FROM teachers where teacher_id = $teach_id;";
              $classN101 = $conn->query($sql555);
              $teacher_name = mysqli_fetch_assoc($classN101);
              ?>
              <tr>
              </tr>
              <tr>
                <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
              </tr>
                        <tr>
                          <td colspan="4">School: Sto. Cristo Integrated School</td>
                          <td colspan="3">School ID: 500557</td>
                          <td colspan="4">District: Tarlac Central District-A</td>
                          <td colspan="3">Division: Tarlac City</td>
                          <td colspan="3">Region: III</td>
                        </tr>
                        <tr>
                          <td colspan="3">Classified as Grade: <?php echo $class_info10['grade']; ?> </td>
                          <td colspan="3">Section: <?php echo $class_info10['section_code']; ?></td>
                          <td colspan="3">School Year: <?php echo $school_year; ?> </td>
                          <td colspan="5">Name of Adviser/Teacher: <?php echo $teacher_name['f_name']." ".$teacher_name['l_name']; ?></td>
                          <td colspan="2">Signature: </td>
                        </tr>
                        <tr>
                          <td colspan="5">Student Name: <?php echo $student['l_name'].", ".$student['f_name']; ?></td>
                          <td colspan="3">LRN: <?php echo $student['school_id']; ?></td>
                        </tr>
                        <tr>
                          <th colspan="3" rowspan="2">LEARNING AREAS</th>
                          <th colspan="4">Quarterly Rating</th>
                          <th colspan="2" rowspan="2">FINAL RATING</th>
                          <th colspan="4" rowspan="2">REMARKS</th>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
                        $stmt = mysqli_stmt_init($conn);
                          mysqli_stmt_prepare($stmt, $sql);
                          mysqli_stmt_bind_param($stmt, "i", $class_info10['class_id']);
                          mysqli_stmt_execute($stmt);
                          $result_2 = mysqli_stmt_get_result($stmt);
                          while ($row_2 = mysqli_fetch_assoc($result_2)) {
                            $teacher_id = $row_2['teacher_id'];
                            $subject_code_check = $row_2['subject_id'];
                            $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_id;";
                            $output11 = $conn->query($checkClasses11);
                            if ($output11->num_rows > 0) {
                              $arrayClasses11 = mysqli_fetch_assoc($output11);
                              $teacher_fname = $arrayClasses11['f_name'];
                              $teacher_lname = $arrayClasses11['l_name'];
                            }else {
                              $teacher_fname = "DELETED";
                              $teacher_lname = "TEACHER";
                            }
                            //
                            $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
                            $output112 = $conn->query($checkClasses112);
                            if ($output112->num_rows > 0) {
                              $arrayClasses112 = mysqli_fetch_assoc($output112);
                              $subject_code = $arrayClasses112['subject_title'];
                            }else {
                              $subject_code = "DELETED SUBJECT";
                            }
                            $teacher_class_id = $row_2['teacher_class_id'];
                            $grade = "SELECT * FROM stu_grade where student_id = $student_id AND subject_id = $subject_code_check;";
                            $gradeoutput = $conn->query($grade);
                            if ($gradeoutput->num_rows > 0) {
                              $view_grade = mysqli_fetch_assoc($gradeoutput);
                              $one = $view_grade['first'];
                              $two = $view_grade['second'];
                              $three =  $view_grade['third'];
                              $four = $view_grade['fourth'];
                              $five = $view_grade['final'];
                            }else {
                              $one = 0;
                              $two = 0;
                              $three = 0;
                              $four = 0;
                              $five = 0;
                            }
                            ?>
                            <tr>
                              <td colspan="3"><?php echo  $subject_code;?></td>
                              <td><?php echo $one; ?></td>
                              <td><?php echo $two; ?></td>
                              <td><?php echo $three;?></td>
                              <td><?php echo $four; ?></td>
                              <td colspan="2"><?php echo $five; ?></td>
                              <?php if ($five >= 75) {
                                $remarks = "Passed";
                              }else {
                                $remarks = "Failed";
                              } ?>
                              <td colspan="4"><?php echo $remarks; ?></td>
                            </tr>
                            <?php
                          }
            }else {
              ?>
              <tr>
              </tr>
              <tr>
                <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
              </tr>
              <tr>
                <td colspan="4">School: Sto. Cristo Integrated School</td>
                <td colspan="3">School ID: 500557</td>
                <td colspan="4">District: Tarlac Central District-A</td>
                <td colspan="3">Division: Tarlac City</td>
                <td colspan="3">Region: III</td>
              </tr>
              <tr>
                <td colspan="3">Classified as Grade: 10 </td>
                <td colspan="3">Section: </td>
                <td colspan="3">School Year: <?php echo $school_year; ?> </td>
                <td colspan="5">Name of Adviser/Teacher: </td>
                <td colspan="2">Signature: </td>
              </tr>
              <tr>
                <td colspan="5">Student Name: </td>
                <td colspan="3">LRN: </td>
              </tr>
              <tr>
                <th colspan="3" rowspan="2">LEARNING AREAS</th>
                <th colspan="4">Quarterly Rating</th>
                <th colspan="2" rowspan="2">FINAL RATING</th>
                <th colspan="4" rowspan="2">REMARKS</th>
              </tr>
              <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                </tr>
              <?php
            }
          ?>
          <tr>
          </tr>
          <tr>
            <td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
          </tr>
        </table>
</body>
</html>
<script type="text/javascript">
function html_table_to_excel(type)
  {
      var data = document.getElementById('employee_data');

      var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

      XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

      XLSX.writeFile(file, 'SF10.' + type);
  }

      html_table_to_excel('csv');
      window.location.href = "advisory_view.php?class_id=<?php echo $ee; ?>";
</script>

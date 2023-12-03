<?php
require_once 'includes_classes_id_check.php';
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
//Teacher_name
$sql = "SELECT * FROM teachers WHERE teacher_id =?;";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $csv_teacher_id2);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$teacher_info = mysqli_fetch_assoc($result);
//Section name
$sql = "SELECT * FROM class WHERE class_id =?;";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $csv_class_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$class_info = mysqli_fetch_assoc($result);
//Subject name
$sql = "SELECT * FROM subjects WHERE subject_id =?;";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $csv_subject_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$subject_info = mysqli_fetch_assoc($result);
//students
$sql = "SELECT * FROM student WHERE class_id =? ORDER BY l_name ASC;";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $csv_class_id);
mysqli_stmt_execute($stmt);
$students = mysqli_stmt_get_result($stmt);
$student_sum = $students->num_rows;
//exams
$sql = "SELECT * FROM exam WHERE teacher_class_id =?;";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$exams = mysqli_stmt_get_result($stmt);
$exam_sum = $exams->num_rows;
//quizzes
$sql = "SELECT * FROM quiz WHERE teacher_class_id =?;";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$quizzes = mysqli_stmt_get_result($stmt);
$quiz_sum = $quizzes->num_rows;
//Assignments
$sql = "SELECT * FROM teacher_assignments WHERE teacher_class_id =?;";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$assignments = mysqli_stmt_get_result($stmt);
$ass_sum = $assignments->num_rows;
 ?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>
    			<table id="employee_data" class="table table-striped table-bordered">
										<tr>
											<td colspan="2">Region: III</td>
											<td colspan="2">Division: Tarlac City</td>
											<td colspan="4">District: Tarlac Central District-A</td>
										</tr>
										<tr>
											<td colspan="4">School Name: Sto. Cristo Integrated School</td>
											<td colspan="3">School ID: 500557</td>
										</tr>
										<tr>
											<td colspan="4">Grade & Section: <?php echo $class_info['grade']." ".$class_info['section_code']; ?></td>
											<td colspan="3">School Year: <?php echo $school_year; ?> </td>
										</tr>
										<tr>
											<td colspan="4">Teacher: <?php echo $teacher_info['f_name']." ".$teacher_info['l_name']; ?></td>
											<td colspan="3">Subject: <?php echo $subject_info['subject_code']; ?> </td>
										</tr>
										<tr>
											<th colspan="4" rowspan="2">LEARNERS' NAMES</th>
											<th colspan="<?php echo $exam_sum+1; ?>" rowspan="2">EXAMS</th>
											<th colspan="<?php echo $quiz_sum+1; ?>" rowspan="2">QUIZZES</th>
											<th colspan="<?php echo $ass_sum+1; ?>" rowspan="2">ASSIGNMENTS</th>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="4"></td>
											<?php
											$e = 0;
											while ($e < $exam_sum) {
												$e++;
												?>
												<td><?php echo $e; ?></td>
												<?php
											}
											 ?>
											<td>Total</td>
											<?php
											$q = 0;
											while ($q < $quiz_sum) {
												$q++;
												?>
												<td><?php echo $q; ?></td>
												<?php
											}
											 ?>
											<td>Total</td>
											<?php
											$a = 0;
											while ($a < $ass_sum) {
												$a++;
												?>
												<td><?php echo $a; ?></td>
												<?php
											}
											 ?>
											<td>Total</td>
										</tr>

										<tr>
											<td></td>
											<td colspan="3">Highest Possible Score</td>
											<?php
											$total_exam = 0;
											while ($exam_2 = mysqli_fetch_assoc($exams)) {
												$exam_id = $exam_2['exam_id'];
												$exam_points = 0;
					              $points_search_exam = "SELECT points_1, points_2, points_3, points_4, points_5 FROM exam_question where exam_id = $exam_id;";
					              $result_points_exam = $conn->query($points_search_exam);
					              while($loop_exam = mysqli_fetch_assoc($result_points_exam))
					              {
					                 $sum = $loop_exam['points_1']+$loop_exam['points_2']+$loop_exam['points_3']+$loop_exam['points_4']+$loop_exam['points_5'];
					                 $exam_points += $sum;
					              }
												?>
												<td><?php echo $exam_points; ?></td>
												<?php
												$total_exam += $exam_points;
											}
											 ?>
											<td><?php echo $total_exam; ?></td>
											<?php
											$total_quiz = 0;
											while ($quiz_2 = mysqli_fetch_assoc($quizzes)) {
												$quiz_id = $quiz_2['quiz_id'];
												$quiz_points = 0;
												$points_search_quiz = "SELECT points_1, points_2, points_3, points_4, points_5 FROM quiz_question where quiz_id = $quiz_id;";
												$result_points_quiz = $conn->query($points_search_quiz);
												while($loop_quiz = mysqli_fetch_assoc($result_points_quiz))
												{
													 $sum = $loop_quiz['points_1']+$loop_quiz['points_2']+$loop_quiz['points_3']+$loop_quiz['points_4']+$loop_quiz['points_5'];
													 $quiz_points += $sum;
												}
												?>
												<td><?php echo $quiz_points; ?></td>
												<?php
												$total_quiz += $quiz_points;
											}
											 ?>
											<td><?php echo $total_quiz; ?></td>
											<?php
											$total_ass = 0;
											while ($ass_2 = mysqli_fetch_assoc($assignments)) {
												?>
												<td><?php echo $ass_2['max_score']; ?></td>
												<?php
												$total_ass += $ass_2['max_score'];
											}
											 ?>
											<td><?php echo $total_ass; ?></td>
										</tr>
										<?php
										$numbered = 1;
										while ($student_name = mysqli_fetch_assoc($students)) {
											$student_id = $student_name['student_id'];
											$exam_student = 0;
											$quiz_student = 0;
											$ass_student = 0;
											$exams->data_seek(0);
											$quizzes->data_seek(0);
											$assignments->data_seek(0);
											?>
										<tr>
											<td colspan="4"><?php echo $numbered.". ".$student_name['l_name']." ".$student_name['f_name']; ?></td>
											<?php
											$total_exam = 0;
											while ($exam_3 = mysqli_fetch_assoc($exams)) {
												$exam_id = $exam_3['exam_id'];
												$exam_points = 0;
					              $points_search_exam = "SELECT * FROM student_exam_answer where exam_id = $exam_id AND student_id = $student_id;";
					              $result_points_exam = $conn->query($points_search_exam);
					              while($loop_exam = mysqli_fetch_assoc($result_points_exam))
					              {
					                 $sum = $loop_exam['essay_score']+$loop_exam['score'];
					                 $exam_points += $sum;
					              }
												?>
												<td><?php echo $exam_points; ?></td>
												<?php
												$total_exam += $exam_points;
											}
											 ?>
											 <td><?php echo $total_exam; ?></td>
											 <?php
 											$total_quiz = 0;
 											while ($quiz_3 = mysqli_fetch_assoc($quizzes)) {
 												$quiz_id = $quiz_3['quiz_id'];
 												$quiz_points = 0;
 												$points_search_quiz = "SELECT * FROM student_quiz where quiz_id = $quiz_id AND student_id = $student_id;";
 												$result_points_quiz = $conn->query($points_search_quiz);
 												while($loop_quiz = mysqli_fetch_assoc($result_points_quiz))
 												{
 													 $sum = $loop_quiz['total_score'];
 													 $quiz_points += $sum;
 												}
 												?>
 												<td><?php echo $quiz_points; ?></td>
 												<?php
 												$total_quiz += $quiz_points;
 											}
 											 ?>
 											<td><?php echo $total_quiz; ?></td>
											<?php
											$total_ass = 0;
											while ($ass_3 = mysqli_fetch_assoc($assignments)) {
												$ass_id = $ass_3['teacher_assignment_id'];
 												$ass_points = 0;
 												$points_search_ass = "SELECT * FROM student_assignment where teacher_assignment_id = $ass_id AND student_id = $student_id;";
 												$result_points_ass = $conn->query($points_search_ass);
 												while($loop_ass = mysqli_fetch_assoc($result_points_ass))
 												{
 													 $sum = $loop_ass['score'];
 													 $ass_points += $sum;
 												}
 												?>
 												<td><?php echo $ass_points; ?></td>
 												<?php
 												$total_ass += $ass_points;
											}
											 ?>
											<td><?php echo $total_ass; ?></td>
										</tr>
											<?php
											$numbered++;
										}
										 ?>
                </table>
</body>
</html>
<script type="text/javascript">
function html_table_to_excel(type)
  {
      var data = document.getElementById('employee_data');

      var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

      XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

      XLSX.writeFile(file, 'Class_record.' + type);
  }

      html_table_to_excel('csv');
      window.location.href = "teacher_class.php";
</script>

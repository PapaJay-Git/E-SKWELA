
<?php
require_once 'includes_header.php';
require_once 'includes_exam_id_check.php';
require_once 'includes_side_nav.php';
$ee = $row['class_id'];
$ee2 = $row['subject_id'];
$session = $_SESSION['student_session_id'];
$id = $_GET['tc_id'];
//searching for class_name of class_id
$sql5 = "SELECT class_name FROM class where class_id = $ee;";
$classN = $conn->query($sql5);
$classN2 = mysqli_fetch_assoc($classN);
//searhing for subject_code of subject_id
$sql33 = "SELECT subject_code FROM subjects where subject_id = $ee2;";
$classNN = $conn->query($sql33);
$classNN2 = mysqli_fetch_assoc($classNN);

 ?>
 <div class="container-xxl">
 <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>
      <h1 class="card-title"><?php echo $classNN2['subject_code']." - EXAMS";?></h1>
          <hr size="4" width="100%" color="grey">
    <div class="col-md-10">
      <h5></h5>
    </div>
        <a type="button" style="float:right; width: 100px;" href="exam.php" class="btn btn-primary">BACK</a>

   <div class="card" style="margin-top: 70px;">
    <div class="card-header" style="color: black;">
      My Exams
    </div>
    <div class="card-body"><!-- BODY-->
       <div class="row">
        <div class="table-responsive">
         <table id="classdata" class="table table-hover table-xxlg table-bordered">
            <caption><?php echo $row_includes['f_name']." ".$row_includes['l_name']."'s exams"; ?></caption>
             <thead>
              <tr>
               <th> ID </th>
               <th> Title</th>
               <th> Start</th>
               <th> Deadline</th>
               <th> Attempt</th>
               <th> Timer</th>
               <th> Essay</th>
               <th> Non-Essay</th>
               <th> Action</th>
              </tr>
              </thead>
<?php
//check if there is modules/files available for tc_id and the teacher
$sql = "SELECT * FROM exam WHERE teacher_class_id =? AND class_id =? AND published =?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['error'] = "SQL eerror";
        header("location: exam.php?tc_id=$tcid&sql=error");
        exit();
  }
    $published = 1;
      mysqli_stmt_bind_param($stmt, "iii", $id, $ee, $published);
      if(!mysqli_stmt_execute($stmt)){
        $_SESSION['error'] = "Problem viewing exams";
        header("location: exam.php?tc_id=$tcid&sql=error");
        exit();
      }
      $result = mysqli_stmt_get_result($stmt);
      while($rowExam = mysqli_fetch_assoc($result)){
    $timestamp = strtotime($rowExam['deadline_date']); $today = date("F j, g:i a", $timestamp);
    $timestamp2 = strtotime($rowExam['start_date']); $today2 = date("F j, g:i a", $timestamp2);
    $exam_id_for_search = $rowExam['exam_id'];
    $one = 5;
    $query = "SELECT * FROM exam_question where exam_id = ? AND exam_type_id != ?;";
    $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)) {
            $_SESSION['error'] = "SQL ereeor";
            header("location: exam.php?tc_id=$tcid&sql=error");
            exit();
      }
          mysqli_stmt_bind_param($stmt, "ii", $exam_id_for_search, $one);
          mysqli_stmt_execute($stmt);
          $result4 = mysqli_stmt_get_result($stmt);
    $none = 0;
    while($result2 = mysqli_fetch_assoc($result4))
    {
       $sumoff = $result2['points_1']+$result2['points_2']+$result2['points_3']+$result2['points_4']+$result2['points_5'];
       $none += $sumoff;
    }
    $query = "SELECT * FROM exam_question where exam_id = ? AND exam_type_id = ?;";
    $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)) {
            $_SESSION['error'] = "SQL ereeeor";
            header("location: exam.php?tc_id=$tcid&sql=error");
            exit();
      }
          mysqli_stmt_bind_param($stmt, "ii", $exam_id_for_search, $one);
          mysqli_stmt_execute($stmt);
          $result4 = mysqli_stmt_get_result($stmt);
    $none2 = 0;
    while($result2 = mysqli_fetch_assoc($result4))
    {
       $sumoff = $result2['points_1'];
       $none2 += $sumoff;
    }
    $query11 = "SELECT * FROM student_exam_answer where exam_id = ? AND exam_type_id = ? AND student_id =?;";
    $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query11)) {
            $_SESSION['error'] = "SQL error";
            header("location: exam.php?tc_id=$tcid&sql=error");
            exit();
      }
          mysqli_stmt_bind_param($stmt, "iii", $exam_id_for_search, $one, $_SESSION['student_session_id']);
          mysqli_stmt_execute($stmt);
          $result99 = mysqli_stmt_get_result($stmt);
    $essaysum = 0;
    if ($result99->num_rows > 0) {
      while($result12= mysqli_fetch_assoc($result99))
      {
         $sumoff22 = $result12['essay_score'];
         $essaysum += $sumoff22;
      }
    }
    $query11 = "SELECT * FROM student_exam where exam_id = ? AND published=? AND student_id=?;";
    $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query11)) {
            $_SESSION['error'] = "SQL error";
            header("location: exam.php?tc_id=$tcid&sql=error");
            exit();
      }
          mysqli_stmt_bind_param($stmt, "iii", $exam_id_for_search, $published, $_SESSION['student_session_id']);
          mysqli_stmt_execute($stmt);
          $result199 = mysqli_stmt_get_result($stmt);
    $qsum = 0;
    $attempts = 0;
    if ($result199->num_rows > 0) {
      while($result22= mysqli_fetch_assoc($result199))
      {
         $sumoff221 = $result22['question_score'];
         $qsum += $sumoff221;
         $attempts = $result22['used_attempt'];
      }
    }
    $str = mb_strimwidth($rowExam['exam_title'], 0, 35, "...");
    ?>
      <tr>
        <td><?php echo $rowExam['exam_id'];?></td>
        <td><?php echo $str;?></td>
        <td><?php echo $today2; ?></td>
        <td><?php echo $today; ?></td>
        <td><?php echo $attempts."/".$rowExam['max_attempt'];?></td>
        <td><?php echo $rowExam['timer']."mins";?></td>
        <td><?php echo $essaysum."/".$none2."pts";?></td>
        <td><?php echo $qsum."/".$none."pts";?></td>
        <td><a href="exam_open.php?tc_id=<?php echo $id;?>&exam_id=<?php echo $rowExam['exam_id']; ?>" class="btn btn-primary">OPEN</a></td>
      </tr>
      <?php
        }
?>
      </table>
    </div>
</div>
</div>
</div>
</div>
<script>
$(document).ready(function() {
    $('#classdata').DataTable( {
      dom: 'Blfrtip',
      "order": [[ 0, "desc" ]],
      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
       buttons: ['copy',
       {
         extend: 'print',
         title: 'My Exams id:<?php $rand = substr(uniqid('', true), -5); echo $rand?>'
       }]
  } );
} );
 </script>
<?php
  require_once 'includes_footer.php';

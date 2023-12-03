<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_assignment_id_check.php';
  require_once 'includes_assignment_id_val.php';
  require_once 'includes_assignment_student_id.php';
  //timezone
  $ee = $row['class_id'];
  $ee2 = $row['subject_id'];
  //searching for class_name of class_id
  $sql5 = "SELECT class_name FROM class where class_id = $ee;";
  $classN = $conn->query($sql5);
  $classN2 = mysqli_fetch_assoc($classN);
  //searhing for subject_code of subject_id
  $sql33 = "SELECT subject_code FROM subjects where subject_id = $ee2;";
  $classNN = $conn->query($sql33);
  $classNN2 = mysqli_fetch_assoc($classNN);
  $sqlasstype = "SELECT * FROM ass_type";
  $assTypes = $conn->query($sqlasstype);
  $ass_id = $_GET['ass_id'];
  $tc_id = $_GET['tc_id'];
  $student_id = $_GET['student_id'];
  $type = 5;
  $sql = "SELECT * FROM student where student_id =?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: assignment_submissions.php?tc_id=$tc_id&ass_id=$ass_id&view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "i", $student_id);
      mysqli_stmt_execute($stmt);
      $result6 = mysqli_stmt_get_result($stmt);
      $student_name = mysqli_fetch_assoc($result6)
      ?>
      <div class="container-xxl">
        <h2 style="margin-top:40px; margin-bottom:20px" class="head">Student Submission</h2>
        <hr size="4" width="100%" color="grey">
        <h4>Student Name: <?php echo $student_name['f_name']." ".$student_name['l_name'] ?></h4>
<div id="essay" style="display:block;">
  <form onsubmit="return clicked()" id="update_answer_form" action="assignment_save_grade.php?tc_id=<?php echo $tc_id; ?>&ass_id=<?php echo $ass_id; ?>&student_id=<?php echo $student_id; ?>&view=failed" method="post">
    <?php
//check if there is modules/files available for tc_id and the teacher
$sql5 = "SELECT * FROM student_assignment where teacher_assignment_id=? AND student_id =? AND teacher_id=?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql5)) {
    echo "string";
    header("location: assignment_submissions.php?tc_id=$tc_id&ass_id=$ass_id&view=failed");
    exit();
  }
    mysqli_stmt_bind_param($stmt, "iii", $ass_id, $student_id, $_SESSION['teacher_session_id']);
    mysqli_stmt_execute($stmt);
    $result51 = mysqli_stmt_get_result($stmt);
  if ($result51->num_rows > 0) {
   while ($student_answers2 = mysqli_fetch_assoc($result51)) {
                 ?>
                 <div class="card shadow-sm" style="margin-top:10px;">
                   <div class="card-header bg-transparent border-0">
                     <h4 class="mb-0">Assignment</h4>
                   </div>
                   <div class="card-body pt-0">
                     <table class="table table-bordered">
                       <tr>
                         <th width="100%">Student's given answer</th>
                       </tr>
                       <tr>
                         <td>
                           <div class="form-group">
                             <?php echo $student_answers2['submission_text'];?>
                           </div>
                       </td>
                       </tr>
                       <tr>
                         <th width="100%">Student's submitted file</th>
                       </tr>
                       <tr>
                         <td>
                           <div class="form-group">
                             <?php if ($student_answers2['submission_file'] == NULL || $student_answers2['submission_file'] == "") {
                               echo "No file submitted. Check the submitted text.";
                             }else {
                                ?>
                                <a style="width: 130px;" href="assignment_download_student_file.php?tc_id=<?php echo $tc_id.'&ass_id='.$student_answers2['teacher_assignment_id'].'&student_id='.$student_answers2['student_id']; ?>" class="btn btn-primary" >DOWNLOAD</a>
                               <?php
                             }?>
                           </div>
                       </td>
                       </tr>
                       <tr>
                         <th width="100%">Teacher's given score</th>
                       </tr>
                       <tr>
                         <td>
                           <div class="form-group">
                             <small>Max score:<?php echo $student_answers2['max_score']; ?></small><br>
                             <input type="hidden" name="student_assignment_id" value="<?php echo $student_answers2['student_assignment_id'];?>">
                             <input type="number" class="form-control"min="0" max="<?php echo $student_answers2['max_score']; ?>"name="score" value="<?php echo $student_answers2['score']; ?>">
                           </div>
                       </td>
                       </tr>
                     </table>
                   </div>
                 </div>
             <div class="row">
               <div class="col-md-8"><h5> </h5></div>
               <div class="col-md-4 btn-group" role="group" style=" margin-top: 20px;">
                 <input type="submit" style="width: 120px; float:right;"class="btn btn-primary" value="SAVE GRADE">
                 <input type="hidden" name="save_ass" value="SAVE GRADE">
                 <a href="assignment_submissions.php?tc_id=<?php echo $tc_id.'&ass_id='.$student_answers2['teacher_assignment_id'];?>" class="btn btn-danger" >BACK</a>
               </div>
             </div>
             <?php
            }
  } else if($result51->num_rows == 0){
    echo "No Submissions Found.";
  }
?>
</form>
</div>
   </div>
   <script type="text/javascript">
   function clicked() {
    swal.fire({
      title: "Are you sure?",
      text: "You are about to grade the assignment submission of this student. Are you sure you want to do that?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Save grade"
    }).then(function (result){
      if (result.isConfirmed) {
            document.getElementById("update_answer_form").submit();
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Save Cancelled', showConfirmButton: false, timer: 1500})
          }
      })
   return false;
   }
   </script>
<?php
require_once 'includes_footer.php';

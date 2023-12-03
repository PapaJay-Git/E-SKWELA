<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_exam_id_check.php';
  require_once 'includes_exam_id_val.php';
  require_once 'includes_exam_student_id.php';
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
  $sqlExamtype = "SELECT * FROM exam_type";
  $examTypes = $conn->query($sqlExamtype);
  $id = $_GET['tc_id'];
  $exam_id = $_GET['exam_id'];
  $tc_id = $_GET['tc_id'];
  $student_id = $_GET['student_id'];
  $type = 5;
  $sql = "SELECT * FROM student where student_id =?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: exam_submissions.php?tc_id=$tc_id&exam_id=$exam_id&view=failed");
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
        <div class="row">
          <div class="col-md-8"><h5> </h5></div>
          <div class="col-md-4 btn-group" role="group">
            <input type="button"  style="width: 100px;"class="btn btn-primary" onclick="showEssay()" value="Essay">
            <input type="button"  style="width: 100px;" class="btn btn-primary" onclick="showQuestions()" value="Non-Essay">
            <a href="exam_submissions.php?tc_id=<?php echo $tc_id; ?>&exam_id=<?php echo $exam_id; ?>" class="btn btn-danger" >BACK</a>
          </div>
        </div>
  <div id="question" style="display:none;">
      <?php
  //check if there is modules/files available for tc_id and the teacher
  $sql = "SELECT * FROM student_exam_answer where exam_id=? AND student_id =? AND exam_type_id != ?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      echo "string";
      header("location: exam_submissions.php?tc_id=$tc_id&exam_id=$exam_id&view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "iii", $exam_id, $student_id, $type);
      mysqli_stmt_execute($stmt);
      $result5 = mysqli_stmt_get_result($stmt);
    if ($result5->num_rows > 0) {
      $numbered = 1;
     while ($student_answers = mysqli_fetch_assoc($result5)) {
       $question_id = $student_answers['exam_question_id'];
       $q1 = "SELECT * FROM exam_question where exam_question_id = $question_id;";
       $q2 = $conn->query($q1);
       $q3 = mysqli_fetch_assoc($q2);
       if ($q3 == NULL || $q3 =="") {
         $sum = "Deleted Question";
         $question_text = "Question has been Deleted after the student answered. Student scored ".$student_answers['score']." in this question.";
         $multiple = "Deleted Answer";
         $a1 = "Deleted Answer";
         $a2 = "Deleted Answer";
         $a3 = "Deleted Answer";
         $a4 = "Deleted Answer";
         $a5 = "Deleted Answer";
       }else {
          $sum1 = $q3['points_1']+$q3['points_2']+$q3['points_3']+$q3['points_4']+$q3['points_5'];
          $sum = $student_answers['score']."/".$sum1." points";
          $question_text = $q3['exam_question_txt'];
          $a1 = "Right Answer: ".$q3['answer_1'];
          $a2 = "Right Answer: ".$q3['answer_a_2'];
          $a3 = "Right Answer: ".$q3['answer_b_3'];
          $a4 = "Right Answer: ".$q3['answer_c_4'];
          $a5 = "Right Answer: ".$q3['answer_d_5'];
       }

               if($student_answers['exam_type_id'] == 1){
                 ?>
                     <div class="card shadow-sm" style="margin-top:10px;" id="" >
                       <div class="card-header bg-transparent border-0">
                          <small style="float:right;"><?php echo $sum; ?></small>
                         <h4 class="mb-0"><?php echo $numbered.". "; ?>True or False</h4>
                       </div>
                       <div class="card-body pt-0">
                         <table class="table table-bordered">
                           <tr>
                             <th width="30%">Question</th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                 <?php echo $question_text;?>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="30%"><?php echo $a1; ?></th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                 <?php echo "Student Answer: ".$student_answers['answer_1'];?>
                               </div>
                           </td>
                           </tr>
                         </table>
                       </div>
                     </div>
                     <?php
                 }
                 elseif ($student_answers['exam_type_id'] == 2) {
                   ?>
                   <div class="card shadow-sm" style="margin-top:10px;" id="" >
                     <div class="card-header bg-transparent border-0">
                       <small style="float:right;"><?php echo $sum; ?></small>
                       <h4 class="mb-0"><?php echo $numbered.". "; ?>Multiple Choice</h4>
                     </div>
                     <div class="card-body pt-0">
                       <table class="table table-bordered">
                         <tr>
                           <th width="30%">Question</th>
                           <td width="2%">:</td>
                           <td>
                             <div class="form-group">
                               <?php echo $question_text;?>
                             </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%"><?php echo $a1;?></th>
                           <td width="2%">:</td>
                           <td>
                             <div class="form-group">
                                 <?php echo "Student Answer: ".$student_answers['answer_1']; ?>
                             </div>
                         </td>
                         </tr>
                       </table>
                     </div>
                   </div>
                   <?php
                 }
                 elseif ($student_answers['exam_type_id'] == 3) {
                   ?>
                   <div class="card shadow-sm" style="margin-top:10px;" id="" >
                     <div class="card-header bg-transparent border-0">
                       <small style="float:right;"><?php echo $sum; ?></small>
                       <h4 class="mb-0"><?php echo $numbered.". "; ?>Enumeration</h4>
                     </div>
                     <div class="card-body pt-0">
                       <table class="table table-bordered">
                         <tr>
                           <th width="30%">Question</th>
                           <td width="2%">:</td>
                           <td>
                             <div class="form-group">
                               <?php echo $question_text;?>
                             </div>
                         </td>
                         </tr>
                           <tr>
                             <th width="30%"><?php echo $a1; ?></th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                  <?php echo "Student Answer: ".$student_answers['answer_1'];?>
                               </div>
                           </td>
                           </tr>
                         <?php if ($student_answers['answer_a_2'] != NULL): ?>
                           <tr>
                             <th width="30%"><?php echo $a2; ?></th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                   <?php echo "Student Answer: ".$student_answers['answer_a_2'];?>
                               </div>
                           </td>
                           </tr>
                         <?php endif; ?>
                         <?php if ($student_answers['answer_b_3'] != NULL): ?>
                           <tr>
                             <th width="30%"><?php echo $a3; ?></th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                   <?php echo "Student Answer: ".$student_answers['answer_b_3'];?>
                               </div>
                           </td>
                           </tr>
                         <?php endif; ?>
                         <?php if ($student_answers['answer_c_4'] != NULL): ?>
                           <tr>
                             <th width="30%"><?php echo $a4; ?></th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                   <?php echo "Student Answer: ".$student_answers['answer_c_4'];?>
                               </div>
                           </td>
                           </tr>
                         <?php endif; ?>
                         <?php if ($student_answers['answer_d_5'] != NULL): ?>
                           <tr>
                             <th width="30%"><?php echo $a5; ?></th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                    <?php echo "Student Answer: ".$student_answers['answer_d_5'];?>
                               </div>
                           </td>
                           </tr>
                         <?php endif; ?>
                       </table>
                     </div>
                   </div>
                   <?php
                 }
                 elseif ($student_answers['exam_type_id'] == 4) {
                   ?>
                   <div class="card shadow-sm" style="margin-top:10px;" id="" >
                     <div class="card-header bg-transparent border-0">
                       <small style="float:right;"><?php echo $sum; ?></small>
                       <h4 class="mb-0"><?php echo $numbered.". "; ?>Identification</h4>
                     </div>
                     <div class="card-body pt-0">
                       <table class="table table-bordered">
                         <tr>
                           <th width="30%">Question</th>
                           <td width="2%">:</td>
                           <td>
                             <div class="form-group">
                               <?php echo $question_text;?>
                             </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%"><?php echo $a1; ?></th>
                           <td width="2%">:</td>
                           <td>
                             <div class="form-group">
                               <?php echo "Student Answer: ".$student_answers['answer_1']; ?>
                             </div>
                         </td>
                         </tr>
                       </table>
                     </div>
                   </div>
                   <?php
                 }
                 $numbered++;
               }
    } else if($result5->num_rows == 0){
      echo "No Questionaire and Answer.";
    }
?>
</div>
<div id="essay" style="display:block;">
  <form onsubmit="return clicked()" id="update_answer_form" action="exam_essay_grade.php?tc_id=<?php echo $tc_id; ?>&exam_id=<?php echo $exam_id; ?>&student_id=<?php echo $student_id; ?>&view=failed" method="post">
    <?php
//check if there is modules/files available for tc_id and the teacher
$sql5 = "SELECT * FROM student_exam_answer where exam_id=? AND student_id =? AND exam_type_id = ?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql5)) {
    echo "string";
    header("location: exam_submissions.php?tc_id=$tc_id&exam_id=$exam_id&view=failed");
    exit();
  }
    mysqli_stmt_bind_param($stmt, "iii", $exam_id, $student_id, $type);
    mysqli_stmt_execute($stmt);
    $result51 = mysqli_stmt_get_result($stmt);
  if ($result51->num_rows > 0) {
    $numbered = 1;
   while ($student_answers2 = mysqli_fetch_assoc($result51)) {
     $question_id2 = $student_answers2['exam_question_id'];
     $q1 = "SELECT * FROM exam_question where exam_question_id = $question_id2;";
     $q2 = $conn->query($q1);
     $q3 = mysqli_fetch_assoc($q2);
     if ($q3 == NULL || $q3 =="") {
       $sum1 = "Deleted Question";
       $question_text = "Question has been Deleted after the student answered. Student scored ";
     }else {
        $sum1 = $q3['points_1'];
        $sum = $student_answers2['essay_score']."/".$sum1." points";
        $question_text = $q3['exam_question_txt'];
     }
               if ($student_answers2['exam_type_id'] == 5) {
                 ?>
                 <div class="card shadow-sm" style="margin-top:10px;">
                   <div class="card-header bg-transparent border-0">
                     <small style="float:right;"><?php echo $sum; ?></small>
                     <h4 class="mb-0"><?php echo $numbered.". "; ?>Essay</h4>
                   </div>
                   <div class="card-body pt-0">
                     <table class="table table-bordered">
                       <tr>
                         <th width="30%">Instruction</th>
                         <td width="2%">:</td>
                         <td>
                           <div class="form-group">
                             <?php echo $question_text;?>
                           </div>
                       </td>
                       </tr>
                       <tr>
                         <th width="30%">Student Answer</th>
                         <td width="2%">:</td>
                         <td>
                           <div class="form-group">
                             <?php echo $student_answers2['answer_1']; ?>
                           </div>
                       </td>
                       </tr>
                       <tr>
                         <th width="30%">Given Score</th>
                         <td width="2%">:</td>
                         <td>
                           <div class="form-group">
                             <input type="hidden" name="question_id[]" value="<?php echo $student_answers2['exam_question_id'];?>">
                             <input type="number" class="form-control"min="0" max="<?php echo $sum1; ?>"name="essayScore[]" value="<?php echo $student_answers2['essay_score']; ?>"
                             title="You can only grade your students based on your indicated max score on this essay!">
                           </div>
                       </td>
                       </tr>
                     </table>
                   </div>
                 </div>
                 <?php
               }
               $numbered++;
             }
             ?>
             <input type="submit" style="width: 140px; float:right; margin-top:15px; height: 50px; font-size:17px;"class="btn btn-primary" value="SAVE GRADE">
             <input type="hidden" name="save_essay"  value="SAVE GRADE">
             <?php
  } else if($result51->num_rows == 0){
    echo "No Essay Answer.";
  }
?>
</form>
</div>
   </div>
   <script>
   function clicked() {
    swal.fire({
      title: "Are you sure?",
      text: "You are about to grade the essay answers of this student. Are you sure you want to do that?",
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
   var q = document.getElementById('question');
   var e = document.getElementById('essay');
   function showEssay(){
     e.style.display = "block";
     q.style.display = "none";
   }
   function showQuestions(){
     q.style.display = "block";
     e.style.display = "none";
   }
    </script>
<?php
require_once 'includes_footer.php';

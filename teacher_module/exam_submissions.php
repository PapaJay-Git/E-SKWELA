<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_exam_id_check.php';
  require_once 'includes_exam_id_val.php';
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
  //check if there is modules/files available for tc_id and the teacher
  $sql = "SELECT * FROM student_exam where teacher_class_id =? AND teacher_id=? AND exam_id=?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: teacher_view_exam.php?tc_id=$tc_id&view=failed");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "iii", $_GET['tc_id'], $_SESSION['teacher_session_id'], $exam_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
   ?>
   <div class="container-xxl">
     <h2 style="margin-top:40px; margin-bottom:20px" class="head">EXAM SUBMISSIONS</h2>
     <hr size="4" width="100%" color="grey">
     <section>
         <div class="rt-container-xxl">
               <div class="col-rt-12">
                   <div class="Scriptcontent">

                     <div class="card shadow-sm"style="display: block;">
                       <div class="card-header bg-transparent border-0">
                         <h3 class="mb-0"> <?php echo $classNN2['subject_code']." ".$classN2['class_name']?>
                           <a style="float:right; width: 100px;"  href='teacher_view_exam.php?exam_id=<?php echo $exam_id.'&tc_id='.$id; ?>' class="btn btn-primary">BACK</a>
                         </h3>
                       </div>
                       <div class="card-body pt-0">
                         <table class="table table-bordered">
                           <tr>
                             <th width="30%">Exam Title</th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                 <textarea class="form-control" disabled><?php echo $examrow['exam_title']?></textarea>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="30%">Description</th>
                             <td width="2%">:</td>
                             <td><div class="form-group">
                               <textarea class="form-control" disabled><?php echo $examrow['exam_description']?> </textarea>
                             </div></td>
                           </tr>
                           <tr>
                             <th width="30%">Start</th>
                             <td width="2%">:</td>
                             <td><div class="form-group">
                               <?php $timestamp = strtotime($examrow['start_date']);
                               $today = date("F j, g:i a", $timestamp); ?>
                               <input class="form-control" value="<?php echo $today?> "disabled>
                             </td>
                             </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="30%">Deadline</th>
                             <td width="2%">:</td>
                             <td><div class="form-group">
                               <?php $timestamp = strtotime($examrow['deadline_date']);
                               $today = date("F j, g:i a", $timestamp); ?>
                               <input class="form-control" value="<?php echo $today?> "disabled>
                             </td>
                             </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="30%">Time Limit</th>
                             <td width="2%">:</td>
                             <td><div class="form-group">
                               <input class="form-control" value="<?php echo $examrow['timer']."mins";?> "disabled>
                             </td>
                             </div>
                           </td>
                           </tr>
                         </table>
                       </div>
                     </div>
             </div>
         </div>
         </div>
     </section>
           <div class="table-responsive" style="margin-top: 10px;">
           <table id="aexample" class="table table-hover table-xxlg table-bordered" style="width:100%">
             <thead>
              <tr>
               <th>Login ID</th>
               <th>LRN </th>
               <th>Name</th>
               <th>Attempt</th>
               <th>Submit Date</th>
              <th>Time</th>
               <th>Non-essay</th>
               <th>Essay</th>
               <th>Action</th>
              </tr>
             </thead>
           <?php
           while($row = mysqli_fetch_assoc($result)){
             if(!strtotime($row['start_time']) || !strtotime($row['submit_date'])){
               $start_time = "Unreadable Date";
            }else{
              $d1 = new DateTime($row['submit_date']);
              $d2 = new DateTime($row['start_time']);
              $interval = $d1->diff($d2);
              $diffInSeconds = $interval->s;
              $diffInMinutes = $interval->i;
              $start_time = $diffInMinutes."mins ".$diffInSeconds."secs";
            }
             $student_id = $row['student_id'];
             $exid = $row['exam_id'];
             $s1 = "SELECT f_name, l_name, school_id FROM student where student_id = $student_id;";
             $c1 = $conn->query($s1);
             $op1 = mysqli_fetch_assoc($c1);
             //essay
             $type5 = 5;
             $s2 = "SELECT points_1 FROM exam_question where exam_id = $exid AND exam_type_id = $type5;";
             $c2 = $conn->query($s2);
             $essay = 0;
             while($op2 = mysqli_fetch_assoc($c2))
             {
                $sumE= $op2['points_1'];
                $essay += $sumE;
             }
             //non essay
             $nonessay = 0;
             $s3 = "SELECT points_1, points_2, points_3, points_4, points_5 FROM exam_question where exam_id = $exid AND exam_type_id != $type5;";
             $c3 = $conn->query($s3);
             while($op3 = mysqli_fetch_assoc($c3))
             {
                $sumoS = $op3['points_1']+$op3['points_2']+$op3['points_3']+$op3['points_4']+$op3['points_5'];
                $nonessay += $sumoS;
             }
             $myessayscore = 0;
             $s4 = "SELECT essay_score FROM student_exam_answer where exam_id = $exid AND exam_type_id = $type5 AND student_id = $student_id;";
             $c4 = $conn->query($s4);
             while($op4 = mysqli_fetch_assoc($c4))
             {
                $sumoS1 = $op4['essay_score'];
                $myessayscore += $sumoS1;
             }

           ?><tr>
              <td><?php echo $row['student_id']; ?></td>
              <td><?php echo $op1['school_id']; ?></td>
              <td><?php echo $op1['f_name']." ".$op1['l_name']; ?></td>
              <td><?php echo $row['used_attempt']."/".$row['max_attempt']; ?></td>
              <?php
                if($row['submit_date'] != NULL || $row['submit_date'] != ""){$timestamp = strtotime($row['submit_date']); $today = date("F j, g:i a", $timestamp);}
                else {$today = "None";}
              ?>
              <td><?php echo $today; ?></td>
              <td><?php echo $start_time; ?></td>
              <td><?php echo $row['question_score']."/".$nonessay."pts";?></td>
              <td><?php echo $myessayscore."/".$essay."pts";?></td>
              <td><a href='exam_student_answer.php?exam_id=<?php echo $row['exam_id'].'&tc_id='.$id.'&student_id='.$row['student_id']; ?>'  class="btn btn-primary">ANSWERS</a></td>
             </tr>
           <?php
             }
       }
     ?>
     </table>
     </div>
     </div>
   </div>
   <script>
   $(document).ready(function() {
       $('#aexample').DataTable( {
         dom: 'Blfrtip',
         "order": [[ 3, "desc" ]],
         lengthMenu: [[70, 100, -1], [70, 100, "All"]],
          buttons: ['copy',
          {
            extend: 'print',
            title: 'Exam Submissions id:<?php $rand = substr(uniqid('', true), -5); echo $rand?>'
          },
          {
            extend: 'excelHtml5',
            title: 'Exam Submissions id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
          }]
     } );
   } );
    </script>
<?php
require_once 'includes_footer.php';

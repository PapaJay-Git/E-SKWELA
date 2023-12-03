<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_quiz_id_check.php';
  require_once 'includes_quiz_id_val.php';
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
  $sqlquiztype = "SELECT * FROM quiz_type";
  $quizTypes = $conn->query($sqlquiztype);
  $id = $_GET['tc_id'];
  $quiz_id = $_GET['quiz_id'];
  //check if there is modules/files available for tc_id and the teacher
  $sql = "SELECT * FROM student_quiz where teacher_class_id =? AND teacher_id=? AND quiz_id=?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: teacher_view_quiz.php?tc_id=$tc_id&view=failed");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "iii", $_GET['tc_id'], $_SESSION['teacher_session_id'], $quiz_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
   ?>
   <div class="container-xxl">
     <h2 style="margin-top:40px; margin-bottom:20px" class="head">QUIZ SUBMISSIONS</h2>
     <hr size="4" width="100%" color="grey">
     <section>
         <div class="rt-container-xxl">
               <div class="col-rt-12">
                   <div class="Scriptcontent">

                     <div class="card shadow-sm"style="display: block;">
                       <div class="card-header bg-transparent border-0">
                         <h3 class="mb-0"> <?php echo $classNN2['subject_code']." ".$classN2['class_name']?>
                           <a style="float:right; width: 100px;"  href='teacher_view_quiz.php?quiz_id=<?php echo $quiz_id.'&tc_id='.$id; ?>' class="btn btn-primary">BACK</a>
                         </h3>
                       </div>
                       <div class="card-body pt-0">
                         <table class="table table-bordered">
                           <tr>
                             <th width="30%">Quiz Title</th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                 <textarea class="form-control" disabled><?php echo $quizrow['quiz_title']?></textarea>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="30%">Description</th>
                             <td width="2%">:</td>
                             <td><div class="form-group">
                               <textarea class="form-control" disabled><?php echo $quizrow['quiz_description']?> </textarea>
                             </div></td>
                           </tr>
                           <tr>
                             <th width="30%">Start</th>
                             <td width="2%">:</td>
                             <td><div class="form-group">
                               <?php $timestamp = strtotime($quizrow['start_date']);
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
                               <?php $timestamp = strtotime($quizrow['deadline_date']);
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
                               <input class="form-control" value="<?php echo $quizrow['timer']."mins";?> "disabled>
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
           <table id="aquizple" class="table table-hover table-xxlg table-bordered" style="width:100%">
             <thead>
              <tr>
               <th>Login ID</th>
               <th>LRN</th>
               <th>Name</th>
               <th>Attempt</th>
               <th>Submit Date</th>
              <th>Time</th>
               <th>Total</th>
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
             $exid = $row['quiz_id'];
             $s1 = "SELECT f_name, l_name, school_id FROM student where student_id = $student_id;";
             $c1 = $conn->query($s1);
             $op1 = mysqli_fetch_assoc($c1);
             //non essay
             $nonessay = 0;
             $s3 = "SELECT points_1, points_2, points_3, points_4, points_5 FROM quiz_question where quiz_id = $exid;";
             $c3 = $conn->query($s3);
             while($op3 = mysqli_fetch_assoc($c3))
             {
                $sumoS = $op3['points_1']+$op3['points_2']+$op3['points_3']+$op3['points_4']+$op3['points_5'];
                $nonessay += $sumoS;
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
              <td><?php echo $row['total_score']."/".$nonessay."pts";?></td>
              <td><a href='quiz_student_answer.php?quiz_id=<?php echo $row['quiz_id'].'&tc_id='.$id.'&student_id='.$row['student_id']; ?>'  class="btn btn-primary">ANSWERS</a></td>
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
       $('#aquizple').DataTable( {
         dom: 'Blfrtip',
         "order": [[ 3, "desc" ]],
         lengthMenu: [[70, 100, -1], [70, 100, "All"]],
          buttons: ['copy',
          {
            extend: 'print',
            title: 'Quiz Submissions id:<?php $rand = substr(uniqid('', true), -5); echo $rand?>'
          },
          {
            extend: 'excelHtml5',
            title: 'Quiz Submissions id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
          }]
     } );
   } );
    </script>
<?php
require_once 'includes_footer.php';

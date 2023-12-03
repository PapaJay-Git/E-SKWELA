<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_assignment_id_check.php';
  require_once 'includes_assignment_id_val.php';
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
  $id = $_GET['tc_id'];
  $ass_id = $_GET['ass_id'];
  //check if there is modules/files available for tc_id and the teacher
  $sql = "SELECT * FROM student_assignment where teacher_class_id =? AND teacher_id=? AND teacher_assignment_id=?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: teacher_view_assignments.php?tc_id=$tc_id&view=failed");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "iii", $_GET['tc_id'], $_SESSION['teacher_session_id'], $ass_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
   ?>
   <div class="container-xxl">
     <h2 style="margin-top:40px; margin-bottom:20px" class="head">ASSIGNMENT SUBMISSIONS</h2>
     <hr size="4" width="100%" color="grey">
     <section>
         <div class="rt-container-xxl">
               <div class="col-rt-12">
                   <div class="Scriptcontent">

                     <div class="card shadow-sm"style="display: block;">
                       <div class="card-header bg-transparent border-0">
                         <h3 class="mb-0"> <?php echo $classNN2['subject_code']." ".$classN2['class_name']?>
                           <a style="float:right; width: 100px;"  href='teacher_view_assignments.php?ass_id=<?php echo $ass_id.'&tc_id='.$id; ?>' class="btn btn-primary">BACK</a>
                         </h3>
                       </div>
                       <div class="card-body pt-0">
                         <table class="table table-bordered">
                           <tr>
                             <th width="30%">Assignment Title</th>
                             <td width="2%">:</td>
                             <td>
                               <div class="form-group">
                                 <textarea class="form-control" disabled><?php echo $assrow['ass_title']?></textarea>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="30%">Description</th>
                             <td width="2%">:</td>
                             <td><div class="form-group">
                               <textarea class="form-control" disabled><?php echo $assrow['ass_desc']?> </textarea>
                             </div></td>
                           </tr>
                           <tr>
                             <th width="30%">Start</th>
                             <td width="2%">:</td>
                             <td><div class="form-group">
                               <?php $timestamp = strtotime($assrow['start_date']);
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
                               <?php $timestamp = strtotime($assrow['deadline_date']);
                               $today = date("F j, g:i a", $timestamp); ?>
                               <input class="form-control" value="<?php echo $today?> "disabled>
                             </td>
                             </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="30%">File Instruction</th>
                             <td width="2%">:</td>
                             <td><div class="form-group">
                               <?php if ($assrow['ass_loc'] == NULL || $assrow['ass_loc'] == "") {
                                 echo "No File instruction Given";
                               }else {
                                 ?>
                                 <a style="width:140px;"href="assignment_download.php?ass_id=<?php echo $assrow['teacher_assignment_id']; ?>&tc_id=<?php echo $assrow['teacher_class_id']; ?>" class="btn btn-primary" >DOWNLOAD</a>
                                 <?php
                               }?>
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
           <table id="aassple" class="table table-hover table-xxlg table-bordered" style="width:100%">
             <thead>
              <tr>
               <th>Login ID</th>
               <th>LRN</th>
               <th>Name</th>
               <th>Attempt</th>
               <th>Submit Date</th>
               <th>Score</th>
               <th>Action</th>
              </tr>
             </thead>
           <?php
           while($row = mysqli_fetch_assoc($result)){

             $student_id = $row['student_id'];
             $s1 = "SELECT f_name, l_name, school_id FROM student where student_id = $student_id;";
             $c1 = $conn->query($s1);
             $op1 = mysqli_fetch_assoc($c1);
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
              <td><?php echo $row['score']."/".$row['max_score'];?></td>
              <td><a href='assignment_student_answer.php?ass_id=<?php echo $row['teacher_assignment_id'].'&tc_id='.$row['teacher_class_id'].'&student_id='.$row['student_id']; ?>'  class="btn btn-primary">GRADE</a></td>
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
       $('#aassple').DataTable( {
         dom: 'Blfrtip',
         "order": [[ 3, "desc" ]],
         lengthMenu: [[70, 100, -1], [70, 100, "All"]],
          buttons: ['copy',
          {
            extend: 'print',
            title: 'Assignment Submissions id:<?php $rand = substr(uniqid('', true), -5); echo $rand?>'
          },
          {
            extend: 'excelHtml5',
            title: 'Assignment Submissions id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
          }]
     } );
   } );
    </script>
<?php
require_once 'includes_footer.php';

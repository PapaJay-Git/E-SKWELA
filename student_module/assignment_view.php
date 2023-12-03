
<?php
require_once 'includes_header.php';
require_once 'includes_assignment_id_check.php';
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
      <h1 class="card-title"><?php echo $classNN2['subject_code']." - ASSIGNMENTS";?></h1>
       <hr size="4" width="100%" color="grey">
    <div class="col-md-10">
      <h5></h5>
    </div>
        <a type="button" style="float:right; width: 100px;" href="assignment.php" class="btn btn-primary">BACK</a>

   <div class="card" style="margin-top: 70px;">
    <div class="card-header" style="color: black;">
      My Assignments
    </div>
    <div class="card-body"><!-- BODY-->
       <div class="row">
        <div class="table-responsive">
         <table id="classdata" class="table table-hover table-xxlg table-bordered">
            <caption><?php echo $row_includes['f_name']." ".$row_includes['l_name']."'s assignments"; ?></caption>
             <thead>
              <tr>
               <th> ID </th>
               <th> Title</th>
               <th> Start</th>
               <th> Deadline</th>
               <th> Attempt</th>
               <th> Score </th>
               <th> Action</th>
              </tr>
              </thead>
<?php
//check if there is modules/files available for tc_id and the teacher
$sql = "SELECT * FROM teacher_assignments WHERE teacher_class_id =? AND class_id =? AND published =?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['error'] = "SQL essrror";
        header("location: assignment.php?tc_id=$tcid&sql=error");
        exit();
  }
    $published = 1;
      mysqli_stmt_bind_param($stmt, "iii", $id, $ee, $published);
      if(!mysqli_stmt_execute($stmt)){
        $_SESSION['error'] = "Problem viewing assignments";
        header("location: assignment.php?tc_id=$tcid&sql=error");
        exit();
      }
      $result = mysqli_stmt_get_result($stmt);
    while($rowassignment = mysqli_fetch_assoc($result)){
    $timestamp = strtotime($rowassignment['deadline_date']); $today = date("F j, g:i a", $timestamp);
    $timestamp2 = strtotime($rowassignment['start_date']); $today2 = date("F j, g:i a", $timestamp2);
    $assignment_id_for_search = $rowassignment['teacher_assignment_id'];
    $query = "SELECT * FROM student_assignment where teacher_assignment_id = ? AND student_id =?";
    $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $query)) {
            $_SESSION['error'] = "SQL errsor";
            header("location: assignment.php?tc_id=$tcid&sql=error");
            exit();
      }
          mysqli_stmt_bind_param($stmt, "ii", $assignment_id_for_search, $_SESSION['student_session_id']);
          mysqli_stmt_execute($stmt);
          $result4 = mysqli_stmt_get_result($stmt);
          if ($result4->num_rows > 0) {
            //show the info as $row
            //this can be use by another file if imported
            $rowss = mysqli_fetch_assoc($result4);
            $attempt = $rowss['used_attempt'];
            $score = $rowss['score'];
            if ($score == 0) {
              $score = "Wait if you have submission";
            }else {
              $score = $rowss['score']."/".$rowss['max_score'];
            }
            //error in url id is missing go back to homepage
          } else if($result4->num_rows == 0){
            $attempt = 0;
            $score = "None Yet";
          }
          $str = mb_strimwidth($rowassignment['ass_title'], 0, 35, "...");
    ?>
      <tr>
        <td><?php echo $rowassignment['teacher_assignment_id'];?></td>
        <td><?php echo $str;?></td>
        <td><?php echo $today2; ?></td>
        <td><?php echo $today; ?></td>
        <td><?php echo $attempt."/".$rowassignment['sub_attempt'];?></td>
        <td><?php echo $score;?></td>
        <td><a href="assignment_open.php?tc_id=<?php echo $id;?>&ass_id=<?php echo $rowassignment['teacher_assignment_id']; ?>" class="btn btn-primary">OPEN</a></td>
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
         title: 'My assignments id:<?php $rand = substr(uniqid('', true), -5); echo $rand?>'
       }]
  } );
} );
 </script>
<?php
  require_once 'includes_footer.php';

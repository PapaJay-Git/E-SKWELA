
<?php
  require_once 'includes_header.php';
  require_once 'includes_assignment_id_check.php';
  require_once 'includes_side_nav.php';
?>
<div class="container-xxl">
<h2 style="margin-top:40px; margin-bottom:20px" class="head">ASSIGNMENTS</h2>
<hr size="4" width="100%" color="grey">
<?php
$ee = $row['class_id'];
$ee2 = $row['subject_id'];
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
<h3> <?php echo $classNN2['subject_code']?> </h3>
<h3 style="margin-bottom:40px"> <?php echo $classN2['class_name']?> </h3>
<?php
//check if tc_id and seassion id is valid or can be found in the assignments
$sql = "SELECT * FROM teacher_assignments where teacher_class_id =? AND teacher_id=?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: teacher_assignments.php?view=failed");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ii", $_GET['tc_id'], $_SESSION['teacher_session_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    //check if there is an assignments or none
      ?>
      <div class="row">
        <div class="col-md-8"><h5> </h5></div>
        <div class="col-md-4 btn-group" role="group">
          <a href='teacher_upload_assignments.php?tc_id=<?php echo $row['teacher_class_id']; ?>'style="width: 100px;" class="btn btn-primary" >CREATE ASSIGNMENT</a>
          <a style="width: 30px" href="teacher_assignments.php" class="btn btn-danger">BACK</a>
        </div>
      </div>
      <div class="table-responsive" style="margin-top: 10px;">
      <table id="assdata" class="table table-hover table-xxlg table-bordered" style="width:100%">
        <thead>
         <tr>
          <th> ID </th>
          <th> Title </th>
          <th>Start Time </th>
          <th>Deadline</th>
          <th>Attempt</th>
          <th>Published</th>
          <th>Submissions</th>
          <th>Edit</th>
          <th>Delete</th>
         </tr>
        </thead>
      <?php
      while($row = mysqli_fetch_assoc($result)){
          $str = mb_strimwidth($row['ass_title'], 0, 28, "...");
      ?>
        <tr>
        <td data-label="Desc"><?php echo $row['teacher_assignment_id']; ?></td>
         <td data-label="Title"><?php echo $str; ?></td>
         <?php
               $timestamp = strtotime($row['start_date']); $timestamp2 = strtotime($row['deadline_date']);
               $today = date("F j, g:i a", $timestamp); $today2 = date("F j, g:i a", $timestamp2);?>
         <td data-label="Date"><?php echo $today ?></td>
         <td data-label="Deadline"><?php echo $today2?></td>
         <td data-label="Date"><?php echo $row['sub_attempt']; ?></td>
         <td><?php if ($row['published'] == 1) {?>
                      <a href='assignment_published.php?ass_id=<?php echo $row['teacher_assignment_id'].'&tc_id='.$id; ?>'  class="btn btn-danger">OFF</a><?php
                    }else{?>
                       <a href='assignment_published.php?ass_id=<?php echo $row['teacher_assignment_id'].'&tc_id='.$id; ?>'  class="btn btn-primary">ON</a><?php
                      }?>
         </td>
         <td data-label="Submissions">
           <a href='assignment_submissions.php?ass_id=<?php echo $row['teacher_assignment_id'].'&tc_id='.$id; ?>'class="btn btn-primary" >VIEW</a>
         </td>
         <td>
           <a href='assignment_edit.php?ass_id=<?php echo $row['teacher_assignment_id'].'&tc_id='.$id; ?>'input class="btn btn-primary">EDIT</a>
         </td>
         <td>
             <button type="button" class="btn btn-danger" onclick="ConfirmDelete('assignment_delete.php?ass_id=<?php echo $row['teacher_assignment_id'].'&tc_id='.$id; ?>');">DELETE</button>
         </td>
        </tr>
      <?php
        }
  }
?>
</table>
</div>
</div>
<!-- for tables design, functions and printing output -->
 <script>
 $(document).ready(function() {
     $('#assdata').DataTable( {
       dom: 'Blfrtip',
       "order": [[ 0, "desc" ]],
       lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
      	buttons: [ 'copy',
				{
					extend: 'print',
					title: 'Create Assignments :<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
				},
				{
					extend: 'excelHtml5',
					title: 'Create Assignments :<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
				}]
   } );
 } );
  </script>

</div>
<?php
  require_once 'includes_footer.php';

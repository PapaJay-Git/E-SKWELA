
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
?>
<div class="container-xxl">
  <h2 style="margin-top:40px; margin-bottom:20px" class="head">Quiz Management </h2>
  <hr size="4" width="100%" color="grey">
<?php
  //check the assigned classes from the teacher
  $sql = "SELECT * FROM teacher_class where teacher_id =?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: index.php?view=failed");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $_SESSION['teacher_session_id']);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
}
?>
<div class="table-responsive">
<table id="myidata" class="display responsive nowrap" style="width:100%">
    <thead>
     <tr>
      <th>SECTION </th>
      <th>SUBJECT </th>
      <th>ACTION</th>
     </tr>
    </thead>
<?php while($row = mysqli_fetch_assoc($result)){
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
  ?>
    <tr>
     <td data-label="Section"><?php echo $classN2['class_name']; ?></td>
     <td data-label="Subject"><?php echo $classNN2['subject_code']; ?></td>
     <!-- View and upload modules from designated classes-->
     <td data-label="GIVEN"><a href='teacher_view_quiz.php?tc_id=<?php echo $row['teacher_class_id']; ?>'class="btn btn-primary" >OPEN</a></td>
    </tr>
  <?php
    }
  ?>
</table>
</div>
</div>
<script>
$(document).ready(function() {
    $('#myidata').DataTable( {
      dom: 'Blfrtip',
      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
       buttons: ['copy',
       {
         extend: 'print',
         title: 'Your Class List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
       },
       {
         extend: 'excelHtml5',
         title: 'Your Class List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
       }]
  } );
} );
 </script>
<?php
  require_once 'includes_footer.php';

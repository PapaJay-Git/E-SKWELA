<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
 ?>
<div class="container-xxl">
<h2 class="head" style="margin-top:40px; margin-bottom:20">Class Management</h2>
<hr size="4" width="100%" color="grey">
<?php
//checking if session id is valid as a teacher
$sql = "SELECT * FROM teacher_class where teacher_id =? ORDER BY teacher_class_id DESC";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    $_SESSION['error'] = "SQL error, please contact tech support. ";
    header("location: index.php?view=failed");
      exit();
  } else {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['teacher_session_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    //Go to print classes php
  }
?>

<div class="table-responsive-xxl">
<table id="class_data" class="display responsive nowrap" style="width:100%" >
  <caption>List of classes</caption>
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
   <td data-label="Class name"><?php echo $classN2['class_name']; ?></td>
   <td data-label="Subject code"><?php echo $classNN2['subject_code']; ?></td>
   <!--Go to grade students with designated section, subject and its teacher_class_id-->
   <td data-label="View"><a href='teacher_view_students.php?tc_id=<?php echo $row['teacher_class_id']; ?>' class="btn btn-primary">OPEN</a></td>
  <!--<td data-label="Delete"><a href='class_delete.php?tc_id=<?php /*echo $row['teacher_class_id']; */?>' class='btn-delete' onClick="javascript:return confirm('Delete Class?');"> Delete </a></td><tr> -->
  </tr>
<?php
  }
?>
</table>
<!-- for tables design, functions and printing output -->
 <script>
 $(document).ready(function() {
     $('#class_data').DataTable( {
       dom: 'Bfrtip',
       lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
      	buttons: ['copyHtml5',
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

</div>
</div>

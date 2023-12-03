
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
?>
<div class="container-xxl">
<h2 class="head" style="margin-top:40px; margin-bottom:20">Section Advisory</h2>
<hr size="4" width="100%" color="grey">
<?php
//checking if session id is valid as a teacher
$sql = "SELECT * FROM advisory where teacher_id =?";
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
  <caption>List of Advisory</caption>
  <thead>
   <tr>
     <th>SECTION </th>
     <th>ACTION</th>
   </tr>
  </thead>
<?php while($row = mysqli_fetch_assoc($result)){
        $ee = $row['class_id'];
        //searching for class_name of class_id
        $sql5 = "SELECT class_name FROM class where class_id = $ee;";
        $classN = $conn->query($sql5);
        $classN2 = mysqli_fetch_assoc($classN);
?>
  <tr>
   <td data-label="SECTION"><?php echo $classN2['class_name']; ?></td>
   <td data-label="ACTION"><a href='advisory_view.php?class_id=<?php echo $row['class_id']; ?>' class="btn btn-primary">OPEN</a></td>
  </tr>
<?php
  }
?>
</table>
<!-- for tables design, functions and printing output -->
 <script>
 $(document).ready(function() {
     $('#class_data').DataTable( {
       dom: 'Blfrtip',
       lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]],
      	buttons: ['copyHtml5',
				{
					extend: 'print',
					title: 'Your Advisory List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
				},
				{
					extend: 'excelHtml5',
					title: 'Your Advisory List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
				}]
   } );
 } );
  </script>

</div>
</div>

<?php
  require_once 'includes_footer.php';

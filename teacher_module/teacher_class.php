
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
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
     <th>CLASS RECORD</th>
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
   <td data-label="SECTION"><?php echo $classN2['class_name']; ?></td>
   <td data-label="SUBJECT"><?php echo $classNN2['subject_code']; ?></td>
   <td data-label="ACTION"><a href='teacher_view_students.php?tc_id=<?php echo $row['teacher_class_id']; ?>' class="btn btn-primary">OPEN</a></td>
   <td data-label="CLASS RECORD"><a style="width:120px;"onclick=" ConfirmDownload('class_record.php?tc_id=<?php echo $row['teacher_class_id']; ?>')" class="btn btn-primary">DOWNLOAD</a></td>
  </tr>
<?php
  }
?>
</table>
<!-- for tables design, functions and printing output -->
 <script>
 function ConfirmDownload(e)
 {
   swal.fire({
     title: "Are you sure?",
     text: "You're about to download a copy of this class' Class Record.",
     icon: "question",
     showCancelButton: true,
     confirmButtonText: "Download"
   }).then(function (result){
     if (result.isConfirmed) {
           setTimeout(function(){ window.location = e;});
       } else if (result.dismiss === 'cancel') {
           swal.fire({position: 'center', icon: 'error', title: 'Download Cancelled', showConfirmButton: false, timer: 1500})
         }
     })
 }
 $(document).ready(function() {
     $('#class_data').DataTable( {
       dom: 'Blfrtip',
       lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]],
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

<?php
  require_once 'includes_footer.php';

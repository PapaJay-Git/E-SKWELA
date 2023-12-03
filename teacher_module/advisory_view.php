<?php
 require_once 'includes_header.php';
 require_once 'includes_side_nav.php';
 require_once "includes_advisory.php";
 $ee = $row['class_id'];
 //searching for class_name of class_id
 $sql5 = "SELECT class_name FROM class where class_id = $ee;";
 $classN = $conn->query($sql5);
 $classN2 = mysqli_fetch_assoc($classN);
 			$sql = "SELECT * FROM student WHERE class_id=?;";
 			$stmt = mysqli_stmt_init($conn);
 			  mysqli_stmt_prepare($stmt, $sql);
 				mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
 				mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
 ?>
 <div class="container-xxl">
 <h2 style="margin-top:40px; margin-bottom:20px" class="head"><?php echo $classN2['class_name']?> STUDENTS</h2>
 <hr size="4" width="100%" color="grey">
 <form onsubmit="return clicked()" id="multi"  method="post" style="display:block; margin-top:10px;">
   <button type="button" onclick="window.location.href = 'advisory.php';" style="float:right; width: 100px;" class="btn btn-primary">BACK</button>
   <div class="row" style="margin-bottom: 10px;">
     <h1>&nbsp</h1>
   </div>
 	<div class="table-responsive" style="margin-top: 10px;">
 	<table id="classdata" class="table table-hover table-xxlg table-bordered">
 		  <caption>List of students</caption>
 		  <thead>
 		   <tr>
 				<th> Login ID</th>
 				<th> LRN </th>
 		    <th> Name </th>
        <th> SF9</th>
        <th> SF10</th>
 		   </tr>
 			 </thead>
         <?php
         while ($students = mysqli_fetch_assoc($result)) {
           ?>
       <tr>
           <td><?php echo $students['student_id']; ?></td>
           <td><?php echo $students['school_id']; ?></td>
           <td><?php echo $students['f_name']." ".$students['l_name']; ?></td>
            <td data-label="SF9"><a style="width:120px;"onclick=" ConfirmDownload('report_card.php?class_id=<?php echo $ee."&student_id=".$students['student_id']; ?>')" class="btn btn-primary">DOWNLOAD</a></td>
            <td data-label="SF10"><a style="width:120px;"onclick=" ConfirmDownload2('report_card_10.php?class_id=<?php echo $ee."&student_id=".$students['student_id']; ?>')" class="btn btn-primary">DOWNLOAD</a></td>
        </tr>
           <?php
         }
          ?>
 </table>
 </div>
 </form>
 <!-- for tables design, functions and printing output -->
  <script>
  function ConfirmDownload(e)
  {
    swal.fire({
      title: "Are you sure?",
      text: "You're about to download a copy of SF9 of this student.",
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
  function ConfirmDownload2(e)
  {
    swal.fire({
      title: "Are you sure?",
      text: "You're about to download a copy of SF10 of this student.",
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
      $('#classdata').DataTable( {
        dom: 'Blfrtip',
        lengthMenu: [[50, 100, -1], [50, 100, "All"]],
       	buttons: ['copy',
 				{
 					extend: 'print',
 					title: 'Student Advisory List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
 				},
 				{
 					extend: 'excelHtml5',
 					title: 'Student Advisory List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
 				}]
    } );
  } );

   </script>

 </div>

  <?php
    require_once 'includes_footer.php';

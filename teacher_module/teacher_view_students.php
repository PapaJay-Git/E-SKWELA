
<?php
require_once 'includes_header.php';
require_once 'includes_side_nav.php';
require_once 'includes_classes_id_check.php';
//for adding 1 every table to determince the submit
$num = 0;
?>
<div class="container-xxl">
<h2 style="margin-top:40px; margin-bottom:20px" class="head">STUDENTS</h2>
<hr size="4" width="100%" color="grey">
<?php
$status99 = "unlocked";
$sql898 = "SELECT * FROM grading WHERE status = ?;";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql898);
mysqli_stmt_bind_param($stmt, "s", $status99);
mysqli_stmt_execute($stmt);
$result099 = mysqli_stmt_get_result($stmt);
if ($result099->num_rows == 0) {
	$identifier = true;
}else {
	$identifier = false;
}
$quarters2 = NULL;
while ($open = mysqli_fetch_assoc($result099)) {
	$quarters2 .= $open['quarter']." ";
}

$grading = "SELECT * FROM grading";
$quarter1 = $conn->query($grading);
while ($quarter = mysqli_fetch_assoc($quarter1)) {
	if ($quarter['id'] == 1) {
		$quarter_1 = $quarter['status'];
	}
	if ($quarter['id'] == 2) {
		$quarter_2 = $quarter['status'];
	}
	if ($quarter['id'] == 3) {
		$quarter_3 = $quarter['status'];
	}
	if ($quarter['id'] == 4) {
		$quarter_4 = $quarter['status'];
	}
}
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

//checking students that have the same class_id or section with the assigned tc_id
		if (isset($_GET['tc_id']) && !empty($_GET['tc_id'])){
			$sql = "SELECT * FROM student WHERE class_id=?;";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)) {
				header("location: index.php?view=sqlerror");
        exit();
			} else {
				mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
				mysqli_stmt_execute($stmt);
        $result_2 = mysqli_stmt_get_result($stmt);
			}
		}else{
			header("location: index.php?tc_id=invalid");
      exit();
		}
    if (isset($_GET['tc_id']) && !empty($_GET['tc_id'])){
      $sql = "SELECT * FROM student WHERE class_id=?;";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?view=sqlerror");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
        mysqli_stmt_execute($stmt);
        $result_5 = mysqli_stmt_get_result($stmt);
      }
    }else{
      header("location: index.php?tc_id=invalid");
      exit();
    }
?>
<i class="fa fa-question-circle fa-2x" title="Instructions" onclick="window.open('DEMO/SKWELA_CSV_GRADING.pdf','_blank');"
style="cursor: pointer; float:right"></i>
<h3> <?php echo $classNN2['subject_code']?> </h3>
<h3 style="margin-bottom:40px"> <?php echo $classN2['class_name']?> </h3>

<form  id="csv_form" action="csv_grades.php?tc_id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-8"><h5> </h5></div>
		<div class="col-md-4 btn-group" role="group" >
			<label class="btn btn-outline-secondary" style="height: 35px;" title="Choose File">
			<i class="fa fa-upload"></i>CSV File<input type="file" style="display: none;" name="file" id="csv_file">
		</label>
		<input type="button" onclick="check_file()"class="btn btn-primary" value="Upload Now">

	</div>
	</div>
</form>
<form onsubmit="return clicked()" id="multi" action="save_grade_multi.php?tc_id=<?php echo $id ?>" method="post" style="display:block; margin-top:10px;">
	<div class="row">
		<div class="col-md-8"><h5> </h5></div>
		<div class="col-md-4 btn-group" role="group">
    <input style="float:right; width: 150px;"type="submit" class="btn btn-primary" value="Save Input" title="Save inputted grades from textboxes">
		<button type="button" class="btn btn-danger" onclick="goBack()">Back</button>
	</div>
</div>
    <input type="hidden" name="save_all" value="SAVE GRADES">
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
				<th> Last login</th>
				<th> <?php if ($quarter_1 == "locked") {
					?>
					First <i class="fa fa-lock"></i>
					<?php
				}else {
					echo "First";
				} ?></th>
				<th> <?php if ($quarter_2 == "locked") {
					?>
					Second <i class="fa fa-lock"></i>
					<?php
				}else {
					echo "Second";
				} ?></th>
				<th> <?php if ($quarter_3 == "locked") {
					?>
					Third <i class="fa fa-lock"></i>
					<?php
				}else {
					echo "Third";
				} ?></th>
				<th> <?php if ($quarter_4 == "locked") {
					?>
					Fourth <i class="fa fa-lock"></i>
					<?php
				}else {
					echo "Fourth";
				} ?></th>
				<th> <?php if ($quarter_4 == "locked") {
					?>
					Final <i class="fa fa-lock"></i>
					<?php
				}else {
					echo "Final";
				} ?></th>
		   </tr>
			 </thead>
<?php
//For showing the paramters of every students ex. Grade
while($row_5 = mysqli_fetch_assoc($result_5)){
	 $sql = "SELECT first, second, third, fourth, final FROM stu_grade WHERE subject_id =? AND student_id=?;";
	 $stmt = mysqli_stmt_init($conn);
	 if(!mysqli_stmt_prepare($stmt, $sql)) {
		 header("location: index.php?sql_error");
     exit();
	 }
		 mysqli_stmt_bind_param($stmt, "ii", $ee2, $row_5['student_id']);
		 mysqli_stmt_execute($stmt);
		 $result_3 = mysqli_stmt_get_result($stmt);
		 $row_3 = mysqli_fetch_assoc($result_3);
    if($result_3->num_rows > 0){
     $first1 = $row_3['first'];
      $second1 = $row_3['second'];
      $third1 = $row_3['third'];
      $fourth1 = $row_3['fourth'];
      $final1 = $row_3['final'];
    }else{
       $first1 = 0;
       $second1 =0;
       $third1 = 0;
       $fourth1 = 0;
       $final1 = 0;
    }
		if (strtotime($row_5['last_log_in'])) {
			$timestamp = strtotime($row_5['last_log_in']);
			$today99 = date("F j, g:i a", $timestamp);
		}else {
			$today99 = "never";
		}

?>
<tr>
		 <td><?php echo $row_5['student_id']; ?>
       <input type="hidden" name="subject_id" value="<?php echo $ee2; ?>">
       <input type="hidden" name="id_num[]" value="<?php echo $row_5['student_id'];?>" ></input></td>
			 <td><?php echo $row_5['school_id']; ?></td>
     <td><?php echo $row_5['f_name']." ".$row_5['l_name']; ?></td>
		 <td><?php echo $today99; ?></td>
		 <?php
		 if ($quarter_1 == "locked") {
		 ?>
		<td><input style="width:70px; display: none;" min="0" max="100" step=".01" type="number" name="first[]" value="<?php echo $first1; ?>" required>
		<label ><?php echo $first1; ?></label></td>
		 <?php
		}else {
			?>
     <td><input style="width:70px;" min="0" max="100" step=".01" type="number" name="first[]" value="<?php echo $first1; ?>" required>
     <label style="display: none;"><?php echo $first1; ?></label></td>
			<?php
		}
		if ($quarter_2 == "locked") {
		?>
	 <td><input style="width:70px; display: none;"  min="0" max="100" step=".01" type="number" name="second[]" value="<?php echo $second1; ?>" required>
	 <label ><?php echo $second1; ?></label></td>
		<?php
	 }else {
		 ?>
		<td><input style="width:70px;" min="0" max="100" step=".01" type="number" name="second[]" value="<?php echo $second1; ?>" required>
		<label style="display: none;"><?php echo $second1; ?></label></td>
		 <?php
	 }
	 if ($quarter_3 == "locked") {
	 ?>
	<td><input style="width:70px; display: none;"  min="0" max="100" step=".01" type="number" name="third[]" value="<?php echo $third1; ?>" required>
	<label ><?php echo $third1; ?></label></td>
	 <?php
	}else {
		?>
	 <td><input style="width:70px;" min="0" max="100" step=".01" type="number" name="third[]" value="<?php echo $third1; ?>" required>
	 <label style="display: none;"><?php echo $third1; ?></label></td>
		<?php
	}
	if ($quarter_4 == "locked") {
	?>
 <td><input style="width:70px; display: none;"  min="0" max="100" step=".01" type="number" name="fourth[]" value="<?php echo $fourth1; ?>" required>
 <label><?php echo $fourth1; ?></label></td>
 <td><input style="width:70px; display: none;"  min="0" max="100" step=".01" type="number" name="final[]" value="<?php echo $final1; ?>" required>
 <label><?php echo $final1; ?></label></td>
	<?php
 }else {
	 ?>
	<td><input style="width:70px;" min="0" max="100" step=".01" type="number" name="fourth[]" value="<?php echo $fourth1; ?>" required>
	<label style="display: none;"><?php echo $fourth1; ?></label></td>
	<td><input style="width:70px;" min="0" max="100" step=".01" type="number" name="final[]" value="<?php echo $final1; ?>" required>
	<label style="display: none;"><?php echo $final1; ?></label></td>
	 <?php
 }
		  ?>

 </tr>
<?php
  }
?>
</table>
</div>
</form>
<!-- for tables design, functions and printing output -->
 <script>
 $(document).ready(function() {
     $('#classdata').DataTable( {
       dom: 'Blfrtip',
       lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]],
      	buttons: ['copy',
				{
					extend: 'print',
					title: 'Student List of Grades id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
				},
				{
					extend: 'excelHtml5',
					title: 'Student List of Grades id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
				}]
   } );
 } );
 function clicked() {
	 <?php
	 if ($identifier) {
	 	?>
		swal.fire({
			title: "No quarter unlocked at the moment!",
			text: "Please wait for the admin to unlock grading for atleast one quarter."
		});
		return false;
		<?php
	 }
	  ?>
  swal.fire({
    title: "Are you sure?",
    text: "You are about to update the (<?php echo $quarters2; ?>) quarter grades of these students. Are you sure you want to do that?",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Update"
  }).then(function (result){
    if (result.isConfirmed) {
          document.getElementById("multi").submit();
          swal.fire({position: 'center', title: 'Updating...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
      } else if (result.dismiss === 'cancel') {
          swal.fire({position: 'center', icon: 'error', title: 'Update Cancelled', showConfirmButton: false, timer: 1500})
        }
    })
 return false;
 }

 function check_file() {
	 <?php
	 if ($identifier) {
	 	?>
		swal.fire({
			title: "No quarter unlocked at the moment!",
			text: "Please wait for the admin to unlock grading for atleast one quarter."
		});
		return
		<?php
	 }
	  ?>
	 if( document.getElementById("csv_file").files.length == 0 ){
		 swal.fire({
       title: "No file selected",
       text: "Please choose your CSV file first before you can proceed."
		 });
		 return
	}
	 swal.fire({
     title: "Are you sure?",
     text: "You are about to upload a file to update or insert (<?php echo $quarters2; ?>) quarter grades of these students. Are you sure you want to do that?",
     icon: "question",
     showCancelButton: true,
     confirmButtonText: "Confirm"
   }).then(function (result){
     if (result.isConfirmed) {
            document.getElementById("csv_form").submit();
            swal.fire({position: 'center', title: 'Uploading...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
       } else if (result.dismiss === 'cancel') {
           swal.fire({position: 'center', icon: 'error', title: 'Update Cancelled', showConfirmButton: false, timer: 1500})
         }
     })
 }

  </script>

</div>

 <?php
   require_once 'includes_footer.php';

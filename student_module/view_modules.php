
<?php
require_once 'includes_header.php';
require_once 'includes_module_id_check.php';
require_once 'includes_side_nav.php';
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
 <div class="container-xxl">
 <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>
      <h1 class="card-title"><?php echo $classNN2['subject_code']." - Modules";?></h1>
          <hr size="4" width="100%" color="grey">
    <div class="col-md-10">
      <h5></h5>
    </div>
        <button type="button" style="float:right; width: 100px;" onClick="goBack()" class="btn btn-primary">BACK</button>



   <div class="card" style="margin-top: 70px;">
    <div class="card-header">
      Student's Module
    </div>
    <div class="card-body"><!-- BODY-->
       <div class="row">
<?php
$id = $_GET['tc_id'];
//check if there is modules/files available for tc_id and the teacher
$sql = "SELECT * FROM files where teacher_class_id =? AND class_id=?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: modules.php?view=failed");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ii", $_GET['tc_id'], $ee);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
      while($rowFile = mysqli_fetch_assoc($result)){
      ?>          <div class="col-md-4 mb-3">
                  <div class="card"><img style="cursor: pointer;"class="img-fluid" alt="100%x280"  src="../assets/subj_pics/subject_pic.jpg">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $classNN2['subject_code']."-".$rowFile['file_name'];?></h4>
                      <center>
                        <span style="display: inline-block;">
                          <a href='module_download.php?file_id=<?php echo $rowFile['file_id'].'&tc_id='.$id; ?>' style="width: 120px;" class="btn btn-primary" title="Click to view Modules">Download</a>
                        </span>
                      </center>
                    </div>
                  </div>
                </div>
      <?php
        }
  }
?>
</div>
</div>
</div>
</div>
<script>
$(document).ready(function() {
    $('#aexample').DataTable( {
      dom: 'Blfrtip',
      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
       buttons: ['copy',
       {
         extend: 'print',
         title: 'Uploaded Modules id:<?php $rand = substr(uniqid('', true), -5); echo $rand?>'
       },
       {
         extend: 'excelHtml5',
         title: 'Uploaded Modules id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
       }]
  } );
} );
 </script>
<?php
  require_once 'includes_footer.php';

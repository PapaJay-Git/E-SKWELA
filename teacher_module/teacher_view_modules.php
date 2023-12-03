
<?php
require_once 'includes_header.php';
require_once 'includes_module_id_check.php';
require_once 'includes_side_nav.php';
?>
<div class="container-xxl">

<h2 class="head" style="margin-top:40px;">MODULES</h2>
<hr size="4" width="100%" color="grey">
<?php
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
<h3> <?php echo $classNN2['subject_code']?> </h3>
<h3 style="margin-bottom:40px"> <?php echo $classN2['class_name']?> </h3>
<?php
$id = $_GET['tc_id'];
//check if there is modules/files available for tc_id and the teacher
$sql = "SELECT * FROM files where teacher_class_id =? AND teacher_id=?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: teacher_modules.php?view=failed");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ii", $_GET['tc_id'], $_SESSION['teacher_session_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
      ?>
      <div class="row">
        <div class="col-md-8"><h5> </h5></div>
        <div class="col-md-4 btn-group" role="group">
          <a href='teacher_upload_modules.php?tc_id=<?php echo $row['teacher_class_id']; ?>'style="width: 120px;" class="btn btn-primary" >UPLOAD MODULE</a>
          <a style="width: 30px" href="teacher_modules.php" class="btn btn-danger">BACK</a>
        </div>
      </div>
      <div class="table-responsive" style="margin-top: 10px;">
      <table id="aexample" class="table table-hover table-xxlg table-bordered" style="width:100%">
        <thead>
         <tr>
          <th> ID </th>
          <th >Title </th>
          <th>Uploaded </th>
          <th>Edit</th>
          <th>Open</th>
          <th>Download</th>
          <th>Delete</th>
         </tr>
        </thead>
      <?php
      while($row = mysqli_fetch_assoc($result)){
        $str = mb_strimwidth($row['file_name'], 0, 28, "...");
      ?><tr>
         <td data-label="ID"><?php echo $row['file_id']; ?></td>
         <td data-label="Name"><?php echo $str; ?></td>
         <?php $timestamp = strtotime($row['file_date']);
               $today = date("F j, g:i a", $timestamp);
          ?>
         <td data-label="Date"><?php echo $today?></td>
         <td data-label="Edit"><a href='module_edit.php?file_id=<?php echo $row['file_id'].'&tc_id='.$id; ?>'  class="btn btn-primary">Edit</a></td>


        <td data-label="Open"><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Open</button></td>
         <td data-label="Download"><a href='module_download.php?file_id=<?php echo $row['file_id'].'&tc_id='.$id; ?>'  class="btn btn-primary">Download</a></td>
         <td data-label="Delete">
           <button type="button" onclick="ConfirmDelete('module_delete.php?file_id=<?php echo $row['file_id'].'&tc_id='.$id; ?>')" class="btn btn-danger">Delete</button>
          </td>
        </tr>
      <?php
        }

  }
?>
</table>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<script>
$(document).ready(function() {
    $('#aexample').DataTable( {
      dom: 'Blfrtip',
      "order": [[ 0, "desc" ]],
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

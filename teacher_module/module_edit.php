<?php
require_once 'includes_header.php';
require_once 'includes_module_id_check.php';
require_once 'includes_module_id_val.php';
require_once 'includes_side_nav.php';
$tcid = $_GET['tc_id'];
$file_id = $_GET['file_id'];
  $ee = $row['class_id'];
  $ee2 = $row['subject_id'];
  //searching for class_name of class_id
  $sql5 = "SELECT class_name, grade FROM class where class_id = $ee;";
  $classN = $conn->query($sql5);
  $classN2 = mysqli_fetch_assoc($classN);
  //searhing for subject_code of subject_id
  $sql33 = "SELECT subject_code FROM subjects where subject_id = $ee2;";
  $classNN = $conn->query($sql33);
  $classNN2 = mysqli_fetch_assoc($classNN);
    $tc_id_check = $_SESSION['teacher_session_id'];
    $checkClasses = "SELECT * FROM teacher_class where teacher_id = ? AND teacher_class_id != ?;";
      if(!mysqli_stmt_prepare($stmt, $checkClasses)) {
          $_SESSION['error'] = "SQL error, please contact tech support.";
            header("location: teacher_view_quiz.php?tc_id=$iddd&sql=error");
            exit();
      } else {
          mysqli_stmt_bind_param($stmt, "ii", $tc_id_check, $tcid);
          mysqli_stmt_execute($stmt);
          $output = mysqli_stmt_get_result($stmt);
            if ($result->num_rows > 0) {
              //show the info
              //$row = mysqli_fetch_assoc($result);
              //echo "works";
              //error in url id is missing go back to homepage
            } else if($result->num_rows == 0){
              $_SESSION['error'] = "Access on Exams, Denied!";
              header("location: teacher_view_equiz.php?tc_id=$iddd&id_url=no_match");
              exit();
              //echo "no equal data";
            }
          }
   ?>
   <div class="container-xxl">
     <h2 style="margin-top:40px; margin-bottom:20px" class="head"><?php echo $classNN2['subject_code']." ".$classN2['class_name']?></h2>
     <hr size="4" width="100%" color="grey">
     <div class="btn-group" role="group" style="margin-bottom: 10px;">
     <input type="button"style="width:90px;" id="TEXT"class="btn btn-primary" onclick="showFILE()" value="FILE">
     <input type="button" style="width:90px;"id="FILE"class="btn btn-primary" onclick="showTEXT()" value="TEXT">
     <input type="button" style="width:90px;"id="SHARE"class="btn btn-primary" onclick="showSHARE()" value="SHARE">
     </div>
     <section>
         <div class="rt-container-xxl">
               <div class="col-rt-12">
                   <div class="Scriptcontent">

                     <div class="card shadow-sm"  id="files"style="display:block;" >
                       <div class="card-header bg-transparent border-0">
                         <h3 class="mb-0"> UPDATE FILE </h3>
                       </div>
                       <div class="card-body pt-0">
                         <!-- Edit the file -->
                         <form onsubmit="return clicked2()" id="form_upload" action="module_update.php?file_id=<?php echo $file_id; ?>&tc_id=<?php echo $row['teacher_class_id']; ?>" method="POST" enctype="multipart/form-data">
                         <table class="table table-bordered">
                           <tr>
                             <th width="100%">Module Title</th>
                           </td>
                           </tr>
                           <tr>
                             <td>
                               <div class="form-group">
                                 <textarea class="form-control"name="file_name" maxlength="200" rows="2" cols="40" required><?php echo $row_files['file_name']; ?></textarea>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="100%">Description</th>
                           </tr>
                           <tr>
                             <td>
                               <div class="form-group">
                                 <textarea class="form-control"name="file_description" maxlength="2500" rows="3" required><?php echo $row_files['file_desc']; ?></textarea>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="100%">File up to 25mb</th>
                           </tr>
                           <tr>
                             <td>
                               <div class="custom-file" >
                                 <input  class="form-control" id="formFileSm" type="file" name="file" required>
                               </div>
                           </td>
                           </tr>
                         </table>
                         <div class="row">
                           <div class="col-md-8"><h5> </h5></div>
                           <div class="col-md-4 btn-group" role="group">
                             <input type="submit" class="btn btn-primary"  value="UPDATE">
                             <input type="hidden" name="update_file" value="UPDATE">
                             <a href="teacher_view_modules.php?tc_id=<?php echo $row['teacher_class_id']; ?>" class="btn btn-danger" >BACK</a>
                           </div>
                         </div>
                         </form>
                       </div>
                     </div>
                     <div class="card shadow-sm"  id="texts" style="display:none;" >
                       <div class="card-header bg-transparent border-0">
                         <h3 class="mb-0"> UPDATE TEXT</h3>
                       </div>
                       <div class="card-body pt-0">
                         <!-- Edit the TEXT-->
                         <form onsubmit="return clicked()" id="text_form" action="module_update.php?file_id=<?php echo $file_id; ?>&tc_id=<?php echo $row['teacher_class_id']; ?>" method="POST" enctype="multipart/form-data">
                         <table class="table table-bordered">
                           <tr>
                             <th width="100%">Module Title</th>
                           </tr>
                           <tr>
                             <td>
                               <div class="form-group">
                                 <textarea class="form-control" name="file_name" maxlength="200" rows="2" cols="40" required><?php echo $row_files['file_name']; ?></textarea>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="100%">Description</th>
                           </tr>
                           <tr>
                             <td>
                               <div class="form-group">
                                 <textarea class="form-control"name="file_description" maxlength="2500" rows="3" required><?php echo $row_files['file_desc']; ?></textarea>
                               </div>
                           </td>
                           </tr>
                         </table>
                         <div class="row">
                           <div class="col-md-8"><h5> </h5></div>
                           <div class="col-md-4 btn-group" role="group">
                             <input type="submit" class="btn btn-primary" value="UPDATE">
                             <input type="hidden" name="update_text" value="UPDATE">
                             <a href="teacher_view_modules.php?tc_id=<?php echo $row['teacher_class_id']; ?>" class="btn btn-danger" >BACK</a>
                           </div>
                         </div>
                         </form>
                       </div>
                     </div>
                     <div class="card shadow-sm"  id="shares" style="display:none;" >
                       <div class="card-header bg-transparent border-0">
                         <h3 class="mb-0"> SHARE MODULE</h3>
                       </div>
                       <div class="card-body pt-0">
                         <!-- Edit the TEXT-->
                         <form class="share_form" action="module_update.php?file_id=<?php echo $file_id; ?>&tc_id=<?php echo $row['teacher_class_id']; ?>" method="POST" enctype="multipart/form-data">
                         <table class="table table-bordered">
                           <tr>
                             <th width="100%">Module Title</th>
                           </tr>
                           <tr>
                             <td>
                               <div class="form-group">
                                 <textarea class="form-control" disabled><?php echo $row_files['file_name']; ?></textarea>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="100%">Description</th>
                           </tr>
                           <tr>
                             <td>
                               <div class="form-group">
                                 <textarea class="form-control" disabled><?php echo $row_files['file_desc']; ?></textarea>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="100%">Classes you can share this module with</th>
                           </tr>
                           <tr>
                             <td>
                               <div class="form-group">
                                 <?php
                                 // loop for dropdown option,
                                 $grade = $classN2['grade'];
                                 while ($arrayClasses = mysqli_fetch_assoc($output)) {
                                 $class_name_check = $arrayClasses['class_id'];
                                 $subject_code_check = $arrayClasses['subject_id'];
                                 $checkClasses11 = "SELECT class_name FROM class where class_id = $class_name_check AND grade = $grade;";
                                 $output11 = $conn->query($checkClasses11);
                                 $arrayClasses11 = mysqli_fetch_assoc($output11);
                                 //
                                 $checkClasses112 = "SELECT subject_code FROM subjects class where subject_id = $subject_code_check AND grade = $grade;";
                                 $output112 = $conn->query($checkClasses112);
                                 if ($output112->num_rows > 0) {
                                   $arrayClasses112 = mysqli_fetch_assoc($output112);
                                   ?>
                                    <input type="checkbox" id="ckx" name="share[]" value="<?php echo $arrayClasses['teacher_class_id']; ?>">   <?php echo $arrayClasses11['class_name']."   :   ".$arrayClasses112['subject_code']; ?><br>
                                    <?php
                                 }
                                 }?>
                               </div>
                           </td>
                           </tr>
                         </table>
                         <div class="row">
                           <div class="col-md-8"><h5> </h5></div>
                           <input type="hidden" name="file_name" value="<?php echo $row_files['file_name']; ?>">
                           <input type="hidden" name="description" value="<?php echo $row_files['file_desc']; ?>">
                           <input type="hidden" name="file_loc" value="<?php echo $row_files['file_loc']; ?>">
                           <div class="col-md-4 btn-group" role="group">
                             <input type="button" id="btn-ok"class="btn btn-primary"value="SHARE">
                             <input type="hidden" name="share_module" value="hahaha">
                             <a href="teacher_view_modules.php?tc_id=<?php echo $row['teacher_class_id']; ?>" class="btn btn-danger" >BACK</a>
                           </div>
                         </div>
                         </form>
                       </div>
                     </div>
             </div>
         </div>
         </div>
     </section>
   </div>
<script type="text/javascript">
//forms
var files = document.getElementById('files');
var texts = document.getElementById('texts');
var share = document.getElementById('shares');
function showFILE() {
  //display
      files.style.display = "block";
      texts.style.display = "none";
      share.style.display = "none";
}
function showTEXT() {
  //display
      files.style.display = "none";
      texts.style.display = "block";
      share.style.display = "none";
}
function showSHARE() {
  //display
      files.style.display = "none";
      texts.style.display = "none";
      share.style.display = "block";
}
$(document).ready(function() {
$('.share_form #btn-ok').click(function() {
  var ischecked = $('#ckx:checked').length;
  if (ischecked > 0) {

  }else {
    Swal.fire({title: 'None Selected', text: 'Please select atleast one class to share with.'});
    return
  }
  //For number of grade7 being deleted
    var num = document.querySelectorAll('input[type="checkbox"]:checked').length;
    let form = $(this).closest('form');
    swal.fire({
      title: "SHARE THIS MODULE TO ("+num+") OTHER CLASSES?",
      text: "Are you sure you want to share this module to this number ("+num+") of classes?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Share"
    }).then(function (result){
      if (result.isConfirmed) {
          form.submit();
          swal.fire({position: 'center', title: 'Sharing...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Sharing Cancelled', showConfirmButton: false, timer: 1500})
          }
      })

});
});

function clicked() {
 swal.fire({
   title: "Are you sure?",
   text: "You are about to update the title and description of this module. Are you sure you want to do that?",
   icon: "question",
   showCancelButton: true,
   confirmButtonText: "Update"
 }).then(function (result){
   if (result.isConfirmed) {
         document.getElementById("text_form").submit();
         swal.fire({position: 'center', title: 'Updating...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
     } else if (result.dismiss === 'cancel') {
         swal.fire({position: 'center', icon: 'error', title: 'Update Cancelled', showConfirmButton: false, timer: 1500})
       }
   })
return false;
}
function clicked2() {
 swal.fire({
   title: "Are you sure?",
   text: "You are about to update the actual file of this module. Are you sure you want to do that?",
   icon: "question",
   showCancelButton: true,
   confirmButtonText: "Update"
 }).then(function (result){
   if (result.isConfirmed) {
         document.getElementById("form_upload").submit();
         swal.fire({position: 'center', title: 'Uploading...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
     } else if (result.dismiss === 'cancel') {
         swal.fire({position: 'center', icon: 'error', title: 'Update Cancelled', showConfirmButton: false, timer: 1500})
       }
   })
return false;
}
</script>
<?php
  require_once 'includes_footer.php';

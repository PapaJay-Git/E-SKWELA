
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
     <h2 style="margin-top:40px; margin-bottom:20px" class="head">Upload Module</h2>
     <hr size="4" width="100%" color="grey">

     <section>
         <div class="rt-container-xxl">
               <div class="col-rt-12">
                   <div class="Scriptcontent">

                     <div class="card shadow-sm">
                       <div class="card-header bg-transparent border-0">
                         <h3 class="mb-0"><?php echo $classNN2['subject_code']." ".$classN2['class_name']?></h3>
                       </div>
                       <div class="card-body pt-0">
                         <form onsubmit="return clicked()" id="file_upload" action="upload_module.php?tc_id=<?php echo $row['teacher_class_id']; ?>" method="POST" enctype="multipart/form-data">
                         <table class="table table-bordered">
                           <tr>
                               <th width="100%">Module Title</th>
                           </tr>
                           <tr>
                             <td>
                               <div class="form-group">
                                 <textarea name="file_name" maxlength="250" class="form-control" rows="2"required></textarea>
                               </div>
                           </td>
                           </tr>
                           <tr>
                             <th width="100%">Description</th>
                           </tr>
                           <tr>
                             <td><div class="form-group">
                               <textarea class="form-control" id="mytext" name="file_description" maxlength="2500" rows="5" required></textarea>
                             </div></td>
                           </tr>
                           <tr>
                             <th width="100%">File up to 25mb</th>
                           </td>
                           </tr>
                           <tr>
                             <td><div class="form-group">
                               <input class="form-control" type="file" name="file" accept="file_extension|image/*|media_type"required>
                             </td>
                             </div>
                           </td>
                           </tr>
                         </table>
                         <div class="row">
                           <div class="col-md-8" ><h5> </h5></div>
                           <div class="col-md-4 btn-group" role="group">
                             <input type="submit" class="btn btn-primary" value="UPLOAD">
                             <input type="hidden" name="submit_file"  value="UPLOAD">
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
function clicked() {
 swal.fire({
   title: "Are you sure?",
   text: "You are about to upload this file as a module. Are you sure you want to do that?",
   icon: "question",
   showCancelButton: true,
   confirmButtonText: "Upload"
 }).then(function (result){
   if (result.isConfirmed) {
         document.getElementById("file_upload").submit();
         swal.fire({position: 'center', title: 'Uploading...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
     } else if (result.dismiss === 'cancel') {
         swal.fire({position: 'center', icon: 'error', title: 'Upload Cancelled', showConfirmButton: false, timer: 1500})
       }
   })
return false;
}
</script>
<?php
  require_once 'includes_footer.php';

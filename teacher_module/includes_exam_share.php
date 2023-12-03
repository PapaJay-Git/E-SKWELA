<div id="share_exam" style="display: none;">
  <?php
  $tc_id_check = $_SESSION['teacher_session_id'];
  $checkClasses = "SELECT * FROM teacher_class where teacher_id = ? AND teacher_class_id != ?;";
    if(!mysqli_stmt_prepare($stmt, $checkClasses)) {
        $_SESSION['error'] = "SQL error, please contact tech support.";
          header("location: teacher_view_exam.php?tc_id=$iddd&sql=error");
          exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $tc_id_check, $iddd);
        mysqli_stmt_execute($stmt);
        $output = mysqli_stmt_get_result($stmt);
          if ($result->num_rows > 0) {
            //show the info
            //$row = mysqli_fetch_assoc($result);
            //echo "works";
            //error in url id is missing go back to homepage
          } else if($result->num_rows == 0){
            $_SESSION['error'] = "Access on Exams, Denied!";
            header("location: teacher_view_exam.php?tc_id=$iddd&id_url=no_match");
            exit();
            //echo "no equal data";
          }
        }
  $three = 3;
   ?>
   <form class="share_form" action="exam_add_query.php?view_id=<?php echo $three ?>&exam_id=<?php echo $examiddd ?>&tc_id=<?php echo $iddd ?>" method="post">
  <h5>Exam Share</h5>
   <table class="table table-bordered">
     <tr>
       <th width="30%">Classes you can share this exam with</th>
       <td width="2%">:</td>
       <td><div class="form-group">
                    <?php
                    // loop for dropdown option,
                    $gradeshare = $classN2['grade'];
                    while ($arrayClasses = mysqli_fetch_assoc($output)) {
                    $class_name_check = $arrayClasses['class_id'];
                    $subject_code_check = $arrayClasses['subject_id'];
                    $checkClasses11 = "SELECT class_name FROM class where class_id = $class_name_check AND grade = $gradeshare;";
                    $output11 = $conn->query($checkClasses11);
                    $arrayClasses11 = mysqli_fetch_assoc($output11);
                    //
                    $checkClasses112 = "SELECT subject_code FROM subjects class where subject_id = $subject_code_check AND grade = $gradeshare;";
                    $output112 = $conn->query($checkClasses112);
                    if ($output112->num_rows > 0) {
                      $arrayClasses112 = mysqli_fetch_assoc($output112);
                      ?>
                       <input type="checkbox" id="ckx" name="share[]" value="<?php echo $arrayClasses['teacher_class_id']; ?>">   <?php echo $arrayClasses11['class_name']."   :   ".$arrayClasses112['subject_code']; ?><br><?php
                    }
                    }?>
       </div></td>
     </tr>
     <tr>
       <th width="30%"> Quesions of this exam</th>
       <td width="2%">:</td>
       <td>
         <div class="form-group">
           <textarea disabled><?php echo $a-1; ?></textarea>
         </div>
     </td>
     </tr>
   </table>
   <input style="float:right"type="button" class="btn-primary" value="Share Now" id="btn-ok">
   <h1>&nbsp</h1>
   <div class="row">
     <input type="hidden" name="title" value="<?php echo $examrow['exam_title']; ?>">
     <input type="hidden" name="description" value="<?php echo $examrow['exam_description']; ?>">
     <input type="hidden" name="udate" value="<?php echo $examrow['upload_date']; ?>">
     <input type="hidden" name="ddate" value="<?php echo $examrow['deadline_date']; ?>">
     <input type="hidden" name="max" value="<?php echo $examrow['max_attempt']; ?>">
     <input type="hidden" name="published" value="<?php echo $examrow['published']; ?>">
     <input type="hidden" name="minutes" value="<?php echo $examrow['timer']; ?>">
     <input type="hidden" name="startd" value="<?php echo $examrow['start_date']; ?>">
     <input type="hidden" name="share_this_exam" value="asss">
   </div>
   </form>
</div>
<script type="text/javascript">
$(document).ready(function() {
$('.share_form #btn-ok').click(function() {
  var ischecked = $('#ckx:checked').length;
  if (ischecked > 0) {

  }else {
    Swal.fire({title: 'None Selected', text: 'Please select atleast one class to share with.'});
    return
  }
  //For number of grade7 being deleted
    var num = document.querySelectorAll('#ckx:checked').length;
    let form = $(this).closest('form');
    swal.fire({
      title: "SHARE THIS EXAM TO ("+num+") OTHER CLASSES?",
      text: "Are you sure you want to share this exam to this number ("+num+") of classes?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Share"
    }).then(function (result){
      if (result.isConfirmed) {
        swal.fire({position: 'center', icon: 'success', title: 'Submitting for validation...', showConfirmButton: false, timer: 2500, timerProgressBar: true})
        setTimeout( function () {
          form.submit();
        }, 2500);
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Sharing Cancelled', showConfirmButton: false, timer: 1500})
          }
      })

});
});
</script>


<?php
require_once 'includes_header.php';
require_once 'includes_assignment_id_check.php';
require_once 'includes_assignment_id_val.php';
require_once 'includes_side_nav.php';
//timezone
date_default_timezone_set('Asia/Manila');
// Then call the date functions
//for minimun date deadline
$date = date('Y-m-d');
//echo $date;
$assid = $_GET['ass_id'];
 $ee = $row['class_id'];
 $ee2 = $row['subject_id'];
 //searching for class_name of class_id
 $sql5 = "SELECT class_name, grade FROM class where class_id = $ee;";
 $classN = $conn->query($sql5);
 $classN2 = mysqli_fetch_assoc($classN);
 $gradeshare = $classN2['grade'];
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
      $tcid = $assrow['teacher_class_id'];
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
            header("location: teacher_view_assignments.php?tc_id=$iddd&id_url=no_match");
            exit();
            //echo "no equal data";
          }
        }
  ?>
  <div class="container-xxl">
    <h2 style="margin-top:40px; margin-bottom:20px" class="head"><?php echo $classNN2['subject_code']." ".$classN2['class_name']?></h2>
    <hr size="4" width="100%" color="grey">
    <div class="btn-group" role="group" style="margin-bottom: 10px;">
    <input type="button" style="width:90px;"id="UPDATE"class="btn btn-primary" onclick="showUPDATE()" value="UPDATE">
    <input type="button" style="width:90px;"id="SHARE"class="btn btn-primary" onclick="showSHARE()" value="SHARE">
    </div>
    <section>
        <div class="rt-container-xxl">
              <div class="col-rt-12">
                  <div class="Scriptcontent">

                    <div class="card shadow-sm" style="display:block;" id="update" >
                      <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0">Update assignment</h3>
                      </div>
                      <div class="card-body pt-0">
                        <form onsubmit="return clicked()" id="update_assignment_form" action="assignment_update.php?ass_id=<?php echo $assid; ?>&tc_id=<?php echo $assrow['teacher_class_id']; ?>" method="POST" enctype="multipart/form-data">
                        <table class="table table-bordered">
                          <tr>
                            <th width="30%">Assignment Title</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                <textarea class="form-control" name="ass_name" maxlength="200" rows="2" required><?php echo $assrow['ass_title']; ?></textarea>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Description</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <textarea class="form-control" name="ass_description" maxlength="2500" rows="4" required><?php echo $assrow['ass_desc']; ?></textarea>
                            </div></td>
                          </tr>
                          <tr>
                            <th width="30%">Start</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <input class="form-control" value="<?php echo $assrow['start_date']; ?>" type="text" name="start" id="datepicker2" placeholder="DATE" onpaste="return false;" onkeypress="return false;" onDrag="return false" onDrop="return false" autocomplete="off" required>
                            </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Deadline</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <input class="form-control" value="<?php echo $assrow['deadline_date']; ?>" type="text" name="date" id="datepicker" placeholder="DATE" onpaste="return false;" onkeypress="return false;" onDrag="return false" onDrop="return false" autocomplete="off" required>
                            </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Attempts</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                            <input class="form-control" value="<?php echo $assrow['sub_attempt']; ?>"type="number" name="max_attempt" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" min="1" max="100" placeholder="Attempt" required>
                            </td>
                            </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Max Score</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <input class="form-control" value="<?php echo $assrow['max_score']; ?>" type="number" name="max_score" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" min="1" max="100" placeholder="Max Score" required>
                            </div></td>
                          </tr>
                          <?php
                          if ($assrow['ass_loc'] != NULL) {
                            ?>
                            <tr>
                              <th width="30%">Download or Delete</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                                <div class="col-md-5 btn-group" role="group" style="float:left;">
                                 <a  href="assignment_download.php?ass_id=<?php echo $assrow['teacher_assignment_id']; ?>&tc_id=<?php echo $assrow['teacher_class_id']; ?>" class="btn btn-primary" >DOWNLOAD</a>
                                 <button type="button" onclick="ConfirmDelete('assignment_one_delete.php?ass_id=<?php echo $assrow['teacher_assignment_id']; ?>&tc_id=<?php echo $assrow['teacher_class_id']; ?>')" class="btn btn-danger">DELETE</button>
                               </div>
                              </td>
                              </div>
                            </td>
                            </tr>
                            <tr>
                              <th width="30%">FILE exist, upload to change</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                                  <input class="form-control" type="file" name="assignment">
                              </td>
                              </div>
                            </td>
                            </tr>
                            <?php
                          } else {
                            ?>
                            <tr>
                              <th width="30%">No File yet</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                                  <input class="form-control" type="file" name="assignment">
                              </td>
                              </div>
                            </td>
                            </tr>
                            <?php
                          }
                           ?>
                        </table>
                        <div class="row">
                          <div class="col-md-8"><h5> </h5></div>
                          <div class="col-md-4 btn-group" role="group" style="float:right;">
                           <input  type="submit" class="btn btn-primary"  value="UPDATE">
                           <input type="hidden" name="submit_assignment" value="UPDATE">
                           <a href="teacher_view_assignments.php?tc_id=<?php echo $row['teacher_class_id']; ?>" class="btn btn-danger" >BACK</a>
                         </div>
                        </div>
                        </form>
                      </div>
                    </div>
                    <div class="card shadow-sm" style="display: none;" id="share" >
                      <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0">Share assignment</h3>
                      </div>
                      <div class="card-body pt-0">
                        <form  class="share_form" action="assignment_update.php?ass_id=<?php echo $assid; ?>&tc_id=<?php echo $assrow['teacher_class_id']; ?>" method="POST">
                        <table class="table table-bordered">
                          <tr>
                            <th width="30%">Assignment Title</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                <textarea class="form-control" disabled> <?php echo $assrow['ass_title']; ?></textarea>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Description</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <textarea class="form-control" disabled><?php echo $assrow['ass_desc']; ?></textarea>
                            </div></td>
                          </tr>
                          <tr>
                            <th width="30%">Start</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <input class="form-control" value="<?php echo $assrow['start_date']; ?>" type="text" disabled>
                            </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Deadline</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <input class="form-control" value="<?php echo $assrow['deadline_date']; ?>" type="text" disabled>
                            </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Attempts</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                            <input class="form-control" value="<?php echo $assrow['sub_attempt']; ?>"type="number" disabled>
                            </td>
                            </div>
                          </td>
                          </tr>
                            <tr>
                              <th width="30%">Classes you can share this assignment</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                                <?php
                                // loop for dropdown option,
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
                                   <input type="checkbox" id="ckx" name="share[]" value="<?php echo $arrayClasses['teacher_class_id']; ?>">   <?php echo $arrayClasses11['class_name']."   :   ".$arrayClasses112['subject_code']; ?><br>
                                   <?php
                                }
                                }?>
                              </td>
                              </div>
                            </td>
                            </tr>
                        </table>
                        <div class="row">
                          <div class="col-md-8"><h5> </h5></div>
                          <div class="col-md-4 btn-group" role="group" style="float:right;">
                            <input style="width: 120px;" type="button" class="btn btn-primary" value="SHARE" id="btn-ok">
                            <input type="hidden" name="share_assignment" value="fddddd" >
                            <a style="width: 120px;" href="teacher_view_assignments.php?tc_id=<?php echo $row['teacher_class_id']; ?>" class="btn btn-danger" >BACK</a>
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
<script >
function clicked() {
 swal.fire({
   title: "Are you sure?",
   text: "You are about to update this assignment. Are you sure you want to do that?",
   icon: "question",
   showCancelButton: true,
   confirmButtonText: "Update"
 }).then(function (result){
   if (result.isConfirmed) {
         document.getElementById("update_assignment_form").submit();
         swal.fire({position: 'center', title: 'Updating...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
     } else if (result.dismiss === 'cancel') {
         swal.fire({position: 'center', icon: 'error', title: 'Update Cancelled', showConfirmButton: false, timer: 1500})
       }
   })
return false;
}
//forms
var update = document.getElementById('update');
var share = document.getElementById('share');
function showUPDATE() {
  //display
      update.style.display = "block";
      share.style.display = "none";
}
function showSHARE() {
  //display
      update.style.display = "none";
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
    var num = document.querySelectorAll('#ckx:checked').length;
    let form = $(this).closest('form');
    swal.fire({
      title: "SHARE THIS ASSIGNMENT TO ("+num+") OTHER CLASSES?",
      text: "Are you sure you want to share this assignment to this number ("+num+") of Classes?",
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
</script>
<?php
require_once "../assets/includes_datetime.php";
require_once "includes_footer.php";

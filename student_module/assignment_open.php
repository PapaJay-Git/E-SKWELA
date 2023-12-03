
<?php
require_once 'includes_header.php';
require_once 'includes_assignment_id_check.php';
require_once 'includes_assignment_id_val.php';
require_once 'includes_side_nav.php';
$ee = $row['class_id'];
$ee2 = $row['subject_id'];
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
//searhing for subject_code of subject_id
$sql33 = "SELECT subject_code FROM subjects where subject_id = $ee2;";
$classNN = $conn->query($sql33);
$classNN2 = mysqli_fetch_assoc($classNN);
$assignment_id_for_search = $assrow['teacher_assignment_id'];
$query = "SELECT * FROM student_assignment where teacher_assignment_id = ? AND student_id =?";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $query)) {
        $_SESSION['error'] = "SQL errsor";
        header("location: assignment.php?tc_id=$tcid&sql=error");
        exit();
  }
      mysqli_stmt_bind_param($stmt, "ii", $assignment_id_for_search, $_SESSION['student_session_id']);
      mysqli_stmt_execute($stmt);
      $result4 = mysqli_stmt_get_result($stmt);
      if ($result4->num_rows > 0) {
        //show the info as $row
        //this can be use by another file if imported
        $rowss = mysqli_fetch_assoc($result4);
        $attempt = $rowss['used_attempt'];
        $score = $rowss['score'];
        $subdate = $rowss['submit_date'];
        //error in url id is missing go back to homepage
      } else if($result4->num_rows == 0){
        $attempt = 0;
        $score = "None Yet";
        $subdate = "";
      }
 ?>
 <div class="container-xxl">
 <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>
      <h1 class="card-title"><?php echo $classNN2['subject_code']." - Assignment";?></h1>
          <hr size="4" width="100%" color="grey">
  <div class="btn-group" role="group" style="margin-bottom: 10px;">
  <input type="button" style="width:100px;"class="btn btn-primary" onclick="showD()" value="DETAILS">
  <input type="button" style="width:100px;"class="btn btn-primary" onclick="showA()" value="ANSWER">
  </div>
    <section>
        <div class="rt-container-xxl" style="display:block;" id="details">
              <div class="col-rt-12">
                  <div class="Scriptcontent">

                    <div class="card shadow-sm" style="display:block;">
                      <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0">Assignment Instruction</h3>
                      </div>
                      <div class="card-body pt-0">
                        <table class="table table-bordered">
                          <tr>
                            <th width="30%">Assignment Title</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                <?php echo $assrow['ass_title'];?>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Description</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <?php echo $assrow['ass_desc'];?>
                            </div></td>
                          </tr>
                          <tr>
                            <th width="30%">Start</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <?php      $timestamp2 = strtotime($assrow['start_date']); $today2 = date("F j, g:i a", $timestamp2);
                              echo $today2; ?>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Deadline</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <?php      $timestamp = strtotime($assrow['deadline_date']); $today = date("F j, g:i a", $timestamp);
                              echo $today; ?>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Last submit</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <?php
                              if($subdate ==""){ echo "None";}
                              else{$timestamp = strtotime($subdate); $today = date("F j, g:i a", $timestamp); echo $today;} ?>
                              </div>
                          </td>
                          </tr>
                            <tr>
                              <th width="30%">Score</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                                <?php echo $score; ;?>
                                </div>
                              </td>
                            </td>
                            </tr>
                            <tr>
                              <th width="30%">Max Score</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                                <?php echo $assrow['max_score']; ;?>
                                </div>
                              </td>
                            </td>
                            </tr>
                            <tr>
                              <th width="30%">Attempt</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                              <?php echo $attempt."/".$assrow['sub_attempt'];?>
                              </td>
                              </div>
                            </td>
                            </tr>
                            <tr>
                              <th width="30%">Status</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                                <?php
                                  if($assrow['deadline_date']  >= $date){
                                    echo "Ongoing";
                                  }else {
                                    echo "Past Due";
                                  }
                                  ?>
                                </div>
                              </td>
                            </td>
                            </tr>
                            <tr>
                              <th width="30%">File Instruction</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                                <?php if ($assrow['ass_loc'] == NULL || $assrow['ass_loc'] == "") {
                                  echo "No file given";
                                }else {
                                  ?>
                                  <a href="download_instruction.php?tc_id=<?php echo $tcid; ?>&ass_id=<?php echo $assrow['teacher_assignment_id']; ?>"  style="width: 120px;" class="btn btn-primary">Download</a>
                                  <?php
                                }?>
                                </div>
                              </td>
                            </td>
                            </tr>
                        </table>
                        <div class="row">
                          <div class="col-md-8"><h5> </h5></div>
                          <div class="col-md-4 btn-group" role="group" style="float:right;">
                            <a type="button" style="width: 120px" href="assignment_view.php?tc_id=<?php echo $tcid; ?>" class="btn btn-primary">BACK</a>
                         </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
      <div class="rt-container-xxl" style="display:none;" id="answer">
<?php  if ($assrow['start_date']  <= $date){
        if ($attempt < $assrow['sub_attempt'] ){
          if($assrow['deadline_date']  >= $date){?>
              <div class="col-rt-12">
                <div class="Scriptcontent">
                <div class="card shadow-sm">
              <div class="card-header bg-transparent border-0">
                <h3 class="mb-0">Add Answer</h3>
                <small>This submission will overwrite your past submissions if there is one. So please include all that is required.</small>
              </div>
                <form onsubmit="return clicked()"id="form" action="assignment_submit.php?tc_id=<?php echo $tcid; ?>&ass_id=<?php echo $assignment_id_for_search; ?>" method="post" enctype="multipart/form-data">
                  <div class="card-body pt-0">
                  <table class="table table-bordered">
                    <tr>
                      <th width="100%">Text Answer</th>
                    </tr>
                    <tr>
                      <th><div class="form-group"><textarea class="form-control" name="text" rows="5" required placeholder="Text..."></textarea>
                    </div></th>
                    </tr>
                    <tr>
                      <th width="100%">File up to 25mb</th>
                    </tr>
                    <tr>
                      <th><div class="form-group">
                        <input type="file" name="file" class="form-control">
                      </div></th>
                    </tr>
                  </table>
                  <div class="row">
                    <div class="col-md-8"><h5> </h5></div>
                    <input type="hidden" name="ass_pass" value="pass">
                    <div class="col-md-4 btn-group" role="group" style="float:right;">
                      <?php if ($attempt < $assrow['sub_attempt'] ){
                        if($assrow['deadline_date']  >= $date){?>

                        <button style="width: 120px;" type="submit" class="btn btn-primary" value="pass">SUBMIT</button>
                      <?php
                      }
                    }?>
                      <a type="button" style="width: 120px" href="assignment_view.php?tc_id=<?php echo $tcid; ?>" class="btn btn-primary">BACK</a>
                   </div>
                  </div>
                </div>
                 </form>
               </div>
               </div>
               </div>
               <?php
             }else {
               echo "I'm sorry, it looks like you did not make it through deadine.";
             }
              }else {
                echo "I'm sorry, it looks like you have maxed out your attempts;";
              }
            }else {
              echo "I'm sorry, it looks like this assignment does not start yet.";
            }
                ?>
            </div>
            </section>
          </div>
<script type="text/javascript">
function clicked() {
    swal.fire({
      title: "Are you sure?",
      text: "You are about to submit your answer on this assignment. All previous answers will be overwritten with this submit if there is one. Are you okay with that?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Submit"
    }).then(function (result){
      if (result.isConfirmed) {
            document.getElementById("form").submit();
            swal.fire({position: 'center', title: 'Uploading...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Submit Cancelled', showConfirmButton: false, timer: 1500})
          }
      })
return false;
}
var d = document.getElementById('details');
var a = document.getElementById('answer');
  function showD(){
    d.style.display = "block";
    a.style.display = "none";
  }
  function showA(){
    d.style.display = "none";
    a.style.display = "block";
  }
</script>
<?php
  require_once 'includes_footer.php';

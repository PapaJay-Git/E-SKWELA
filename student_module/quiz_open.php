
<?php
require_once 'includes_header.php';
require_once 'includes_quiz_id_check.php';
require_once 'includes_quiz_id_val.php';
require_once 'includes_side_nav.php';
$ee = $row['class_id'];
$ee2 = $row['subject_id'];
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');
//searhing for subject_code of subject_id
$sql33 = "SELECT subject_code FROM subjects where subject_id = $ee2;";
$classNN = $conn->query($sql33);
$classNN2 = mysqli_fetch_assoc($classNN);
$quiz_id_for_search = $quizrow['quiz_id'];
$query = "SELECT * FROM quiz_question where quiz_id = ?;";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $query)) {
        $_SESSION['error'] = "SQL error";
          header("location: quiz_view.php?tc_id=$tcid&sql=error");
        exit();
  }
      mysqli_stmt_bind_param($stmt, "i", $quiz_id_for_search);
      mysqli_stmt_execute($stmt);
      $result4 = mysqli_stmt_get_result($stmt);
$none = 0;
while($result2 = mysqli_fetch_assoc($result4))
{
   $sumoff = $result2['points_1']+$result2['points_2']+$result2['points_3']+$result2['points_4']+$result2['points_5'];
   $none += $sumoff;
}
/////////////////////////////
$query11 = "SELECT * FROM student_quiz where quiz_id = ? AND published=? AND student_id=?;";
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $query11)) {
        $_SESSION['error'] = "SQL error";
        header("location: quiz.php?tc_id=$tcid&sql=error");
        exit();
  }
      mysqli_stmt_bind_param($stmt, "iii", $quiz_id_for_search, $published, $_SESSION['student_session_id']);
      mysqli_stmt_execute($stmt);
      $result199 = mysqli_stmt_get_result($stmt);
$total = 0;
$attempts = 0;
$subdate = "";
$start_time = "none";
if ($result199->num_rows > 0) {
$result22= mysqli_fetch_assoc($result199);
     $total = $result22['total_score'];
     $attempts = $result22['used_attempt'];
     $subdate = $result22['submit_date'];
     $start_time = $result22['start_time'];
}
 ?>
 <div class="container-xxl">
 <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>
      <h1 class="card-title"><?php echo $classNN2['subject_code']." - QUIZ";?></h1>
          <hr size="4" width="100%" color="grey">
    <section>
        <div class="rt-container-xxl">
              <div class="col-rt-12">
                  <div class="Scriptcontent">

                    <div class="card shadow-sm" style="display:block;" id="update" >
                      <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0">Take Quiz</h3>
                      </div>
                      <div class="card-body pt-0">
                        <table class="table table-bordered">
                          <tr>
                            <th width="30%">Quiz Title</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                <?php echo $quizrow['quiz_title'];?>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Description</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <?php echo $quizrow['quiz_description'];?>
                            </div></td>
                          </tr>
                          <tr>
                            <th width="30%">Start</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <?php      $timestamp2 = strtotime($quizrow['start_date']); $today2 = date("F j, g:i a", $timestamp2);
                              echo $today2; ?>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Deadline</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <?php      $timestamp = strtotime($quizrow['deadline_date']); $today = date("F j, g:i a", $timestamp);
                              echo $today; ?>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Last submit</th>
                            <td width="2%">:</td>
                            <td><div class="form-group">
                              <?php
                              if($subdate ==""||$subdate ==NULL){ echo "None";}
                              else{$timestamp = strtotime($subdate); $today = date("F j, g:i a", $timestamp); echo $today;} ?>
                              </div>
                          </td>
                          </tr>
                            <tr>
                              <th width="30%">Total</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                                <?php echo $total."/".$none."pts" ;?>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th width="30%">Attempt</th>
                              <td width="2%">:</td>
                              <td><div class="form-group">
                              <?php echo $attempts."/".$quizrow['max_attempt'];?>
                              </td>
                              </div>
                            </td>
                            </tr>
                              <tr>
                                <th width="30%">Timer</th>
                                <td width="2%">:</td>
                                <td><div class="form-group">
                              <?php echo $quizrow['timer']." minutes";?>
                                  </div>
                                </td>
                              </td>
                              </tr>
                              <tr>
                                <th width="30%">Last Take</th>
                                <td width="2%">:</td>
                                <td><div class="form-group">
                                    <?php
                                  if(!strtotime($start_time) || !strtotime($subdate)){
                                    $start_time = "None";
                                 }else{
                                   $d1 = new DateTime($subdate);
                                   $d2 = new DateTime($start_time);
                                   $interval = $d1->diff($d2);
                                   $diffInSeconds = $interval->s;
                                   $diffInMinutes = $interval->i;
                                   $start_time = $diffInMinutes."mins ".$diffInSeconds."secs";
                                 }
                                  echo $start_time;?>
                                  </div>
                                </td>
                              </td>
                              </tr>
                              <tr>
                                <th width="30%">Status</th>
                                <td width="2%">:</td>
                                <td><div class="form-group">
                                  <?php
                                    if($quizrow['deadline_date']  >= $date){
                                      echo "Ongoing";
                                    }else {
                                      echo "Past Due";
                                    }
                                    ?>
                                  </div>
                                </td>
                              </td>
                              </tr>
                        </table>
                        <div class="row">
                          <div class="col-md-8"><h5> </h5></div>
                          <div class="col-md-4 btn-group" role="group" style="float:right;">
                            <?php if ($quizrow['start_date']  <= $date) {
                              if($attempts < $quizrow['max_attempt'] ){
                              if($quizrow['deadline_date']  >= $date){?>
                              <button style="width: 120px;" type="submit"class="btn btn-primary"
                              onClick="takequiz('quiz_take.php?tc_id=<?php echo $quizrow['teacher_class_id']."&quiz_id=".$quizrow['quiz_id'];?>')">TAKE</button>
                            <?php
                            }
                          }
                          } ?>
                            <a type="button" style="width: 120px" href="quiz_view.php?tc_id=<?php echo $tcid; ?>" class="btn btn-primary">BACK</a>
                         </div>
                        </div>
                      </div>
                    </div>
        </div>
    </section>
</div>
</div>
</div>

<?php
  require_once 'includes_footer.php';

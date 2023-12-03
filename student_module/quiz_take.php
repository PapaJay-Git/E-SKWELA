<?php
require_once 'includes_header.php';
require_once 'includes_quiz_id_check.php';
require_once 'includes_quiz_id_val.php';
require_once "includes_popup.php";
$ee = $row['class_id'];
$ee2 = $row['subject_id'];
$quiz_id = $quizrow['quiz_id'];
$tc_id = $quizrow['teacher_class_id'];
$student_id = $_SESSION['student_session_id'];
date_default_timezone_set('Asia/Manila');
$current_date = date('Y-m-d H:i:s');
$a =1;
      $sql = "SELECT * FROM quiz_question WHERE quiz_id=?";
			$stmt = mysqli_stmt_init($conn);
		    if(!mysqli_stmt_prepare($stmt, $sql)) {
							$_SESSION['error'] = "SQL error";
				      header("location: quiz_open.php?tc_id=$tcid&quiz_id=$quiz_id&sql=error");
              exit();
			  }
    				mysqli_stmt_bind_param($stmt, "i", $quiz_id);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                //show the info as $row
								//this can be use by another file if imported
                //error in url id is missing go back to homepage
              } else if($result->num_rows == 0){
								$_SESSION['error'] = "This quiz has no question. Please contact your teacher.";
                header("location: quiz_open.php?tc_id=$tcid&quiz_id=$quiz_id&id_url=no_match");
								exit();
			        }
            //searhing for subject_code of subject_id
            $sql33 = "SELECT subject_code FROM subjects where subject_id = $ee2;";
            $classNN = $conn->query($sql33);
            $classNN2 = mysqli_fetch_assoc($classNN);

            $sql3332 = "SELECT * FROM student_quiz where quiz_id = $quiz_id AND student_id = $student_id;";
            $classNNN1 = $conn->query($sql3332);
            if ($classNNN1->num_rows == 0) {
              $add_quiz_students = "INSERT INTO student_quiz (quiz_id, teacher_class_id, teacher_id, class_id, student_id, max_attempt, deadline_date,  quiz_title, quiz_description,
                published, timer, start_date)
               VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?, ?);";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
              if(!mysqli_stmt_prepare($stmt, $add_quiz_students)) {
                  $_SESSION['error'] = "SQL error, please contact tech support.";
                  header("Location: quiz_open.php?tc_id=$tcid&quiz_id=$quiz_id&sql=error");
                  exit();
              }
              mysqli_stmt_bind_param($stmt, "iiiiiisssiis", $quizrow['quiz_id'], $quizrow['teacher_class_id'], $quizrow['teacher_id'], $quizrow['class_id'], $student_id,
              $quizrow['max_attempt'], $quizrow['deadline_date'], $quizrow['quiz_title'], $quizrow['quiz_description'], $quizrow['published'], $quizrow['timer'], $quizrow['start_date']);
                mysqli_stmt_execute($stmt);
            }
            $sql333 = "SELECT used_attempt, deadline_date, max_attempt, start_date FROM student_quiz where quiz_id = $quiz_id AND student_id = $student_id;";
            $classNNN = $conn->query($sql333);
            $classNN22 = mysqli_fetch_assoc($classNNN);
            if($classNN22['start_date'] <= $current_date){
            }else {
              $_SESSION['error'] = "You cannot take a quiz that does not started yet!";
              header("location: quiz_open.php?tc_id=$tcid&quiz_id=$quiz_id&time=due");
              exit();
            }
              if($classNN22['deadline_date'] >= $current_date){
              }else {
                $_SESSION['error'] = "You cannot take a quiz that is past its due!";
                header("location: quiz_open.php?tc_id=$tcid&quiz_id=$quiz_id&time=due");
                exit();
              }
            if ($classNN22['used_attempt'] >= $classNN22['max_attempt']) {
                $_SESSION['error'] = "You have used all of your attempts. You cannot answer it again!";
                header("location: quiz_open.php?tc_id=$tcid&quiz_id=$quiz_id&attempt=limit");
                exit();
             }else {
              $used_attempt = $classNN22['used_attempt']+1;
              $sql = "UPDATE student_quiz SET used_attempt=? WHERE quiz_id=? AND student_id =?";
              $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                      $_SESSION['error'] = "SQL error";
                      header("location: quiz_open.php?tc_id=$tcid&quiz_id=$quiz_id&sql=error");
                       exit();
                }
                    mysqli_stmt_bind_param($stmt, "iii", $used_attempt, $quiz_id, $student_id);
                    mysqli_stmt_execute($stmt);
                    $add_one = 1;
             }
             $time = $quizrow['timer'];
             $date = date('Y-m-d H:i:s', strtotime('+'.$time.' minute'));
             $timerjs = $quizrow['timer'] * 60000;
             $timestamp = strtotime($date); $today = date("g:i a", $timestamp);
 ?>
 <div class="top" id="myTop"><img src="download (1).png" alt="School Logo"  height="100">E-SKWELA</div>
 <div class="container-xxl">
 <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>
 <div class="card w-100" style="margin-bottom: 15px;">
    <div class="card-body">
      <h1 class="card-title"><?php echo $classNN2['subject_code']." - QUIZ";?></h1>
    </div>
  </div>
  <div class="card w-100">
    <div class="card-body">
    <small>These answers will be discarded if without submisssion in <?php echo $today; ?>.</small>
    <small>Please submit your quiz before leaving the page.</small><br>
    <script language="JavaScript">
    TargetDate = "<?php echo $date; ?>";
    BackColor = "white";
    ForeColor = "navy";
    CountActive = true;
    CountStepper = -1;
    LeadingZero = true;
    DisplayFormat = "%%H%% Hours,%%M%% Minutes, %%S%% Seconds.";
    FinishMessage = "Time Out!";
    </script>
    <script language="JavaScript" src="https://rhashemian.github.io/js/countdown.js"></script>
  </div>
  </div>
    <section>
        <div class="rt-container-xxl">
              <div class="col-rt-12">
                  <div class="Scriptcontent">
<form onsubmit="return clicked()" id="form" action="quiz_submit.php?tc_id=<?php echo $tc_id; ?>&quiz_id=<?php echo $quiz_id; ?>" method="post">
  <input type="hidden" name="add_one" value="<?php echo $add_one; ?>">
    <input type="hidden" name="start_time" value="<?php echo $current_date; ?>">
<?php
    $tf = 0;
    $multi = 0;
    $enum = 0;
    $numbered = 1;
    while ($quizquestions = mysqli_fetch_assoc($result)) {
    $sum =  $quizquestions['points_1']+$quizquestions['points_2']+$quizquestions['points_3']+$quizquestions['points_4']+$quizquestions['points_5'];
              if($quizquestions['quiz_type_id'] == 1){
                ?>
                    <div class="card shadow-sm" style="margin-top:10px;" id="" >
                      <div class="card-header bg-transparent border-0">
                        <small style="float:right;"><?php echo $sum." "; ?>Points</small>
                        <h4 class="mb-0"><?php echo $numbered.". "; ?>True or False</h4>
                      </div>
                      <div class="card-body pt-0">
                        <table class="table table-bordered">
                          <tr>
                            <th width="30%">Question</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                <?php echo $quizquestions['quiz_question_txt'];?>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Answer</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                <input type="hidden" name="TF_id[]" value="<?php echo $quizquestions['quiz_question_id'];?>">
                                <label>True &nbsp;</label><input type="radio" style="cursor: pointer;" name="TF<?php echo $tf; ?>"value="true" checked>
                                <label>False &nbsp;</label><input type="radio" style="cursor: pointer;" name="TF<?php echo $tf; ?>"value="false">
                              </div>
                          </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <?php
                      $tf++;
                }
                elseif ($quizquestions['quiz_type_id'] == 2) {
                  ?>
                  <div class="card shadow-sm" style="margin-top:10px;" id="" >
                    <div class="card-header bg-transparent border-0">
                      <small style="float:right;"><?php echo $sum." "; ?>Points</small>
                      <h4 class="mb-0"><?php echo $numbered.". "; ?>Multiple Choice</h4>
                    </div>
                    <div class="card-body pt-0">
                      <table class="table table-bordered">
                        <tr>
                          <th width="30%">Question</th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                              <?php echo $quizquestions['quiz_question_txt'];?>
                              <input type="hidden" name="multi_id[]" value="<?php echo $quizquestions['quiz_question_id'];?>">
                            </div>
                        </td>
                        </tr>
                        <tr>
                          <th width="30%"><?php echo $quizquestions['answer_a_2'];?></th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                                A <input type="radio" style="cursor: pointer;" name="multi<?php echo $multi; ?>" value="A" checked>
                            </div>
                        </td>
                        </tr>
                        <tr>
                          <th width="30%"><?php echo $quizquestions['answer_b_3'];?></th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                                B <input type="radio" style="cursor: pointer;" name="multi<?php echo $multi; ?>" value="B">
                            </div>
                        </td>
                        </tr>
                        <tr>
                          <th width="30%"><?php echo $quizquestions['answer_c_4'];?></th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                                C <input type="radio" style="cursor: pointer;" name="multi<?php echo $multi; ?>" value="C">
                            </div>
                        </td>
                      </tr>
                        <tr>
                          <th width="30%"><?php echo $quizquestions['answer_d_5'];?></th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                                D <input type="radio" style="cursor: pointer;" name="multi<?php echo $multi; ?>" value="D">
                            </div>
                        </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <?php
                  $multi++;
                }
                elseif ($quizquestions['quiz_type_id'] == 3) {
                  ?>
                  <div class="card shadow-sm" style="margin-top:10px;" id="" >
                    <div class="card-header bg-transparent border-0">
                      <small style="float:right;"><?php echo $sum." "; ?>Points</small>
                      <h4 class="mb-0"><?php echo $numbered.". "; ?>Enumeration</h4>
                      <small><?php
                      if ($quizquestions['case_sensitive'] == "no") {
                        echo "Not case sensitive.";
                      }else {
                        echo "Case sensitive.";
                      } ?></small>
                    </div>
                    <div class="card-body pt-0">
                      <table class="table table-bordered">
                        <tr>
                          <th width="30%">Question</th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                              <?php echo $quizquestions['quiz_question_txt'];?>
                                  <input type="hidden" name="enum_id[]" value="<?php echo $quizquestions['quiz_question_id'];?>">
                            </div>
                        </td>
                        </tr>
                          <tr>
                            <th width="30%">1</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                <input class="form-control"type="text" name="answer_1<?php echo $enum; ?>">
                              </div>
                          </td>
                          </tr>
                        <?php if ($quizquestions['answer_a_2'] != NULL): ?>
                          <tr>
                            <th width="30%">2</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                  <input class="form-control"type="text" name="answer_a_2<?php echo $enum; ?>">
                              </div>
                          </td>
                          </tr>
                        <?php endif; ?>
                        <?php if ($quizquestions['answer_b_3'] != NULL): ?>
                          <tr>
                            <th width="30%">3</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                  <input class="form-control"type="text" name="answer_b_3<?php echo $enum; ?>">
                              </div>
                          </td>
                          </tr>
                        <?php endif; ?>
                        <?php if ($quizquestions['answer_c_4'] != NULL): ?>
                          <tr>
                            <th width="30%">4</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                  <input class="form-control"type="text" name="answer_c_4<?php echo $enum; ?>">
                              </div>
                          </td>
                          </tr>
                        <?php endif; ?>
                        <?php if ($quizquestions['answer_d_5'] != NULL): ?>
                          <tr>
                            <th width="30%">5</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                  <input class="form-control"type="text" name="answer_d_5<?php echo $enum; ?>">
                              </div>
                          </td>
                          </tr>
                        <?php endif; ?>
                      </table>
                    </div>
                  </div>
                  <?php
                  $enum++;
                }
                elseif ($quizquestions['quiz_type_id'] == 4) {
                  ?>
                  <div class="card shadow-sm" style="margin-top:10px;" id="" >
                    <div class="card-header bg-transparent border-0">
                      <small style="float:right;"><?php echo $sum." "; ?>Points</small>
                      <h4 class="mb-0"><?php echo $numbered.". "; ?>Identification</h4>
                      <small><?php
                      if ($quizquestions['case_sensitive'] == "no") {
                        echo "Not case sensitive.";
                      }else {
                        echo "Case sensitive.";
                      } ?></small>
                    </div>
                    <div class="card-body pt-0">
                      <table class="table table-bordered">
                        <tr>
                          <th width="30%">Question</th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                              <?php echo $quizquestions['quiz_question_txt'];?>
                                <input type="hidden" name="iden_id[]" value="<?php echo $quizquestions['quiz_question_id'];?>">
                            </div>
                        </td>
                        </tr>
                        <tr>
                          <th width="30%">Answer</th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                                <input class="form-control"type="text" name="iden[]">
                            </div>
                        </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <?php
                }
                $numbered++;
              }

              ?>
              <div class="card w-100" style="margin-top:10px;">
                <div class="card-body">
                <input type="hidden" name="submit_quiz"  value="SUBMIT ALL">
                <input type="submit" style="font-size : 20px; float:right; margin-top: 10px; height: 50px; width: 150px;"class="btn btn-primary"value="SUBMIT ALL">
              </div>
            </div>
          </form>
        </div>
    </section>
</div>
</div>
</div>
<script type="text/javascript">
function clicked() {
    swal.fire({
      title: "Are you sure?",
      text: "You are about to submit all of your quiz answers. Are you sure about that?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Submit"
    }).then(function (result){
      if (result.isConfirmed) {
            document.getElementById("form").submit();
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Submit Cancelled', showConfirmButton: false, timer: 1500})
          }
      })
return false;
}
setTimeout(function(){
  window.location = "quiz_open.php?tc_id=<?php echo $tc_id."&quiz_id=".$quiz_id; ?>";
  <?php $_SESSION['caution'] = "Submit your answers before timer goes off. Do not leave the page without submitting your answers. Every page refresh will also count as an attempt."; ?>
}, <?php echo $timerjs; ?>);
</script>
 <?php

 require_once "Includes_footer.php";

<?php
require_once 'includes_header.php';
require_once 'includes_exam_id_check.php';
require_once 'includes_exam_id_val.php';
require_once "includes_popup.php";
$ee = $row['class_id'];
$ee2 = $row['subject_id'];
$exam_id = $examrow['exam_id'];
$tc_id = $examrow['teacher_class_id'];
$student_id = $_SESSION['student_session_id'];
date_default_timezone_set('Asia/Manila');
$current_date = date('Y-m-d H:i:s');
$a =1;
      $sql = "SELECT * FROM exam_question WHERE exam_id=?";
			$stmt = mysqli_stmt_init($conn);
		    if(!mysqli_stmt_prepare($stmt, $sql)) {
							$_SESSION['error'] = "SQL error";
				      header("location: exam_open.php?tc_id=$tcid&exam_id=$exam_id&sql=error");
              exit();
			  }
    				mysqli_stmt_bind_param($stmt, "i", $exam_id);
				    mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
              if ($result->num_rows > 0) {
                //show the info as $row
								//this can be use by another file if imported
                //error in url id is missing go back to homepage
              } else if($result->num_rows == 0){
								$_SESSION['error'] = "This exam has no question. Please contact your teacher.";
                header("location: exam_open.php?tc_id=$tcid&exam_id=$exam_id&id_url=no_match");
								exit();
			        }
            //searhing for subject_code of subject_id
            $sql33 = "SELECT subject_code FROM subjects where subject_id = $ee2;";
            $classNN = $conn->query($sql33);
            $classNN2 = mysqli_fetch_assoc($classNN);

            $sql3332 = "SELECT * FROM student_exam where exam_id = $exam_id AND student_id = $student_id;";
            $classNNN1 = $conn->query($sql3332);
            if ($classNNN1->num_rows == 0) {
              $add_exam_students = "INSERT INTO student_exam (exam_id, teacher_class_id, teacher_id, class_id, student_id, max_attempt, deadline_date,  exam_title, exam_description,
                published, timer, start_date)
               VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?,?);";
              $stmt = mysqli_stmt_init($conn);
              //Preparing the prepared statement
              if(!mysqli_stmt_prepare($stmt, $add_exam_students)) {
                  $_SESSION['error'] = "SQL error, please contact tech support.";
                  header("Location: exam_open.php?tc_id=$tcid&exam_id=$exam_id&sql=error");
                  exit();
              }
              mysqli_stmt_bind_param($stmt, "iiiiiisssiis", $examrow['exam_id'], $examrow['teacher_class_id'], $examrow['teacher_id'], $examrow['class_id'], $student_id,
              $examrow['max_attempt'], $examrow['deadline_date'], $examrow['exam_title'], $examrow['exam_description'], $examrow['published'], $examrow['timer'], $examrow['start_date']);
                mysqli_stmt_execute($stmt);
            }
            $sql333 = "SELECT used_attempt, deadline_date, max_attempt, start_date FROM student_exam where exam_id = $exam_id AND student_id = $student_id;";
            $classNNN = $conn->query($sql333);
            $classNN22 = mysqli_fetch_assoc($classNNN);
            if($classNN22['start_date'] <= $current_date){
            }else {
              $_SESSION['error'] = "You cannot take an exam that does not started yet!";
              header("location: exam_open.php?tc_id=$tcid&exam_id=$exam_id&time=due");
              exit();
            }
              if($classNN22['deadline_date'] >= $current_date){
              }else {
                $_SESSION['error'] = "You cannot take an exam that is past its due!";
                header("location: exam_open.php?tc_id=$tcid&exam_id=$exam_id&time=due");
                exit();
              }
            if ($classNN22['used_attempt'] >= $classNN22['max_attempt']) {
                $_SESSION['error'] = "You have used all of your attempts. You cannot answer it again!";
                header("location: exam_open.php?tc_id=$tcid&exam_id=$exam_id&sattempt=max");
                exit();
             }else {
              $used_attempt = $classNN22['used_attempt']+1;
              $sql = "UPDATE student_exam SET used_attempt=? WHERE exam_id=? AND student_id =?";
              $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                      $_SESSION['error'] = "SQL error";
                      header("location: exam_open.php?tc_id=$tcid&exam_id=$exam_id&sql=error");
                       exit();
                }
                    mysqli_stmt_bind_param($stmt, "iii", $used_attempt, $exam_id, $student_id);
                    mysqli_stmt_execute($stmt);
                    $add_one = 1;
             }
             $time = $examrow['timer'];
             $date = date('Y-m-d H:i:s', strtotime('+'.$time.' minute'));
             $timerjs = $examrow['timer'] * 60000;
             $timestamp = strtotime($date); $today = date("g:i a", $timestamp);
 ?>
 <div class="top" id="myTop" ><img src="download (1).png" alt="School Logo"height="100">E-SKWELA</div>
 <div class="container-xxl">
 <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>
 <div class="card w-100" style="margin-bottom: 15px;">
    <div class="card-body">
      <h1 class="card-title"><?php echo $classNN2['subject_code']." - EXAM";?></h1>
    </div>
  </div>
  <div class="card w-100">
    <div class="card-body">
    <small>These answers will be discarded if without submisssion in <?php echo $today; ?>.</small>
    <small>Please submit your exam before leaving the page.</small><br>
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
<form id="form" onsubmit="return clicked()"action="exam_submit.php?tc_id=<?php echo $tc_id; ?>&exam_id=<?php echo $exam_id; ?>" method="post">
  <input type="hidden" name="add_one" value="<?php echo $add_one; ?>">
  <input type="hidden" name="start_time" value="<?php echo $current_date; ?>">
<?php
    $tf = 0;
    $multi = 0;
    $enum = 0;
    $numbered = 1;
    while ($examquestions = mysqli_fetch_assoc($result)) {
    $sum =  $examquestions['points_1']+$examquestions['points_2']+$examquestions['points_3']+$examquestions['points_4']+$examquestions['points_5'];
              if($examquestions['exam_type_id'] == 1){
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
                                <?php echo $examquestions['exam_question_txt'];?>
                              </div>
                          </td>
                          </tr>
                          <tr>
                            <th width="30%">Answer</th>
                            <td width="2%">:</td>
                            <td>
                              <div class="form-group">
                                <input type="hidden" name="TF_id[]" value="<?php echo $examquestions['exam_question_id'];?>">
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
                elseif ($examquestions['exam_type_id'] == 2) {
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
                              <?php echo $examquestions['exam_question_txt'];?>
                              <input type="hidden" name="multi_id[]" value="<?php echo $examquestions['exam_question_id'];?>">
                            </div>
                        </td>
                        </tr>
                        <tr>
                          <th width="30%"><?php echo $examquestions['answer_a_2'];?></th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                                A <input type="radio" style="cursor: pointer;" name="multi<?php echo $multi; ?>" value="A" checked>
                            </div>
                        </td>
                        </tr>
                        <tr>
                          <th width="30%"><?php echo $examquestions['answer_b_3'];?></th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                                B <input type="radio" style="cursor: pointer;" name="multi<?php echo $multi; ?>" value="B">
                            </div>
                        </td>
                        </tr>
                        <tr>
                          <th width="30%"><?php echo $examquestions['answer_c_4'];?></th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                                C <input type="radio" style="cursor: pointer;" name="multi<?php echo $multi; ?>" value="C">
                            </div>
                        </td>
                      </tr>
                        <tr>
                          <th width="30%"><?php echo $examquestions['answer_d_5'];?></th>
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
                elseif ($examquestions['exam_type_id'] == 3) {
                  ?>
                  <div class="card shadow-sm" style="margin-top:10px;" id="" >
                    <div class="card-header bg-transparent border-0">
                      <small style="float:right;"><?php echo $sum." "; ?>Points</small>
                      <h4 class="mb-0"><?php echo $numbered.". "; ?>Enumeration</h4>
                      <small><?php
                      if ($examquestions['case_sensitive'] == "no") {
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
                              <?php echo $examquestions['exam_question_txt'];?>
                                  <input type="hidden" name="enum_id[]" value="<?php echo $examquestions['exam_question_id'];?>">
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
                        <?php if ($examquestions['answer_a_2'] != NULL): ?>
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
                        <?php if ($examquestions['answer_b_3'] != NULL): ?>
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
                        <?php if ($examquestions['answer_c_4'] != NULL): ?>
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
                        <?php if ($examquestions['answer_d_5'] != NULL): ?>
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
                elseif ($examquestions['exam_type_id'] == 4) {
                  ?>
                  <div class="card shadow-sm" style="margin-top:10px;" id="" >
                    <div class="card-header bg-transparent border-0">
                      <small style="float:right;"><?php echo $sum." "; ?>Points</small>
                      <h4 class="mb-0"><?php echo $numbered.". "; ?>Identification</h4>
                      <small ><?php
                      if ($examquestions['case_sensitive'] == "no") {
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
                              <?php echo $examquestions['exam_question_txt'];?>
                                <input type="hidden" name="iden_id[]" value="<?php echo $examquestions['exam_question_id'];?>">
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
                elseif ($examquestions['exam_type_id'] == 5) {
                  ?>
                  <div class="card shadow-sm" style="margin-top:10px;" id="" >
                    <div class="card-header bg-transparent border-0">
                      <small style="float:right;"><?php echo $sum." "; ?>Points</small>
                      <h4 class="mb-0"><?php echo $numbered.". "; ?>Essay</h4>

                    </div>
                    <div class="card-body pt-0">
                      <table class="table table-bordered">
                        <tr>
                          <th width="30%">Instruction</th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                                <input type="hidden" name="essay_id[]" value="<?php echo $examquestions['exam_question_id'];?>">
                              <?php echo $examquestions['exam_question_txt'];?>
                            </div>
                        </td>
                        </tr>
                        <tr>
                          <th width="30%">Answer</th>
                          <td width="2%">:</td>
                          <td>
                            <div class="form-group">
                              <textarea class="form-control" name="essay[]"></textarea>
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
                  <input type="hidden" name="submit_exam"  value="SUBMIT ALL">
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
      text: "You are about to submit all of your exam answers. Are you sure about that?",
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
  window.location = "exam_open.php?tc_id=<?php echo $tc_id."&exam_id=".$exam_id; ?>";
  <?php $_SESSION['caution'] = "Submit your answers before timer goes off, do not leave the page without submitting your answers, and every page refresh will also count as an attempt."; ?>
}, <?php echo $timerjs; ?>);
</script>

 <?php

 require_once "Includes_footer.php";

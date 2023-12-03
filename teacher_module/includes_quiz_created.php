<!-- for viewing created questions -->
<div id="created_questions" style="display: none;">
      <h5>Created Questions</h5>
        <?php
        $sql = "SELECT * FROM quiz_question WHERE quiz_id=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['error'] = "SQL error, please contact tech support.";
                header("location: teacher_view_quiz.php?tc_id=$iddd&sql=error");
                exit();
          } else {
              mysqli_stmt_bind_param($stmt, "i", $quiziddd);
              mysqli_stmt_execute($stmt);
              $result123 = mysqli_stmt_get_result($stmt);
                if ($result123->num_rows > 0) {
                  //show the info
                  ?>
                  <script type="text/javascript">
                  var dataArray = new Array();
                  </script>
                  <?php
                  $sql51 = "SELECT * FROM quiz_question WHERE quiz_id= $quiziddd;";
                  $classN12 = $conn->query($sql51);
                  while ($quizrow12345 = mysqli_fetch_assoc($classN12)) {
                    ?>
                    <!-- Numbered radio button questions to be showed -->
                    <span ><?php echo $a; $a++;?></span>&nbsp;&nbsp;
                    <input type="radio" style="cursor: pointer;" name="questions" onclick="showDivQ(<?php echo $quizrow12345['quiz_question_id']; ?>)" value="<?php echo $quizrow12345['quiz_question_id']; ?>">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                  <?php }
                  while ($quizrow1234 = mysqli_fetch_assoc($result123)) {
                    ?>
                    <div  style="display:none" id="div<?php echo $quizrow1234['quiz_question_id']; ?>">
                      <?php
                      $two = 2;
                      //check if the quiz is true or false type
                      if ($quizrow1234['quiz_type_id']==1) {
                        ?>
                        <!-- True or false UPDATE-->
                        <form class="form-horizontal" action="quiz_add_query.php?view_id=<?php echo $two ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>" method="post" id="TFshow" style="display: block;">
                          <label>True or False</label><br>
                          <label>Question</label><br>
                          <input type="hidden" name="question_id" value="<?php echo $quizrow1234['quiz_question_id']; ?>">
                          <textarea name="TFQ" maxlength="250" style="width: 100%; height: 100px;" required><?php echo $quizrow1234['quiz_question_txt']; ?></textarea><br>
                          <!-- Check if the value is t or f -->
                          <?php if ($quizrow1234['answer_1']=="true") {
                            ?>
                            <input type="radio" name="TFcorrect" value="true" required checked="checked">
                            <label>TRUE</label>
                            <input type="radio" name="TFcorrect" value="false">
                            <label>FALSE</label><br>
                            <?php
                          } else {
                            ?>
                            <input type="radio" name="TFcorrect" value="true" required>
                            <label>TRUE</label>
                            <input type="radio" name="TFcorrect" value="false" checked="checked">
                            <label>FALSE</label><br>
                            <?php
                          }
                           ?>
                          <label>Points</label>
                          <input type="number" name="TFpoints" min="1" max="100" value="<?php echo $quizrow1234['points_1']; ?>"
                          onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points" required></p>
                          <div class="btn-group" role="group">
                            <input type="submit" class="btn btn-success" name="TF_Update" value="Update">
                            <button type="button" class="btn btn-danger" onclick="ConfirmDelete('quiz_add_query.php?question_iddd=<?php echo $quizrow1234['quiz_question_id']; ?>&view_id=<?php echo $two ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>')">Delete</button>
                          </div>
                        </form>
                        <?php
                      }
                        // check if quiz is multiple choice
                      elseif ($quizrow1234['quiz_type_id']==2) {
                        ?>
                        <!-- Multiple choice UPDATE-->
                          <form class="form-horizontal" action="quiz_add_query.php?view_id=<?php echo $two ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>" method="post" id="multiShow" style="display: block;">
                            <label>Multiple Choice</label><br>
                            <label>Question</label><br>
                            <input type="hidden" name="question_id" value="<?php echo $quizrow1234['quiz_question_id']; ?>">
                            <textarea name="MCQ" style="width: 100%; height: 100px;" required><?php echo $quizrow1234['quiz_question_txt']; ?></textarea><br>
                            <label>Choices</label><br>
                            <!-- check if the answer in multiple choice is A -->
                            <?php if ($quizrow1234['answer_1']=="A") {
                              ?>
                              A: <input type="radio" name="multi_correct" value="A" required checked="checked">
                              <textarea name="A" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_a_2']; ?></textarea><br>
                              B: <input type="radio" name="multi_correct" value="B">
                              <textarea name="B" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_b_3']; ?></textarea><br>
                              C: <input type="radio" name="multi_correct" value="C">
                              <textarea name="C" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_c_4']; ?></textarea><br>
                              D: <input type="radio" name="multi_correct" value="D">
                              <textarea name="D" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_d_5']; ?></textarea><br>
                              <?php
                              //  check if the answer in multiple choice is B
                            } elseif ($quizrow1234['answer_1']=="B") {
                              ?>
                              A: <input type="radio" name="multi_correct" value="A" required >
                              <textarea name="A" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_a_2']; ?></textarea><br>
                              B: <input type="radio" name="multi_correct" value="B" checked="checked">
                              <textarea name="B" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_b_3']; ?></textarea><br>
                              C: <input type="radio" name="multi_correct" value="C">
                              <textarea name="C" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_c_4']; ?></textarea><br>
                              D: <input type="radio" name="multi_correct" value="D">
                              <textarea name="D" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_d_5']; ?></textarea><br>
                              <?php
                              //  check if the answer in multiple choice is C
                            }elseif ($quizrow1234['answer_1']=="C") {
                              ?>
                              A: <input type="radio" name="multi_correct" value="A" required >
                              <textarea name="A" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_a_2']; ?></textarea><br>
                              B: <input type="radio" name="multi_correct" value="B" >
                              <textarea name="B" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_b_3']; ?></textarea><br>
                              C: <input type="radio" name="multi_correct" value="C" checked="checked">
                              <textarea name="C" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_c_4']; ?></textarea><br>
                              D: <input type="radio" name="multi_correct" value="D">
                              <textarea name="D" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_d_5']; ?></textarea><br>
                              <?php
                              //  check if the answer in multiple choice is D
                            }elseif ($quizrow1234['answer_1']=="D") {
                              ?>
                              A: <input type="radio" name="multi_correct" value="A" required >
                              <textarea name="A" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_a_2']; ?></textarea><br>
                              B: <input type="radio" name="multi_correct" value="B" checked="checked">
                              <textarea name="B" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_b_3']; ?></textarea><br>
                              C: <input type="radio" name="multi_correct" value="C">
                              <textarea name="C" style="width: 80%; height: 70px;" required ><?php echo $quizrow1234['answer_c_4']; ?></textarea><br>
                              D: <input type="radio" name="multi_correct" value="D" checked="checked">
                              <textarea name="D" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_d_5']; ?></textarea><br>
                              <?php
                            }
                             ?>
                            <label>Points</label>
                            <input type="number" name="Multipoints" min="1" max="100" value="<?php echo $quizrow1234['points_1']; ?>"
                            onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points" required></p>
                            <div class="btn-group" role="group">
                              <input type="submit" class="btn btn-success" name="Multi_Update" value="Update">
                              <button type="button" class="btn btn-danger" onclick="ConfirmDelete('quiz_add_query.php?question_iddd=<?php echo $quizrow1234['quiz_question_id']; ?>&view_id=<?php echo $two ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>')">Delete</button>

                            </div>
                          </form>
                        <?php
                      }
                      // Check if the quiz type is enumeration
                      elseif ($quizrow1234['quiz_type_id']==3) {
                        ?>
                        <!-- Enumeration UPDATE -->
                          <form class="form-horizontal" action="quiz_add_query.php?view_id=<?php echo $two ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>" method="post" id="enume" style="display: block;">
                            <label>Enumeration</label><br>
                            <label>Question</label><br>
                            <input type="hidden" name="question_id" value="<?php echo $quizrow1234['quiz_question_id']; ?>">
                            <textarea name="ENUMQ" style="width: 100%; height: 100px;" required><?php echo $quizrow1234['quiz_question_txt']; ?></textarea><br>
                            <?php
                            if ($quizrow1234['case_sensitive'] == "no") {
                              ?>
                              <label >Case Sensitive: </label>
                              <input type="checkbox" name="check" value="checked"><br>
                              <?php
                            }else {
                              ?>
                              <label >Case Sensitive: </label>
                              <input type="checkbox" name="check" value="checked" checked><br>
                              <?php
                            }
                             ?>
                            <label>Answer/s</label>
                            <select name="enumNumbers"  onchange="choicesChange2<?php echo $quizrow1234['quiz_question_id']; ?>(this)">
                              <?php
                              // checking if how many answers are being selected 1, 2, 3, 4, and 5
                              if ($quizrow1234['enum_sum']==1) {
                                ?><option value="1" selected>1</option><?php
                              } else {
                                ?><option value="1">1</option><?php
                              }if ($quizrow1234['enum_sum']==2) {
                                ?><option value="2" selected>2</option><?php
                              } else {
                                ?><option value="2">2</option><?php
                              }if ($quizrow1234['enum_sum']==3) {
                                ?><option value="3" selected>3</option><?php
                              } else {
                                ?><option value="3">3</option><?php
                              }if ($quizrow1234['enum_sum']==4) {
                                ?><option value="4" selected>4</option><?php
                              } else {
                                ?><option value="4">4</option><?php
                              }if ($quizrow1234['enum_sum']==5) {
                                ?><option value="5" selected>5</option><?php
                              } else {
                                ?><option value="5">5</option><?php
                              }?>
                            </select><br>
                            <!-- this is the first block of answer, which is never going to be blank so no need checking -->
                            <div id="A1A<?php echo $quizrow1234['quiz_question_id']; ?>" style="display: block;">
                            <textarea id="A111<?php echo $quizrow1234['quiz_question_id']; ?>" name="A1" style="width: 80%; height: 70px;" required><?php echo $quizrow1234['answer_1']; ?></textarea>
                            <input id="A11_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>" type="number" value="<?php echo $quizrow1234['points_1']; ?>"
                            style="width: 17%;" name="A1_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points" required><br>
                            </div>
                            <!-- Check if 2nd answer is null, if null dont diplay the block of answer 2 if not null the show-->
                            <?php if ($quizrow1234['answer_a_2']==NULL) {
                              ?>
                              <div id="B2B<?php echo $quizrow1234['quiz_question_id']; ?>" style="display: none;">
                              <textarea id="A122<?php echo $quizrow1234['quiz_question_id']; ?>" name="B2" style="width: 80%; height: 70px;"></textarea>
                              <input id="B22_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>" type="number" style="width: 17%;"name="B2_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"<br>
                              </div>
                              <?php
                            } else {
                              ?>
                              <div id="B2B<?php echo $quizrow1234['quiz_question_id']; ?>" style="display: block;">
                              <textarea id="A122<?php echo $quizrow1234['quiz_question_id']; ?>" name="B2" style="width: 80%; height: 70px;"><?php echo $quizrow1234['answer_a_2']; ?></textarea>
                              <input id="B22_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>" type="number" value="<?php echo $quizrow1234['points_2']; ?>"
                              style="width: 17%;"name="B2_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"<br>
                              </div>
                              <?php
                              //        Check if 3rd answer is null, if null dont diplay the block of answer 3 if not null the show
                            }if ($quizrow1234['answer_b_3']==NULL) {
                              ?>
                              <div id="C3C<?php echo $quizrow1234['quiz_question_id']; ?>" style="display: none;">
                              <textarea id="A133<?php echo $quizrow1234['quiz_question_id']; ?>" name="C3" style="width: 80%; height: 70px;"></textarea>
                              <input id="C33_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>" type="number"
                              style="width: 17%; " name="C3_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"><br>
                              </div>
                              <?php

                            } else {
                              ?>
                              <div id="C3C<?php echo $quizrow1234['quiz_question_id']; ?>" style="display: block;">
                              <textarea id="A133<?php echo $quizrow1234['quiz_question_id']; ?>" name="C3" style="width: 80%; height: 70px;"><?php echo $quizrow1234['answer_b_3']; ?></textarea>
                              <input id="C33_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>" type="number" value="<?php echo $quizrow1234['points_3']; ?>"
                              style="width: 17%; " name="C3_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"><br>
                              </div>
                              <?php
                                // Check if 4th answer is null, if null dont diplay the block of answer 4 if not null the show
                            }if ($quizrow1234['answer_c_4']==NULL) {
                              ?>
                              <div id="D4D<?php echo $quizrow1234['quiz_question_id']; ?>" style="display: none;">
                              <textarea id="A144<?php echo $quizrow1234['quiz_question_id']; ?>" name="D4" style="width:80%; height: 70px;"></textarea>
                              <input id="D44_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>" type="number" style="width: 17%;" name="D4_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"><br>
                              </div>
                              <?php
                            } else {
                              ?>
                              <div id="D4D<?php echo $quizrow1234['quiz_question_id']; ?>" style="display: block;">
                              <textarea id="A144<?php echo $quizrow1234['quiz_question_id']; ?>" name="D4" style="width:80%; height: 70px;"><?php echo $quizrow1234['answer_c_4']; ?></textarea>
                              <input id="D44_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>" type="number" value="<?php echo $quizrow1234['points_4']; ?>"
                              style="width: 17%;" name="D4_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"><br>
                              </div>
                              <?php
                            // Check if 5th answer is null, if null dont diplay the block of answer 5 if not null the show
                            }if ($quizrow1234['answer_d_5']==NULL) {
                              ?>
                              <div id="E5E<?php echo $quizrow1234['quiz_question_id']; ?>" style="display: none;">
                              <textarea id="A155<?php echo $quizrow1234['quiz_question_id']; ?>" name="E5" style="width: 80%; height: 70px;"></textarea>
                              <input id="E55_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>" type="number" style="width: 17%;" name="E5_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"><br>
                              </div>
                              <?php
                            } else {
                              ?>
                              <div id="E5E<?php echo $quizrow1234['quiz_question_id']; ?>" style="display: blocke;">
                              <textarea id="A155<?php echo $quizrow1234['quiz_question_id']; ?>" name="E5" style="width: 80%; height: 70px;"><?php echo $quizrow1234['answer_d_5']; ?></textarea>
                              <input id="E55_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>" type="number"  value="<?php echo $quizrow1234['points_5']; ?>"
                              style="width: 17%;" name="E5_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"><br>
                              </div>
                              <?php
                            }?>
                            <div class="btn-group" role="group">
                              <input type="submit" class="btn btn-success" name="Enum_Update" value="Update">
                              <button type="button" onclick="ConfirmDelete('quiz_add_query.php?question_iddd=<?php echo $quizrow1234['quiz_question_id']; ?>&view_id=<?php echo $two ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>')" class="btn btn-danger">Delete</button>
                            </div>
                          </form>
                          <!-- loop script to give for each answer block of enumeration, to be able to show how many blocks
                          are indicated in the dropdown list. In loop because each enumeration questions have different id and block
                          format.
                          -->
                          <!-- dropdown list for enumeration -->
                          <script type="text/javascript">
                          function choicesChange2<?php echo $quizrow1234['quiz_question_id']; ?>(select){
                            var one1 = document.getElementById('A1A<?php echo $quizrow1234['quiz_question_id']; ?>');
                            var one2 = document.getElementById('B2B<?php echo $quizrow1234['quiz_question_id']; ?>');
                            var one3 = document.getElementById('C3C<?php echo $quizrow1234['quiz_question_id']; ?>');
                            var one4 = document.getElementById('D4D<?php echo $quizrow1234['quiz_question_id']; ?>');
                            var one5 = document.getElementById('E5E<?php echo $quizrow1234['quiz_question_id']; ?>');
                            if(select.value==1){
                              one1.style.display = "block";
                              one2.style.display = "none";
                              one3.style.display = "none";
                              one4.style.display = "none";
                              one5.style.display = "none";
                              document.getElementById("A111<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A122<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A133<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A144<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A155<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A11_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("B22_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("C33_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("D44_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("E55_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                            }else if (select.value==2) {
                              one1.style.display = "block";
                              one2.style.display = "block";
                              one3.style.display = "none";
                              one4.style.display = "none";
                              one5.style.display = "none";
                              document.getElementById("A111<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A122<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A133<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A144<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A155<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A11_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("B22_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("C33_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("D44_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("E55_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                            }else if (select.value==3) {
                              one1.style.display = "block";
                              one2.style.display = "block";
                              one3.style.display = "block";
                              one4.style.display = "none";
                              one5.style.display = "none";
                              document.getElementById("A111<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A122<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A133<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A144<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A155<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A11_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("B22_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("C33_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("D44_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("E55_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                            }else if (select.value==4) {
                              one1.style.display = "block";
                              one2.style.display = "block";
                              one3.style.display = "block";
                              one4.style.display = "block";
                              one5.style.display = "none";
                              document.getElementById("A111<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A122<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A133<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A144<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A155<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                              document.getElementById("A11_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("B22_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("C33_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("D44_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("E55_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = false;
                            }else if (select.value==5) {
                              one1.style.display = "block";
                              one2.style.display = "block";
                              one3.style.display = "block";
                              one4.style.display = "block";
                              one5.style.display = "block";
                              document.getElementById("A111<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A122<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A133<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A144<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A155<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("A11_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("B22_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("C33_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("D44_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                              document.getElementById("E55_enumpoints<?php echo $quizrow1234['quiz_question_id']; ?>").required = true;
                            }else{
                              alert("No selected value");
                              one1.style.display = "none";
                              one2.style.display = "none";
                              one3.style.display = "none";
                              one4.style.display = "none";
                              one5.style.display = "none";
                            }
                          }
                          </script>
                        <?php
                      }
                        // Check if quiztype question is identification
                      elseif ($quizrow1234['quiz_type_id']==4) {
                        ?>
                          <!-- Identification UPDATE-->
                          <form class="form-horizontal" action="quiz_add_query.php?view_id=<?php echo $two ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>" method="post" id="idenShow" style="display: block;">
                            <label>Identification</label><br>
                            <label>Question</label><br>
                            <input type="hidden" name="question_id" value="<?php echo $quizrow1234['quiz_question_id']; ?>">
                            <textarea name="IDNQ" style="width: 100%; height: 100px;" required><?php echo $quizrow1234['quiz_question_txt']; ?></textarea><br>
                            <?php
                            if ($quizrow1234['case_sensitive'] == "no") {
                              ?>
                              <label >Case Sensitive: </label>
                              <input type="checkbox" name="check" value="checked"><br>
                              <?php
                            }else {
                              ?>
                              <label >Case Sensitive: </label>
                              <input type="checkbox" name="check" value="checked" checked><br>
                              <?php
                            }
                             ?>
                            <label>Answer</label><br>
                            <textarea name="answerIDN"  style="width: 100%; height: 100px;" required><?php echo $quizrow1234['answer_1']; ?></textarea><br>
                            <label>Points</label>
                            <input type="number" name="IDENpoints" min="1" max="100"  value="<?php echo $quizrow1234['points_1']; ?>"
                            onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points" required></p>
                            <div class="btn-group" role="group">
                              <input type="submit" class="btn btn-success" name="Iden_Update" value="Update">
                              <input type="button" onclick="ConfirmDelete('quiz_add_query.php?question_iddd=<?php echo $quizrow1234['quiz_question_id']; ?>&view_id=<?php echo $two ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>')" class="btn btn-danger" value="Delete">
                            </div>
                          </form>
                        <?php
                      } ?>
                    </div>
                      <script type="text/javascript">
                      //add in array
                      dataArray.push("<?php echo $quizrow1234['quiz_question_id']; ?>");
                      //console.log(dataArray);
                      //show question div update depends on question id
                      function showDivQ(x){
                        let i = 0;
                        //current quiz_id
                        var current = "div"+x;
                        //loop to check arrays and set all style display = none
                        while (dataArray[i]) {
                          var a = "div"+dataArray[i];
                          //none
                          document.getElementById(a).style.display = "none";
                          //check if the current quiz_id is = to the variable in loop
                          if (current == a) {
                            //if yes, then check if its style is in none.
                            if(document.getElementById(current).style.display = "none"){
                              let ii = 0;
                              //if the style of current is none, loop all as none and..
                              while (dataArray[ii]) {
                                  var a1 = "div"+dataArray[ii];
                                  document.getElementById(a1).style.display = "none";
                                  ii++;
                              }
                              //..only current question will be set as block or showned
                              document.getElementById(current).style.display = "block";
                              //then stop
                              break

                            }else{
                              let iii = 0;
                              while (dataArray[iii]) {
                                  var a2 = "div"+dataArray[iii];
                                  document.getElementById(a2).style.display = "none";
                                  iii++;
                              }
                              break;
                            }
                            //If current is not in the loop, then set all display as none
                          } else {
                          document.getElementById(current).style.display = "none";
                          }
                          i++;
                        }
                      }
                      </script>
                    <?php
                  };
                  //error, id in url id is not found in database. Or not accesible by the teacher
                } else if($result123->num_rows == 0){
                  echo "No available questions";
                }
              }
         ?>
</div>

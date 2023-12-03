<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM quiz;";
  $quiz = $conn->query($checkClasses11);

?>
<div class="container">
  <h2 class="head" id="text" style="margin-top:40px; margin-bottom:20px">Created Quizzes</h2>
                  <hr size="4" width="100%" color="grey">
                      <button type="button" onclick="goBack()" style="float:right; width: 100px;" class="btn btn-primary">BACK</button>
                      <div class="row" style="margin-bottom: 10px;">
                        <h1>&nbsp</h1>
                      </div>
                  <div class="table-responsive" style="display: block; margin-top: 10px;" id="quizs">
                  <table id="myidata" style="width:100%">
                      <thead>
                       <tr>
                         <th>School ID</th>
                        <th> Created by</th>
                        <th> Section </th>
                        <th> Created Date </th>
                        <th> Start Date</th>
                        <th> Deadline Date</th>
                        <th> Questions </th>
                        <th> Attempts </th>
                        <th> Time </th>
                        <th> Published</th>
                       </tr>
                      </thead>
                      <?php
                      while ($quiz_row = mysqli_fetch_assoc($quiz)) {
                        $teacher_id = $quiz_row['teacher_id'];
                        $class_id = $quiz_row['class_id'];
                        $quiz_id = $quiz_row['quiz_id'];
                        $checkClasses11 = "SELECT * FROM quiz_question where quiz_id = $quiz_id;";
                        if($teachers = $conn->query($checkClasses11)){
                          $number2 = mysqli_num_rows($teachers);
                          if ($number2 == 0) {
                            $number = "None";
                          }else {
                            $number = $number2." item";
                          }
                        }
                        $checkClasses11 = "SELECT * FROM teachers where teacher_id = $teacher_id;";
                        $teachers = $conn->query($checkClasses11);
                        $teacher_row = mysqli_fetch_assoc($teachers);
                        $checkClasses11 = "SELECT * FROM class where class_id = $class_id;";
                        $classes = $conn->query($checkClasses11);
                        $class_row = mysqli_fetch_assoc($classes);
                        if ($quiz_row['published'] == 1) {
                          $published = "Yes";
                        }else {
                          $published = "No";
                        }
                        if (strtotime($quiz_row['upload_date'])) {
                          $timestamp = strtotime($quiz_row['upload_date']);
                          $upload = date("F j Y, g:i a", $timestamp);
                        }else {
                          $today = "Unreadable";
                        }
                        if (strtotime($quiz_row['start_date'])) {
                          $timestamp = strtotime($quiz_row['start_date']);
                          $start = date("F j, g:i a", $timestamp);
                        }else {
                          $start = "Unreadable";
                        }
                        if (strtotime($quiz_row['deadline_date'])) {
                          $timestamp = strtotime($quiz_row['deadline_date']);
                          $end = date("F j, g:i a", $timestamp);
                        }else {
                          $end = "Unreadable";
                        }
                        ?>
                       <tr>
                         <td><?php echo $teacher_row['teacher_id']; ?></td>
                         <td><?php echo $teacher_row['l_name'].", ".$teacher_row['f_name']; ?></td>
                         <td><?php echo $class_row['class_name']; ?></td>
                         <td><?php echo $upload; ?></td>
                         <td><?php echo $start; ?></td>
                         <td><?php echo $end; ?></td>
                         <th><?php echo $number; ?></th>
                         <td><?php echo $quiz_row['max_attempt']; ?></td>
                         <td><?php echo $quiz_row['timer']." mins"; ?></td>
                         <td><?php echo $published; ?></td>
                       </tr>
                        <?php
                      }
                       ?>
                  </table>
                  </div>
                  </div>
                  <script>
                  $(document).ready(function() {
                      $('#myidata').DataTable( {
                        dom: 'Blfrtip',
                        "order": [[ 0, "desc" ]],
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Created quizs ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Created quizzes ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';

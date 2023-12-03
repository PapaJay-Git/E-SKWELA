<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM teacher_assignments ;";
  $assignment = $conn->query($checkClasses11);

?>
<div class="container">
  <h2 class="head" id="text" style="margin-top:40px; margin-bottom:20px">Created Assignments</h2>
                  <hr size="4" width="100%" color="grey">
                      <button type="button" onclick="goBack()" style="float:right; width: 100px;" class="btn btn-primary">BACK</button>
                      <div class="row" style="margin-bottom: 10px;">
                        <h1>&nbsp</h1>
                      </div>
                  <div class="table-responsive" style="display: block; margin-top: 10px;" id="assignments">
                  <table id="myidata" style="width:100%">
                      <thead>
                       <tr>
                         <th>School ID</th>
                        <th> Created by</th>
                        <th> Section </th>
                        <th> Created Date </th>
                        <th> Start Date</th>
                        <th> Deadline Date</th>
                        <th> File Instruction </th>
                        <th> Attempts </th>
                        <th> Published</th>
                       </tr>
                      </thead>
                      <?php
                      while ($assignment_row = mysqli_fetch_assoc($assignment)) {
                        $teacher_id = $assignment_row['teacher_id'];
                        $class_id = $assignment_row['class_id'];
                        $checkClasses11 = "SELECT * FROM teachers where teacher_id = $teacher_id;";
                        $teachers = $conn->query($checkClasses11);
                        $teacher_row = mysqli_fetch_assoc($teachers);
                        $checkClasses11 = "SELECT * FROM class where class_id = $class_id;";
                        $classes = $conn->query($checkClasses11);
                        $class_row = mysqli_fetch_assoc($classes);
                        if ($assignment_row['published'] == 1) {
                          $published = "Yes";
                        }else {
                          $published = "No";
                        }
                        if (strtotime($assignment_row['upload_date'])) {
                          $timestamp = strtotime($assignment_row['upload_date']);
                          $upload = date("F j Y, g:i a", $timestamp);
                        }else {
                          $today = "Unreadable";
                        }
                        if (strtotime($assignment_row['start_date'])) {
                          $timestamp = strtotime($assignment_row['start_date']);
                          $start = date("F j, g:i a", $timestamp);
                        }else {
                          $start = "Unreadable";
                        }
                        if (strtotime($assignment_row['deadline_date'])) {
                          $timestamp = strtotime($assignment_row['deadline_date']);
                          $end = date("F j, g:i a", $timestamp);
                        }else {
                          $end = "Unreadable";
                        }
                        if ($assignment_row['ass_loc'] != NULL && $assignment_row['ass_loc'] != "") {
                          $file = "Exist";
                        }else{
                          $file = "None";
                        }
                        ?>
                       <tr>
                         <td><?php echo $teacher_row['school_id'] ?></td>
                         <td><?php echo $teacher_row['l_name'].", ".$teacher_row['f_name']; ?></td>
                         <td><?php echo $class_row['class_name']; ?></td>
                         <td><?php echo $upload; ?></td>
                         <td><?php echo $start; ?></td>
                         <td><?php echo $end; ?></td>
                         <th><?php echo $file; ?></th>
                         <td><?php echo $assignment_row['sub_attempt']; ?></td>
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
                           title: 'Created assignments ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Created assignments ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';


<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM files;";
  if($output11 = $conn->query($checkClasses11)){
    $modules = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM exam;";
  if($output11 = $conn->query($checkClasses11)){
    $exams = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM quiz";
  if($output11 = $conn->query($checkClasses11)){
    $quizzes = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM teacher_assignments;";
  if($output11 = $conn->query($checkClasses11)){
    $assignments = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM student;";
  if($output11 = $conn->query($checkClasses11)){
    $students = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM admin;";
  if($output11 = $conn->query($checkClasses11)){
    $admins = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM parents;";
  if($output11 = $conn->query($checkClasses11)){
    $parents = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM teachers;";
  if($output11 = $conn->query($checkClasses11)){
    $teachers = mysqli_num_rows($output11);
  }
  $sum = $students+$admins+$parents+$teachers;

?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">User Logs</h2>
                  <hr size="4" width="100%" color="grey">
                  <div class="table-responsive">
                  <table id="myidata" class="display responsive nowrap" style="width:100%">
                      <thead>
                       <tr>
                        <th> TYPE</th>
                        <th> TOTAL </th>
                        <th> OPEN </th>
                       </tr>
                      </thead>
                      <tr>
                        <td> USER LOGIN</td>
                        <td><?php echo $sum; ?></td>
                        <td><a href="user_login.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td> UPLOADED MODULES </td>
                        <td><?php echo $modules; ?></td>
                        <td><a href="modules.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td> CREATED EXAMS </td>
                        <td><?php echo $exams; ?></td>
                        <td><a href="logs_exam.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>CREATED QUIZZES</td>
                        <td><?php echo $quizzes; ?></td>
                        <td><a href="logs_quizzes.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>CREATED ASSIGNMENTS</td>
                        <td><?php echo $assignments; ?></td>
                        <td><a href="logs_assignments.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                  </table>
                  </div>
                  </div>
                  <script>
                  $(document).ready(function() {
                      $('#myidata').DataTable( {
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Logs ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Logs ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';

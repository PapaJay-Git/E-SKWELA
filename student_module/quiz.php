
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';?>

    <div class="container-xxl">
    <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>
         <h1 class="card-title">QUIZZES</h1>
             <hr size="4" width="100%" color="grey">

      <div class="card">
       <div class="card-header">
         Enrolled Subjects
       </div>
       <div class="card-body"><!-- BODY-->
          <div class="row">
            <div class="table-responsive">
             <table id="classdata" class="table table-hover table-xxlg table-bordered">
                 <caption><?php echo $row['f_name']." ".$row['l_name']."'s SUBJECTS"; ?></caption>
                 <thead>
                  <tr>
                   <th> Teacher Name</th>
                   <th> Subject</th>
                   <th> Quizzes </th>
                  </tr>
                  </thead>
<?php
                  $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
                  $stmt = mysqli_stmt_init($conn);
                  if(!mysqli_stmt_prepare($stmt, $sql)) {
                    $_SESSION['error'] = "SQL error, on page grades";
                    header("location: index.php?view=sqlerror");
                    exit();
                  } else {
                    mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
                    mysqli_stmt_execute($stmt);
                    $result_2 = mysqli_stmt_get_result($stmt);
                    while ($row_2 = mysqli_fetch_assoc($result_2)) {
                      $teacher_id = $row_2['teacher_id'];
                      $subject_code_check = $row_2['subject_id'];
                      $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_id;";
                      $output11 = $conn->query($checkClasses11);
                      if ($output11->num_rows > 0) {
                        $arrayClasses11 = mysqli_fetch_assoc($output11);
                        $teacher_fname = $arrayClasses11['f_name'];
                        $teacher_lname = $arrayClasses11['l_name'];
                      }else {
                        $teacher_fname = "DELETED";
                        $teacher_lname = "TEACHER";
                      }
                      //
                      $checkClasses112 = "SELECT subject_code FROM subjects class where subject_id = $subject_code_check;";
                      $output112 = $conn->query($checkClasses112);
                      $arrayClasses112 = mysqli_fetch_assoc($output112);
                      ?>
                      <tr>
                        <td><?php echo $teacher_fname." ".$teacher_lname;?></td>
                        <td><?php echo $arrayClasses112['subject_code']; ?></td>
                        <td><a href="quiz_view.php?tc_id=<?php echo $row_2['teacher_class_id']; ?>" class="btn btn-primary">OPEN<a></td>
                      </tr>
                      <?php
                    }
                  }
          ?>
                </table>
          <!-- for tables design, functions and printing output -->
           <script>
           $(document).ready(function() {
               $('#classdata').DataTable( {
                 dom: 'Blfrtip',
                 lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                	buttons: ['copy',
          				{
          					extend: 'print',
          					title: 'My Quizzes, id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
          				}]
             } );
           } );
            </script>

          </div>
      </div>
    </div>
  </div>
</div>

<?php
  require_once 'includes_footer.php';

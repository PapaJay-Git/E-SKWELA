
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';?>

    <div class="container-xxl">
    <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>

         <h1 class="card-title">Grades</h1>
             <hr size="4" width="100%" color="grey">

      <div class="card">
       <div class="card-header">
         Subject grades
       </div>
       <div class="card-body"><!-- BODY-->
          <div class="row">
            <div class="table-responsive">
             <table id="classdata" class="table table-hover table-xxlg table-bordered">
                 <caption><?php echo $row['f_name']." ".$row['l_name']."'s Grade"; ?></caption>
                 <thead>
                  <tr>
                   <th> Teacher Name</th>
                   <th> Subject</th>
                   <th> 1st </th>
                   <th> 2nd </th>
                   <th> 3rd </th>
                   <th> 4th </th>
                   <th> Final </th>
                  </tr>
                  </thead>
<?php
if ($row['class_id'] == 1) {
  $ten = 10;
  $sql = "SELECT * FROM subjects WHERE grade =?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    $_SESSION['error'] = "SQL error, on page grades";
    header("location: index.php?view=sqlerror");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "i", $ten);
    mysqli_stmt_execute($stmt);
    $result_22 = mysqli_stmt_get_result($stmt);
    while ($row_22 = mysqli_fetch_assoc($result_22)) {
      $subject_code_check = $row_22['subject_id'];
      $studentid = $_SESSION['student_session_id'];
      $grade = "SELECT * FROM stu_grade where student_id = $studentid AND subject_id = $subject_code_check;";
      $gradeoutput = $conn->query($grade);
      if ($gradeoutput->num_rows > 0) {
        $view_grade = mysqli_fetch_assoc($gradeoutput);
        $one = $view_grade['first'];
        $two = $view_grade['second'];
        $three =  $view_grade['third'];
        $four = $view_grade['fourth'];
        $five = $view_grade['final'];
        $teacher_iddddd = $view_grade['teacher_id'];
      }else {
        $one = 0;
        $two = 0;
        $three = 0;
        $four = 0;
        $five = 0;
        $teacher_iddddd = 0;
      }
      $checkClasses11 = "SELECT f_name, l_name FROM teachers where teacher_id = $teacher_iddddd;";
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
      $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
      $output112 = $conn->query($checkClasses112);
      if ($output112->num_rows > 0) {
        $arrayClasses112 = mysqli_fetch_assoc($output112);
        $subject_code = $arrayClasses112['subject_title'];
      }else {
        $subject_code = "DELETED SUBJECT";
      }

      ?>
      <tr>
        <td><?php echo $teacher_fname." ".$teacher_lname;?></td>
        <td><?php echo  $subject_code;?></td>
        <td><?php echo $one; ?></td>
        <td><?php echo $two; ?></td>
        <td><?php echo $three;?></td>
        <td><?php echo $four; ?></td>
        <td><?php echo $five; ?></td>
      </tr>
      <?php
    }
  }

}else {
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
                      $checkClasses112 = "SELECT subject_title FROM subjects class where subject_id = $subject_code_check;";
                      $output112 = $conn->query($checkClasses112);
                      if ($output112->num_rows > 0) {
                        $arrayClasses112 = mysqli_fetch_assoc($output112);
                        $subject_code = $arrayClasses112['subject_title'];
                      }else {
                        $subject_code = "DELETED SUBJECT";
                      }
                      $studentid = $_SESSION['student_session_id'];
                      $teacher_class_id = $row_2['teacher_class_id'];
                      $grade = "SELECT * FROM stu_grade where student_id = $studentid AND subject_id = $subject_code_check;";
                      $gradeoutput = $conn->query($grade);
                      if ($gradeoutput->num_rows > 0) {
                        $view_grade = mysqli_fetch_assoc($gradeoutput);
                        $one = $view_grade['first'];
                        $two = $view_grade['second'];
                        $three =  $view_grade['third'];
                        $four = $view_grade['fourth'];
                        $five = $view_grade['final'];
                      }else {
                        $one = 0;
                        $two = 0;
                        $three = 0;
                        $four = 0;
                        $five = 0;
                      }
                      ?>
                      <tr>
                        <td><?php echo $teacher_fname." ".$teacher_lname;?></td>
                        <td><?php echo  $subject_code;?></td>
                        <td><?php echo $one; ?></td>
                        <td><?php echo $two; ?></td>
                        <td><?php echo $three;?></td>
                        <td><?php echo $four; ?></td>
                        <td><?php echo $five; ?></td>
                      </tr>
                      <?php
                    }
                  }

                    // code...
                  }
          ?>
                </table>

          </div>
      </div>
    </div>
  </div>
</div>
<!-- for tables design, functions and printing output -->
 <script>
 $(document).ready(function() {
     $('#classdata').DataTable( {
       dom: 'Blfrtip',
       lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        buttons: ['copy',
        {
          extend: 'print',
          title: 'My Grades, id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
        }]
   } );
 } );
  </script>
<?php
  require_once 'includes_footer.php';

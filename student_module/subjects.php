
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
?>

    <div class="container-xxl">
    <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>

         <h1 class="card-title">Subjects</h1>
             <hr size="4" width="100%" color="grey">

      <div class="card">
       <div class="card-header">
         Student's Subjects
       </div>
       <div class="card-body"><!-- BODY-->
          <div class="row">
    <?php

      $sql = "SELECT * FROM teacher_class WHERE class_id=?;";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?view=sqlerror");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "i", $row['class_id']);
        mysqli_stmt_execute($stmt);
        $result_2 = mysqli_stmt_get_result($stmt);
        while ($row_2 = mysqli_fetch_assoc($result_2)) {
          $class_name_check = $row_2['class_id'];
          $subject_code_check = $row_2['subject_id'];
          $checkClasses11 = "SELECT class_name FROM class where class_id = $class_name_check;";
          $output11 = $conn->query($checkClasses11);
          $arrayClasses11 = mysqli_fetch_assoc($output11);
          //
          $checkClasses112 = "SELECT subject_code FROM subjects where subject_id = $subject_code_check;";
          $output112 = $conn->query($checkClasses112);
          $arrayClasses112 = mysqli_fetch_assoc($output112);
          ?>
          <div class="col-md-4 mb-3">
            <div class="card"><img style="cursor: pointer;"class="img-fluid" alt="100%x280"
              src="../assets/subj_pics/subject_pic.jpg" onClick="window.location.href = 'view_modules.php?tc_id=<?php echo $row_2['teacher_class_id'] ?>';" title="Click to view Modules">

              <div class="card-body">
                <a href="view_modules.php?tc_id=<?php echo $row_2['teacher_class_id'] ?>" style="text-decoration:none" title="Click to view Modules">
                  <h4 class="card-title"><?php echo $arrayClasses11['class_name']." ".$arrayClasses112['subject_code']; ?></h4>
                </a>
                <center>
                  <span style="display: inline-block;">
                    <a href="view_modules.php?tc_id=<?php echo $row_2['teacher_class_id'] ?>" class="btn btn-primary" title="Click to view Modules">Modules</a>
                  </span>
                </center>
              </div>
            </div>
          </div>
          <?php
        }
      }
  ?>
      </div>
    </div>
  </div>
</div>

<?php
  require_once 'includes_footer.php';

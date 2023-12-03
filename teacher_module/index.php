
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d H:i:s');

        $checkClasses11 = "SELECT * FROM announcements ORDER BY announcement_id DESC";
        $ann = $conn->query($checkClasses11);
        $ann3 = 0;
        while ($ann4 = mysqli_fetch_assoc($ann)) {
          if ($ann4['deadline'] >= $date) {
            $ann3 +=1;
          }
        }
        $ann->data_seek(0);

        $online_teacher = "SELECT * FROM teachers";
        $online_teacher2 = $conn->query($online_teacher);

?>


<div class="container-fluid">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 mr-auto">

              <h1 class="card-title">Teacher's Dashboard</h1>
                  <hr size="4" width="100%" color="grey">


            <div class="card mb-3">

              <div class="card-header">
                Welcome <?php echo $row['f_name']; ?>
              </div>

              <div class="card-body">
                <div class="row">
    <?php

      $sql = "SELECT * FROM teacher_class WHERE teacher_id=?;";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?view=sqlerror");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "i", $row['teacher_id']);
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
              src="../assets/subj_pics/subject_pic.jpg" onClick="window.location.href = 'teacher_view_modules.php?tc_id=<?php echo $row_2['teacher_class_id'] ?>';" title="Click to view Modules">

              <div class="card-body">
                <a href="teacher_view_modules.php?tc_id=<?php echo $row_2['teacher_class_id'] ?>" style="text-decoration:none" title="Click to view Modules">
                  <h4 class="card-title"><?php echo $arrayClasses11['class_name']." ".$arrayClasses112['subject_code']; ?></h4>
                </a>
                <center>
                  <span style="display: inline-block;">
                    <a href="teacher_view_assignments.php?tc_id=<?php echo $row_2['teacher_class_id'] ?>" style="width: 40px;display: inline-block;"class="btn btn-primary" title="Open Assignments">A</a>
                    <a href="teacher_view_exam.php?tc_id=<?php echo $row_2['teacher_class_id'] ?>" style="width: 40px;display: inline-block;"class="btn btn-primary" title="Open Exams">E</a>
                    <a href="teacher_view_students.php?tc_id=<?php echo $row_2['teacher_class_id'] ?>" style="width: 40px;display: inline-block;"class="btn btn-primary" title="Open Grades">G</a>
                    <a href="teacher_view_quiz.php?tc_id=<?php echo $row_2['teacher_class_id'] ?>" style="width: 40px;display: inline-block;"class="btn btn-primary" title="Open Quizzes">Q</a>
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
  <div class="col-lg-3">
          <div class="box">

            <div class="row">

              <div class="col-md-12">
                <div class="card mb-3" >
                  <div class="card-header">
                    Calendar
                  </div>

                  <div class="card-body">
                    <script src="https://jsuites.net/v4/jsuites.js"></script>
                    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />

                    <div id='calendar'></div>

                  </div>
                </div>
              </div>

            </div>


              <div class="row">

                <div class="col-md-12">

                  <div class="card mb-3 majorpoints">
                    <div class="card-header majorpointslegend">
                      Announcement (<?php echo $ann3; ?>)
                    </div>

                    <div class="card-body">
                      <a onClick="announcement()" id="show" title="Show/hide"style="cursor: pointer; color:green; font-size: 14px">Show...</a>
                      <div id="a1" style="display:none;">
                      <ul class="list-unstyled">
                        <?php
                        while ($ann2 = mysqli_fetch_assoc($ann)) {
                          $title = mb_strimwidth($ann2['title'], 0, 25, "...");
                          if ($ann2['deadline'] >= $date) {
                           ?>
                          <div class="col-xs-12 col-md-10">
                           <li class="d-flex mb-2"> <a title="Announcement" href="view_announcement.php?id=<?php echo $ann2['announcement_id']; ?>" style="text-decoration:none"><?php echo $title; ?></a> </li>
                        </div>
                      <?php
                          }
                        }
                         ?>
                      </ul>
                    </div>
                    </div>
                  </div>

                </div>
                </div>

            </div>

            <div class="row">

              <div class="col-md-12 ">
                <div class="card mb-3 majorpoints">
                  <div class="card-header majorpointslegend">
                    Online
                  </div>

                  <div class="card-body hider">
                    <div class="row align-items-center">
                      <?php
                        $limit_online = 8;
                        $based_online = 0;
                        while ($online_row = mysqli_fetch_assoc($online_teacher2)) {
                        $new_date = date('Y-m-d H:i:s',strtotime('-5 minutes',strtotime($date)));
                        if ($online_row['last_log_in'] >= $new_date) {

                        if (file_exists($online_row['profile'])) {
                          $profile_pic = $online_row['profile'];
                        } else {
                          $profile_pic = "../assets/subj_pics/profile.png";
                        }
                        $based_online += 1;
                        ?>
                        <div class="col-sm-6">
                          <center>
                              <a href="others.php?id=<?php echo $online_row['teacher_id'] ?>" title="Profile" style="text-decoration:none; cursor: pointer; color: black;" >
                          <img class="img-fluid" style=" width: 100px; height: 100px; object-fit: cover; margin: 10px auto; border: 10px solid #301934; border-radius: 50%;"
                          src="<?php echo $profile_pic; ?>" alt="NO IMAGE" class="rounded-circle" >
                          <p><?php echo $online_row['l_name'];?></p></a></center>
                        </div>
                        <?php
                        if ($based_online >= $limit_online) {
                          break;
                        }
                      }
                    }?>

                    </div>

                  </div>
                </div>
              </div>

          </div>
        </div>
      </div>
    </div>
</div>
</div>
<script type="text/javascript">
    var show = document.getElementById('show');
    var ann = document.getElementById('a1');
  function announcement() {
    if (ann.style.display == "block") {
      ann.style.display = "none";
      show.innerHTML = "Show...";
      console.log('ss');
    }else if (ann.style.display == "none") {
      ann.style.display = "block";
      show.innerHTML = "Hide...";
    }

  }
  $('.majorpoints').click(function(){
    $(this).find('.hider').toggle();
  });

  jSuites.calendar(document.getElementById('calendar'), {
    format: 'YYYY-MM-DD',
    onupdate: function(a,b) {
      document.getElementById('calendar-value');
    }
  });
</script>


<?php
  require_once 'includes_footer.php';

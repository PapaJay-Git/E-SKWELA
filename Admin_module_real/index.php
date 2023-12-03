
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';

  date_default_timezone_set('Asia/Manila');
  $date = date('Y-m-d H:i:s');
  $online_admin = "SELECT * FROM admin";
  $online_admin2 = $conn->query($online_admin);
?>

<div class="container-fluid">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 mr-auto">

              <h1 class="card-title">Admin's Dashboard</h1>
                  <hr size="4" width="100%" color="grey">


            <div class="card mb-3">

              <div class="card-header">
                Welcome <?php echo $row['f_name']; ?>
              </div>

              <div class="card-body">
                <div class="row">
    <?php
          $checkClasses11 = "SELECT * FROM announcements ORDER BY announcement_id DESC";
          $ann = $conn->query($checkClasses11);
          $ann3 = 0;
          while ($ann4 = mysqli_fetch_assoc($ann)) {
            if ($ann4['deadline'] >= $date) {
              $ann3 +=1;
            }
          }
          $ann->data_seek(0);

          $checkClasses11 = "SELECT * FROM student";
          if($output11 = $conn->query($checkClasses11)){
            $students = mysqli_num_rows($output11);
          }
          $checkClasses11 = "SELECT * FROM teachers";
          if($output11 = $conn->query($checkClasses11)){
            $teachers = mysqli_num_rows($output11);
          }
          $checkClasses11 = "SELECT * FROM admin";
          if($output11 = $conn->query($checkClasses11)){
            $admins = mysqli_num_rows($output11);
          }
          $checkClasses11 = "SELECT * FROM parents";
          if($output11 = $conn->query($checkClasses11)){
            $parents = mysqli_num_rows($output11);
          }
          $checkClasses11 = "SELECT * FROM files";
          if($output11 = $conn->query($checkClasses11)){
            $modules = mysqli_num_rows($output11);
          }
          $checkClasses11 = "SELECT * FROM subjects";
          if($output11 = $conn->query($checkClasses11)){
            $subjects = mysqli_num_rows($output11);
          }
          $checkClasses11 = "SELECT * FROM class";
          if($output11 = $conn->query($checkClasses11)){
            $sections = mysqli_num_rows($output11);
          }
          $checkClasses11 = "SELECT * FROM exam";
          if($output11 = $conn->query($checkClasses11)){
            $exams = mysqli_num_rows($output11);
          }
          $checkClasses11 = "SELECT * FROM quiz";
          if($output11 = $conn->query($checkClasses11)){
            $quiz = mysqli_num_rows($output11);
          }
          $checkClasses11 = "SELECT * FROM teacher_assignments";
          if($output11 = $conn->query($checkClasses11)){
            $assignments = mysqli_num_rows($output11);
          }

          ?>
          <div class="col-md-4 mb-3">
            <a href="students.php" style="text-decoration:none" >
            <div class="card" title="STUDENTS"style="cursor: pointer;">
              <center>
                <h2> <?php echo $students; ?></h2>
                <h5>Total Students</h5>
              </center>
            </div>
            </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="teachers.php" style="text-decoration:none" >
            <div class="card" title="TEACHERS"style="cursor: pointer;">
              <center>
                <h2> <?php echo $teachers; ?></h2>
                <h5>Total Teachers</h5>
              </center>
            </div>
          </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="parents.php"style="text-decoration:none" >
            <div class="card" title="PARENTS"style="cursor: pointer;">
              <center>
                <h2> <?php echo $parents; ?></h2>
                <h5>Total Parents</h5>
              </center>
            </div>
          </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="admins.php" style="text-decoration:none" >
            <div class="card" title="ADMINS"style="cursor: pointer;">
              <center>
                <h2> <?php echo $admins; ?></h2>
                <h5>Total Admins</h5>
            </center>
            </div>
          </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="modules.php"style="text-decoration:none" >
            <div class="card" title="MODULES"style="cursor: pointer;">
              <center>
                <h2> <?php echo $modules; ?></h2>
                <h5>Total Modules</h5>
            </center>
            </div>
          </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="curriculum.php" style="text-decoration:none" >
            <div class="card" title="SUBJECTS"style="cursor: pointer;">
              <center>
                <h2> <?php echo $subjects; ?></h2>
                <h5>Total Subjects</h5>
              </center>
            </div>
          </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="sections.php"style="text-decoration:none" >
            <div class="card" title="SECTIONS"style="cursor: pointer;">
              <center>
                <h2> <?php echo $sections; ?></h2>
                <h5>Total Sections</h5>
            </center>
          </div>
        </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="logs_exam.php"style="text-decoration:none" >
            <div class="card" title="EXAMS"style="cursor: pointer;">
              <center>
                <h2> <?php echo $exams; ?></h2>
                <h5>Total Exams</h5>
            </center>
            </div>
          </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="logs_quizzes.php"style="text-decoration:none" >
            <div class="card" title="QUIZZES"style="cursor: pointer;">
              <center>
                <h2> <?php echo $quiz; ?></h2>
                <h5>Total Quizzes</h5>
            </center>
            </div>
          </a>
          </div>
          <div class="col-md-4 mb-3">
            <a href="logs_assignments.php"style="text-decoration:none" >
            <div class="card" title="ASSIGNMENTS"style="cursor: pointer;">
              <center>
                <h2> <?php echo $assignments; ?></h2>
                <h5>Total Assignments</h5>
            </center>
            </div>
          </a>
          </div>
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
                        while ($online_row = mysqli_fetch_assoc($online_admin2)) {
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
                            <a href="others.php?id=<?php echo $online_row['admin_id'] ?>" title="Profile" style="text-decoration:none; cursor: pointer; color: black;" >
                          <img class="img-fluid" style=" width: 100px; height: 100px; object-fit: cover; margin: 10px auto; border: 10px solid #301934; border-radius: 50%;"
                          src="<?php echo $profile_pic; ?>" alt="NO IMAGE" class="rounded-circle" >
                          <p><?php echo $online_row['l_name'];?></p> </a></center>
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
</script>
<script>
  jSuites.calendar(document.getElementById('calendar'), {
    format: 'YYYY-MM-DD',
    onupdate: function(a,b) {
      document.getElementById('calendar-value');
    }
  });
</script>


<?php
  require_once 'includes_footer.php';

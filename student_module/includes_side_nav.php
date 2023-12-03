<?php
  if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  die('Direct access not allowed');
  exit();
  };
  date_default_timezone_set('Asia/Manila');
  $date = date('Y-m-d H:i:s');
  $sql_online = "UPDATE student SET last_log_in = ?, last_session_id = ? WHERE student_id =?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql_online);
  mysqli_stmt_bind_param($stmt, "ssi", $date, $date, $_SESSION['student_session_id']);
  mysqli_stmt_execute($stmt);
  $_SESSION['last_session_id'] = $date;
  $session_id_12345 = $_SESSION['student_session_id'];
  $check1234 = "SELECT class_id FROM student where student_id = $session_id_12345;";
  $check12345 = $conn->query($check1234);
  $check1234567 = mysqli_fetch_assoc($check12345);
  $my_class_id_for_notif = $check1234567['class_id'];
  $status = "unread";
  $pubs = 1;
  $sql_online = "SELECT * FROM student_notification WHERE student_id =? AND status =? AND published=? AND class_id =?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql_online);
  mysqli_stmt_bind_param($stmt, "isii", $_SESSION['student_session_id'], $status, $pubs, $my_class_id_for_notif);
  mysqli_stmt_execute($stmt);
  $result_check = mysqli_stmt_get_result($stmt);
  $number = $result_check->num_rows;

  function badgeNotif(){
    global $number;
    if ($number > 0) {
      ?><span class="badge"><?php echo $number; ?></span><?php
    }
  }
  ?>
  <style media="screen">
  .badge{
    position: relative !important;
    top: -7px;
    right: 7px;
    padding: 2px 2px;
    border-radius: 20%;
    background: red;
    color: white;
  }
  </style>
<div class="top" id="myTop"><img src="download (1).png" alt="School Logo"  height="100">E-SKWELA</div>
<div class="conatainer">
<div class="topnav" id="myTopnav">
  <a href="index.php">Home</a>
  <a href="profile.php">Profile</a>
  <a href="subjects.php">Subjects</a>
  <a href="grades.php">Grades</a>
  <a href="exam.php" >Exams</a>
  <a href="quiz.php" >Quizzes</a>
  <a href="assignment.php" >Assignments</a>
  <a href="notification.php">Notifications
  <?php badgeNotif(); ?></a>
  <a href="#" onClick="logout()" >Logout</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
  <b style="width: 30px; font-size:23px;  transform: scale(.5, 1);">&#9778; <?php badgeNotif(); ?></b>
  </a>
</div>
</div>
<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
<script>
// Add active class to the current button
jQuery(function($) {
  var path = window.location.href;
  // because the 'href' property of the DOM element is the absolute path
  $('a').each(function() {
    if (this.href === path) {
      $(this).addClass('active');
    }
  });
});
</script>
<?php require_once "includes_popup.php"; ?>

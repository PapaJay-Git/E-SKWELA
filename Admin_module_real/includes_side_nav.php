<?php
  if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  die('Direct access not allowed');
  exit();
  };
  date_default_timezone_set('Asia/Manila');
  $date = date('Y-m-d H:i:s');
  $sql_online = "UPDATE admin SET last_log_in = ?, last_session_id = ? WHERE admin_id =?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql_online);
  mysqli_stmt_bind_param($stmt, "ssi", $date, $date, $_SESSION['admin_session_id']);
  mysqli_stmt_execute($stmt);
  $_SESSION['admin_last_session_id'] = $date;
  $sql_online = "SELECT * FROM admin_notification WHERE admin_id =? AND status =?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql_online);
  $status ="unread";
  mysqli_stmt_bind_param($stmt, "is", $_SESSION['admin_session_id'], $status);
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
  <a href="users.php" >Users</a>
  <a href="curriculum.php">Curriculum</a>
  <a href="sections.php" >Classes</a>
  <a href="announcement.php" >Announcement</a>
  <a href="notifications.php">Notifications
  <?php badgeNotif(); ?></a>
  <a href="logs.php" >Logs</a>
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

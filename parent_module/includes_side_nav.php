<?php
  if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  die('Direct access not allowed');
  exit();
  };
  date_default_timezone_set('Asia/Manila');
  $date = date('Y-m-d H:i:s');
  $sql_online = "UPDATE parents SET last_log_in = ? WHERE parent_id =?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql_online);
  mysqli_stmt_bind_param($stmt, "si", $date, $_SESSION['parent_session_id']);
  mysqli_stmt_execute($stmt);
?>

  <div class="top" id="myTop"><img src="download (1).png" alt="School Logo"  height="100">E-SKWELA</div>
<div class="conatainer">

<div class="topnav" id="myTopnav">
  <a href="index.php">Home</a>
  <a href="profile.php">Profile</a>
  <a href="#" onClick="logout()" >Logout</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
  <b style="width: 30px; font-size:23px;  transform: scale(.5, 1);">&#9778;</b>
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

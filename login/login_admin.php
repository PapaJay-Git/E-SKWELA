<?php
  require_once '../assets/db.php';
  require_once 'checker.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SKWELA </title>
    <link rel="icon" href="logo1.png">
    <link type="text/css" rel="stylesheet" href="../assets/bootstrap-5.1.0-dist/css/bootstrap.min.css">
    <script language="javascript" src="../assets/bootstrap-5.1.0-dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../assets/tables/jquery-3.5.1.js"></script>
    <!--Sweetalert for notification-->
    <script type="text/javascript" language="javascript" src="../assets/sweetalert/sweetalert2.all.min.js"></script>
    <script src="../assets/promise/promise.min.js"></script>


<link href="css/login.css" rel="stylesheet" type="text/css">
<link href="css/captcha.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
<div class=" hero d-flex" style="background-image: url('images/banner_2.0.jpg');">
  <div class="container">
    <div>
          <a class="navbar-brand" href="../website/index.php"><img src="images/Nav-logo.png" width="400px" height="120px"></a>
        </div>


    <div class="d-flex justify-content-center align-items-center mt-1">
      <div class="card">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item text-center">
            <a class="nav-link active btl">Admin</a>
          </li>
        </ul>
        <form action="#" onsubmit="clickedForm();return false" id="admin_form" method="post" style="display:block">
          <center><h4>Admin Login</h4></center>
          <div class="form px-4 pt-5" style="margin-top: -20px;">
            <input type="text" name="id_admin" id="admin_login_id" class="form-control" placeholder="Login ID" required>
            <input type="password" name="password_admin" id="admin_login_password" class="form-control" placeholder="Password" required>
            <div class="captcha-area">
                <div class="captcha-img">
                  <img src="images/captcha-bg.png" alt="Captch Background">
                  <span class="captcha" id="captcha_admin"></span>
                </div>
                <button type="button" onClick="change_admin()" class="reload-btn btn-dark"><i class="fas fa-redo-alt"></i></button>
              </div>
                <input type="text" id="admin_input" class="form-control" placeholder="Enter captcha" maxlength="6" spellcheck="false" required>
                 <div id="admin_text"></div>
                 <button style="width: 100%;" id="admin_check" onClick="clicked_admin()"class="btn btn-dark" type="button"><b>Check Captcha</b></button>
                <input style="width: 100%; display:none" id="admin_submit" name="admin_submit" class="btn btn-dark" type="button" value="Login">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function clickedForm() {

  var admin_ID = document.getElementById('admin_login_id').value;
  var admin_PASS = document.getElementById('admin_login_password').value;
  $.ajax({
  url : 'log_admin_query.php',
  data : {'admin_id' : admin_ID, 'admin_password': admin_PASS},
  type : 'POST',
  dataType : "text",
  cache : false,

  success : function(result) {
  if (result == "notset") {
    Swal.fire({title: "Empty", text: "Your input info is empty."});
  }else if (result == "wrongid") {
    Swal.fire({title: "Wrong", text: "Wrong admin Login ID."});
  }else if (result == "wrongpassword") {
    Swal.fire({title: "Wrong", text: "Wrong admin Password."});
  }else if (result == "success") {
    swal.fire({position: 'center', icon: 'success', title: 'Logging you in...', showConfirmButton: false, timer: 2500, timerProgressBar: true})
    setTimeout( function () {
      window.location.reload();
    }, 2500);
  }else if (result == "inactive") {
    Swal.fire({title: "Inactive", text: "This account was set as inactive by an admin. You cannot login until it was activated!"});
  }
  },
  error : function (request, status, error) {
        console.log(error);
  }
  });
}
</script>
<script src="js/admin.js"></script>
</body>
</html>
<script>
if (window.document.documentMode) {
  Swal.fire({
  width: '800px',
  title: 'We do not support Internet Explorer <br><h5>Please use one of these browsers</h5>',
  showConfirmButton: false,
  allowOutsideClick: false,
  html:
  '<a href="https://www.google.com/chrome/?form=MY01SV&OCID=MY01SV" target="_blank"><img src="../assets/pics/chrome.png" width="100px" height="100px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
  '<a href="https://www.microsoft.com/en-us/edge" target="_blank"><img src="../assets/pics/edge.png" width="100px" height="100px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
  '<a href="https://www.mozilla.org/en-US/firefox/new/" target="_blank"><img src="../assets/pics/firefox.png" width="100px" height="100px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
  '<a href="https://support.apple.com/downloads/safari" target="_blank"><img src="../assets/pics/safari.png" width="100px" height="100px"></a>'
})
}
</script>
<noscript>
  <meta http-equiv="Refresh" content="0; url=no_js.php">
</noscript>

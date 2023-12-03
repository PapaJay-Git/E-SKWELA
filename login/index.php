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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/login.css" rel="stylesheet" type="text/css">
    <link href="css/captcha.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <style type="text/css">
      @media (max-width: 505px) {
                  .logo{
                    width: 250px;
                    height: 80px;
                  }}
      @media (max-height: 505px) {
                  .logo{
                    width: 250px;
                    height: 80px;
                  }}

    </style>

</head>
<body>
  <!-- Background image -->
  <div class="image-fluid bg-image" 
       style="background-image: url('images/banner2.jpeg'); background-size: cover ;
              height: 180vh">
    <div class="container">
      <a class="navbar-brand" href="../website/"><img class ="logo" src="images/Nav-logo.png" width="400px" height="120px"></a>
    </div>

    <div class="d-flex justify-content-center align-items-center">
      <div class="card">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item text-center">
            <a class="nav-link active btl btr" onclick="location.reload();" style="text-align: left;cursor: pointer;">Login<i class="fas fa-sign-in-alt"style="float:right; "></i></a>
          </li>
        </ul>
        <form action="#" onsubmit="clickedForm4();return false" id="admin_form" method="post" style="display:none">
          <center><h4><i class="fas fa-user"></i> Admin Login</h4></center>
          <div class="form px-4 pt-5" style="margin-top: -20px;">
            <input type="number" name="id_admin" id="admin_login_id" class="form-control" placeholder="Login ID" required>
            <input type="password" name="password_admin" id="admin_login_password" class="form-control" placeholder="Password" required>
            <div class="captcha-area">
                <div class="captcha-img">
                  <img src="images/captcha-bg.png" alt="Captch Background">
                  <span class="captcha" id="captcha_admin"></span>
                </div>
                <button type="button" onClick="change_admin()" class="reload-btn btn-dark"><i class="fas fa-redo-alt"></i></button>
              </div>
                <input type="text" id="admin_input" class="form-control" placeholder="Enter captcha" maxlength="6" spellcheck="false" autocomplete="off" required>
                 <div id="admin_text"></div>
                 <button style="width: 100%;" id="admin_check" onClick="clicked_admin()"class="btn btn-dark" type="button"><b>Check Captcha</b></button>
                <button style="width: 100%; display:none" id="admin_submit" name="admin_submit" class="btn btn-dark" type="button"><b>Login</b></button>
          </div>
        </form>
        <form action="#" onsubmit="clickedForm();return false" id="teacher_form" method="post" style="display:none">
          <center><h4><i class="fas fa-user"></i> Teacher Login</h4></center>
          <div class="form px-4 pt-5" style="margin-top: -20px;">
            <input type="number" name="id_teacher" id="teacher_login_id" class="form-control" placeholder="Login ID" required>
            <input type="password" name="password_teacher" id="teacher_login_password" class="form-control" placeholder="Password" required>
            <div class="captcha-area">
                <div class="captcha-img">
                  <img src="images/captcha-bg.png" alt="Captch Background">
                  <span class="captcha" id="captcha_teacher"></span>
                </div>
                <button type="button" onClick="change_teacher()" class="reload-btn btn-dark"><i class="fas fa-redo-alt"></i></button>
              </div>
                <input type="text" id="teacher_input" class="form-control" placeholder="Enter captcha" maxlength="6" spellcheck="false" autocomplete="off" required>
                 <div id="teacher_text"></div>
                 <button style="width: 100%;" id="teacher_check" onClick="clicked_teacher()"class="btn btn-dark" type="button"><b>Check Captcha</b></button>
                <button style="width: 100%; display:none" id="teacher_submit" name="teacher_submit" class="btn btn-dark" type="button"><b>Login</b></button>
          </div>
        </form>
        <form  action="#" onsubmit="clickedForm2();return false" method="post" id="student_form" style="display:none">
          <center><h4><i class="fas fa-user"></i> Student Login</h4></center>
          <div class="form px-4 pt-5" style="margin-top: -20px;">
            <input type="number" name="id_student" id="student_login_id" class="form-control" placeholder="Login ID" required>
            <input type="password" name="password_student" id="student_login_password" class="form-control" placeholder="Password" required>
            <div class="captcha-area">
                <div class="captcha-img">
                  <img src="images/captcha-bg.png" alt="Captch Background">
                  <span class="captcha" id="captcha_student"></span>
                </div>
                <button type="button" onClick="change_student()" class="reload-btn btn-dark"><i class="fas fa-redo-alt"></i></button>
              </div>
                <input type="text" id="student_input" class="form-control" placeholder="Enter captcha" maxlength="6" spellcheck="false" autocomplete="off" required>
                 <div id="student_text"></div>
                 <button style="width: 100%;" id="student_check" onClick="clicked_student()"class="btn btn-dark" type="button"><b>Check Captcha</b></button>
                <button style="width: 100%; display:none" id="student_submit" name="student_submit" class="btn btn-dark" type="button"><b>Login</b></button>
          </div>
        </form>
        <form  action="#" onsubmit="clickedForm3();return false" method="post" id="parent_form" style="display:none">
          <center><h4><i class="fas fa-user"></i> Parent Login</h4></center>
          <div class="form px-4 pt-5" style="margin-top: -20px;">
            <input type="number" name="id_parent" class="form-control" id="parent_login_id" placeholder="Login ID" required>
            <input type="password" name="password_parent" id="parent_login_password" class="form-control" placeholder="Password" required>
            <div class="captcha-area">
                <div class="captcha-img">
                  <img src="images/captcha-bg.png" alt="Captch Background">
                  <span class="captcha" id="captcha_parent"></span>
                </div>
                <button type="button" onClick="change_parent()" class="reload-btn btn-dark"><i class="fas fa-redo-alt"></i></button>
              </div>
                <input type="text" id="parent_input" class="form-control" placeholder="Enter captcha" maxlength="6" spellcheck="false" autocomplete="off" required>
                 <div id="parent_text"></div>
                 <button style="width: 100%;" id="parent_check" onClick="clicked_parent()"class="btn btn-dark" type="button"><b>Check Captcha</b></button>
                <button style="width: 100%; display:none" id="parent_submit" name="parent_submit" class="btn btn-dark" type="button"><b>Login</b></button>
          </div>
        </form>
      </div>

    </div>
  </div>
  <!-- Background image -->
<script type="text/javascript">
<?php
if (isset($_SESSION['notify'])) {
  ?>
  Swal.fire({title: "Logged Out", text: "We detected that you just logged in on a new browser. For that reason, we logged you out here in this browser."});
  <?php
  unset($_SESSION['notify']);
}
 ?>
 function clickedForm4() {

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
     swal.fire({position: 'center', icon: 'success', title: 'Logging you in...', showConfirmButton: false, timer: 2500, timerProgressBar: true, allowOutsideClick: false})
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
function clickedForm() {

  var teacher_ID = document.getElementById('teacher_login_id').value;
  var teacher_PASS = document.getElementById('teacher_login_password').value;
  $.ajax({
  url : 'login_query.php',
  data : {'teacher_id' : teacher_ID, 'teacher_password': teacher_PASS},
  type : 'POST',
  dataType : "text",
  cache : false,

  success : function(result) {
  if (result == "notset") {
    Swal.fire({title: "Empty", text: "Your input info is empty."});
  }else if (result == "wrongid") {
    Swal.fire({title: "Wrong", text: "Wrong Teacher Login ID."});
  }else if (result == "wrongpassword") {
    Swal.fire({title: "Wrong", text: "Wrong Teacher Password."});
  }else if (result == "success") {
    swal.fire({position: 'center', icon: 'success', title: 'Logging you in...', showConfirmButton: false, timer: 2500, timerProgressBar: true, allowOutsideClick: false})
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
function clickedForm2() {

  var student_ID = document.getElementById('student_login_id').value;
  var student_PASS = document.getElementById('student_login_password').value;
  $.ajax({
  url : 'login_query.php',
  data : {'student_id' : student_ID, 'student_password': student_PASS},
  type : 'POST',
  dataType : "text",
  cache : false,

  success : function(result) {
  if (result == "notset") {
    Swal.fire({title: "Empty", text: "Your input info is empty."});
  }else if (result == "wrongid2") {
    Swal.fire({title: "Invalid", text: "Invalid Student Login ID."});
  }else if (result == "wrongpassword2") {
    Swal.fire({title: "Wrong", text: "Wrong Student Password."});
  }else if (result == "success2") {
    swal.fire({position: 'center', icon: 'success', title: 'Logging you in...', showConfirmButton: false, timer: 2500, timerProgressBar: true, allowOutsideClick: false})
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
function clickedForm3() {

    var parent_ID = document.getElementById('parent_login_id').value;
    var parent_PASS = document.getElementById('parent_login_password').value;
    $.ajax({
    url : 'login_query.php',
    data : {'parent_id' : parent_ID, 'parent_password': parent_PASS},
    type : 'POST',
    dataType : "text",
    cache : false,

    success : function(result) {
    if (result == "notset") {
      Swal.fire({title: "Empty", text: "Your input info is empty."});
    }else if (result == "wrongid3") {
      Swal.fire({title: "Invalid", text: "Invalid Login ID."});
    }else if (result == "wrongpassword3") {
      Swal.fire({title: "Wrong", text: "Wrong Password."});
    }else if (result == "success3") {
      swal.fire({position: 'center', icon: 'success', title: 'Logging you in...', showConfirmButton: false, timer: 2500, timerProgressBar: true, allowOutsideClick: false})
      setTimeout( function () {
        window.location.reload();
      }, 2500);
    }
    },
    error : function (request, status, error) {
          console.log(error);
    }
    });
  }
var teacher = document.getElementById("teacher_form");
var student = document.getElementById("student_form");
var parent = document.getElementById("parent_form");
var admin = document.getElementById("admin_form");

function teachers() {
  teacher.style.display = "block";
  student.style.display = "none";
  parent.style.display = "none";
  admin.style.display = "none";
}
function students() {
  teacher.style.display = "none";
  student.style.display = "block";
  parent.style.display = "none";
  admin.style.display = "none";
}
function parents() {
  teacher.style.display = "none";
  student.style.display = "none";
  parent.style.display = "block";
  admin.style.display = "none";
}
function admins() {
  teacher.style.display = "none";
  student.style.display = "none";
  parent.style.display = "none";
  admin.style.display = "block";
}
</script>
<script src="js/script.js"></script>
</body>
</html>
<script>
Swal.fire({
title: '<h4>Please choose the type of account you have</h4>',
confirmButtonText: 'Done',
confirmButtonColor: "#301934",
allowOutsideClick: false,
html:
'<p> <i class="fas fa-user"></i> Types of account:</p>'+
'<button type="button" style="margin-top: 10px" class="btn btn-dark" name="button" onClick="admins()"><b> ADMIN</b></button>&nbsp;'+
'<button type="button" style="margin-top: 10px" class="btn btn-dark" name="button"  onClick="teachers()"><b> TEACHER</b></button>&nbsp;'+
'<button type="button" style="margin-top: 10px" class="btn btn-dark" name="button"  onClick="students()"><b>STUDENT</b></button>&nbsp;'+
'<button type="button" style="margin-top: 10px" class="btn btn-dark" name="button"  onClick="parents()"><b> PARENT</b></button>'
})
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

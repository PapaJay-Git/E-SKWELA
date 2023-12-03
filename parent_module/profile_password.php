
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head">CHANGE PASSWORD</h2>

            <hr size="4" width="100%" color="grey">
              <!-- Student Profile -->
            <div class="student-profile py-4" >
              <div class="container-md">
                <div class="row">
                  <div class="col-lg-100">
                    <div class="card shadow-sm">
                      <div class="card-body">
                         <form onsubmit="return clicked()" id="formpassword" action="profile_update_password.php?view_id=2" method="post">
                           <div class="form-group">
                             <label for="exampleInputPassword1">New Password</label><br>
                             <label for="password"><small>Only letters (either case), numbers, and the underscore; 6 to 20 characters.</small></label>
                             <input type="password" class="form-control" pattern="[A-Za-z0-9_]{6,20}"
                             placeholder="password" name="new_password" id="password2" onkeyup="check();" title=
                             "Only letters (either case), numbers, and the underscore; 6 to 20 characters. " required>
                           </div>
                           <div class="form-group">
                             <label for="password3">Confirm New Password</label>
                             <input type="password" class="form-control" pattern="[A-Za-z0-9_]{6,20}"
                             placeholder="password" name="confirm_password" id="password3" onkeyup="check();" title=
                             "Only letters (either case), numbers, and the underscore; 6 to 20 characters."  required>
                             <span id='message'></span>
                           </div>
                             <div class="form-group">
                               <label for="password4">Confirm Old Password</label>
                               <input type="password" class="form-control" placeholder="password" id="password4"name="old_password" required>
                             </div>
                             <div class="form-group form-check">
                               <input type="checkbox" class="form-check-input" id="exampleCheck1" onClick="showPass2()">
                               <label class="form-check-label" for="exampleCheck1">Show Password</label>
                             </div>
                             <div class="btn-group" role="group" style="float:right;">
                             <button type="submit" class="btn btn-primary" >UPDATE</button>
                             <input type="hidden" name="update_password" value="hello">
                             <a href="profile.php" class="btn btn-danger">BACK</a>
                             </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
          <script type="text/javascript">
              var check = function() {
                if (document.getElementById('password3').value != "" ||  document.getElementById('password2').value !=""){
                  if (document.getElementById('password3').value == document.getElementById('password2').value) {
                    document.getElementById('message').style.color = 'green';
                    document.getElementById('message').innerHTML = 'password match';
                  } else {
                    document.getElementById('message').style.color = 'red';
                    document.getElementById('message').innerHTML = 'password not match';
                  }
                }else {
                  document.getElementById('message').innerHTML = '';
                }
              }
              function showPass2() {

                var p2 = document.getElementById('password2');
                //question form
                var p3 = document.getElementById('password3');
                var p4 = document.getElementById('password4');
                if (p2.type === "password") {
                    p2.type = "text";
                    p3.type = "text";
                    p4.type = "text";
                    } else {
                      p2.type = "password";
                      p3.type = "password";
                      p4.type = "password";
                    }
              }

              function clicked() {
                  swal.fire({
                    title: "Are you sure?",
                    text: "You are about to change your password. Are you sure you want to do this?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Change"
                  }).then(function (result){
                    if (result.isConfirmed) {
                          document.getElementById("formpassword").submit();
                      } else if (result.dismiss === 'cancel') {
                          swal.fire({position: 'center', icon: 'error', title: 'Change Cancelled', showConfirmButton: false, timer: 1500})
                        }
                    })
              return false;
              }
          </script>
<?php
  require_once 'includes_footer.php';


<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $admin_id = $_GET['admin_id'];
  $sql = "SELECT * FROM admin where admin_id =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: admins.php?view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "i", $admin_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
    } else {
      $_SESSION['error'] = "It looks like this admin is already been deleted!";
        header("location: admins.php?view=failed");
        exit();
    }
?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head" id="h2">CHANGE ADMIN DETAILS</h2>

            <hr size="4" width="100%" color="grey">
            <div class="btn-group" role="group" style="margin-top:20px;">
            <button type="button" class="btn btn-primary" onClick="showName()">Details</button>
            <button type="button" class="btn btn-primary" onClick="showPassword()">Password</button>
            </div>
              <!-- admin Profile -->
            <div class="admin-profile py-4" style="display: block;" id="nameform">
              <div class="container-md">
                <div class="row">
                  <div class="col-lg-100">
                    <div class="card shadow-sm">
                      <div class="card-body">
                         <form onsubmit="return clicked()" id="formpassword" action="edit_admin_query.php" method="post" >
                           <div class="form-group">
                             <label for="ID">School ID</label>
                             <input type="number" class="form-control" id="ID"name="school_id" required value="<?php echo $row['school_id'] ?>">
                             <input type="hidden" name="admin_id" value="<?php echo $row['admin_id']; ?>">
                             <label for="first">First Name</label><br>
                             <input type="text" class="form-control" id="first"name="first" required value="<?php echo $row['f_name'] ?>">
                             <label for="last">Last Name</label>
                             <input type="text" class="form-control" id="last"name="last" required value="<?php echo $row['l_name'] ?>">
                           </div>
                             <div class="btn-group" role="group" style="float:right; margin-top:20px;">
                             <button type="submit" class="btn btn-primary" >UPDATE</button>
                             <input type="hidden" name="update_admin_name" value="low">
                             <a href="admins.php" class="btn btn-danger">BACK</a>
                             </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="admin-profile py-4" style="display: none;" id="passform">
            <div class="container-md">
              <div class="row">
                <div class="col-lg-100">
                  <div class="card shadow-sm">
                    <div class="card-body">
                       <form onsubmit="return clicked2()" id="formpassword2" action="edit_admin_query.php" method="post">
                         <div class="form-group">
                           <label for="password3">New Password</label>
                           <input type="hidden" name="admin_id" value="<?php echo $row['admin_id']; ?>">
                           <input type="password" class="form-control" pattern="[A-Za-z0-9_]{6,20}"
                           placeholder="password" name="new_password" id="password4" title=
                           "Only letters (either case), numbers, and the underscore; 6 to 20 characters."  required>
                         </div>
                         <div class="form-group">
                           <label for="password3">Confirm New Password</label>
                           <input type="password" class="form-control" pattern="[A-Za-z0-9_]{6,20}"
                           placeholder="password" name="confirm_password" id="password3" title=
                           "Only letters (either case), numbers, and the underscore; 6 to 20 characters."  required>
                         </div>
                           <div class="form-group form-check">
                             <input type="checkbox" class="form-check-input" id="exampleCheck1" onClick="showPass2()">
                             <label class="form-check-label" for="exampleCheck1">Show Password</label>
                           </div>
                           <div class="btn-group" role="group" style="float:right;">
                           <button type="submit" class="btn btn-primary" >UPDATE</button>
                           <input type="hidden" name="update_admin_password" value="low">
                           <a href="admins.php" class="btn btn-danger">BACK</a>
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
              function showPass2() {
                var p3 = document.getElementById('password4');
                var p4 = document.getElementById('password3');
                if (p4.type === "password") {
                    p4.type = "text";
                    p3.type = "text";
                    } else {
                      p4.type = "password";
                      p3.type = "password";
                    }
              }

              function showName(){
                document.getElementById('nameform').style.display = "block";
                document.getElementById('passform').style.display = "none";
              }
              function showPassword(){
                document.getElementById('nameform').style.display = "none";
                document.getElementById('passform').style.display = "block";
              }
              function clicked() {
                  swal.fire({
                    title: "Are you sure?",
                    text: "You are about to change the details of this user. Are you sure you want to do that?",
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
              function clicked2() {
                  swal.fire({
                    title: "Are you sure?",
                    text: "You are about to change the password of this user. Are you sure you want to do that?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Change"
                  }).then(function (result){
                    if (result.isConfirmed) {
                          document.getElementById("formpassword2").submit();
                      } else if (result.dismiss === 'cancel') {
                          swal.fire({position: 'center', icon: 'error', title: 'Change Cancelled', showConfirmButton: false, timer: 1500})
                        }
                    })
              return false;
              }
          </script>
<?php
  require_once 'includes_footer.php';

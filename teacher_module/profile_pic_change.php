
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';

?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head">Profile Picture</h2>
            <hr size="4" width="100%" color="grey">

            <section>
                <div class="rt-container-xxl">
                      <div class="col-rt-12">
                          <div class="Scriptcontent">

            <!-- Student Profile -->
            <div class="student-profile py-4" >
              <div class="container-xxl">
                <div class="row">
                  <div class="col-lg-100">
                    <div class="card shadow-sm">
                      <div class="card-header bg-transparent text-center">
                        <img class="profile_img" src="<?php echo $profile_pic;  ?>"  alt="teacher dp">
                        <h3><?php echo $row['f_name']." ".$row['l_name'] ?></h3>
                      </div>
                      <div class="card-body">
                        <form onsubmit="return clicked()" id="form_picture"class="form-group" action="profile_upload_pic.php" method="post" enctype="multipart/form-data">
                          <label class="form-label" for="customFile">Profile Picture</label>
                          <input type="file" name="file" class="form-control" style="margin-bottom:40px" accept="image/*" required>
                          <div class="row">
                            <div class="col-md-8"><h5> </h5></div>
                            <div class="col-md-4 btn-group" role="group">
                              <input type="submit" style="float:right;" class="btn btn-primary" value="UPLOAD">
                              <input type="hidden" name="change_profile" value="value">
                              <a href="profile.php" class="btn btn-danger" >BACK</a>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- partial -->

                		</div>
            		</div>
                </div>
            </section>
          </div>
          <script type="text/javascript">
          function clicked() {
              swal.fire({
                title: "Are you sure?",
                text: "You are about to change your profile picture. Are you sure you want to do this?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Change"
              }).then(function (result){
                if (result.isConfirmed) {
                      document.getElementById("form_picture").submit();
                      swal.fire({position: 'center', title: 'Uploading...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
                  } else if (result.dismiss === 'cancel') {
                      swal.fire({position: 'center', icon: 'error', title: 'Change Cancelled', showConfirmButton: false, timer: 1500})
                    }
                })
          return false;
          }
          </script>
<?php

  require_once 'includes_footer.php';

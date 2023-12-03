
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
?>
          <div class="container-xxl">
            <h2 class="head" style="margin-top:40px; margin-bottom:20px"></h2>
                 <h1 class="card-title">Profile</h1>
                     <hr size="4" width="100%" color="grey">

            <section>
                <div class="rt-container-xxl">
                      <div class="col-rt-12">
                          <div class="Scriptcontent">

            <!-- Student Profile -->
            <div class="student-profile py-4">
              <div class="container-xxl">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="card shadow-sm">
                      <div class="card-header bg-transparent text-center">
                        <img class="profile_img" src="<?php echo $profile_pic;  ?>"  alt="student dp">
                        <h3><?php echo $row['f_name']." ".$row['l_name'] ?></h3>
                          <p></p>
                       <a style="width: 140px;"class="btn btn-primary" name="pic_change" href="profile_pic_change.php">Profile Picture</a>
                      </div>
                      <div class="card-body">
                        <h5></h5>
                        <p class="mb-0"><strong class="pr-1">LRN: </strong><?php echo $row['school_id'] ?></p>
                        <p class="mb-0"><strong class="pr-1">Login ID: </strong><?php echo $row['student_id'] ?></p>
                        <p class="mb-0"><strong class="pr-1">Password: </strong>&#x2713;</p>
                        <p></p>
                        <a style="width: 110px;" class="btn btn-primary" name="password" href="profile_password.php">Password</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="card shadow-sm">
                      <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0">General Information</h3>
                      </div>
                      <div class="card-body pt-0">
                        <table class="table table-bordered">
                          <tr>
                            <th width="30%">Role</th>
                            <td width="2%">:</td>
                            <td>Student</td>
                          </tr>
                          <tr>
                            <th width="30%">Section</th>
                            <td width="2%">:</td>
                            <td><?php echo $section; ?></td>
                          </tr>
                          <tr>
                            <th width="30%">Gender</th>
                            <td width="2%">:</td>
                            <td><?php echo $row['gender'] ?></td>
                          </tr>
                          <tr>
                            <th width="30%">Birthday</th>
                            <td width="2%">:</td>
                            <td><?php echo $row['birthday'] ?></td>
                          </tr>
                          <tr>
                            <th width="30%">Address</th>
                            <td width="2%">:</td>
                            <td><?php echo $row['adress'] ?></td>
                          </tr>
                        </table>
                          <a style="width: 70px;" class="btn btn-primary" name="profile_edit_details" href="profile_edit.php">Edit</a>
                      </div>
                    </div>
                      <div style="height: 26px"></div>
                    <div class="card shadow-sm">
                      <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0">Other Information</h3>
                      </div>
                      <div class="card-body pt-0">
                          <p><?php echo $row['about'] ?></p>
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
<?php

  require_once 'includes_footer.php';

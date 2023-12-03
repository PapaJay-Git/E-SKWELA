
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';

  if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No ID given!";
      header("location: notification.php?view=failed");
      exit();
  }
  $others_id = $_GET['id'];
  $sql = "SELECT * FROM admin where admin_id =?";
  $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_bind_param($stmt, "i", $others_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        if (file_exists($row['profile'])) {
          $filepath = $row['profile'];
        } else {
          $filepath = "../assets/subj_pics/profile.png";
        }
        $numberOFF = $result->num_rows;
    } else {
      $_SESSION['error'] = "It looks like this user does not exist!";
        header("location: notification.php?view=failed");
        exit();

    }


?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head">Admin Profile</h2>
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
                        <br>
                        <img class="profile_img" src="<?php echo $filepath;?>"  alt="student dp">
                        <h3 ><?php echo $row['f_name']." ".$row['l_name'] ?></h3>
                        <br>
                        <br>
                        <br>
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
                            <td>Admin</td>
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
                        </table>
                      </div>
                    </div>
                      <div style="height: 26px"></div>
                    <div class="card shadow-sm">
                      <div class="card-header bg-transparent border-0">
                        <h3 class="mb-0">Other Information</h3>
                      </div>
                      <div class="card-body pt-0">
                          <p><?php echo $row['about'] ?></p>
                          <button type="button" class="btn btn-primary"name="button" style="float:right;" onClick="back()">Back</button>
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
            function back() {
              history.back();
            }
          </script>
          <?php
  require_once 'includes_footer.php';

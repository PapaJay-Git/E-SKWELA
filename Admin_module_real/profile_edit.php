
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head">Profile General Info</h2>
            <hr size="4" width="100%" color="grey">

            <section>
                <div class="rt-container-xxl">
                      <div class="col-rt-12">
                          <div class="Scriptcontent">

                            <div class="card shadow-sm">
                              <div class="card-header bg-transparent border-0">
                                <h3 class="mb-0">General Information</h3>
                              </div>
                              <div class="card-body pt-0">
                                <form onsubmit="return clicked()" id="form_info" action="profile_update_edit.php" method="post">
                                <table class="table table-bordered">
                                  <tr>
                                    <th width="30%">Address</th>
                                    <td width="2%">:</td>
                                    <td>
                                      <div class="form-group">
                                      <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="2"required><?php echo $row['address'] ?></textarea>
                                      </div>
                                  </td>
                                  </tr>
                                  <tr>
                                    <th width="30%">Role</th>
                                    <td width="2%">:</td>
                                    <td>Admin</td>
                                  </tr>
                                  <tr>
                                    <th width="30%">Gender</th>
                                    <td width="2%">:</td>
                                    <td>
                                      <div class="form-group">
                                        <select name="gender" class="form-control" required>
                                          <?php
                                          if ($row['gender']=="Male") {
                                            ?>
                                            <option value="Male" selected>Male</option>
                                            <option value="Female">Female</option>
                                            <?php
                                          } else {
                                            ?>
                                            <option value="Male">Male</option>
                                            <option value="Female" selected>Female</option>
                                            <?php
                                          }
                                           ?>
                                        </select>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th width="30%">Birthday</th>
                                    <td width="2%">:</td>
                                    <td>
                                    <div class="form-group">
                                    <input name="bday" class="form-control" id="birthday" value="<?php echo $row['birthday'] ?>" rows="2"  placeholder="DATE" onpaste="return false;" onkeypress="return false;" onDrag="return false" onDrop="return false" autocomplete="off" required>
                                    </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th width="30%">About</th>
                                    <td width="2%">:</td>
                                    <td><div class="form-group">
                                      <textarea name="about"class="form-control" rows="2" required><?php echo $row['about'] ?></textarea>
                                    </div>
                                  </td>
                                  </tr>
                                </table>
                                <div class="row">
                                  <div class="col-md-8"><h5> </h5></div>
                                  <div class="col-md-4 btn-group" role="group">
                                    <input type="submit" style="float:right;" class="btn btn-primary" value="UPDATE">
                                    <input type="hidden" name="edit_profile" value="value">
                                    <a href="profile.php" class="btn btn-danger" >BACK</a>
                                  </div>
                                </div>
                                </form>
                              </div>
                            </div>

                		</div>
            		</div>
                </div>
            </section>
          </div>
          <script type="text/javascript">
          function clicked() {
              swal.fire({
                title: "Are you sure?",
                text: "You are about to change your profile Information. Are you sure you want to do this?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Change"
              }).then(function (result){
                if (result.isConfirmed) {
                      document.getElementById("form_info").submit();
                  } else if (result.dismiss === 'cancel') {
                      swal.fire({position: 'center', icon: 'error', title: 'Change Cancelled', showConfirmButton: false, timer: 1500})
                    }
                })
          return false;
          }
          </script>
<?php
  require_once 'includes_footer.php';
  require_once "../assets/includes_datetime.php";

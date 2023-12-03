
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">CREATE ANNOUNCEMENT</h2>
  <hr size="4" width="100%" color="grey">
                    <form onsubmit="return clicked()" id="formm"action="create_announcement_query.php" method="post">
                        <div class="col-rt-12">
                              <div class="card shadow-sm">
                                <div class="Scriptcontent">
                                  <div class="card-header bg-transparent border-0">
                                    <h3 class="mb-0">Announcement</h3>
                                  </div>
                                <div class="card-body pt-0">
                                  <table class="table table-bordered">
                                    <tr>
                                      <th width="30%">Short Title</th>
                                      <td width="2%">:</td>
                                      <td>
                                        <div class="form-group">
                                          <textarea name="title" maxlength="300" class="form-control" rows="2"required></textarea>
                                        </div>
                                    </td>
                                    </tr>
                                    <tr>
                                      <th width="30%">Your Message</th>
                                      <td width="2%">:</td>
                                      <td><div class="form-group">
                                        <textarea class="form-control" name="text" maxlength="2500" rows="4" required></textarea>
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <th width="30%">Viewable Until</th>
                                      <td width="2%">:</td>
                                      <td><div class="form-group">
                                        <input class="form-control"type="text" name="date" id="datepicker" placeholder="Deadline" onkeypress="return false;" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" required>
                                      </td>
                                      </div>
                                    </td>
                                    </tr>
                                  </table>
                                  <div class="row">
                                    <div class="col-md-8"><h5> </h5></div>
                                    <div class="col-md-4 btn-group" role="group">
                                      <input type="submit" id="btn-ok" value="SAVE NOW"class="btn btn-primary">
                                      <input type="hidden" name="add_announcement" value="secret">
                                      <a href="announcement.php"class="btn btn-danger">BACK</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                      </div>
                  </div>
                    </form>
</div>
<script>
function clicked() {
    swal.fire({
      title: "Are you sure?",
      text: "You are about to create an announcement. Are you sure you want to do this?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Create"
    }).then(function (result){
      if (result.isConfirmed) {
            document.getElementById("formm").submit();
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Create Cancelled', showConfirmButton: false, timer: 1500})
          }
      })
return false;
}
</script>

<?php
  require_once '../assets/includes_datetime.php';
  require_once 'includes_footer.php';


<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $subject_id = $_GET['subject_id'];
  $seven = 10;
  $sql = "SELECT * FROM subjects where subject_id =? AND grade = ?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: grade10.php?view=failed");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ii", $subject_id, $seven);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
    } else {
      $_SESSION['error'] = "It looks like its either this subject is already been deleted or not a grade 10 subject!";
        header("location: grade10.php?view=failed");
        exit();

    }
  }
?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head" id="h2">CHANGE G-10 SUBJECT NAME</h2>

            <hr size="4" width="100%" color="grey">
              <!-- grade10 Profile -->
            <div class="grade10-profile py-4" >
              <div class="container-md">
                <div class="row">
                  <div class="col-lg-100">
                    <div class="card shadow-sm">
                      <div class="card-body">
                         <form onsubmit="return clicked()" id="form" action="edit_subject_query10.php" method="post">
                           <div class="form-group">
                             <input type="hidden" name="subject_id_10" value="<?php echo $row['subject_id']; ?>">
                             <label for="first">SUBJECT NAME</label><br>
                             <input type="text" class="form-control" name="name_10"required value="<?php echo $row['subject_code'] ?>">
                           </div>
                             <div class="btn-group" role="group" style="float:right; margin-top:20px;">
                             <button type="submit" class="btn btn-primary" >UPDATE</button>
                             <input type="hidden" name="update_10" value="grade10">
                             <a href="grade10.php" class="btn btn-danger">BACK</a>
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
      function clicked() {
          swal.fire({
            title: "Are you sure?",
            text: "You are about to change the name of this subject. Are you sure you want to do this?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Change"
          }).then(function (result){
            if (result.isConfirmed) {
                  document.getElementById("form").submit();
              } else if (result.dismiss === 'cancel') {
                  swal.fire({position: 'center', icon: 'error', title: 'Change Cancelled', showConfirmButton: false, timer: 1500})
                }
            })
      return false;
      }
      </script>
<?php
  require_once 'includes_footer.php';

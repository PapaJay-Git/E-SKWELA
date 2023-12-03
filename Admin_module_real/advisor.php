
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
    $grade = 100;
    $sql = "SELECT * FROM class where grade !=? ORDER BY grade ASC";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "i", $grade);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head" id="h2"><p id="pp" style="display:inline">SECTION ADVISERS</h2>

            <hr size="4" width="100%" color="grey">
        <form id="advisors" onsubmit="return clicked()" action="advisor_query.php" method="post">
                  <div class="btn-group" role="group" style="float:right; margin-bottom:10px">
                  <input name="promote_now" type="submit" class="btn btn-primary" value="UPDATE" id="btn-ok2">
                  <a href="sections.php" class="btn btn-danger">BACK</a>
                  </div>
              <div class="table" style=" margin-top:20px;" id="students">
              <table id="myidata2" class="display responsive" style="width:100%">
                  <thead>
                   <tr>
                    <th> Section </th>
                    <th> Assigned Adviser</th>
                   </tr>
                  </thead>
                  <?php
                  $one = 1;
                  while ($sections = mysqli_fetch_assoc($result)) {
                  ?>
                  <tr>
                    <td data-sort="<?php echo $sections['grade']; ?>"><?php echo $sections['class_name']; ?></td>
                  <td>
                  <input type="hidden" name="class_id[]" value="<?php echo $sections['class_id']; ?>">
                  <select name="teacher_id[]" class="form-control" required>
                      <option disabled selected value> -- TEACHERS -- </option>
                    <?php
                    $sql = "SELECT * FROM advisory WHERE class_id = ?";
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $sections['class_id']);
                    mysqli_stmt_execute($stmt);
                    $result2 = mysqli_stmt_get_result($stmt);
                    $selected = mysqli_fetch_assoc($result2);
                    $active_status = 1;
                    if ($result2->num_rows > 0) {
                      $sql = "SELECT * FROM teachers WHERE active_status = $active_status ORDER BY l_name;";
                      $query = $conn->query($sql);
                      while ($row3 = $query->fetch_assoc()) {
                        if ($row3['teacher_id'] == $selected['teacher_id']) {
                            ?>
                            <option selected value="<?php echo $row3['teacher_id'] ?>"required><?php echo "School ID: ".$row3['school_id']." - Name: ".$row3['l_name'].", ".$row3['f_name'];?></option>
                            <?php
                        }else {
                          ?>
                          <option value="<?php echo $row3['teacher_id'] ?>"required><?php echo "School ID: ".$row3['school_id']." - Name: ".$row3['l_name'].", ".$row3['f_name'];?></option>
                          <?php
                        }
                      }
                    }else {
                      $sql = "SELECT * FROM teachers WHERE active_status = $active_status ORDER BY l_name;";
                      $query = $conn->query($sql);
                      while ($row3 = $query->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row3['teacher_id'] ?>" required><?php echo "School ID: ".$row3['school_id']." - Name: ".$row3['l_name'].", ".$row3['f_name'];?></option>
                          <?php
                      }
                    }

                     ?>
                  </select>
                  </td>
                  </tr>
                  <?php
                }
                   ?>
              </table>
              </div>
              </form>
        </div>
          <script type="text/javascript">

          function clicked(){
            swal.fire({
              title: "Update the assigned advisors?",
              text: "Are you sure you want to update the assigned advisors in every section?",
              icon: "question",
              showCancelButton: true,
              confirmButtonText: "Update"
            }).then(function (result){
              if (result.isConfirmed) {
                swal.fire({position: 'center', icon: 'success', title: 'Submitting for validation...', showConfirmButton: false, timer: 2500, timerProgressBar: true})
                setTimeout( function () {
                  document.getElementById("advisors").submit();
                }, 2500);
                } else if (result.dismiss === 'cancel') {
                    swal.fire({position: 'center', icon: 'error', title: 'Update Cancelled', showConfirmButton: false, timer: 1500})
                  }
              })
              return false;
          }
                  //for tables
                  $(document).ready(function() {
                      $('#myidata2').DataTable( {
                        dom: 'Blfrtip',
                        lengthMenu: [[100, -1], [100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Repeaters List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Repeaters List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
          </script>
<?php
  require_once 'includes_footer.php';

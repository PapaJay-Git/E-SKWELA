
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
    $grade = 7;
    $sql = "SELECT * FROM class where grade =?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "i", $grade);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head" id="h2"><p id="pp" style="display:inline">GRADE 7 REPEATERS</h2>

            <hr size="4" width="100%" color="grey">
        <form class="transfer_form" id="transfer"action="repeater_7_query.php" method="post">
                  <div class="btn-group" role="group" style="float:right; margin-bottom:10px">
                  <input name="promote_now" type="button" class="btn btn-primary" value="TRANSFER" id="btn-ok2">
                  <a href="repeaters_all.php" class="btn btn-danger">BACK</a>
                  </div>
                    <select id="card2"class="form-control" name="section_id">
                      <option default selected value disabled>-- GRADE 7 SECTIONS YOU CAN TRANSFER TO--</option>
                      <?php while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                        <?php
                      } ?>
                    </select>
              <div class="table" style=" margin-top:20px;" id="students">
              <table id="myidata2" class="display responsive" style="width:100%">
                  <thead>
                   <tr>
                    <th><input type="checkbox" onclick="toggle2(this);"></th>
                    <th> login ID </th>
                    <th> LRN</th>
                    <th> Name </th>
                    <th> Section</th>
                    <th> Last promoted</th>
                   </tr>
                  </thead>
                  <?php
                  $result->data_seek(0);
                  $one = 1;
                  while ($sections = mysqli_fetch_assoc($result)) {
                  $sql = "SELECT * FROM student WHERE class_id = ? AND repeater = ?;";
                  $stmt = mysqli_stmt_init($conn);
                  mysqli_stmt_prepare($stmt, $sql);
                  mysqli_stmt_bind_param($stmt, "ii", $sections['class_id'], $one);
                  mysqli_stmt_execute($stmt);
                  $result2 = mysqli_stmt_get_result($stmt);
                  while ($students = mysqli_fetch_assoc($result2)) {
                    $timestamp = strtotime($students['date_promoted']);
                    $today = date("F j Y", $timestamp);
                   ?>
                  <tr>
                    <td><input type="checkbox" id="ckx2" name="transfer_students[]" value="<?php echo $students['student_id'];?>"></td>
                    <td><?php echo $students['student_id']; ?></td>
                    <td><?php echo $students['school_id']; ?></td>
                    <td><?php echo $students['f_name']." ".$students['l_name']; ?></td>
                    <td><?php echo $sections['class_name'];?></td>
                    <td><?php echo $today; ?></td></td>
                  </tr>
                   <?php
                  }
                }
                   ?>
              </table>
              </div>
              </form>
        </div>
          <script type="text/javascript">
          var minus = 0;
          var minus2 = 0;
          function toggle2(source) {
            var checkboxes2 = document.querySelectorAll('#ckx2');
            for (var i = 0; i < checkboxes2.length; i++) {
              if (checkboxes2[i] != source)
              checkboxes2[i].checked = source.checked;
            }
          }
                //for notification before promoting the students
                    $(document).ready(function() {
                    $('.transfer_form #btn-ok2').click(function(e) {
                      var combo2 = document.getElementById("card2");
                      if(combo2.selectedIndex <=0){
                        Swal.fire({title: 'None Selected', text: 'Please select a section.'});
                        return
                      }
                      var ischecked = $('#ckx2:checked').length;
                      if (ischecked > 0) {

                      }else {
                        Swal.fire({title: 'None Selected', text: 'Please select atleast one student'});
                        return
                      }
                      //For number of students being deleted
                        var num = document.querySelectorAll('#ckx2:checked').length;
                        let form = $(this).closest('form');
                        swal.fire({
                          title: "TRANSFER ("+num+") STUDENT?",
                          text: "Are you sure you want to transfer this number ("+num+") of student?",
                          icon: "warning",
                          showCancelButton: true,
                          confirmButtonText: "Transfer"
                        }).then(function (result){
                          if (result.isConfirmed) {
                            swal.fire({position: 'center', icon: 'success', title: 'Submitting for validation...', showConfirmButton: false, timer: 2500, timerProgressBar: true})
                            setTimeout( function () {
                              form.submit();
                            }, 2500);
                            } else if (result.dismiss === 'cancel') {
                                swal.fire({position: 'center', icon: 'error', title: 'Transder Cancelled', showConfirmButton: false, timer: 1500})
                              }
                          })

                    });
                  });
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

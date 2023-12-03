
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  require_once 'a.php';
  $section_id = $_GET['section_id'];
  $grade = 9;
  $grade10 = 10;
  $sql = "SELECT * FROM class where class_id =? AND grade =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: section_9.php?view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ii", $section_id, $grade);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        $section_id2 = $row['class_id'];
    } else {
      $_SESSION['error'] = "It looks like this section is missing or this section is not a grade 9 section!";
        header("location: section_9.php?view=failed");
        exit();

    }
    $sql = "SELECT * FROM class where grade =? AND class_id != $section_id;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['error'] = "SQL error, viewing profile.";
        header("location: section_9.php?view=failed");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "i", $grade);
        mysqli_stmt_execute($stmt);
        $result222 = mysqli_stmt_get_result($stmt);

  $sql = "SELECT * FROM class where grade =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: section_9.php?view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "i", $grade10);
      mysqli_stmt_execute($stmt);
      $result2 = mysqli_stmt_get_result($stmt);
if ($row['ste'] == 1) {
  $sql = "SELECT * FROM subjects where grade =? ORDER BY subject_id ASC";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: section_9.php?view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "i", $grade);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
}else {
  $ste = 0;
  $sql = "SELECT * FROM subjects where grade =? AND ste = ? ORDER BY subject_id ASC";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: section_9.php?view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ii", $grade, $ste);
      mysqli_stmt_execute($stmt);
      $result44 = mysqli_stmt_get_result($stmt);
}


?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head" id="h2"><p id="pp" style="display:inline">TRANSFER</p> <?php echo $row['class_name']; ?></h2>

            <hr size="4" width="100%" color="grey">
            <!-- <div class="btn-group">
              <button type="button" class="btn btn-primary" onClick="promote()">PROMOTE</button>
              <button type="button" class="btn btn-primary" onclick="transfer()">TRANSFER</button>
            </div> -->
  <form class="promote_form" id="promote" style="display:none;"action="promote_section_9_query.php" method="post">
            <div class="btn-group" role="group" style="float:right; margin-bottom:10px">
            <input name="promote_now" type="button" class="btn btn-primary" value="PROMOTE" id="btn-ok">
            <input type="hidden" name="current_section_id" value="<?php echo $row['class_id']; ?>">
            <input type="hidden" name="verify" value="2">
            <a href="section_9.php" class="btn btn-danger">BACK</a>
            </div>
              <select id="card"class="form-control" name="section_id">
                <option default selected value disabled>-- GRADE 10 SECTIONS YOU CAN PROMOTE STUDENTS TO --</option>
                <?php
                $result2->data_seek(0);
                while ($row55 = mysqli_fetch_assoc($result2)) {
                  ?>
                  <option value="<?php echo $row55['class_id']; ?>"><?php echo $row55['class_name']; ?></option>
                  <?php
                } ?>
              </select>
        <div class="table" style="display:block; margin-top:20px;" id="students">
        <table id="myidata" class="display responsive" style="width:100%">
            <thead>
             <tr>
              <th><input type="checkbox" onclick="toggle(this);"></th>
              <th> login ID </th>
              <th> LRN</th>
              <th> Name </th>
              <?php while ($row44 = mysqli_fetch_assoc($result44)) {
                ?>
                <th><?php echo $row44['subject_code']; ?></th>
                <?php
              } ?>
              <th>Promoted</th>
              <th> Repeater?</th>
             </tr>
            </thead>
            <?php
            $sql = "SELECT * FROM student WHERE class_id = ?;";
            $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $sql);
              mysqli_stmt_bind_param($stmt, "i", $section_id2);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
            while ($students = mysqli_fetch_assoc($result)) {
              if ($students['repeater'] == 1) {
                $active = "YES";
              }else {
                $active = "NO";
              }
             ?>
            <tr>
              <?php
              $result44->data_seek(0);
              $myArr = [];
              while ($row99 = mysqli_fetch_assoc($result44)) {
                      $sql = "SELECT * FROM stu_grade where student_id =? AND subject_id =?";
                      $stmt = mysqli_stmt_init($conn);
                      mysqli_stmt_prepare($stmt, $sql);
                      mysqli_stmt_bind_param($stmt, "ii", $students['student_id'], $row99['subject_id']);
                      mysqli_stmt_execute($stmt);
                      $result46 = mysqli_stmt_get_result($stmt);
                      if ($result46->num_rows > 0) {
                        $row99 = mysqli_fetch_assoc($result46);
                        array_push($myArr, $row99['final']);
                      }else {
                        array_push($myArr, 0);
                      }

              }
                if(min($myArr) < 75) {
                  ?>
                  <td>X</td>
                  <?php
                }else {
                  ?>
                  <td><input type="checkbox" id="ckx" name="promote_students[]" value="<?php echo $students['student_id'];?>"></td>
                  <?php
                }
               ?>
              <td><?php echo $students['student_id']; ?></td>
              <td><?php echo $students['school_id']; ?></td>
              <td><?php echo $students['f_name']." ".$students['l_name']; ?></td>
              <?php
              $result44->data_seek(0);
              while ($row99 = mysqli_fetch_assoc($result44)) {
                      $sql = "SELECT * FROM stu_grade where student_id =? AND subject_id =?";
                      $stmt = mysqli_stmt_init($conn);
                      mysqli_stmt_prepare($stmt, $sql);
                      mysqli_stmt_bind_param($stmt, "ii", $students['student_id'], $row99['subject_id']);
                      mysqli_stmt_execute($stmt);
                      $result46 = mysqli_stmt_get_result($stmt);
                      if ($result46->num_rows > 0) {
                        $row99 = mysqli_fetch_assoc($result46);
                        ?>
                        <td><?php echo $row99['final']; ?></td>
                        <?php
                      }else {
                        ?>
                        <td>None</td>
                        <?php
                      }

              }
                         ?>
              <td><?php $timestamp = strtotime($students['date_promoted']);
                    $today = date("F j Y", $timestamp);
               echo $today; ?></td>
              <td><?php echo $active; ?></td>
            </tr>

             <?php
            }
             ?>
        </table>
        </div>
        </form>
        <form class="transfer_form" id="transfer" style="display:block;"action="promote_section_9_query.php" method="post">
                  <div class="btn-group" role="group" style="float:right; margin-bottom:10px">
                  <input name="promote_now" type="button" class="btn btn-primary" value="TRANSFER" id="btn-ok2">
                  <input type="hidden" name="current_section_id" value="<?php echo $row['class_id']; ?>">
                  <input type="hidden" name="verify" value="1">
                  <a href="section_9.php" class="btn btn-danger">BACK</a>
                  </div>
                    <select id="card2"class="form-control" name="section_id">
                      <option default selected value disabled>-- GRADE 9 SECTION YOU CAN TRANSFER TO--</option>
                      <?php while ($row55 = mysqli_fetch_assoc($result222)) {
                        ?>
                        <option value="<?php echo $row55['class_id']; ?>"><?php echo $row55['class_name']; ?></option>
                        <?php
                      } ?>
                    </select>
              <div class="table" style="display:block; margin-top:20px;" id="students">
              <table id="myidata2" class="display responsive" style="width:100%">
                  <thead>
                   <tr>
                    <th><input type="checkbox" onclick="toggle2(this);"></th>
                    <th> login ID </th>
                    <th> LRN </th>
                    <th> Name </th>
                    <?php
                    $result44->data_seek(0);
                     while ($row44 = mysqli_fetch_assoc($result44)) {
                      ?>
                      <th><?php echo $row44['subject_code']; ?></th>
                      <?php
                    } ?>
                    <th>Promoted</th>
                    <th> Repeater?</th>
                   </tr>
                  </thead>
                  <?php
                  $sql = "SELECT * FROM student WHERE class_id = ?;";
                  $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $section_id2);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                  while ($students = mysqli_fetch_assoc($result)) {
                    if ($students['repeater'] == 1) {
                      $active = "YES";
                    }else {
                      $active = "NO";
                    }
                   ?>
                  <tr>
                    <td><input type="checkbox" id="ckx2" name="transfer_students[]" value="<?php echo $students['student_id'];?>"></td>
                    <td><?php echo $students['student_id']; ?></td>
                    <td><?php echo $students['school_id']; ?></td>
                    <td><?php echo $students['f_name']." ".$students['l_name']; ?></td>
                    <?php
                    $result44->data_seek(0);
                    while ($row99 = mysqli_fetch_assoc($result44)) {
                            $sql = "SELECT * FROM stu_grade where student_id =? AND subject_id =?";
                            $stmt = mysqli_stmt_init($conn);
                            mysqli_stmt_prepare($stmt, $sql);
                            mysqli_stmt_bind_param($stmt, "ii", $students['student_id'], $row99['subject_id']);
                            mysqli_stmt_execute($stmt);
                            $result46 = mysqli_stmt_get_result($stmt);
                            if ($result46->num_rows > 0) {
                              $row99 = mysqli_fetch_assoc($result46);
                              ?>
                              <td><?php echo $row99['final']; ?></td>
                              <?php
                            }else {
                              ?>
                              <td>None</td>
                              <?php
                            }

                    }
                               ?>
                    <td><?php $timestamp = strtotime($students['date_promoted']);
                          $today = date("F j Y", $timestamp);
                     echo $today; ?></td>
                    <td><?php echo $active; ?></td>
                  </tr>

                   <?php
                  }
                   ?>
              </table>
              </div>
              </form>
        </div>
          <script type="text/javascript">
          var prom = document.getElementById('promote');
          var trans = document.getElementById('transfer');
          var pp = document.getElementById('pp');
          function promote() {
            prom.style.display = "block";
            trans.style.display = "none";
            pp.innerHTML = "PROMOTE";
          }
          function transfer() {
            trans.style.display = "block";
            prom.style.display = "none";
            pp.innerHTML = "TRANSFER";
          }
          var minus = 0;
          var minus2 = 0;
          function toggle(source) {
            var checkboxes = document.querySelectorAll('#ckx');
            for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i] != source)
              checkboxes[i].checked = source.checked;
            }
          }
          function toggle2(source) {
            var checkboxes2 = document.querySelectorAll('#ckx2');
            for (var i = 0; i < checkboxes2.length; i++) {
              if (checkboxes2[i] != source)
              checkboxes2[i].checked = source.checked;
            }
          }

              //for tables
              $(document).ready(function() {
                  $('#myidata').DataTable( {
                    dom: 'Blfrtip',
                    lengthMenu: [[100, -1], [100, "All"]],
                     buttons: ['copy',
                     {
                       extend: 'print',
                       title: 'Students List <?php echo $row['class_name']; ?> id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                     },
                     {
                       extend: 'excelHtml5',
                       title: 'Students List <?php echo $row['class_name']; ?> id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                     }]
                } );
              } );
              //for tables
              $(document).ready(function() {
                  $('#myidata2').DataTable( {
                    dom: 'Blfrtip',
                    lengthMenu: [[100, -1], [100, "All"]],
                     buttons: ['copy',
                     {
                       extend: 'print',
                       title: 'Students List <?php echo $row['class_name']; ?> id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                     },
                     {
                       extend: 'excelHtml5',
                       title: 'Students List <?php echo $row['class_name']; ?> id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                     }]
                } );
              } );
              //for notification before promoting the students
                  $(document).ready(function() {
                  $('.promote_form #btn-ok').click(function(e) {
                    <?php
                    if ($validation == 1) {
                    ?>
                    Swal.fire({title: "Grades are not fully encoded", text: "It looks like, teachers are still not done encoding final grades of their students. Please update the teachers to finish encoding all of the grades of their students first to be able to proceed."});
                    return
                    <?php
                    }
                     ?>
                    var combo = document.getElementById("card");
                    if(combo.selectedIndex <=0){
                      Swal.fire({title: 'None Selected', text: 'Please select a section.'});
                      return
                    }
                    var ischecked = $('#ckx:checked').length;
                    if (ischecked > 0) {

                    }else {
                      Swal.fire({title: 'None Selected', text: 'Please select atleast one student'});
                      return
                    }
                    //For number of students being deleted
                      var num = document.querySelectorAll('#ckx:checked').length;
                      let form = $(this).closest('form');
                      swal.fire({
                        title: "PROMOTE ("+num+") STUDENT?",
                        text: "Are you sure you want to promote this number ("+num+") of student?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Promote"
                      }).then(function (result){
                        if (result.isConfirmed) {
                          swal.fire({position: 'center', icon: 'success', title: 'Submitting for validation...', showConfirmButton: false, timer: 2500, timerProgressBar: true})
                          setTimeout( function () {
                            form.submit();
                          }, 2500);
                          } else if (result.dismiss === 'cancel') {
                              swal.fire({position: 'center', icon: 'error', title: 'Promotion Cancelled', showConfirmButton: false, timer: 1500})
                            }
                        })

                  });
                });

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
          </script>
<?php
  require_once 'includes_footer.php';

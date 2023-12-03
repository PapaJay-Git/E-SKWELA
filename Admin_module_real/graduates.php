
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $grade = 100;
  $grade10 = 10;
  $sql = "SELECT * FROM class where grade =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: section_10.php?view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "i", $grade);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
          $result1 = mysqli_fetch_assoc($result);
          $section_id2 = $result1['class_id'];
    } else {
      $_SESSION['error'] = "It looks like this section is missing!";
        header("location: section_10.php?view=failed");
        exit();
    }
    $sql = "SELECT * FROM subjects where grade =?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['error'] = "SQL error, viewing profile.";
        header("location: section_10.php?view=failed");
        exit();
      }
        mysqli_stmt_bind_param($stmt, "i", $grade10);
        mysqli_stmt_execute($stmt);
        $result2 = mysqli_stmt_get_result($stmt);

?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head" id="h2">JUNIOR HIGH GRADUATES</h2>

            <hr size="4" width="100%" color="grey">
  <form id="formm"action="graduates_active.php" method="post">
            <div class="btn-group" role="group" style="float:right; margin-bottom:10px">
            <input onclick="clicked()" type="button" class="btn btn-primary" value="ACTIVATE" id="btn-ok">
            <input onclick="clicked2()" style="width: 140px;"type="button" class="btn btn-primary" value="DEACTIVATE" id="btn-ok">
            <input name="active_status" type="submit" id="activate" class="btn btn-primary" value="ACTIVATE" style="display:none;">
            <input name="inactive_status" type="submit" id="deactivate" class="btn btn-primary" value="DEACTIVATE"  style="display:none;">
            <a href="sections.php" class="btn btn-danger">BACK</a>
            </div>
        <div class="table" style="display:block; margin-top:20px;" id="students">
        <table id="myidata" class="display responsive" style="width:100%">
            <thead>
             <tr>
              <th><input type="checkbox" onclick="toggle(this);"></th>
              <th> login ID </th>
              <th> LRN </th>
              <th> Name </th>
              <?php while ($row44 = mysqli_fetch_assoc($result2)) {
                ?>
                <th><?php echo $row44['subject_code']; ?></th>
                <?php
              } ?>
              <th>Graduated</th>
              <th> Status</th>
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
              if ($students['active_status'] == 1) {
                $active = "Active";
              }else {
                $active = "Inactive";
              }
             ?>
            <tr>
              <td><input type="checkbox" id="ckx"name="student_id[]" value="<?php echo $students['student_id'];?>"></td>
              <td><?php echo $students['student_id']; ?></td>
              <td><?php echo $students['school_id']; ?></td>
              <td><?php echo $students['f_name']." ".$students['l_name']; ?></td>
              <?php
              $result2->data_seek(0);
              while ($row1010 = mysqli_fetch_assoc($result2)) {
                      $sql = "SELECT * FROM stu_grade where student_id =? AND subject_id =?";
                      $stmt = mysqli_stmt_init($conn);
                      mysqli_stmt_prepare($stmt, $sql);
                      mysqli_stmt_bind_param($stmt, "ii", $students['student_id'], $row1010['subject_id']);
                      mysqli_stmt_execute($stmt);
                      $result46 = mysqli_stmt_get_result($stmt);
                      if ($result46->num_rows > 0) {
                        $row1010 = mysqli_fetch_assoc($result46);
                        ?>
                        <td><?php echo $row1010['final']; ?></td>
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
          function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i] != source)
              checkboxes[i].checked = source.checked;
            }
          }
              //for tables
              $(document).ready(function() {
                  $('#myidata').DataTable( {
                    dom: 'Blfrtip',
                    lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
                     buttons: ['copy',
                     {
                       extend: 'print',
                       title: 'List of Graduates id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                     },
                     {
                       extend: 'excelHtml5',
                       title: 'List of Graduates id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                     }]
                } );
              } );

              function clicked() {
              var num2 = document.querySelectorAll('#ckx:checked').length;
              if (num2 <=0) {
                Swal.fire({title: 'None Selected', text: 'Please select atleast one graduate!'});
                return
              }
              swal.fire({
              title: "Are you sure?",
              text: "You are about to activate "+num2+" graduates. Are you sure you want to do this?",
              icon: "question",
              showCancelButton: true,
              confirmButtonText: "Activate"
              }).then(function (result){
              if (result.isConfirmed) {
              document.getElementById('activate').click();
              } else if (result.dismiss === 'cancel') {
              swal.fire({position: 'center', icon: 'error', title: 'Activation Cancelled', showConfirmButton: false, timer: 1500})
              }
              })
              return false;
              }
              function clicked2() {
              var num2 = document.querySelectorAll('#ckx:checked').length;
              if (num2 <=0) {
                Swal.fire({title: 'None Selected', text: 'Please select atleast one graduate!'});
                return
              }
              swal.fire({
              title: "Are you sure?",
              text: "You are about to deactivate "+num2+" graduates. Are you sure you want to do this?",
              icon: "question",
              showCancelButton: true,
              confirmButtonText: "Deactivate"
              }).then(function (result){
              if (result.isConfirmed) {
              document.getElementById('deactivate').click();
              } else if (result.dismiss === 'cancel') {
              swal.fire({position: 'center', icon: 'error', title: 'Deactivation Cancelled', showConfirmButton: false, timer: 1500})
              }
              })
              return false;
              }

          </script>
<?php
  require_once 'includes_footer.php';

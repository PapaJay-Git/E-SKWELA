
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $n7 = 7;
  $n8 = 8;
  $n9 = 9;
  $n10 = 10;
  $oneh = 1;
  $checkClasses11 = "SELECT * FROM class where grade = $n7";
  if($output11 = $conn->query($checkClasses11)){
    $section_7 = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM class where grade = $n8";
  if($output11 = $conn->query($checkClasses11)){
    $section_8 = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM class where grade = $n9";
  if($output11 = $conn->query($checkClasses11)){
    $section_9 = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM class where grade = $n10";
  if($output11 = $conn->query($checkClasses11)){
    $section_10 = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM student where class_id = $oneh";
  if($output11 = $conn->query($checkClasses11)){
    $section_100 = mysqli_num_rows($output11);
  }
?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">Class Management</h2>
                  <hr size="4" width="100%" color="grey">
                  <div class="table-responsive">
                  <table id="myidata" class="display responsive nowrap" style="width:100%">
                      <thead>
                       <tr>
                        <th> SECTION PER GRADE</th>
                        <th> TOTAL </th>
                        <th> OPEN </th>
                       </tr>
                      </thead>
                      <tr>
                        <td>Unlock Quarterly Grading</td>
                        <td>All</td>
                        <td><a href="unlock.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>ALL REPEATERS</td>
                        <td>All</td>
                        <td><a href="repeaters_all.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>SECTION ADVISERS</td>
                        <td>All</td>
                        <td><a href="advisor.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>PROMOTE ALL SECTIONS</td>
                        <td>All</td>
                        <td><a href="promote_all.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>PREVIOUS STE STUDENTS</td>
                        <td>All</td>
                        <td><a href="previous.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>SECTIONS FOR GRADE 7</td>
                        <td><?php echo $section_7; ?></td>
                        <td><a href="section_7.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>SECTIONS FOR GRADE 8</td>
                        <td><?php echo $section_8; ?></td>
                        <td><a href="section_8.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>SECTIONS FOR GRADE 9</td>
                        <td><?php echo $section_9; ?></td>
                        <td><a href="section_9.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>SECTIONS FOR GRADE 10</td>
                        <td><?php echo $section_10; ?></td>
                        <td><a href="section_10.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>JUNIOR HIGH GRADUATES</td>
                        <td><?php echo $section_100; ?></td>
                        <td><a href="graduates.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                  </table>
                  </div>
                  </div>
                  <script>
                  $(document).ready(function() {
                      $('#myidata').DataTable( {
                        dom: 'Blfrtip',
                        "order": [[ 1, "desc" ]],
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Your Section Per Grade id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Your Section Per Grade id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';

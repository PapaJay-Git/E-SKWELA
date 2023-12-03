
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $zero = 0;
  $g7 = 0;
  $g8 = 0;
  $g9 = 0;
  $g10 = 0;
  $checkClasses11 = "SELECT * FROM student where previous_ste != $zero";
  $output = $conn->query($checkClasses11);
  while ($students = mysqli_fetch_assoc($output)) {
    $class_id = $students['class_id'];
    $checkClasses11 = "SELECT grade FROM class where class_id = $class_id;";
    $output11 = $conn->query($checkClasses11);
    $grades = mysqli_fetch_assoc($output11);
    if ($grades['grade'] == 7) {
      $g7 += 1;
    } elseif ($grades['grade'] == 8) {
      $g8 += 1;
    } elseif ($grades['grade'] == 9) {
      $g9 += 1;
    } elseif ($grades['grade'] == 10) {
      $g10 += 1;
    }
  }


?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">STUDENTS FROM STE</h2>
                  <hr size="4" width="100%" color="grey">
                  <h5>STE students who didn't pass the grade requirement of 85 but still passed the 75. These students got promoted to non-STE sections.</h5>
                  <a href="sections.php" style="float:right; width: 100px;" class="btn btn-primary">BACK</a>
                  <div class="row" style="margin-bottom: 10px;">
                    <h1>&nbsp</h1>
                  </div>
                  <div class="table-responsive">
                  <table id="myidata" class="display responsive nowrap" style="width:100%">
                      <thead>
                       <tr>
                        <th> Grade </th>
                        <th> TOTAL </th>
                        <th> OPEN </th>
                       </tr>
                      </thead>
                      <tr>
                        <td>Grade 7</td>
                        <td><?php echo $g7; ?></td>
                        <td><a href="previous_7.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>Grade 8</td>
                        <td><?php echo $g8; ?></td>
                        <td><a href="previous_8.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>Grade 9</td>
                        <td><?php echo $g9; ?></td>
                        <td><a href="previous_9.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>Grade 10</td>
                        <td><?php echo $g10; ?></td>
                        <td><a href="previous_10.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                  </table>
                  </div>
                  </div>
                  <script>
                  $(document).ready(function() {
                      $('#myidata').DataTable( {
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Previous STE Per Grade id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Previous STE Per Grade id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';

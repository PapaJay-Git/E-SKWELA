
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $grade7 = 7;
  $grade8 = 8;
  $grade9 = 9;
  $grade10 = 10;
  $checkClasses11 = "SELECT * FROM subjects where grade = $grade7";
  if($output11 = $conn->query($checkClasses11)){
    $g7 = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM subjects where grade = $grade8";
  if($output11 = $conn->query($checkClasses11)){
    $g8 = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM subjects where grade = $grade9";
  if($output11 = $conn->query($checkClasses11)){
    $g9 = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM subjects where grade = $grade10";
  if($output11 = $conn->query($checkClasses11)){
    $g10 = mysqli_num_rows($output11);
  }
?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">Curriculum Management</h2>
                  <hr size="4" width="100%" color="grey">
                  <div class="table-responsive">
                  <table id="myidata" class="display responsive nowrap" style="width:100%">
                      <thead>
                       <tr>
                        <th> GRADES </th>
                        <th> TOTAL SUBJECTS</th>
                        <th> OPEN </th>
                       </tr>
                      </thead>
                      <tr>
                        <td>Grade 7</td>
                        <td><?php echo $g7; ?></td>
                        <td><a href="grade7.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>Grade 8</td>
                        <td><?php echo $g8; ?></td>
                        <td><a href="grade8.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>Grade 9</td>
                        <td><?php echo $g9; ?></td>
                        <td><a href="grade9.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>Grade 10</td>
                        <td><?php echo $g10; ?></td>
                        <td><a href="grade10.php" class="btn btn-primary">OPEN</a></td>
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
                           title: 'Subject List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Subject List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';

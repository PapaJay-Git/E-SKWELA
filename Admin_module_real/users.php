
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM student";
  if($output11 = $conn->query($checkClasses11)){
    $students = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM teachers";
  if($output11 = $conn->query($checkClasses11)){
    $teachers = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM admin";
  if($output11 = $conn->query($checkClasses11)){
    $admins = mysqli_num_rows($output11);
  }
  $checkClasses11 = "SELECT * FROM parents";
  if($output11 = $conn->query($checkClasses11)){
    $parents = mysqli_num_rows($output11);
  }
?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">User Management</h2>
                  <hr size="4" width="100%" color="grey">
                  <div class="table-responsive">
                  <table id="myidata" class="display responsive nowrap" style="width:100%">
                      <thead>
                       <tr>
                        <th> User Type </th>
                        <th> Total </th>
                        <th> Open </th>
                       </tr>
                      </thead>
                      <tr>
                        <td>Admins</td>
                        <td><?php echo $admins; ?></td>
                        <td><a href="admins.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>Teachers</td>
                        <td><?php echo $teachers; ?></td>
                        <td><a href="teachers.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>Students</td>
                        <td><?php echo $students; ?></td>
                        <td><a href="students.php" class="btn btn-primary">OPEN</a></td>
                      </tr>
                      <tr>
                        <td>Parents</td>
                        <td><?php echo $parents; ?></td>
                        <td><a href="parents.php" class="btn btn-primary">OPEN</a></td>
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
                           title: 'Your Class List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Your Class List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';

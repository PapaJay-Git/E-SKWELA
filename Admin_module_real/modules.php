
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM files;";
  $modules = $conn->query($checkClasses11);

?>
<div class="container">
  <h2 class="head" id="text" style="margin-top:40px; margin-bottom:20px">Uploaded Modules</h2>
                  <hr size="4" width="100%" color="grey">
                        <button type="button" onclick="goBack()" style="float:right; width: 100px;" class="btn btn-primary">BACK</button>
                      <div class="row" style="margin-bottom: 10px;">
                        <h1>&nbsp</h1>
                      </div>
                  <div class="table-responsive" style="display: block; margin-top: 10px;" id="moduless">
                  <table id="myidata" style="width:100%">
                      <thead>
                       <tr>
                         <th>Teacher ID</th>
                        <th> Uploaded by</th>
                        <th> Section </th>
                        <th> Upload Date </th>
                        <th> Download</th>
                       </tr>
                      </thead>
                      <?php
                      while ($modules_row = mysqli_fetch_assoc($modules)) {
                        $teacher_id = $modules_row['teacher_id'];
                        $class_id = $modules_row['class_id'];
                        $checkClasses11 = "SELECT * FROM teachers where teacher_id = $teacher_id;";
                        $teachers = $conn->query($checkClasses11);
                        $teacher_row = mysqli_fetch_assoc($teachers);
                        $checkClasses11 = "SELECT * FROM class where class_id = $class_id;";
                        $classes = $conn->query($checkClasses11);
                        $class_row = mysqli_fetch_assoc($classes);
                        if (strtotime($modules_row['file_date'])) {
                          $timestamp = strtotime($modules_row['file_date']);
                          $today = date("F j Y, g:i a", $timestamp);
                        }else {
                          $today = "Unreadable";
                        }
                        ?>
                       <tr>
                         <td><?php echo $teacher_row['teacher_id']; ?></td>
                         <td><?php echo $teacher_row['l_name'].", ".$teacher_row['f_name']; ?></td>
                         <td><?php echo $class_row['class_name']; ?></td>
                         <td><?php echo $today; ?></td>
                         <td><a href="module_download.php?id=<?php echo $modules_row['file_id']; ?>" class="btn btn-primary">Download</a></td>
                       </tr>
                        <?php
                      }
                       ?>
                  </table>
                  </div>
                  </div>
                  <script>
                  $(document).ready(function() {
                      $('#myidata').DataTable( {
                        dom: 'Blfrtip',
                        "order": [[ 0, "desc" ]],
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Uploaded Modules ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Uploaded Modules ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';

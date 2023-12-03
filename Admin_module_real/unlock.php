
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM grading";
  $output = $conn->query($checkClasses11);


?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">Quarterly Grading</h2>
                  <hr size="4" width="100%" color="grey">
                  <a href="sections.php" style="float:right; width: 100px;" class="btn btn-primary">BACK</a>
                  <div class="row" style="margin-bottom: 10px;">
                    <h1>&nbsp</h1>
                  </div>
                  <div class="table-responsive">
                  <table id="myidata" class="display responsive nowrap" style="width:100%">
                      <thead>
                       <tr>
                        <th> Quarter</th>
                        <th> Status </th>
                       </tr>
                      </thead>
                      <?php while ($grading = mysqli_fetch_assoc($output)) {
                      ?>
                      <tr>
                        <td><?php echo $grading['quarter']; ?> </td>
                        <?php if ($grading['status'] == "locked") {
                          ?>
                          <td><a style="width: 150px;" href="unlock_query.php?id=<?php echo $grading['id']; ?>" class="btn btn-primary"><i class="fa fa-lock"></i> <?php echo $grading['status']; ?></a></td>
                          <?php
                        }else {
                          ?>
                          <td><a style="width: 150px;" href="unlock_query.php?id=<?php echo $grading['id']; ?>" class="btn btn-primary"><i class="fa fa-unlock"></i> <?php echo $grading['status']; ?></a></td>
                          <?php
                        }?>

                      </tr>
                      <?php
                      } ?>
                  </table>
                  </div>
                  </div>
                  <script>
                  $(document).ready(function() {
                      $('#myidata').DataTable( {
                        dom: 'Blfrtip',
                        "ordering": false,
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Your repeater Per Grade id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Your repeater Per Grade id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';

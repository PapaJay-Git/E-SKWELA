
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM announcements;";
  $result = $conn->query($checkClasses11);

?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">Announcement Management</h2>
                  <hr size="4" width="100%" color="grey">
  <form class="delete_form" action="delete_announcement.php" method="post">
                  <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-8"><h5> </h5></div>
                    <div class="col-md-4 btn-group" role="group">
                      <button onclick="location.href='create_announcement.php'" type="button" class="btn btn-primary"><i class="fa fa-plus-circle"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >Create</span></i></button>
                      <button name="delete_now" type="button" class="btn btn-danger" id="btn-ok"><i class="fa fa-trash"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >Delete</span></i></button>
                    </div>
                  </div>
                  <div class="table">
                  <table id="myidata" class="display responsive" style="width:100%">
                      <thead>
                       <tr>
                        <th><input type="checkbox" id="checks" onclick="toggle(this);"></th>
                        <th> ID </th>
                        <th>Created by</th>
                        <th> Title</th>
                        <th> Text</th>
                        <th> Created </th>
                        <th> Viewable until </th>
                        <th> Open</th>
                       </tr>
                      </thead>
                      <?php
                      while ($announcement = mysqli_fetch_assoc($result)) {
                        $title = mb_strimwidth($announcement['title'], 0, 20, "...");
                        $text = mb_strimwidth($announcement['texts'], 0, 20, "...");
                        $timestamp = strtotime($announcement['upload']); $uploaded = date("F j, g:i a", $timestamp);
                        $timestamp2 = strtotime($announcement['deadline']); $deadline = date("F j, g:i a", $timestamp2);
                        $admin_id = $announcement['admin_id'];
                        $checkClasses11 = "SELECT l_name, f_name FROM admin WHERE admin_id = $admin_id;";
                        $admin_result = $conn->query($checkClasses11);
                        $admin_result05 = mysqli_fetch_assoc($admin_result);
                        $admin_name = $admin_result05['l_name'].", ".$admin_result05['f_name'];
                       ?>
                      <tr>
                        <td><input type="checkbox" id="ckx" name="delete_announcement_id[]" value="<?php echo $announcement['announcement_id'];?>"></td>
                        <td><?php echo $announcement['announcement_id']; ?></td>
                        <td><?php  echo $admin_name;?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $text; ?></td>
                        <td><?php echo $uploaded; ?></td>
                        <td><?php echo $deadline; ?></td>
                        <td><a href="edit_announcement.php?id=<?php echo $announcement['announcement_id'];; ?>" class="btn btn-primary">Open</a></td>
                      </tr>

                       <?php
                      }
                       ?>
                  </table>
                  </div>
                  </form>
                  </div>
                  <script>
                  // check all or unchecked all
                  var minus = 0;
                  function toggle(source) {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    for (var i = 0; i < checkboxes.length; i++) {
                      if (checkboxes[i] != source)
                      checkboxes[i].checked = source.checked;
                    }
                    if (source.checked) {
                      minus = 1;
                    }else {
                      minus = 0;
                    }
                  }
                  //for tables
                  $(document).ready(function() {
                      $('#myidata').DataTable( {
                        dom: 'Blfrtip',
                        "order": [[ 1, "desc" ]],
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Announcement List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Announcement List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                  //for notification before deleting the announcement
                      $(document).ready(function() {
                      $('.delete_form #btn-ok').click(function(e) {
                        var ischecked = $('#ckx:checked').length;
                        if (ischecked > 0) {

                        }else {
                          Swal.fire({title: 'None Selected', text: 'Please select atleast one announcement!'});
                          return
                        }
                        //For number of announcement being deleted
                          var num2 = document.querySelectorAll('input[type="checkbox"]:checked').length;
                          let form = $(this).closest('form');
                          var num = num2 - minus;
                          swal.fire({
                              title: "DELETE "+num+" ANNOUNCEMENT?",
                            text: "Are you sure you want to delete these number ("+num+") of Announcement? This cannot be undone, pleasde consider before confirming.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Delete"
                          }).then(function (result){
                            if (result.isConfirmed) {
                              swal.fire({position: 'center', icon: 'success', title: 'Submitting for validation...', showConfirmButton: false, timer: 2500, timerProgressBar: true})
                              setTimeout( function () {
                                form.submit();
                              }, 2500);
                              } else if (result.dismiss === 'cancel') {
                                  swal.fire({position: 'center', icon: 'error', title: 'Delete Cancelled', showConfirmButton: false, timer: 1500})
                                }
                            })

                      });
                    });
                   </script>

<?php
  require_once 'includes_footer.php';

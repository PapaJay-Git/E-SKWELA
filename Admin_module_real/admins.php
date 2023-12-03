
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $id = $_SESSION['admin_session_id'];
  $checkClasses11 = "SELECT * FROM admin where admin_id != $id";
  $result = $conn->query($checkClasses11);

?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">ADMIN MANAGEMENT</h2>
                  <hr size="4" width="100%" color="grey">
  <form class="delete_form" action="delete_admin.php" method="post">
                  <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-8"><h5> </h5></div>
                    <div class="col-md-4 btn-group" role="group">
                      <button onclick="location.href='create_admins.php'" type="button" class="btn btn-primary"><i class="fa fa-user-plus"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >ADMIN</span></i></button>
                      <button name="delete_now" type="button" class="btn btn-danger" id="btn-ok"><i class="fa fa-trash"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >ADMIN</span></i></button>
                      <a href="users.php" class="btn btn-primary">BACK</a>
                    </div>
                  </div>
                  <div class="table">
                  <table id="myidata" class="display responsive" style="width:100%">
                      <thead>
                       <tr>
                        <th><input type="checkbox" id="checks" onclick="toggle(this);"></th>
                        <th> Login ID </th>
                        <th>School ID</th>
                        <th> Name </th>
                        <th> Edit </th>
                        <th>Status</th>
                       </tr>
                      </thead>
                      <?php
                      while ($admins = mysqli_fetch_assoc($result)) {
                       ?>
                      <tr>
                        <td><input type="checkbox" id="ckx" name="delete_admins[]" value="<?php echo $admins['admin_id'];?>"></td>
                        <td><?php echo $admins['admin_id']; ?></td>
                        <td><?php echo $admins['school_id']; ?></td>
                        <td><?php echo $admins['f_name']." ".$admins['l_name']; ?></td>
                        <td><a href="edit_admin.php?admin_id=<?php echo $admins['admin_id'];; ?>" class="btn btn-primary">Edit</a></td>
                        <?php
                        if ($admins['active_status'] == 1) {
                          ?><td><a onclick="ConfirmActive('active_admin.php?admin_id=<?php echo $admins['admin_id']; ?>')" class="btn btn-primary">Active</a></td><?php
                        }else {
                          ?><td><a onclick="ConfirmActive('active_admin.php?admin_id=<?php echo $admins['admin_id']; ?>')" class="btn btn-danger">Inactive</a></td><?php
                        }
                         ?>
                      </tr>

                       <?php
                      }
                       ?>
                  </table>
                  </div>
                  </form>
                  </div>
                  <script>
                  function ConfirmActive(e)
                  {
                    swal.fire({
                      title: "Are you sure?",
                      text: "You're about to change the active status of this Admin account.",
                      icon: "warning",
                      showCancelButton: true,
                      confirmButtonText: "Change"
                    }).then(function (result){
                      if (result.isConfirmed) {
                            setTimeout(function(){ window.location = e;});
                        } else if (result.dismiss === 'cancel') {
                            swal.fire({position: 'center', icon: 'error', title: 'Change Cancelled', showConfirmButton: false, timer: 1500})
                          }
                      })
                  }
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
                           title: 'Admin List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Admin List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                  //for notification before deleting the admins
                      $(document).ready(function() {
                      $('.delete_form #btn-ok').click(function(e) {
                        var ischecked = $('#ckx:checked').length;
                        if (ischecked < 1) {
                          Swal.fire({title: 'None Selected', text: 'Please select atleast one admin!'});
                          return
                        }
                        //For number of admins being deleted
                          var num2 = document.querySelectorAll('input[type="checkbox"]:checked').length;
                          let form = $(this).closest('form');
                          var num = num2 - minus;
                          swal.fire({
                              title: "DELETE "+num+" ADMINS?",
                            text: "Are you sure you want to delete these number ("+num+") of admins? This will also delete all of their Profile information! Please consider before confirming.",
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

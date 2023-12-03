
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM parents";
  $result = $conn->query($checkClasses11);

?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">PARENT MANAGEMENT</h2>
                  <hr size="4" width="100%" color="grey">
  <form class="delete_form" action="delete_parent.php" method="post">
                  <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-8"><h5> </h5></div>
                    <div class="col-md-4 btn-group" role="group">
                      <button onclick="location.href='create_parents.php'" type="button" class="btn btn-primary"><i class="fa fa-user-plus"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >PARENT</span></i></button>
                      <button name="delete_now" type="button" class="btn btn-danger" id="btn-ok"><i class="fa fa-trash"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >PARENT</span></i></button>
                      <a href="users.php" class="btn btn-primary">BACK</a>
                    </div>
                  </div>
                  <div class="table">
                  <table id="myidata" class="display responsive" style="width:100%">
                      <thead>
                       <tr>
                        <th><input type="checkbox" onclick="toggle(this);"> All</th>
                        <th> Login ID </th>
                        <th> Name </th>
                        <th> EDIT </th>
                       </tr>
                      </thead>
                      <?php
                      while ($parents = mysqli_fetch_assoc($result)) {
                        $sql = "SELECT * FROM parent_student WHERE parent_id=?;";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)) {
                          header("location: index.php?view=sqlerror");
                          exit();
                        }
                          mysqli_stmt_bind_param($stmt, "i", $parents['parent_id']);
                          mysqli_stmt_execute($stmt);
                          $result_2 = mysqli_stmt_get_result($stmt);
                          $hold = $result_2->num_rows;
                       ?>
                      <tr>
                        <td><input type="checkbox" id="ckx" name="delete_parents[]" value="<?php echo $parents['parent_id'];?>"></td>
                        <td><?php echo $parents['parent_id']; ?></td>
                        <td><?php echo $parents['f_name']." ".$parents['l_name']; ?></td>
                        <td><a href="edit_parent.php?parent_id=<?php echo $parents['parent_id'];; ?>" class="btn btn-primary">Edit</a></td>
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
                           title: 'parents List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'parents List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                  //for notification before deleting the parents
                      $(document).ready(function() {
                      $('.delete_form #btn-ok').click(function(e) {
                        var ischecked = $('#ckx:checked').length;
                        if (ischecked > 0) {

                        }else {
                          Swal.fire({title: 'None Selected', text: 'Please select atleast one parent!'});
                          return
                        }
                        //For number of parents being deleted
                          var num2 = document.querySelectorAll('input[type="checkbox"]:checked').length;
                          let form = $(this).closest('form');
                          var num = num2 - minus;
                          swal.fire({
                            title: "DELETE "+num+" PARENTS?",
                            text: "Are you sure you want to delete these number ("+num+") of parents? This will also delete all of their Profile information! Please consider before confirming.",
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

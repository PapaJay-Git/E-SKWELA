
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $grade10 = 10;
  $checkClasses11 = "SELECT * FROM subjects WHERE grade = $grade10;";
  $result = $conn->query($checkClasses11);

?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">GRADE 10 SUBJECTS</h2>
                  <hr size="4" width="100%" color="grey">
  <form class="delete_form" action="delete_grade10.php" method="post">
                  <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-8"><h5> </h5></div>
                    <div class="col-md-4 btn-group" role="group">
                      <button onclick="location.href='create_grade10.php'" type="button" class="btn btn-primary"><i class="fa fa-plus-circle"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >SUBJECT</span></i></button>
                      <button name="delete_now" type="button" class="btn btn-danger" id="btn-ok"><i class="fa fa-trash"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >SUBJECT</span></i></button>
                      <a href="curriculum.php" class="btn btn-primary">BACK</a>
                    </div>
                  </div>
                  <div class="table">
                  <table id="myidata" class="display responsive" style="width:100%">
                      <thead>
                       <tr>
                        <th><input type="checkbox" onclick="toggle(this);"></th>
                        <th> ID </th>
                        <th> SUBJECT NAME </th>
                        <th> SUBJECT TITLE</th>
                        <th>STE ADDITIONAL?</th>
                        <th> EDIT </th>
                       </tr>
                      </thead>
                      <?php
                      while ($grade10 = mysqli_fetch_assoc($result)) {
                       ?>
                      <tr>
                        <td><input type="checkbox" id="ckx" name="delete_grade10[]" value="<?php echo $grade10['subject_id'];?>"></td>
                        <td><?php echo $grade10['subject_id']; ?></td>
                        <td><?php echo $grade10['subject_code'];?></td>
                        <td><?php echo $grade10['subject_title']; ?></td>
                        <td>
                          <?php if ($grade10['ste'] == 1) {
                            echo "YES";
                          }else {
                            echo "NO";
                          } ?>
                        </td>
                        <td><a href="edit_grade10.php?subject_id=<?php echo $grade10['subject_id'];; ?>" class="btn btn-primary">Edit</a></td>
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
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Grade 10 subjects id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Grade 10 subjects id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                  //for notification before deleting the grade10
                      $(document).ready(function() {
                      $('.delete_form #btn-ok').click(function(e) {
                        var ischecked = $('#ckx:checked').length;
                        if (ischecked > 0) {

                        }else {
                          Swal.fire({title: 'None Selected', text: 'Please select atleast one subject!'});
                          return
                        }
                        //For number of grade10 being deleted
                          var num2 = document.querySelectorAll('input[type="checkbox"]:checked').length;
                          let form = $(this).closest('form');
                          var num = num2 - minus;
                          swal.fire({
                            title: "DELETE "+num+" GRADE 10 SUBJECTS?",
                            text: "Are you sure you want to delete these number ("+num+") of grade 10 subjects? This will also delete all of the data from these subjects, "+
                            "such as assignments, exams, quizzes, and even scores of the students!" ,
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

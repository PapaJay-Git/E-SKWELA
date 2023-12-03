
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM student";
  $result = $conn->query($checkClasses11);

?>
<div class="container-xl">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">STUDENT MANAGEMENT</h2>
                  <hr size="4" width="100%" color="grey">
  <form class="delete_form" action="delete_student.php" method="post">
                  <div class="row" style="margin-bottom:10px;">
                    <div class="col-md-8"><h5> </h5></div>
                    <div class="col-md-4 btn-group" role="group">
                        <button onclick="location.href='create_students.php'" type="button" class="btn btn-primary"><i class="fa fa-user-plus"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >STUDENT</span></i></button>
                        <button name="delete_now" type="button" class="btn btn-danger" id="btn-ok"><i class="fa fa-trash"><span style="font-family: 'Poppins', sans-serif; font-weight: bold;" >STUDENT</span></i></button>
                      <a href="users.php" class="btn btn-primary">BACK</a>
                    </div>
                  </div>
                  <div class="table-responsive">
                  <table id="myidata" class="table table-hover table-xxlg table-bordered" style="width:100%">
                      <thead>
                       <tr>
                        <th><input type="checkbox" onclick="toggle(this);"></th>
                        <th> Login ID </th>
                        <th> LRN </th>
                        <th> Name </th>
                        <th> Section </th>
                        <th>Grade</th>
                        <th> Dropped?</th>
                        <th> Transferred?</th>
                        <th> Edit </th>
                       </tr>
                      </thead>
                      <tbody>
                      <?php
                      while ($students = mysqli_fetch_assoc($result)) {
                      if ($students['class_id'] == NULL || $students['class_id'] == "" || $students['class_id'] == 0) {
                        $section = "Not assigned";
                      }else {
                        $sql = "SELECT * FROM class WHERE class_id=?;";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)) {
                          header("location: index.php?view=sqlerror");
                          exit();
                        }
                          mysqli_stmt_bind_param($stmt, "i", $students['class_id']);
                          mysqli_stmt_execute($stmt);
                          $result_2 = mysqli_stmt_get_result($stmt);
                          if ($result_2->num_rows > 0) {
                            $section_2 = mysqli_fetch_assoc($result_2);
                            $section = $section_2['section_code'];
                            if ($section == "GRADE 11") {
                              $section = "Junior High Graduate";
                            }
                            $grade = $section_2['grade'];
                            if ($grade == "100") {
                              $grade = 11;
                            }
                          }else {
                            $section = "Invalid Section";
                            $grade = "Invalid Grade";
                          }
                      }
                       ?>
                      <tr>
                        <td><input type="checkbox" id="ckx" name="delete_students[]" value="<?php echo $students['student_id'];?>"></td>
                        <td><?php echo $students['student_id']; ?></td>
                        <td><?php echo $students['school_id']; ?></td>
                        <td><?php echo $students['f_name']." ".$students['l_name']; ?></td>
                        <td><?php echo $section; ?></td>
                        <td><?php echo $grade; ?></td>
                        <?php
                        // if ($students['active_status'] == 1) {
                        //   ?><!--<td><a onclick="ConfirmActive('active_student.php?student_id=<?php //echo $students['student_id']; ?>')" class="btn btn-primary">Active</a></td><?php
                        // }else {
                        //   ?><td><a onclick="ConfirmActive('active_student.php?student_id=<?php //echo $students['student_id']; ?>')" class="btn btn-danger">Inactive</a></td>--><?php
                        // }
                        if ($students['dropped'] == 1) {
                          ?><td><a onclick="ConfirmDrop('a_dropped_student.php?student_id=<?php echo $students['student_id']; ?>')" class="btn btn-primary">NO</a></td><?php
                        }else {
                          ?><td><a onclick="ConfirmDrop('a_dropped_student.php?student_id=<?php echo $students['student_id']; ?>')" class="btn btn-danger">YES</a></td><?php
                        }
                        if ($students['transferred'] == 1) {
                          ?><td><a onclick="ConfirmTransfer('a_transferred_student.php?student_id=<?php echo $students['student_id']; ?>')" class="btn btn-primary">NO</a></td><?php
                        }else {
                          ?><td><a onclick="ConfirmTransfer('a_transferred_student.php?student_id=<?php echo $students['student_id']; ?>')" class="btn btn-danger">YES</a></td><?php
                        }
                         ?>
                         <td><a href="edit_student.php?stu_id=<?php echo $students['student_id']; ?>" class="btn btn-primary">Edit</a></td>
                      </tr>

                       <?php
                      }
                       ?>


                       </tbody>
                  </table>
                  </div>
                  </form>
                  </div>
                  <script>
                  function ConfirmActive(e)
                  {
                    swal.fire({
                      title: "Are you sure?",
                      text: "You're about to change the active status of this student account.",
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
                  function ConfirmDrop(e)
                  {
                    swal.fire({
                      title: "Are you sure?",
                      text: "You're about to change the Drop Status of this student account.",
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
                  function ConfirmTransfer(e)
                  {
                    swal.fire({
                      title: "Are you sure?",
                      text: "You're about to change the Transfer Status of this student account.",
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
                        lengthMenu: [[30, 50, 100, -1], [30, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Students List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Students List id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }],
                         initComplete: function () {
                             this.api().columns(5).every( function () {
                                 var column = this;
                                 var select = $('<select><option value="">Grades</option></select>')
                                     .appendTo( $(column.header()).empty() )
                                     .on( 'change', function () {
                                         var val = $.fn.dataTable.util.escapeRegex(
                                             $(this).val()
                                         );

                                         column
                                             .search( val ? '^'+val+'$' : '', true, false )
                                             .draw();
                                     } );

                                 column.data().unique().sort().each( function ( d, j ) {
                                     select.append( '<option value="'+d+'">'+d+'</option>' )
                                 } );
                             } );
                         }
                    } );
                  } );


                  //for notification before deleting the students
                      $(document).ready(function() {
                      $('.delete_form #btn-ok').click(function(e) {
                        var ischecked = $('#ckx:checked').length;
                        if (ischecked > 0) {

                        }else {
                          Swal.fire({title: 'None Selected', text: 'Please select atleast one student!'});
                          return
                        }
                        //For number of students being deleted
                          var num2 = document.querySelectorAll('input[type="checkbox"]:checked').length;
                          let form = $(this).closest('form');
                          var num = num2 - minus;
                          swal.fire({
                            title: "DELETE "+num+" STUDENTS?",
                            text: "Are you sure you want to delete these number ("+num+") of students? This deletion will not be processed if one of these students have "+
                            "data from their grades, quizzes, exams, and even assignments! Please consider before confirming.",
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

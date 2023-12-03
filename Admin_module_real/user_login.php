
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $checkClasses11 = "SELECT * FROM student;";
  $students = $conn->query($checkClasses11);
  $checkClasses11 = "SELECT * FROM admin;";
  $admins = $conn->query($checkClasses11);
  $checkClasses11 = "SELECT * FROM parents;";
  $parents = $conn->query($checkClasses11);
  $checkClasses11 = "SELECT * FROM teachers;";
  $teachers = $conn->query($checkClasses11);

?>
<div class="container">
  <h2 class="head" id="text" style="margin-top:40px; margin-bottom:20px">Student Logins</h2>
                  <hr size="4" width="100%" color="grey">
                  <button type="button" onclick="goBack()" style="float:right; width: 100px;" class="btn btn-primary">BACK</button>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-10" style="margin: bottom; width: 80% ">
                          <select class="form-control" style="display:inline-block;" onchange="change(this)">
                            <option value="1">STUDENTS</option>
                            <option value="2">ADMINS</option>
                            <option value="3">TEACHERS</option>
                            <option value="4">PARENTS</option>
                         </select>
                        </div>
                    </div>

                  <div class="table-responsive" style="display: block; " id="students">
                  <table id="myidata" style="width:100%">
                      <thead>
                       <tr>
                        <th> Login ID</th>
                        <th> LRN </th>
                        <th> Name </th>
                        <th> Last Login </th>
                        <th> Status</th>
                       </tr>
                      </thead>
                      <?php
                      while ($student_row = mysqli_fetch_assoc($students)) {
                        if ($student_row['active_status'] == 1) {
                          $active = "Active";
                        }else {
                          $active = "Inactive";
                        }
                        if (strtotime($student_row['last_log_in'])) {
                          $timestamp = strtotime($student_row['last_log_in']);
                          $today = date("F j Y, g:i a", $timestamp);
                        }else {
                          $today = "never";
                        }

                        ?>
                       <tr>
                         <td><?php echo $student_row['student_id']; ?></td>
                         <td><?php echo $student_row['school_id']; ?></td>
                         <td><?php echo $student_row['l_name'].", ".$student_row['f_name']; ?></td>
                         <td><?php echo $today; ?></td>
                         <td><?php echo $active; ?></td>
                       </tr>
                        <?php
                      }
                       ?>
                  </table>
                  </div>
                  <div class="table-responsive" style="display: none; " id="admins">
                  <table id="myidata2" style="width:100%">
                      <thead>
                       <tr>
                        <th> Login ID</th>
                        <th> School ID </th>
                        <th> Name </th>
                        <th> Last Login </th>
                        <th> Status</th>
                       </tr>
                      </thead>
                      <?php
                      while ($admin_row = mysqli_fetch_assoc($admins)) {
                        if ($admin_row['active_status'] == 1) {
                          $active = "Active";
                        }else {
                          $active = "Inactive";
                        }
                        if (strtotime($admin_row['last_log_in'])) {
                          $timestamp = strtotime($admin_row['last_log_in']);
                          $today = date("F j Y, g:i a", $timestamp);
                        }else {
                          $today = "never";
                        }

                        ?>
                       <tr>
                         <td><?php echo $admin_row['admin_id']; ?></td>
                         <td><?php echo $admin_row['school_id']; ?></td>
                         <td><?php echo $admin_row['l_name'].", ".$admin_row['f_name']; ?></td>
                         <td><?php echo $today; ?></td>
                         <td><?php echo $active; ?></td>
                       </tr>
                        <?php
                      }
                       ?>
                  </table>
                  </div>
                  <div class="table-responsive" style="display: none; " id="teachers">
                  <table id="myidata3" style="width:100%">
                      <thead>
                       <tr>
                        <th> Login ID</th>
                        <th> School ID </th>
                        <th> Name </th>
                        <th> Last Login </th>
                        <th> Status</th>
                       </tr>
                      </thead>
                      <?php
                      while ($teacher_row = mysqli_fetch_assoc($teachers)) {
                        if ($teacher_row['active_status'] == 1) {
                          $active = "Active";
                        }else {
                          $active = "Inactive";
                        }
                        if (strtotime($teacher_row['last_log_in'])) {
                          $timestamp = strtotime($teacher_row['last_log_in']);
                          $today = date("F j Y, g:i a", $timestamp);
                        }else {
                          $today = "never";
                        }

                        ?>
                       <tr>
                         <td><?php echo $teacher_row['teacher_id']; ?></td>
                         <td><?php echo $teacher_row['school_id']; ?></td>
                         <td><?php echo $teacher_row['l_name'].", ".$teacher_row['f_name']; ?></td>
                         <td><?php echo $today; ?></td>
                         <td><?php echo $active; ?></td>
                       </tr>
                        <?php
                      }
                       ?>
                  </table>
                  </div>
                  <div class="table-responsive" style="display: none; " id="parents">
                  <table id="myidata4" style="width:100%">
                      <thead>
                       <tr>
                        <th> Login ID</th>
                        <th> Name </th>
                        <th> Last Login </th>
                       </tr>
                      </thead>
                      <?php
                      while ($parent_row = mysqli_fetch_assoc($parents)) {
                        if (strtotime($parent_row['last_log_in'])) {
                          $timestamp = strtotime($parent_row['last_log_in']);
                          $today = date("F j Y, g:i a", $timestamp);
                        }else {
                          $today = "never";
                        }

                        ?>
                       <tr>
                         <td><?php echo $parent_row['parent_id']; ?></td>
                         <td><?php echo $parent_row['l_name'].", ".$parent_row['f_name']; ?></td>
                         <td><?php echo $today; ?></td>
                       </tr>
                        <?php
                      }
                       ?>
                  </table>
                  </div>
                  </div>
                  <script>
                  var students = document.getElementById("students");
                  var admins = document.getElementById("admins");
                  var teachers = document.getElementById("teachers");
                  var parents = document.getElementById("parents");
                  var text = document.getElementById("text");
                  function change(select){
                    if (select.value == 1) {
                      students.style.display = "block";
                      admins.style.display = "none";
                      teachers.style.display = "none";
                      parents.style.display = "none";
                      text.innerHTML = "Student Logins";
                    }else if(select.value == 2) {
                      students.style.display = "none";
                      admins.style.display = "block";
                      teachers.style.display = "none";
                      parents.style.display = "none";
                      text.innerHTML = "Admin Logins";
                    }else if(select.value == 3) {
                      students.style.display = "none";
                      admins.style.display = "none";
                      teachers.style.display = "block";
                      parents.style.display = "none";
                      text.innerHTML = "Teacher Logins";
                    }else{
                      students.style.display = "none";
                      admins.style.display = "none";
                      teachers.style.display = "none";
                      parents.style.display = "Block";
                      text.innerHTML = "Parent Logins";
                    }
                  }
                  $(document).ready(function() {
                      $('#myidata').DataTable( {
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Student Login ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Student Login ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                  $(document).ready(function() {
                      $('#myidata2').DataTable( {
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Admin Login ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Admin Login ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                  $(document).ready(function() {
                      $('#myidata3').DataTable( {
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Teacher Login ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Teacher Login ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                  $(document).ready(function() {
                      $('#myidata4').DataTable( {
                        dom: 'Blfrtip',
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                         buttons: ['copy',
                         {
                           extend: 'print',
                           title: 'Parent Login ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         },
                         {
                           extend: 'excelHtml5',
                           title: 'Parent Login ID:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                         }]
                    } );
                  } );
                   </script>
</div>

<?php
  require_once 'includes_footer.php';

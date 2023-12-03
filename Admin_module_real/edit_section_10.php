
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $section_id = $_GET['section_id'];
  $grade = 10;
  $sql = "SELECT * FROM class where class_id =? AND grade =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: section_10.php?view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "ii", $section_id, $grade);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        $section_id2 = $row['class_id'];
    } else {
      $_SESSION['error'] = "It looks like this section is missing or this section is not a grade 10 section!";
        header("location: section_10.php?view=failed");
        exit();

    }
?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head" id="h2"><?php echo $row['class_name']; ?> DETAILS</h2>

            <hr size="4" width="100%" color="grey">

              <div class="btn-group" role="group">
              <button type="button" class="btn btn-primary" onClick="showDetails()">DETAILS</button>
              <button type="button" class="btn btn-primary" onClick="showStudents()">STUDENTS</button>
              <a href="section_10.php" class="btn btn-danger">BACK</a>
              </div>
          <div class="parent-profile py-4" id="details">
            <div class="container-md">
              <div class="row">
                <div class="col-lg-100">
                  <div class="card shadow-sm">
                    <div class="card-body">
                       <form onsubmit="return clicked()" id="form" action="edit_section_10_query.php" method="post">
                         <div class="card-body pt-0">
                           <table class="table table-bordered">
                             <tr>
                               <th width="30%">SECTION NAME</th>
                               <td width="2%">:</td>
                               <td>
                                 <?php if ($row['ste'] == 1) {
                                   ?>
                                   <label ><b><?php echo $row['section_code'] ?></b></label>
                                   <input type="hidden" name="section_name_10" value="STE">
                                   <?php
                                     $sql = "SELECT * FROM subjects where grade =?";
                                     $stmt = mysqli_stmt_init($conn);
                                     if(!mysqli_stmt_prepare($stmt, $sql)) {
                                         $_SESSION['error'] = "SQL error, viewing profile.";
                                         header("location: section_10.php?view=failed");
                                         exit();
                                       }
                                         mysqli_stmt_bind_param($stmt, "i", $grade);
                                         mysqli_stmt_execute($stmt);
                                         $result2 = mysqli_stmt_get_result($stmt);
                                 }else {
                                   ?>
                                   <input type="text" name="section_name_10" class="form-control"value="<?php echo $row['section_code'] ?>" required>
                                   <?php
                                     $sql = "SELECT * FROM subjects where grade =? AND ste != ?";
                                     $stmt = mysqli_stmt_init($conn);
                                     if(!mysqli_stmt_prepare($stmt, $sql)) {
                                         $_SESSION['error'] = "SQL error, viewing profile.";
                                         header("location: section_10.php?view=failed");
                                         exit();
                                       }
                                         $ste = 1;
                                         mysqli_stmt_bind_param($stmt, "ii", $grade, $ste);
                                         mysqli_stmt_execute($stmt);
                                         $result2 = mysqli_stmt_get_result($stmt);
                                 } ?>
                               </td>
                             </tr>
                             <?php while ($row2 = mysqli_fetch_assoc($result2)) {
                               $subject_id = $row2['subject_id'];
                               ?>
                               <tr>
                                 <th width="30%">
                                   <input type="hidden" name="subject_id_10[]" value="<?php echo $row2['subject_id']; ?>">
                                   <?php echo $row2['subject_title']; ?></th>
                                 <td width="2%">:</td>
                                 <td>
                                   <select name="teacher_id_10[]" class="form-control" required>
                                       <option disabled selected value> -- TEACHERS -- </option>
                                     <?php
                                     $sql3 = "SELECT * FROM teacher_class WHERE class_id = $section_id2 AND subject_id = $subject_id;";
                                     $query5 = $conn->query($sql3);
                                     $selected_teacher = $query5->fetch_assoc();
                                     $active_status = 1;
                                     if ($query5->num_rows > 0) {
                                       $sql = "SELECT * FROM teachers WHERE active_status = $active_status ORDER BY l_name;";
                                       $query = $conn->query($sql);
                                       while ($row3 = $query->fetch_assoc()) {
                                         if ($row3['teacher_id'] == $selected_teacher['teacher_id']) {
                                             ?>
                                             <option selected value="<?php echo $row3['teacher_id'] ?>"required><?php echo "School ID: ".$row3['school_id']." - Name: ".$row3['l_name'].", ".$row3['f_name'];?></option>
                                             <?php
                                         }else {
                                           ?>
                                           <option value="<?php echo $row3['teacher_id'] ?>"required><?php echo "School ID: ".$row3['school_id']." - Name: ".$row3['l_name'].", ".$row3['f_name'];?></option>
                                           <?php
                                         }
                                       }
                                     }else {
                                       $sql = "SELECT * FROM teachers WHERE active_status = $active_status ORDER BY l_name;";
                                       $query = $conn->query($sql);
                                       while ($row3 = $query->fetch_assoc()) {
                                           ?>
                                           <option value="<?php echo $row3['teacher_id'] ?>" required><?php echo "School ID: ".$row3['school_id']." - Name: ".$row3['l_name'].", ".$row3['f_name'];?></option>
                                           <?php
                                       }
                                     }

                                      ?>
                                   </select>
                                 </td>
                               </tr>
                               <?php
                             } ?>
                           </table>
                         </div>
                           <input type="hidden" name="class_id_10" value="<?php echo $row['class_id'] ?>">
                           <input type="hidden"  name="update_section_10" value="sections_1010">
                           <div class="btn-group" role="group" style="float:right;">
                           <button type="submit" class="btn btn-primary">UPDATE</button>
                           </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="table" style="display:none; margin-top:20px;" id="students">
        <table id="myidata" class="display responsive" style="width:100%">
            <thead>
             <tr>
              <th> login ID </th>
              <th> LRN </th>
              <th> Full Name </th>
              <th> Repeater?</th>
             </tr>
            </thead>
            <?php
            $sql = "SELECT * FROM student WHERE class_id = ?;";
            $stmt = mysqli_stmt_init($conn);
              mysqli_stmt_prepare($stmt, $sql);
              mysqli_stmt_bind_param($stmt, "i", $section_id2);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
            while ($students = mysqli_fetch_assoc($result)) {
              if ($students['repeater'] == 1) {
                $active = "YES";
              }else {
                $active = "NO";
              }
             ?>
            <tr>
              <td><?php echo $students['student_id']; ?></td>
              <td><?php echo $students['school_id']; ?></td>
              <td><?php echo $students['f_name']." ".$students['l_name']; ?></td>
              <td><?php echo $active; ?></td>
            </tr>

             <?php
            }
             ?>
        </table>
        </div>
        </div>
          <script type="text/javascript">
              var d = document.getElementById('details');
              var s = document.getElementById('students');
              function showDetails() {
                d.style.display = "block"
                s.style.display = "none"
              }
              function showStudents() {
                s.style.display = "block"
                d.style.display = "none"
              }

              //for tables
              $(document).ready(function() {
                  $('#myidata').DataTable( {
                    dom: 'Blfrtip',
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                     buttons: ['copy',
                     {
                       extend: 'print',
                       title: 'Students List <?php echo $row['class_name']; ?> id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                     },
                     {
                       extend: 'excelHtml5',
                       title: 'Students List <?php echo $row['class_name']; ?> id:<?php $rand = substr(uniqid('', true), -5); echo $rand;?>'
                     }]
                } );
              } );
              function clicked() {
                  swal.fire({
                    title: "Are you sure?",
                    text: "You are about to change the Details of this section. Are you sure you want to do this?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Change"
                  }).then(function (result){
                    if (result.isConfirmed) {
                          document.getElementById("form").submit();
                      } else if (result.dismiss === 'cancel') {
                          swal.fire({position: 'center', icon: 'error', title: 'Change Cancelled', showConfirmButton: false, timer: 1500})
                        }
                    })
              return false;
              }
          </script>
<?php
  require_once 'includes_footer.php';

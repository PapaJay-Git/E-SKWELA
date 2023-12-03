
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $parent_id = $_GET['parent_id'];
  $sql = "SELECT * FROM parents where parent_id =?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
      $_SESSION['error'] = "SQL error, viewing profile.";
      header("location: parents.php?view=failed");
      exit();
    }
      mysqli_stmt_bind_param($stmt, "i", $parent_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($result->num_rows > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
    } else {
      $_SESSION['error'] = "It looks like this parent is already been deleted!";
        header("location: parents.php?view=failed");
        exit();
    }
    $sql = "SELECT * FROM parent_student where parent_id =?";
    $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "i", $row['parent_id']);
        mysqli_stmt_execute($stmt);
        $result22 = mysqli_stmt_get_result($stmt);

   $sections = "SELECT * FROM class";
   $querred = $conn->query($sections);

?>
          <div class="container-xxl">
            <h2 style="margin-top:40px; margin-bottom:20px" class="head" id="h2">CHANGE PARENT DETAILS</h2>

            <hr size="4" width="100%" color="grey">
            <div class="btn-group" role="group" style="margin-top:20px;">
            <button type="button" class="btn btn-primary" onClick="showName()">Name</button>
            <button type="button" class="btn btn-primary" onClick="showPassword()">Password</button>
            <button type="button" class="btn btn-primary" onClick="showStudent()">Students</button>
            </div>
              <!-- parent Profile -->
            <div class="parent-profile py-4" style="display: block;" id="nameform">
              <div class="container-md">
                <div class="row">
                  <div class="col-lg-100">
                    <div class="card shadow-sm">
                      <div class="card-body">
                         <form onsubmit="return clicked()" id="formpassword" action="edit_parent_query.php" method="post">
                           <div class="form-group">
                             <input type="hidden" name="parent_id" value="<?php echo $row['parent_id']; ?>">
                             <label for="first">First Name</label><br>
                             <input type="text" class="form-control" id="first"name="first" required value="<?php echo $row['f_name'] ?>">
                             <label for="last">Last Name</label>
                             <input type="text" class="form-control" id="last"name="last" required value="<?php echo $row['l_name'] ?>">
                           </div>
                             <div class="btn-group" role="group" style="float:right; margin-top:20px;">
                             <button type="submit" class="btn btn-primary" >UPDATE</button>
                             <input type="hidden" name="update_parent_name" value="vals">
                             <a href="parents.php" class="btn btn-danger">BACK</a>
                             </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="parent-profile py-4" style="display: none;" id="passform">
            <div class="container-md">
              <div class="row">
                <div class="col-lg-100">
                  <div class="card shadow-sm">
                    <div class="card-body">
                       <form onsubmit="return clicked2()" id="formpassword2" action="edit_parent_query.php" method="post">
                         <div class="form-group">
                           <label for="password3">New Password</label>
                           <input type="hidden" name="parent_id" value="<?php echo $row['parent_id']; ?>">
                           <input type="password" class="form-control" pattern="[A-Za-z0-9_]{6,20}"
                           placeholder="password" name="new_password" id="password4" title=
                           "Only letters (either case), numbers, and the underscore; 6 to 20 characters."  required>
                         </div>
                         <div class="form-group">
                           <label for="password3">Confirm New Password</label>
                           <input type="password" class="form-control" pattern="[A-Za-z0-9_]{6,20}"
                           placeholder="password" name="confirm_password" id="password3" title=
                           "Only letters (either case), numbers, and the underscore; 6 to 20 characters."  required>
                         </div>
                           <div class="form-group form-check">
                             <input type="checkbox" class="form-check-input" id="exampleCheck1" onClick="showPass2()">
                             <label class="form-check-label" for="exampleCheck1">Show Password</label>
                           </div>
                           <div class="btn-group" role="group" style="float:right;">
                           <button type="submit" class="btn btn-primary">UPDATE</button>
                           <input type="hidden"  name="update_parent_password" value="vals">
                           <a href="parents.php" class="btn btn-danger">BACK</a>
                           </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="parent-profile py-4" style="display: none;" id="students">
          <div class="container-md">
            <div class="row">
              <div class="col-lg-100">
                <div class="card shadow-sm">
                  <div class="card-header">
                    <label for="password3">Assigned Students</label>
                  </div>
                  <div class="card-body">
                     <form  onsubmit="return clicked3()" id="formpassword3" action="edit_parent_query.php" method="post">
                       <div class="form-group">
                         <input type="hidden" name="parent_id" value="<?php echo $row['parent_id']; ?>">

                         <?php
                         while ($row22 = mysqli_fetch_assoc($result22)) {
                           $sql = "SELECT * FROM student where student_id =?";
                           $stmt = mysqli_stmt_init($conn);
                               mysqli_stmt_prepare($stmt, $sql);
                               mysqli_stmt_bind_param($stmt, "i", $row22['student_id']);
                               mysqli_stmt_execute($stmt);
                               $result3 = mysqli_stmt_get_result($stmt);
                               $row3 = mysqli_fetch_assoc($result3);
                               $sql = "SELECT * FROM class where class_id =?";
                               $stmt = mysqli_stmt_init($conn);
                                   mysqli_stmt_prepare($stmt, $sql);
                                   mysqli_stmt_bind_param($stmt, "i", $row3['class_id']);
                                   mysqli_stmt_execute($stmt);
                                   $result4 = mysqli_stmt_get_result($stmt);
                                   $row4 = mysqli_fetch_assoc($result4);
                                   ?>
                                   <table class="table table-bordered">
                                     <tr>
                                       <th width="30%">LRN</th>
                                       <td width="2%">:</td>
                                       <td>
                                         <div class="form-group">
                                           <textareaclass="form-control" disabled><?php echo $row3['school_id']; ?></textarea>
                                         </div>
                                     </td>
                                     </tr>
                                     <tr>
                                       <th width="30%">Student Name</th>
                                       <td width="2%">:</td>
                                       <td>
                                         <div class="form-group">
                                           <textareaclass="form-control" disabled><?php echo $row3['l_name'].", ".$row3['f_name']; ?></textarea>
                                         </div>
                                     </td>
                                     </tr>
                                     <tr>
                                       <th width="30%">Student Section</th>
                                       <td width="2%">:</td>
                                       <td>
                                         <div class="form-group">
                                           <textareaclass="form-control" disabled><?php echo $row4['class_name']; ?></textarea>
                                         </div>
                                     </td>
                                     </tr>
                                     <tr>
                                       <th width="30%"></th>
                                       <td width="2%">:</td>
                                       <td>
                                         <div class="form-group">
                                           <div class="btn-group" role="group" style="float:right;">
                                           <a onClick="ConfirmDelete('remove_connection.php?parent_id=<?php echo $row['parent_id']; ?>&parent_student_id=<?php echo $row22['parent_student_id']; ?>')"
                                             class="btn btn-danger primary" name="update_parent_student">REMOVE</a>
                                           </div>
                                         </div>
                                     </td>
                                     </tr>
                                   </table>
                                   <?php
                         }
                          ?>
                         <label for="school_id">Sections</label>
                         <select class="form-control" name="class_id" onchange="change(this)" required>
                           <option value="" selected disabled hidden>Choose here</option>
                           <?php while ($section = $querred->fetch_assoc()) {
                             ?>
                             <option value="<?php echo $section['class_id']; ?>"><?php echo $section['class_name']; ?></option>
                             <?php
                           } ?>
                         </select>
                         <label for="school_id">Students</label>
                         <select class="form-control" name="student_id" id="student_select" required>
                           <option value="" selected disabled hidden>No students</option>
                         </select>
                         <div class="btn-group" role="group" style="float:right; margin-top: 10px;">
                         <button type="submit" class="btn btn-primary" >ADD</button>
                         <input type="hidden" name="update_parent_student" value="student">
                         <a href="parents.php" class="btn btn-danger">BACK</a>
                         </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
        </div>
      </div>
          <script type="text/javascript">
          function change(select){

            var class_id = select.value;
            var students = document.getElementById("student_select");
            $.ajax({
            url : 'parent_student.php',
            data : {'class_id' : class_id},
            dataType : 'html',
            type : 'POST',
            cache : false,
            success : function(result) {
              students.innerHTML = result;
            },

            error : function (request, status, error) {
                  console.log(error);
            }
            });
          }

              function showPass2() {
                var p3 = document.getElementById('password4');
                var p4 = document.getElementById('password3');
                if (p4.type === "password") {
                    p4.type = "text";
                    p3.type = "text";
                    } else {
                      p4.type = "password";
                      p3.type = "password";
                    }
              }

              function showName(){
                document.getElementById('nameform').style.display = "block";
                document.getElementById('passform').style.display = "none";
                document.getElementById('students').style.display = "none";
              }
              function showPassword(){
                document.getElementById('nameform').style.display = "none";
                document.getElementById('passform').style.display = "block";
                document.getElementById('students').style.display = "none";
              }
              function showStudent(){
                document.getElementById('nameform').style.display = "none";
                document.getElementById('passform').style.display = "none";
                document.getElementById('students').style.display = "block";
              }
              function clicked() {
               swal.fire({
                 title: "Are you sure?",
                 text: "You are about to change the name of this parent account. Are you sure you want to do this?",
                 icon: "question",
                 showCancelButton: true,
                 confirmButtonText: "Change"
               }).then(function (result){
                 if (result.isConfirmed) {
                       document.getElementById("formpassword").submit();
                   } else if (result.dismiss === 'cancel') {
                       swal.fire({position: 'center', icon: 'error', title: 'Change Cancelled', showConfirmButton: false, timer: 1500})
                     }
                 })
              return false;
              }
              function clicked2() {
                swal.fire({
                  title: "Are you sure?",
                  text: "You are about to change the password of this parent account. Are you sure you want to do this?",
                  icon: "question",
                  showCancelButton: true,
                  confirmButtonText: "Change"
               }).then(function (result){
                 if (result.isConfirmed) {
                       document.getElementById("formpassword2").submit();
                   } else if (result.dismiss === 'cancel') {
                       swal.fire({position: 'center', icon: 'error', title: 'Change Cancelled', showConfirmButton: false, timer: 1500})
                     }
                 })
              return false;
              }
              function clicked3() {
                swal.fire({
                  title: "Are you sure?",
                  text: "You are about to add a connection between a student and parent. If you confirm, this parent account will be able to see the grades of this student. Are you sure you want to do this?",
                  icon: "question",
                  showCancelButton: true,
                  confirmButtonText: "Yes, Add"
               }).then(function (result){
                 if (result.isConfirmed) {
                       document.getElementById("formpassword3").submit();
                   } else if (result.dismiss === 'cancel') {
                       swal.fire({position: 'center', icon: 'error', title: 'Add Cancelled', showConfirmButton: false, timer: 1500})
                     }
                 })
              return false;
              }
          </script>
<?php
  require_once 'includes_footer.php';

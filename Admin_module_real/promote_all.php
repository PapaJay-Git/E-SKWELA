
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  require_once 'a.php';
  $g7 = 7;
  $g8 = 8;
  $g9 = 9;
  $g10 = 10;
  $checkClasses11 = "SELECT * FROM class WHERE grade = $g7";
  $grade_7 = $conn->query($checkClasses11);
  $checkClasses11 = "SELECT * FROM class WHERE grade = $g8";
  $grade_8 = $conn->query($checkClasses11);
  $checkClasses11 = "SELECT * FROM class WHERE grade = $g9";
  $grade_9 = $conn->query($checkClasses11);
  $checkClasses11 = "SELECT * FROM class WHERE grade = $g10";
  $grade_10 = $conn->query($checkClasses11);
?>
<div class="container" style="font-weight:normal">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">PROMOTE ALL SECTIONS</h2>
                  <hr size="4" width="100%" color="grey">
                  <a href="sections.php" style="float:right; width: 100px;" class="btn btn-primary">BACK</a>
                  <div class="row">
                    <h1>&nbsp</h1>
                  </div>
                    <section id="intro" style="display:block">
                      <div class="rt-container-xxl">
                            <div class="col-rt-12">
                                <div class="Scriptcontent">
                                <div class="student-profile py-4" >
                                  <div class="container-xxl">
                                    <div class="row">
                                      <div class="col-lg-100">
                                        <div class="card shadow-sm">
                                          <div class="card-header bg-transparent">
                                            <small style="float:right">1/4</small>
                                            <b>DETAILS OF PROMOTIONS</b>
                                          </div>
                                          <div class="card-body">
                                            <ul class="list-group">
                                              <li class="list-group-item"><b>1.</b> The created <b>modules</b>, <b>exams</b>, <b>quizzes</b>, and <b>assignments</b> of the teachers will all be removed from the system.
                                                Also, <b>all</b> of the <b>notifications</b> connected from those four will also be removed.
                                              </li>
                                              <li class="list-group-item"><b>2.</b>  The <b>assigned</b> section's subject (<b>classes</b>) on teachers will all be </b>unassigned</b> from them. This will allow the admin to assign new teachers in
                                                each classes properly and will also allow to <b>remove</b> old subjects for the <b>upcoming school year</b>.
                                              </li>
                                              <li class="list-group-item"><b>3.</b>  All of Grade 7, 8 and 9 students who passed will be automatically promoted to the section you have chosen.</li>
                                              <li class="list-group-item"><b>4.</b>  While Grade 10 students who passed will be automatically promoted as a Junior High Graduate or Grade 11 student.</li>
                                              <li class="list-group-item"><b>5.</b>  For those students who failed will remain on their current sections and will all be labeled as a repeater. You can
                                                also view all of those repeaters from every grade. Just go to <b>Classes</b> -> <b>All Repeaters</b> tab.
                                              </li>
                                              <li class="list-group-item"><b>6.</b>  STE students who didn't pass the grade requirement of 85 but passed the 75 will be promoted to a non-STE section.
                                                You can also view all of those previous STE students from every grade. Just go to <b>Classes</b> -> <b>Previous STE students</b> tab.
                                              </li>
                                            </ul>
                                            <div class="btn-group" style="float:right; margin-top: 15px">
                                              <button type="button" name="button" class="btn btn-primary" onclick="show1()">Next</button>
                                            </div>
                                            <h1>&nbsp</h1>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                    </section>
                <form onsubmit="return false" id="myform" method="post">
                  <section id="grade_7" style="display:none">
                    <div class="rt-container-xxl">
                          <div class="col-rt-12">
                              <div class="Scriptcontent">
                              <div class="student-profile py-4" >
                                <div class="container-xxl">
                                  <div class="row">
                                    <div class="col-lg-100">
                                      <div class="card shadow-sm">
                                        <div class="card-header bg-transparent">
                                          <small style="float:right">2/4</small>
                                          <b>Promotion of Grade 7 students</b>
                                        </div>
                                        <div class="card-body">
                                          <div id="message8" style="display:none"class="alert alert-danger" role="alert">
                                            <b>Warning!</b> You have chosen duplicate sections to promote to! If you did this on purpose then
                                            you can ignore this message.
                                          </div>
                                          <?php
                                          while ($row_7 = mysqli_fetch_assoc($grade_7)) {
                                            if ($row_7['ste']== 1) {
                                              ?>
                                            <label><?php echo "Section: <b>".$row_7['class_name']."</b>"; ?></label><br>
                                            <label >Choose</label>
                                            <input type="hidden" name="old_7[]" value="<?php echo $row_7['class_id']; ?>">
                                             <select class="form-control form-control-sm section_8" name="section_8[]">
                                               <?php
                                               $grade_8->data_seek(0);
                                               while ($row_8 =  mysqli_fetch_assoc($grade_8)) {
                                                 if ($row_8['ste'] == 1) {
                                                   ?>
                                                   <option value="<?php echo $row_8['class_id']; ?>"><?php echo $row_8['class_name']; ?></option>
                                                   <?php
                                                 }
                                               }
                                                ?>
                                             </select>
                                               <br>
                                              <?php
                                            }else {
                                              ?>
                                            <label><?php echo "Section: <b>".$row_7['class_name']."</b>"; ?></label><br>
                                            <label >Choose</label>
                                            <input type="hidden" name="old_7[]" value="<?php echo $row_7['class_id']; ?>">
                                             <select class="form-control form-control-sm section_8" name="section_8[]">
                                               <option value="" default disabled selected>--Grade 8 sections you can promote to--</option>
                                               <?php
                                               $grade_8->data_seek(0);
                                               while ($row_8 =  mysqli_fetch_assoc($grade_8)) {
                                                 if ($row_8['ste'] != 1) {
                                                 ?>
                                                 <option value="<?php echo $row_8['class_id']; ?>"><?php echo $row_8['class_name']; ?></option>
                                                 <?php
                                                 }
                                               }
                                                ?>
                                             </select>
                                               <br>
                                              <?php
                                            }
                                          }
                                           ?>
                                          <div class="btn-group" style="float:right; margin-top: 15px">
                                            <button type="button" name="button" class="btn btn-primary" onclick="back2()">Prev</button>
                                            <button type="button" name="button" class="btn btn-primary" onclick="show2()">Next</button>
                                          </div>
                                          <h1>&nbsp</h1>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                  </section>
                  <section id="grade_8" style="display:none">
                    <div class="rt-container-xxl">
                          <div class="col-rt-12">
                              <div class="Scriptcontent">
                              <div class="student-profile py-4" >
                                <div class="container-xxl">
                                  <div class="row">
                                    <div class="col-lg-100">
                                      <div class="card shadow-sm">
                                        <div class="card-header bg-transparent">
                                          <small style="float:right">3/4</small>
                                          <b>Promotion of Grade 8 students</b>
                                        </div>
                                        <div class="card-body">
                                          <div id="message9" style="display:none"class="alert alert-danger" role="alert">
                                            <b>Warning!</b> You have chosen duplicate sections to promote to! If you did this on purpose then
                                            you can ignore this message.
                                          </div>
                                          <?php
                                          $grade_8->data_seek(0);
                                          while ($row_8 = mysqli_fetch_assoc($grade_8)) {
                                            if ($row_8['ste']== 1) {
                                            ?>
                                          <label><?php echo "Section: <b>".$row_8['class_name']."</b>"; ?></label><br>
                                          <label >Choose</label>
                                          <input type="hidden" name="old_8[]" value="<?php echo $row_8['class_id']; ?>">
                                           <select class="form-control form-control-sm section_9" name="section_9[]">
                                             <?php
                                             $grade_9->data_seek(0);
                                             while ($row_9 =  mysqli_fetch_assoc($grade_9)) {
                                               if ($row_9['ste'] == 1) {
                                               ?>
                                               <option value="<?php echo $row_9['class_id']; ?>"><?php echo $row_9['class_name']; ?></option>
                                               <?php
                                               }
                                             }
                                              ?>
                                           </select>
                                             <br>
                                            <?php
                                          }else {
                                            ?>
                                          <label><?php echo "Section: <b>".$row_8['class_name']."</b>"; ?></label><br>
                                          <label >Choose</label>
                                          <input type="hidden" name="old_8[]" value="<?php echo $row_8['class_id']; ?>">
                                           <select class="form-control form-control-sm section_9" name="section_9[]">
                                             <option value="" default disabled selected>--Grade 9 sections you can promote to--</option>
                                             <?php
                                             $grade_9->data_seek(0);
                                             while ($row_9 =  mysqli_fetch_assoc($grade_9)) {
                                               if ($row_9['ste'] != 1) {
                                               ?>
                                               <option value="<?php echo $row_9['class_id']; ?>"><?php echo $row_9['class_name']; ?></option>
                                               <?php
                                               }
                                             }
                                              ?>
                                           </select>
                                             <br>
                                            <?php
                                          }
                                          }
                                           ?>
                                          <div class="btn-group" style="float:right; margin-top: 15px">
                                            <button type="button" name="button" class="btn btn-primary" onclick="back3()">Prev</button>
                                            <button type="button" name="button" class="btn btn-primary" onclick="show3()">Next</button>
                                          </div>
                                          <h1>&nbsp</h1>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                  </section>
                  <section id="grade_9" style="display:none">
                    <div class="rt-container-xxl">
                          <div class="col-rt-12">
                              <div class="Scriptcontent">
                              <div class="student-profile py-4" >
                                <div class="container-xxl">
                                  <div class="row">
                                    <div class="col-lg-100">
                                      <div class="card shadow-sm">
                                        <div class="card-header bg-transparent">
                                          <small style="float:right">4/4</small>
                                          <b> Promotion of Grade 9 students</b>
                                        </div>
                                        <div class="card-body">
                                          <div id="message10" style="display:none"class="alert alert-danger" role="alert">
                                            <b>Warning!</b> You have chosen duplicate sections to promote to! If you did this on purpose then
                                            you can ignore this message.
                                          </div>
                                          <?php
                                          $grade_9->data_seek(0);
                                          while ($row_9 = mysqli_fetch_assoc($grade_9)) {
                                            if ($row_9['ste'] == 1) {
                                            ?>
                                          <label><?php echo "Section: <b>".$row_9['class_name']."</b>"; ?></label><br>
                                          <label >Choose</label>
                                          <input type="hidden" name="old_9[]" value="<?php echo $row_9['class_id']; ?>">
                                           <select class="form-control form-control-sm section_10" name="section_10[]">
                                             <?php
                                             $grade_10->data_seek(0);
                                             while ($row_10 =  mysqli_fetch_assoc($grade_10)) {
                                               if ($row_10['ste'] == 1) {
                                               ?>
                                               <option value="<?php echo $row_10['class_id']; ?>"><?php echo $row_10['class_name']; ?></option>
                                               <?php
                                               }
                                             }
                                              ?>
                                           </select>
                                             <br>
                                            <?php
                                          }else {
                                          ?>
                                        <label><?php echo "Section: <b>".$row_9['class_name']."</b>"; ?></label><br>
                                        <label >Choose</label>
                                        <input type="hidden" name="old_9[]" value="<?php echo $row_9['class_id']; ?>">
                                         <select class="form-control form-control-sm section_10" name="section_10[]">
                                           <option value="" default disabled selected>--Grade 10 sections you can promote to--</option>
                                           <?php
                                           $grade_10->data_seek(0);
                                           while ($row_10 =  mysqli_fetch_assoc($grade_10)) {
                                             if ($row_10['ste'] != 1) {
                                             ?>
                                             <option value="<?php echo $row_10['class_id']; ?>"><?php echo $row_10['class_name']; ?></option>
                                             <?php
                                             }
                                           }
                                            ?>
                                         </select>
                                           <br>
                                          <?php
                                          }
                                          }
                                           ?>
                                          <div class="btn-group" style="float:right; margin-top: 15px">
                                            <button type="button" name="button" class="btn btn-primary" onclick="back4()">Prev</button>
                                            <button type="button" name="button" class="btn btn-primary" onclick="show4()">Next</button>
                                          </div>
                                          <h1>&nbsp</h1>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                  </section>
                  <section id="password" style="display:none">
                    <div class="rt-container-xxl">
                          <div class="col-rt-12">
                              <div class="Scriptcontent">
                              <div class="student-profile py-4" >
                                <div class="container-xxl">
                                  <div class="row">
                                    <div class="col-lg-100">
                                      <div class="card shadow-sm">
                                        <div class="card-header bg-transparent">
                                          <small style="float:right">Final</small>
                                          <b>Confirm your password</b>
                                        </div>
                                        <div class="card-body">
                                          <label>Password</label>
                                          <input class="form-control"type="password" id="password2"name="password" placeholder="Passowrd..." required>
                                          <div class="btn-group" style="float:right; margin-top: 15px">
                                            <button type="button" name="button" class="btn btn-primary" onclick="back5()">Prev</button>
                                            <button type="button" name="button" class="btn btn-primary" onclick="checkpassword()">Submit</button>
                                          </div>
                                          <h1>&nbsp</h1>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                  </section>
                </form>
</div>
<script type="text/javascript">
  var intro = document.getElementById('intro');
  var grade_7 = document.getElementById('grade_7');
  var grade_8 = document.getElementById('grade_8');
  var grade_9 = document.getElementById('grade_9');
  var password = document.getElementById('password');
  var form = document.getElementById('myform');
  var ms8 = document.getElementById('message8');
  var ms9 = document.getElementById('message9');
  var ms10 = document.getElementById('message10');
function foo8() {

    var elements = document.querySelectorAll(".section_8");
        var values = [];
        for (var i = 0; i < elements.length; i++) {
            values.push(elements[i].value);
        }
        var sortedValues = values.sort();
        for (var o = 0; o < values.length-1; o++) {
            if (values[o] == values[o+1]){
              ms8.style.display = "block";
            }else {
              ms8.style.display = "none";
            }
        }

    setTimeout(foo8, 100);
}
foo8();
function foo9() {

    var elements = document.querySelectorAll(".section_9");
        var values = [];
        for (var i = 0; i < elements.length; i++) {
            values.push(elements[i].value);
        }
        var sortedValues = values.sort();
        for (var o = 0; o < values.length-1; o++) {
            if (values[o] == values[o+1]){
              ms9.style.display = "block";
            }else {
              ms9.style.display = "none";
            }
        }

    setTimeout(foo9, 100);
}
foo9();
function foo10() {

    var elements = document.querySelectorAll(".section_10");
        var values = [];
        for (var i = 0; i < elements.length; i++) {
            values.push(elements[i].value);
        }
        var sortedValues = values.sort();
        for (var o = 0; o < values.length-1; o++) {
            if (values[o] == values[o+1]){
              ms10.style.display = "block";
            }else {
              ms10.style.display = "none";
            }
        }

    setTimeout(foo10, 100);
}
foo10();
//pass
function checkpassword(){
  var password2 = document.getElementById('password2').value;
  $.ajax({
  url : 'check_password.php',
  data : {'password' : password2},
  type : 'POST',
  dataType : "text",
  cache : false,

  success : function(result) {
  if (result == "true") {
    swal.fire({
      title: "Are you sure?",
      text: "You are about to promote all of the students from grade 7 to 10 who passed. This will also remove the created modules, exams, quizzes, and assignments from this system. This process cannot be undone. Are you willing to proceed?",
      showCancelButton: true,
      confirmButtonText: "YES"
    }).then(function (result){
      if (result.isConfirmed) {
          form.action = "promote_all_query.php";
          form.submit()
        swal.fire({position: 'center', title: 'Uploading...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Promotion Cancelled', showConfirmButton: false, timer: 1500})
          }
      })
  }else {
    Swal.fire({title: "Wrong", text: "Wrong Password, please try again."});
  }
  },
  error : function (request, status, error) {
        console.log(error);
  }
  });
}
//NEXT BUTTONS
  function show1() {
    <?php
    if ($validation == 1) {
    ?>
    Swal.fire({title: "Grades are not fully encoded", text: "It looks like, teachers are still not done encoding final grades of their students. Please update the teachers to finish encoding all of the grades of their students first to be able to proceed."});
    return
    <?php
    }
     ?>
    Swal.fire({title: "Proceeding to", text: "Grade 7 promotion", showConfirmButton: false, timer: 2000, timerProgressBar: true});
    setTimeout(function() {
    intro.style.display ="none";
    grade_7.style.display = "block";
  }, 2000);
  }
  function show2() {
    var elements = document.querySelectorAll(".section_8");
        var values = [];
        for (var i = 0; i < elements.length; i++) {
            values.push(elements[i].value);
        }
        if (values.includes("")) {
          Swal.fire({title: "Warning", text: "Please choose all the section to promote to, before you can you proceed."});
          return
        }
        var sortedValues = values.sort();
        for (var o = 0; o < values.length-1; o++) {
            if (values[o] == values[o+1]){
              swal.fire({
                title: "DUPLICATE",
                text: "It looks like you have chosen Duplicate Grade 8 section to promote grade 7 students. Did you do this on purpose? If you did, click Yes and if not then Cancel and edit your choices.",
                showCancelButton: true,
                confirmButtonText: "YES"
              }).then(function (result){
                if (result.isConfirmed) {
                    Swal.fire({title: "Proceeding to", text: "Grade 8 promotion", showConfirmButton: false, timer: 2000, timerProgressBar: true});
                    setTimeout(function() {
                      grade_7.style.display = "none";
                      grade_8.style.display = "block";
                    }, 2000);
                  }
                })
                return
            }
        }
        for (var o = 0; o < values.length-1; o++) {
            if (values[o] != values[o+1]){
              Swal.fire({title: "Proceeding to", text: "Grade 8 promotion", showConfirmButton: false, timer: 2000, timerProgressBar: true});
              setTimeout(function() {
                grade_7.style.display = "none";
                grade_8.style.display = "block";
              }, 2000);
            }
        }
  }
  function show3() {
    var elements = document.querySelectorAll(".section_9");
        var values = [];
        for (var i = 0; i < elements.length; i++) {
            values.push(elements[i].value);
        }
        if (values.includes("")) {
          Swal.fire({title: "Warning", text: "Please choose all the section to promote to, before you can you proceed."});
          return
        }
        var sortedValues = values.sort();
        for (var o = 0; o < values.length-1; o++) {
            if (values[o] == values[o+1]){
              swal.fire({
                title: "DUPLICATE",
                text: "It looks like you have chosen Duplicate Grade 9 section to promote grade 8 students. Did you do this on purpose? If you did, click Yes and if not then Cancel and edit your choices.",
                showCancelButton: true,
                confirmButtonText: "YES"
              }).then(function (result){
                if (result.isConfirmed) {
                      Swal.fire({title: "Proceeding to", text: "Grade 9 promotion", showConfirmButton: false, timer: 2000, timerProgressBar: true});
                      setTimeout(function() {
                        grade_8.style.display = "none";
                        grade_9.style.display = "block";
                      }, 2000);
                  }
                })
                return
            }
        }
        for (var o = 0; o < values.length-1; o++) {
            if (values[o] != values[o+1]) {
              Swal.fire({title: "Proceeding to", text: "Grade 9 promotion", showConfirmButton: false, timer: 2000, timerProgressBar: true});
              setTimeout(function() {
                grade_8.style.display = "none";
                grade_9.style.display = "block";
              }, 2000);
            }
        }
  }
  function show4() {
    var elements = document.querySelectorAll(".section_10");
        var values = [];
        for (var i = 0; i < elements.length; i++) {
            values.push(elements[i].value);
        }
        if (values.includes("")) {
          Swal.fire({title: "Warning", text: "Please choose all the section to promote to, before you can you proceed."});
          return
        }
        var sortedValues = values.sort();
        for (var o = 0; o < values.length-1; o++) {
            if (values[o] == values[o+1]){
              swal.fire({
                title: "DUPLICATE",
                text: "It looks like you have chosen Duplicate Grade 10 section to promote grade 9 students. Did you do this on purpose? If you did, click Yes and if not then Cancel and edit your choices.",
                showCancelButton: true,
                confirmButtonText: "YES"
              }).then(function (result){
                if (result.isConfirmed) {
                      Swal.fire({title: "Proceeding to", text: "Password Confirmation", showConfirmButton: false, timer: 2000, timerProgressBar: true});
                      setTimeout(function() {
                        grade_9.style.display = "none";
                        password.style.display = "block";
                      }, 2000);
                  }
                })
                return
            }
        }
        for (var o = 0; o < values.length-1; o++) {
            if (values[o] != values[o+1]){
              Swal.fire({title: "Proceeding to", text: "Password Confirmation", showConfirmButton: false, timer: 2000, timerProgressBar: true});
              setTimeout(function() {
                grade_9.style.display = "none";
                password.style.display = "block";
              }, 2000);
            }
        }
  }
//PREV BUTTONS
function back2(){
  intro.style.display ="block";
  setTimeout(function() {}, 1000);
  grade_7.style.display = "none";
}
function back3(){
  grade_7.style.display = "block";
  setTimeout(function() {}, 1000);
  grade_8.style.display = "none";
}
function back4(){
  grade_8.style.display = "block";
  setTimeout(function() {}, 1000);
  grade_9.style.display = "none";
}
function back5(){
  grade_9.style.display = "block";
  setTimeout(function() {}, 1000);
  password.style.display = "none";
}
</script>
<?php
  require_once 'includes_footer.php';

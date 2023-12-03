
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';

  $sql = "SELECT * FROM class WHERE grade != 100;";
  $query = $conn->query($sql);
?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">CREATE STUDENT ACCOUNT</h2>
  <hr size="4" width="100%" color="grey">
  <div class="btn-group" role="group" style="margin-bottom:15px;">
  <button type="button" class="btn btn-primary" onClick="showText()">Textbox</button>
  <button type="button" class="btn btn-primary" onClick="showCSV()">CSV</button>
  </div>
                    <form onsubmit="return clicked()" id="formm" action="create_students_query.php" method="post">
                        <div class="row">
                            <div style="width: 60%; margin-bottom: 10px">
                              <select class="form-control" name="section" required>
                              <option disabled selected value>-- SECTIONS --</option>
                              <?php while ($row = $query->fetch_assoc()){

                                ?>
                                <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                                <?php
                              }
                              ?>
                             </select>
                            </div>
                          <div class="col-md-4 btn-group" role="group">
                            <input type="submit" value="SAVE NOW"class="btn btn-primary">
                            <input type="hidden" name="add_student" value="basta">
                            <a href="students.php"class="btn btn-danger">BACK</a>
                          </div>
                        </div>
                      <label style="margin-top: 20px">Student's LRN, Name and Password</label><br>
                      <small>Passwords can only be letters (either case), numbers, and the underscore; 6 to 20 characters.</small>
                      <div class="multi-field-wrapper">
                        <div class="multi-fields">
                          <div class="multi-field" style="margin-top: 10px">
                            <input type="number" class="school_id"id="school_id"name="school_id[]" min="100000000000" max="999999999999" style="width: 21%;"placeholder="LRN..." required>
                            <input type="text" name="first_name[]"style="width: 21%;"placeholder="First..." required>
                            <input type="text" name="last_name[]" style="width: 21%;"placeholder="Last..." required>
                            <input type="password" name="password[]" style="width: 21%;"placeholder="Password..."
                            pattern="[A-Za-z0-9_]{6,20}" placeholder="password" name="new_password" id="password2"
                            title="Only letters (either case), numbers, and the underscore; 6 to 20 characters. " required>
                            <button type="button" style="display:inline; width:40px;"class="btn btn-primary" id="remove-field">X</button>
                          </div>
                        </div>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" onClick="showPass2()">
                        <label class="form-check-label" for="exampleCheck1">Show Password</label>
                        <button type="button" class="btn btn-primary"id="add-field">Add field</button>
                      </div>
                    </form>
                    <form id="texts" onsubmit="return clickedText()" action="csv_students.php" style="display:none" method="post" enctype="multipart/form-data">
                      <label style="margin-top: 20px">Required sequence of information are the student's LRN, First Name, Last Name, and Password</label><br>
                      <small>Passwords can only be letters (either case), numbers, and the underscore; 6 to 20 characters.</small>
                      <div class="row">
                      <div style="width: 60%; margin-bottom: 10px">
                        <select class="form-control" name="section" required>
                        <option disabled selected value>-- SECTIONS --</option>
                        <?php
                        $query->data_seek(0);
                        while ($row = $query->fetch_assoc()){

                          ?>
                          <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                          <?php
                        }
                        ?>
                       </select>
                      </div>
                      <input type="file" name="csv_file" class="form-control" style="width:40%; margin-bottom:10px" required>
                      </div>
                      <div class="col-md-4 btn-group" role="group" style="float:right">
                        <input type="submit" value="SAVE NOW"class="btn btn-primary">
                        <a href="students.php"class="btn btn-danger">BACK</a>
                      </div>

                    </div>
                    </form>
</div>
<script>
function showText(){
  document.getElementById('formm').style.display = "block";
  document.getElementById('texts').style.display = "none";
}
function showCSV(){
  document.getElementById('formm').style.display = "none";
  document.getElementById('texts').style.display = "block";
}
function showPass2() {

var k = document.getElementsByName('password[]');

var pass = document.getElementById('password2');
if (pass.type === "password") {
  for(i=0;i<k.length;i++){
      if(k[i].type = "password"){
          k[i].type = "text"
      }
  }
}else {
  for(i=0;i<k.length;i++){
      if(k[i].type = "text"){
          k[i].type = "password"
      }
  }
}

}
$('.multi-field-wrapper').each(function() {
    var $wrapper = $('.multi-fields', this);
    $("#add-field", $(this)).click(function(e) {
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.multi-field #remove-field', $wrapper).click(function() {
        if ($('.multi-field', $wrapper).length > 1)
            $(this).parent('.multi-field').remove();
    });
});
function clickedText() {
  swal.fire({
  title: "Are you sure?",
  text: "You are about to create student account(s) using CSV file.",
  icon: "question",
  showCancelButton: true,
  confirmButtonText: "Create"
  }).then(function (result){
  if (result.isConfirmed) {
  document.getElementById("texts").submit();
  swal.fire({position: 'center', title: 'Uploading...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
  } else if (result.dismiss === 'cancel') {
    swal.fire({position: 'center', icon: 'error', title: 'Create Cancelled', showConfirmButton: false, timer: 1500})
  }
  })
  return false;
}
function clicked() {
  var school_id = $('input[name="school_id[]"]').map(function(){
                    return this.value;
                  }).get();

  if(school_id.length > 0) {
  $.ajax({
  url : 'create_student_2.php',
  data : {'school_id[]' : school_id},
  dataType : 'JSON',
  type : 'POST',
  cache : false,

  success : function(result) {
  if(result == 'none')
  {  }
  else {
    Swal.fire({ title: "EXIST", text: "It looks like this ("+result+") student number is already added before. You cannot duplicate student numbers." });
  }
  },

  error : function(err) {
  console.log(err);
  }
  });
  }
var num2 = document.querySelectorAll('input[type="number"]').length;
var elements = document.querySelectorAll("#school_id");
    var values = [];
    for (var i = 0; i < elements.length; i++) {
        values.push(elements[i].value);
    }
    var sortedValues = values.sort();
    for (var o = 0; o < values.length-1; o++) {
        if (values[o] == values[o+1]){
          Swal.fire({ title: 'DUPLICATE', text: 'You have entered duplicate IDs'});
          return false;
        }
    }
swal.fire({
title: "Are you sure?",
text: "You are about to create "+num2+" Student account.",
icon: "question",
showCancelButton: true,
confirmButtonText: "Create"
}).then(function (result){
if (result.isConfirmed) {
document.getElementById("formm").submit();
swal.fire({position: 'center', title: 'Uploading...', showConfirmButton: false, timer: 1111111, timerProgressBar: true, allowOutsideClick: false})
} else if (result.dismiss === 'cancel') {
  swal.fire({position: 'center', icon: 'error', title: 'Create Cancelled', showConfirmButton: false, timer: 1500})
}
})
return false;
}
</script>

<?php
  require_once 'includes_footer.php';


<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">CREATE PARENT ACCOUNT</h2>
  <hr size="4" width="100%" color="grey">
                    <form onsubmit="return clicked()" id="formm" action="create_parents_query.php" method="post">
                        <div class="row">
                            <div class="col-md-8"><h5> </h5></div>
                          <div class="col-md-4 btn-group" role="group">
                            <input type="submit" value="SAVE NOW"class="btn btn-primary">
                            <input type="hidden" name="add_parent" value="sss">
                            <a href="parents.php"class="btn btn-danger">BACK</a>
                          </div>
                        </div>
                      <label>parent's Name and Password</label><br>
                      <small>Passwords can only be letters (either case), numbers, and the underscore; 6 to 20 characters.</small>
                      <div class="multi-field-wrapper">
                        <div class="multi-fields">
                          <div class="multi-field" style="margin-top: 10px">
                            <input type="text" name="first_name[]"style="width: 28%;"placeholder="First...">
                            <input type="text" name="last_name[]" style="width: 28%;"placeholder="Last..." required>
                            <input type="password" id="password" name="password[]" style="width: 28%;"placeholder="Password..."
                            pattern="[A-Za-z0-9_]{6,20}" placeholder="password" name="new_password"
                            title="Only letters (either case), numbers, and the underscore; 6 to 20 characters. " required>
                            <button type="button" style="display:inline; width:40px;"class="btn btn-primary" id="remove-field">X</button>
                          </div>
                        </div>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" onClick="showPass2()">
                        <label class="form-check-label" for="exampleCheck1">Show Password</label>
                        <button type="button" class="btn btn-primary"id="add-field">Add field</button>
                      </div>
                    </form>
</div>
<script>
function showPass2() {

var k = document.getElementsByName('password[]');

var pass = document.getElementById('password');
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

function clicked() {
var num2 = document.querySelectorAll('#password').length;
swal.fire({
title: "Are you sure?",
text: "You are about to create "+num2+" Parent account. Are you sure you want to do this?",
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

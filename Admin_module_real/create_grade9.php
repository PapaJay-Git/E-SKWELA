
<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $queryy ="SELECT * FROM subjects WHERE grade = 9 AND ste = 1;";
  $connect = $conn->query($queryy);
?>
<div class="container">
  <h2 class="head" style="margin-top:40px; margin-bottom:20px">CREATE GRADE 9 SUBJECT</h2>
  <hr size="4" width="100%" color="grey">
                    <form onsubmit="return clicked()" id="formm" action="create_grade9_query.php" method="post">
                      <div class="row">
                        <div style="width: 60%; margin-bottom: 10px">
                          <?php
                          if ($connect->num_rows < 1) {
                            ?>
                            <select class="form-control" name="STE">
                             <option default selected disabled>--GRADE 9 SUBJECT--</option>
                             <option value="ste">Addition STE Subject</option>
                            </select>
                            <?php
                          }
                           ?>
                        </div>
                          <div class="col-md-4 btn-group" role="group">
                            <input type="submit"  value="SAVE NOW"class="btn btn-primary">
                            <input type="hidden" name="add_grade9" value="retgr">
                            <a href="grade9.php"class="btn btn-danger">BACK</a>
                          </div>
                        </div>
                      <div class="multi-field-wrapper">
                        <div class="multi-fields">
                          <div class="multi-field" style="margin-top: 10px">
                            <label>SUBJECT NAME</label><br>
                            <input type="text" id="name" name="subject_name[]"style="width: 60%;" required placeholder="NAME...">
                            <button type="button" style="display:inline; width:40px;"class="btn btn-primary" id="remove-field">X</button>
                          </div>
                        </div>
                        <button type="button" class="btn btn-primary"id="add-field">Add field</button>
                      </div>
                    </form>
</div>
<script>
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
var num2 = document.querySelectorAll('input[type="text"]').length;
var elements = document.querySelectorAll("#name");
    var values = [];
    for (var i = 0; i < elements.length; i++) {
        values.push(elements[i].value);
    }
    var sortedValues = values.sort();
    for (var o = 0; o < values.length-1; o++) {
        if (values[o] == values[o+1]){
          Swal.fire('You have entered duplicate names');
          return false;
        }
    }
swal.fire({
title: "Are you sure?",
text: "You are about to create "+num2+" Subject for grade 9. Are you sure you want to do this?",
icon: "question",
showCancelButton: true,
confirmButtonText: "Create"
}).then(function (result){
if (result.isConfirmed) {
document.getElementById("formm").submit();
} else if (result.dismiss === 'cancel') {
swal.fire({position: 'center', icon: 'error', title: 'Create Cancelled', showConfirmButton: false, timer: 1500})
}
})
return false;
}

</script>

<?php
  require_once 'includes_footer.php';

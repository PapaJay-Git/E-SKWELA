<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_quiz_id_check.php';
  require_once 'includes_quiz_id_val.php';
  //timezone
  date_default_timezone_set('Asia/Manila');
  // Then call the date functions
  //for minimun date deadline
  $date = date('Y-m-d');
  //echo $date;
  $quiziddd = $_GET['quiz_id'];
  $iddd = $_GET['tc_id'];
  $a = 1;
  //Identify if view_id is set
  if (isset($_GET['view_id'])) {
    $viewid = $_GET['view_id'];
  } else {
      $viewid = 1;
  }
$ee = $row['class_id'];
$ee2 = $row['subject_id'];
//searching for class_name of class_id
$sql5 = "SELECT class_name, grade FROM class where class_id = $ee;";
$classN = $conn->query($sql5);
$classN2 = mysqli_fetch_assoc($classN);
$gradeshare = $classN2['grade'];
//searhing for subject_code of subject_id
$sql33 = "SELECT subject_code FROM subjects where subject_id = $ee2;";
$classNN = $conn->query($sql33);
$classNN2 = mysqli_fetch_assoc($classNN);
$sqlquiztype = "SELECT * FROM quiz_type";
$quizTypes = $conn->query($sqlquiztype);
 ?>
 <div class="container-xxl">
   <h2 style="margin-top:40px; margin-bottom:20px" class="head">QUIZ QUESTIONS</h2>
   <hr size="4" width="100%" color="grey">
     <input type="hidden" id="viewid" value="<?php echo $viewid; ?>">
   <input type="button"  style="width: 160px; margin-bottom: 10px" id="detailss"class="btn btn-primary" onclick="showhide()" value="Show Details">
   <section>
       <div class="rt-container-xxl">
             <div class="col-rt-12">
                 <div class="Scriptcontent">

                   <div class="card shadow-sm" id="formm" style="display: none;">
                     <div class="card-header bg-transparent border-0">
                       <h3 class="mb-0"> <?php echo $classNN2['subject_code']." ".$classN2['class_name']?></h3>
                     </div>
                     <div class="card-body pt-0">
                       <?php $four = 4; ?>
                       <form onsubmit="return clicked()" id="update_quiz_form" action="quiz_add_query.php?view_id=<?php echo $four ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>" method="POST">
                       <table class="table table-bordered">
                         <tr>
                           <th width="30%">Quiz Title</th>
                           <td width="2%">:</td>
                           <td>
                             <div class="form-group">
                               <textarea name="quiz_title" maxlength="300" class="form-control" rows="2"required><?php echo $quizrow['quiz_title']?></textarea>
                             </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%">Description</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <textarea class="form-control" name="quiz_description" maxlength="2500" rows="4" required><?php echo $quizrow['quiz_description']?> </textarea>
                           </div></td>
                         </tr>
                         <tr>
                           <th width="30%">Start</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <input class="form-control"type="text" name="start" id="datepicker2" placeholder="Start date" onkeypress="return false;"
                             value="<?php echo $quizrow['start_date']?> " onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" required>
                           </td>
                           </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%">Deadline</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <input class="form-control"type="text" name="date" id="datepicker" placeholder="Deadline" onkeypress="return false;"
                             value="<?php echo $quizrow['deadline_date']?> " onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" required>
                           </td>
                           </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%">Attempts</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <input class="form-control" type="number" name="max_attempt" min="1" max="100" onpaste="return false;"
                             value="<?php echo $quizrow['max_attempt']?>" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="Attempt" required>
                           </td>
                           </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%">Timer in Minutes</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <input class="form-control" type="number" name="minutes" min="1" onpaste="return false;"
                             value="<?php echo $quizrow['timer']?>" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="Attempt" required>
                           </td>
                           </div>
                         </td>
                         </tr>
                       </table>
                       <div class="row">
                         <div class="col-md-8"><h5> </h5></div>
                         <div class="col-md-4 btn-group" role="group">
                            <input type="submit" class="btn btn-primary" value="Update">
                           <a href="teacher_view_quiz.php?tc_id=<?php echo $row['teacher_class_id']; ?>" class="btn btn-danger" >BACK</a>
                         </div>
                         <input type="hidden" name="update_quiz" value="Update">
                       </div>
                       </form>
                     </div>
                   </div>
                   <!-- QUESTIONS -->
                   <div class="card shadow-sm" id="quess" style="display: block;">
                     <div class="card-header bg-transparent border-0">
                       <h3 class="mb-0"> <?php echo $classNN2['subject_code']." ".$classN2['class_name']?></h3>
                     </div>
                     <div class="card-body pt-0">
                       <div class="row">
                         <div class="col-md-8"><h5> </h5></div>
                         <div class="col-md-4 btn-group" role="group">
                           <input type="button"  style="width: 100px;" id="createNow" class="btn btn-primary" onclick="showcreatenow()" value="Create">
                           <input type="button"  style="width: 100px;" id="created" class="btn btn-primary" onclick="showcreated()" value="Created">
                           <input type="button"  style="width: 100px;" id="share" class="btn btn-primary" onclick="showquiz()" value="Share">
                           <a href="teacher_view_quiz.php?tc_id=<?php echo $row['teacher_class_id']; ?>" class="btn btn-danger" >BACK</a>
                         </div>
                       </div>
                       <?php
                       require_once "includes_quiz_create.php";
                       require_once "includes_quiz_created.php";
                       require_once "includes_quiz_share.php";

                       ?>
                     </div>
                  </div>
           </div>
       </div>
       </div>
   </section>
 </div>
<script type="text/javascript">
function clicked() {
 swal.fire({
   title: "Are you sure?",
   text: "You are about to update the details of this quiz. Are you sure you want to do that?",
   icon: "question",
   showCancelButton: true,
   confirmButtonText: "Update"
 }).then(function (result){
   if (result.isConfirmed) {
         document.getElementById("update_quiz_form").submit();
     } else if (result.dismiss === 'cancel') {
         swal.fire({position: 'center', icon: 'error', title: 'Update Cancelled', showConfirmButton: false, timer: 1500})
       }
   })
return false;
}
  window.onload = load();
  //Onload to see if the user have been in the page before, and send him to the last page
  function load() {
    var share = document.getElementById('share_quiz');
    var created = document.getElementById("created_questions");
    var create = document.getElementById('create_question');
    var ques = document.getElementById('quess');
    var form = document.getElementById('formm');
    var dt = document.getElementById('detailss');
    var number = document.getElementById('viewid').value;
    if (number == 1 ) {
      share.style.display = "none";
      created.style.display = "none";
      create.style.display = "block";
      ques.style.display = "block";
      form.style.display = "none";
    }else if (number == 2 ) {
      share.style.display = "none";
      created.style.display = "block";
      create.style.display = "none";
      ques.style.display = "block";
      form.style.display = "none";
    }else if (number == 3 ) {
      share.style.display = "block";
      created.style.display = "none";
      create.style.display = "none";
      ques.style.display = "block";
      form.style.display = "none";
    }else if (number == 4 ) {
      form.style.display = "block";
      create.style.display = "block";
      ques.style.display = "none";
    }else {
      share.style.display = "none";
      created.style.display = "none";
      create.style.display = "block";
      ques.style.display = "block";
      form.style.display = "none";
    }
  }
</script>
<script type="text/javascript" src="quiz_add_question_query.js">
</script>
<?php
require_once '../assets/includes_datetime.php';
require_once 'includes_footer.php';

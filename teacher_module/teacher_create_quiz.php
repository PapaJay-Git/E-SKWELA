
<?php
  require_once 'includes_header.php';
  require_once 'includes_quiz_id_check.php';
  require_once 'includes_side_nav.php';

  //timezone
  date_default_timezone_set('Asia/Manila');
  // Then call the date functions
  //for minimun date deadline
  $date = date('Y-m-d');
  //echo $date;
$ee = $row['class_id'];
$ee2 = $row['subject_id'];
//searching for class_name of class_id
$sql5 = "SELECT class_name FROM class where class_id = $ee;";
$classN = $conn->query($sql5);
$classN2 = mysqli_fetch_assoc($classN);
//searhing for subject_code of subject_id
$sql33 = "SELECT subject_code FROM subjects where subject_id = $ee2;";
$classNN = $conn->query($sql33);
$classNN2 = mysqli_fetch_assoc($classNN);
 ?>
 <div class="container-xxl">
   <h2 style="margin-top:40px; margin-bottom:20px" class="head">CREATE QUIZ</h2>
   <hr size="4" width="100%" color="grey">

   <section>
       <div class="rt-container-xxl">
             <div class="col-rt-12">
                 <div class="Scriptcontent">

                   <div class="card shadow-sm">
                     <div class="card-header bg-transparent border-0">
                       <h3 class="mb-0"><?php echo $classNN2['subject_code']." ".$classN2['class_name']?> </h3>
                     </div>
                     <div class="card-body pt-0">
                      <form onsubmit="return clicked()" id="create_quiz_form"action="create_quiz.php?tc_id=<?php echo $row['teacher_class_id']; ?>" method="POST">
                       <table class="table table-bordered">
                         <tr>
                           <th width="30%">Quiz Title</th>
                           <td width="2%">:</td>
                           <td>
                             <div class="form-group">
                               <textarea name="quiz_title" maxlength="300" class="form-control" rows="2"required></textarea>
                             </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%">Description</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <textarea class="form-control" name="quiz_description" maxlength="2500" rows="4" required></textarea>
                           </div></td>
                         </tr>
                         <tr>
                           <th width="30%">Start</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <input class="form-control"type="text" name="start" id="datepicker2" placeholder="Start Date" onkeypress="return false;" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" required>
                           </td>
                           </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%">Deadline</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <input class="form-control"type="text" name="date" id="datepicker" placeholder="Deadline" onkeypress="return false;" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" required>
                           </td>
                           </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%">Attempts</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <input class="form-control" type="number" name="max_attempt" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="Attempt" required>
                           </td>
                           </div>
                         </td>
                         </tr>
                         <tr>
                           <th width="30%">Timer in Minutes</th>
                           <td width="2%">:</td>
                           <td><div class="form-group">
                             <input class="form-control" type="number" name="minutes" min="1"onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="In Minutes Only" required>
                           </td>
                           </div>
                         </td>
                         </tr>
                       </table>
                       <div class="row">
                         <div class="col-md-8"><h5> </h5></div>
                         <div class="col-md-4 btn-group" role="group">
                           <input type="submit" class="btn btn-primary" value="CREATE">
                           <a href="teacher_view_quiz.php?tc_id=<?php echo $row['teacher_class_id']; ?>" class="btn btn-danger" >BACK</a>
                         </div>
                         <input type="hidden" name="create_quiz" value="CREATE">
                       </div>
                       </form>
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
    text: "You are about to create a quiz. Are you sure you want to do that?",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Create"
  }).then(function (result){
    if (result.isConfirmed) {
          document.getElementById("create_quiz_form").submit();
      } else if (result.dismiss === 'cancel') {
          swal.fire({position: 'center', icon: 'error', title: 'Create Cancelled', showConfirmButton: false, timer: 1500})
        }
    })
 return false;
 }
 </script>
<?php
  require_once '../assets/includes_datetime.php';
  require_once 'includes_footer.php';


<?php
  require_once 'includes_header.php';
  require_once 'includes_side_nav.php';
  require_once 'includes_profile_id_check.php';
  $sql_notif = "SELECT * FROM teacher_notification WHERE teacher_id =? ORDER BY date_given DESC";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql_notif);
  mysqli_stmt_bind_param($stmt, "i", $_SESSION['teacher_session_id']);
  mysqli_stmt_execute($stmt);
  $notif_result = mysqli_stmt_get_result($stmt);
?>
  <div class="container-xxl">
  <h2 style="margin-top:40px; margin-bottom:20px" class="head">Notification</h2>
  <hr size="4" width="100%" color="grey">
<form class="notification_form" action="notification_query.php" method="post">
  <div class="btn-group mb-3" role="group">
  <button type="button" class="btn btn-primary" id="btn-read" style="width: 60%;">Mark as Read</button>
  <button type="button" class="btn btn-danger" id="btn-delete">Delete</button>
  </div>
    <button type="submit" name="read" id="readb" style="display:none"></button>
      <button type="submit" name="delete" id="deleteb" style="display:none"></button>

  <table class="table">
    <thead class="table-active">
      <tr class="d-flex">
        <th class="col-1 priority-1"><input type="checkbox" onclick="toggle(this);" name="markAll"/>
        <th class="col-3 priority-2">From</th>
        <th class="col priority-3" id="subject">Message</th>
        <th class="col-2 priority-4">Sent</th>
          <th class="col-1 priority-5">Status</th>
      </tr>
    </thead>

    <tbody>
      <?php
      while ($row_notif = mysqli_fetch_assoc($notif_result)) {
        $type = $row_notif['type'];
        $status = $row_notif['status'];
        $timestamp = strtotime($row_notif['date_given']);
        $date_given = date("F j, g:i a", $timestamp);
        if ($type == "exam" || $type == "quiz" || $type == "assignment") {
          $exam_id = $row_notif['exam_id'];
          $quiz_id = $row_notif['quiz_id'];
          $assignment_id = $row_notif['assignment_id'];
          $tc_id = $row_notif['teacher_class_id'];
          $sql_notif = "SELECT * FROM teacher_class WHERE teacher_class_id =?";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $sql_notif);
          mysqli_stmt_bind_param($stmt, "i", $tc_id);
          mysqli_stmt_execute($stmt);
          $my_result = mysqli_stmt_get_result($stmt);
          $subject_row = mysqli_fetch_assoc($my_result);
          $sql_notif = "SELECT * FROM subjects WHERE subject_id =?";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $sql_notif);
          mysqli_stmt_bind_param($stmt, "i", $subject_row['subject_id']);
          mysqli_stmt_execute($stmt);
          $my_result = mysqli_stmt_get_result($stmt);
          $subject_name2 = mysqli_fetch_assoc($my_result);
          $subject_name = $subject_name2['subject_title'];
          $student_notif = "SELECT * FROM class WHERE class_id =?";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $student_notif);
          mysqli_stmt_bind_param($stmt, "i", $subject_row['class_id']);
          mysqli_stmt_execute($stmt);
          $my_result = mysqli_stmt_get_result($stmt);
          $class_name2 = mysqli_fetch_assoc($my_result);
          $class_name = $class_name2['class_name'];
        }
        if ($type == "assigned") {
          $admin_id = $row_notif['admin_id'];
          $new_class_id = $row_notif['class_id'];
          $sub_id = $row_notif['subject_id'];
          $tc_id = $row_notif['teacher_class_id'];
          $admin_notif = "SELECT * FROM class WHERE class_id =?";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $admin_notif);
          mysqli_stmt_bind_param($stmt, "i", $new_class_id);
          mysqli_stmt_execute($stmt);
          $my_result = mysqli_stmt_get_result($stmt);
          $class_name2 = mysqli_fetch_assoc($my_result);
          $class_name = $class_name2['class_name'];
          $sql_notif = "SELECT * FROM admin WHERE admin_id =?";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $sql_notif);
          mysqli_stmt_bind_param($stmt, "i", $admin_id);
          mysqli_stmt_execute($stmt);
          $name_result = mysqli_stmt_get_result($stmt);
          $admin_name2 = mysqli_fetch_assoc($name_result);
          $admin_name = $admin_name2['f_name']." ".$admin_name2['l_name'];
          $assigned_notif = "SELECT * FROM subjects WHERE subject_id =?";
          $stmt = mysqli_stmt_init($conn);
          mysqli_stmt_prepare($stmt, $assigned_notif);
          mysqli_stmt_bind_param($stmt, "i", $sub_id);
          mysqli_stmt_execute($stmt);
          $name_sub = mysqli_stmt_get_result($stmt);
          $name_sub2 = mysqli_fetch_assoc($name_sub);
          $sub_name = $name_sub2['subject_title'];

        }
        if ($type == "exam") {
          if ($status == "unread") {
            ?><tr class="d-flex table-info"><?php
          }else {
            ?><tr class="d-flex"><?php
          }
          ?>
            <td class="col-1 priority-1"><input type="checkbox" name="notif_id[]" id="ckx"  value="<?php echo $row_notif['id']; ?>" />
            <td class="col-3 priority-2">
              <a style="text-decoration:none; cursor: pointer; color: #00008B;" title="Section and Subject"
              href="teacher_view_students.php?tc_id=<?php echo $tc_id; ?>"><?php echo $class_name; ?></a>
            </td>
            <td class="col priority-3" id="subject">
              <a style="text-decoration:none; cursor: pointer; color: #00008B;" title="Exam" onclick="return read(<?php echo $row_notif['id']; ?>);"
              href="exam_submissions.php?tc_id=<?php echo $tc_id."&exam_id=".$exam_id; ?>">New Exam submissions: <b><?php echo $subject_name; ?></b></a>
            </td>
            <td class="col-2 priority-4"><?php echo $date_given; ?></td>
            <td class="col-1 priority-5"><?php echo $status; ?></td>
          </tr>
          <?php
        }
        if ($type == "quiz") {
          if ($status == "unread") {
            ?><tr class="d-flex table-info"><?php
          }else {
            ?><tr class="d-flex"><?php
          }
          ?>
            <td class="col-1 priority-1"><input type="checkbox" name="notif_id[]" id="ckx"  value="<?php echo $row_notif['id']; ?>" />
            <td class="col-3 priority-2">
              <a style="text-decoration:none; cursor: pointer; color: #00008B;" title="Section and Subject"
              href="teacher_view_students.php?tc_id=<?php echo $tc_id; ?>"><?php echo $class_name; ?></a>
            </td>
            <td class="col priority-3" id="subject">
              <a style="text-decoration:none; cursor: pointer; color: #00008B;" title="Exam" onclick="return read(<?php echo $row_notif['id']; ?>);"
              href="quiz_submissions.php?tc_id=<?php echo $tc_id."&quiz_id=".$quiz_id; ?>">New Quiz submissions: <b><?php echo $subject_name; ?></b></a>
            </td>
            <td class="col-2 priority-4"><?php echo $date_given; ?></td>
            <td class="col-1 priority-5"><?php echo $status; ?></td>
          </tr>
          <?php
        }
        if ($type == "assignment") {
          if ($status == "unread") {
            ?><tr class="d-flex table-info"><?php
          }else {
            ?><tr class="d-flex"><?php
          }
          ?>
            <td class="col-1 priority-1"><input type="checkbox" name="notif_id[]" id="ckx"  value="<?php echo $row_notif['id']; ?>" />
            <td class="col-3 priority-2">
              <a style="text-decoration:none; cursor: pointer; color: #00008B;" title="Section and Subject"
              href="teacher_view_students.php?tc_id=<?php echo $tc_id; ?>"><?php echo $class_name; ?></a>
            </td>
            <td class="col priority-3" id="subject">
              <a style="text-decoration:none; cursor: pointer; color: #00008B;" title="Exam" onclick="return read(<?php echo $row_notif['id']; ?>);"
              href="assignment_submissions.php?tc_id=<?php echo $tc_id."&ass_id=".$assignment_id; ?>">New Assignment submissions: <b><?php echo $subject_name; ?></b></a>
            </td>
            <td class="col-2 priority-4"><?php echo $date_given; ?></td>
            <td class="col-1 priority-5"><?php echo $status; ?></td>
          </tr>
          <?php
        }
        if ($type == "assigned") {
          if ($status == "unread") {
            ?><tr class="d-flex table-info"><?php
          }else {
            ?><tr class="d-flex"><?php
          }
          ?>
            <td class="col-1 priority-1"><input type="checkbox" name="notif_id[]" id="ckx"  value="<?php echo $row_notif['id']; ?>" />
            <td class="col-3 priority-2">
              <a style="text-decoration:none; cursor: pointer; color: #00008B;" title="Admin Name"
              href="others_admin.php?id=<?php echo $admin_id; ?>"><?php echo $admin_name; ?></a>
            </td>
            <td class="col priority-3" id="subject">
              <a style="text-decoration:none; cursor: pointer; color: #00008B;" title="Admin Name" onclick="return read(<?php echo $row_notif['id']; ?>);"
              href="teacher_view_students.php?tc_id=<?php echo $tc_id; ?>">New Assigned Section's Subject <b><?php echo $class_name." - ".$sub_name; ?></b></a>

            </td>
            <td class="col-2 priority-4"><?php echo $date_given; ?></td>
            <td class="col-1 priority-5"><?php echo $status; ?></td>
          </tr>
          <?php
        }
    }
       ?>
    </tbody>
  </table>
</form>
</div>

<style type="text/css">

    @media screen and (max-width: 770px) and (min-width: 300px) {
    .priority-5{
      display:none;
    }
    .priority-4{
      display:none;
    }
    .priority-3 th{
      width: 100%;
    }
  }

  @media screen and (max-width: 300px) {
    .priority-5{
      display:none;
    }
    .priority-4{
      display:none;
    }
    .priority-3 tr{
      width: 100%;
    }

  }
</style>
</div>

<script type="text/javascript">
function read(e) {
  $.ajax({
  url : 'notification_query.php',
  data : {'notif_id' : e},
  dataType : 'JSON',
  type : 'POST',
  cache : false,

  success : function(result) {
    return true;
  },

  error : function(err) {
    return false;
  console.log(err);
  }
  });

}
var readb = document.getElementById("readb");
var deleteb = document.getElementById("deleteb");
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
//for notification before deleting the admins
    $(document).ready(function() {
    $('.notification_form #btn-delete').click(function(e) {
      var ischecked = $('#ckx:checked').length;
      if (ischecked < 1){
         Swal.fire({title: 'None Selected', text: 'Please select atleast one Notification.'});
        return
      }
      //For number of admins being deleted
        var num2 = document.querySelectorAll('input[type="checkbox"]:checked').length;
        let form = $(this).closest('form');
        var num = num2 - minus;
        swal.fire({
            title: "Delete ("+num+") Notification?",
          text: "Are you sure you want to delete these number ("+num+") of notifications? Please consider before confirming.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Delete"
        }).then(function (result){
          if (result.isConfirmed) {
            swal.fire({position: 'center', icon: 'success', title: 'Submitting for validation...', showConfirmButton: false, timer: 2500, timerProgressBar: true})
            setTimeout( function () {
              deleteb.click();
            }, 2500);
            } else if (result.dismiss === 'cancel') {
                swal.fire({position: 'center', icon: 'error', title: 'Delete Cancelled', showConfirmButton: false, timer: 1500})
              }
          })

    });
  });
  //for notification before deleting the admins
      $(document).ready(function() {
      $('.notification_form #btn-read').click(function(e) {
        var ischecked = $('#ckx:checked').length;
        if (ischecked < 1){
           Swal.fire({title: 'None Selected', text: 'Please select atleast one Notification.'});
          return
        }
        //For number of admins being deleted
          var num2 = document.querySelectorAll('input[type="checkbox"]:checked').length;
          let form = $(this).closest('form');
          var num = num2 - minus;
          swal.fire({
              title: "  Mark as read ("+num+") Notification?",
            text: "Are you sure you want to mark as Read these number ("+num+") of notifications?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirm"
          }).then(function (result){
            if (result.isConfirmed) {
              swal.fire({position: 'center', icon: 'success', title: 'Submitting for validation...', showConfirmButton: false, timer: 2500, timerProgressBar: true})
              setTimeout( function () {
                readb.click();
              }, 2500);
              } else if (result.dismiss === 'cancel') {
                  swal.fire({position: 'center', icon: 'error', title: 'Confirm Cancelled', showConfirmButton: false, timer: 1500})
                }
            })

      });
    });
</script>
<?php
  require_once 'includes_footer.php';

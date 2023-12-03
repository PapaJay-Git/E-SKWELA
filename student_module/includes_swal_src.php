<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
 ?>

<script type="text/javascript">
//Logout confirmation
  function logout(){
    swal.fire({
      title: "Logout?",
      text: "You are about to logout!",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Logout"
    }).then(function (result){
      if (result.isConfirmed) {
            swal.fire({position: 'center', icon: 'success', title: 'Logout Success', showConfirmButton: false, timer: 2000})
            setTimeout(function(){ window.location = "logout.php";}, 1500);
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Logout Cancelled', showConfirmButton: false, timer: 2000})
          }
      })
    }
    function ConfirmDelete(e)
    {
      swal.fire({
        title: "Are you sure?",
        text: "You're about to delete this item.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Delete"
      }).then(function (result){
        if (result.isConfirmed) {
              setTimeout(function(){ window.location = e;});
          } else if (result.dismiss === 'cancel') {
              swal.fire({position: 'center', icon: 'error', title: 'Delete Cancelled', showConfirmButton: false, timer: 2000})
            }
        })
    }
    function takeExam(e)
    {
      swal.fire({
        title: "Are you sure?",
        text: "Are you sure to take this exam? Before timer goes off, you need to click (submit all) button below to submit"+
        " all of your answers. Without clicking submit, all of your answers will not be submitted, but your attempts will. Previous"+
        " scores will also be overwritten with this submission. If you refreshed the page while taking exam, your valid attempts will be deducted. GOOD LUCK!",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes I am"
      }).then(function (result){
        if (result.isConfirmed) {
              setTimeout(function(){ window.location = e;});
          } else if (result.dismiss === 'cancel') {
              swal.fire({position: 'center', icon: 'error', title: 'Taking exam Cancelled', showConfirmButton: false, timer: 2000})
            }
        })
    }
    function takequiz(e)
    {
      swal.fire({
        title: "Are you sure?",
        text: "Are you sure to take this quiz? Before timer goes off, you need to click (submit all) button below to submit all of your answers. "+
        "Without clicking submit, all of your answers will not be submitted, but your attempts will. Previous scores will also be overwritten with this"+
        " submission. If you refreshed the page while taking quiz, your valid attempts will be deducted. GOOD LUCK!",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes I am"
      }).then(function (result){
        if (result.isConfirmed) {
              setTimeout(function(){ window.location = e;});
          } else if (result.dismiss === 'cancel') {
              swal.fire({position: 'center', icon: 'error', title: 'Taking quiz Cancelled', showConfirmButton: false, timer: 2000})
            }
        })
    }

</script>

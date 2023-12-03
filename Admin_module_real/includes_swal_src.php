<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
 ?>

<script>
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
            swal.fire({position: 'center', icon: 'success', title: 'Logout Success', showConfirmButton: false, timer: 1500})
            setTimeout(function(){ window.location = "logout.php";}, 1500);
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Logout Cancelled', showConfirmButton: false, timer: 1500})
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
              swal.fire({position: 'center', icon: 'error', title: 'Delete Cancelled', showConfirmButton: false, timer: 1500})
            }
        })
    }

</script>

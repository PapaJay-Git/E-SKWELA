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
            swal.fire({position: 'center', icon: 'success', title: 'Logout Success', showConfirmButton: false, timer: 1500})
            setTimeout(function(){ window.location = "logout.php";}, 1500);
        } else if (result.dismiss === 'cancel') {
            swal.fire({position: 'center', icon: 'error', title: 'Logout Cancelled', showConfirmButton: false, timer: 1500})
          }
      })
    }
</script>

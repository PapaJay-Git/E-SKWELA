<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};

     //caution pop ups
  if( isset( $_SESSION['caution'] ) ) {
    ?>
     <script>
         swal.fire({position: 'center', icon: 'warning', title: 'WARNING', text:'<?php echo $_SESSION['caution']; ?>', showConfirmButton: true});
     </script>
     <?php
  } unset($_SESSION['caution']);
  //Error pop ups
 if( isset( $_SESSION['error'] ) ) {
   ?>
    <script>
        swal.fire({position: 'center', icon: 'warning', title: 'WARNING', text:'<?php echo $_SESSION['error']; ?>', showConfirmButton: true});
    </script>
    <?php
 } unset($_SESSION['error']);
 //success pop ups
     if( isset( $_SESSION['success'] ) ) {
       ?>
        <script>
            swal.fire({position: 'center', icon: 'success', title: 'SUCCESS', text:'<?php echo $_SESSION['success']; ?>', showConfirmButton: true});
        </script>
        <?php
     } unset($_SESSION['success']);

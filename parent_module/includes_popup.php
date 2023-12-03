<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
    //Error pop ups
   if( isset( $_SESSION['error'] ) ) {
     ?>
      <script>
          swal.fire({position: 'center', icon: 'warning', title:'WARNING', text: '<?php echo $_SESSION['error']; ?>', showConfirmButton: true, timer: 10000});
      </script>
      <?php
   } unset($_SESSION['error']);
?>
<?php
    //success pop ups
   if( isset( $_SESSION['success'] ) ) {
     ?>
      <script>
          swal.fire({position: 'center', icon: 'success', title: 'SUCCESS', text: '<?php echo $_SESSION['success']; ?>', showConfirmButton: true, timer: 10000});
      </script>
      <?php
   } unset($_SESSION['success']);
?>

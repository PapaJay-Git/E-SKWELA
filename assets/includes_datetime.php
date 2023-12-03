
<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
//timezone
date_default_timezone_set('Asia/Manila');
// Then call the date functions
//for minimun date deadline
$date = date('Y-m-d');
//echo $date;
 ?>
<script src="../assets/time/jquery.js"></script>
<script src="../assets/time/jquery.datetimepicker.full.js"></script>
<script>
$(document).ready(function () {
 $("#datepicker").datetimepicker(
   {
     minDate: '<?php echo $date ?>',
     dateFormat: 'Y-m-d',
     formatTime:'g:i a'
   }
 );
});

$(document).ready(function () {
 $("#datepicker2").datetimepicker(
   {
     minDate: '<?php echo $date ?>',
     dateFormat: 'Y-m-d',
     formatTime:'g:i a'
   }
 );
});

$(document).ready(function () {
 $("#birthday").datetimepicker(
   {
      format: 'F j, Y'
   }
 );
});


</script>

<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};

 ?>
<style>
.footer {
  clear: both;
    position: relative;
    z-index: 10;
   margin-top: 30em;
   left: 0;
   bottom: 0;
   width: 100%;
  background-color: #301934;
   color: #f2f2f2;
   text-align: center;
   font-size: 15px;
}
</style>
</body>

<div class="footer">
<footer width="100%" class="mt-auto">
  <div class="col-md-12 text-center">
       <img src="logo1.png" width="100px" height="100px">
       <h2 class="footer-heading">Sto. Cristo Integrated School</h2>
  </div>
  <!-- Copyright -->
  <div class="text-center p-5">
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Sto. Crsito Integrated School
  </div>
  <!-- Copyright -->
</footer>
</div>
</html>
<script type="text/javascript">
function goBack() {
window.history.back();
}
if (window.document.documentMode) {
  Swal.fire({
  width: '800px',
  title: 'We do not support Internet Explorer <br><h5>Please use one of these browsers</h5>',
  showConfirmButton: false,
  allowOutsideClick: false,
  html:
  '<a href="https://www.google.com/chrome/?form=MY01SV&OCID=MY01SV" target="_blank"><img src="../assets/pics/chrome.png" width="100px" height="100px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
  '<a href="https://www.microsoft.com/en-us/edge" target="_blank"><img src="../assets/pics/edge.png" width="100px" height="100px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
  '<a href="https://www.mozilla.org/en-US/firefox/new/" target="_blank"><img src="../assets/pics/firefox.png" width="100px" height="100px"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
  '<a href="https://support.apple.com/downloads/safari" target="_blank"><img src="../assets/pics/safari.png" width="100px" height="100px"></a>'
})
}
</script>

<?php

ob_end_flush();

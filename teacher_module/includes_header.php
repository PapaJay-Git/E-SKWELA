<?php
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
die('Direct access not allowed');
exit();
};
  require_once 'checker.php';
  require_once 'includes_swal_src.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>E-SKWELA - TEACHER</title>
<link rel="icon" sizes="180x180" href="apple-icon-180x180.png">
<!-- For bootstarp designs-->
<link rel="stylesheet" href="../assets/css/profile.css">
<link type="text/css" rel="stylesheet" href="../assets/bootstrap-5.1.0-dist/css/bootstrap.min.css">
<script language="javascript" src="../assets/bootstrap-5.1.0-dist/js/bootstrap.bundle.min.js"></script>
<!-- For data tables-->
<link rel="stylesheet" href="../assets/tables/responsive.dataTables.min.css">
<script type="text/javascript" src="../assets/tables/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../assets/tables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/tables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../assets/tables/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="../assets/tables/jszip.min.js"></script>
<script type="text/javascript" src="../assets/tables/vfs_fonts.js"></script>
<script type="text/javascript" src="../assets/tables/buttons.html5.min.js"></script>
<script type="text/javascript" src="../assets/tables/buttons.print.min.js"></script>
<link type="text/css" rel="stylesheet" href="../assets/tables/jquery.dataTables.min.css">
<link type="text/css" rel="stylesheet" href="../assets/tables/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--Sweetalert for notification-->
<script type="text/javascript" language="javascript" src="../assets/sweetalert/sweetalert2.all.min.js"></script>
<script src="../assets/promise/promise.min.js"></script>
<!--Date time picker for all browser-->
<link rel="stylesheet" type="text/css" href="../assets/time/jquery.datetimepicker.min.css">
<link rel="stylesheet" type="text/css" href="../assets/css/nav.css">
</head>
<body class="d-flex flex-column min-vh-100">

<?php
require_once "checker.php";
session_destroy();
header('Location: ../login/index.php');
exit();

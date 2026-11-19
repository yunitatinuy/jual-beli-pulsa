<?php
require_once 'sesi.php';

hapus_cookie_ingat();
$_SESSION = [];
session_destroy();
header("location:login.php");
exit;
?>
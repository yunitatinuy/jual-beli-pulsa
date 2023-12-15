<?php
include 'koneksi.php';
$id = $_GET['id'];
$result = mysqli_query($koneksi, "DELETE FROM user WHERE id='$id'");
header("location: user.php");
?>
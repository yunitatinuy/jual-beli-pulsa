<?php
include 'koneksi.php';
$id = $_POST['id'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$role= $_POST['role'];
$result = mysqli_query($koneksi, "UPDATE user SET nama='$nama', email='$email', role='$role' WHERE id='$id'");
header("location: user.php");
?>

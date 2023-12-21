<?php
include 'koneksi.php';
$id_user= $_POST['id_user'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$role= $_POST['role'];
$result = mysqli_query($koneksi, "UPDATE user SET nama='$nama', email='$email', role='$role' WHERE id_user='$id_user'");
header("location: user.php");
?>

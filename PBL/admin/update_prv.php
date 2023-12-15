<?php
include 'koneksi.php';
$id_provider = $_POST['id_provider'];
$nama_provider = $_POST['nama_provider'];
$detail = $_POST['detail'];
$nominal = $_POST['nominal'];
$harga = $_POST['harga'];
$result = mysqli_query($koneksi, "UPDATE proveder SET nama_provider='$nama_provider', detail='$detail', nominal='$nominal', harga='$harga' WHERE id_provider='$id_provider'");
header("location: provider.php");
?>
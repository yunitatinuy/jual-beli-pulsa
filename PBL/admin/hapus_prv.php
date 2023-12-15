<?php
include 'koneksi.php';
$id_provider = $_GET['id_provider'];
$result = mysqli_query($koneksi, "DELETE FROM proveder WHERE id_provider='$id_provider'");
header("location: provider.php");
?>
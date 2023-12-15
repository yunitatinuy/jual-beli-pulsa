<?php
include 'koneksi.php';
$id_kategori = $_POST['id_kategori'];
$nama_kategori = $_POST['nama_kategori'];
$input = mysqli_query($koneksi, "INSERT INTO kategori VALUES ('$id_kategori','$nama_kategori')") or die(mysql_error());
if ($input){
    echo "Data Berhasil Disimpan";
            header("location: index.php");
}
else{
    echo "Data Gagal Disimpan";
}
?>
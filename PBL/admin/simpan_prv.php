<?php
include 'koneksi.php';
$id_kategori = $_POST['id_kategori'];
$nama_provider = $_POST['nama_provider'];
$detail = $_POST['detail'];
$nominal = $_POST['nominal'];
$harga = $_POST['harga'];
$input = mysqli_query($koneksi, "INSERT INTO proveder VALUES ('','$id_kategori','$nama_provider','$detail','$nominal','$harga')") or die(mysql_error());
if ($input){
    echo "Data Berhasil Disimpan";
            header("location: provider.php");
}
else{
    echo "Data Gagal Disimpan";
}
?>
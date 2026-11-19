<?php
require_once __DIR__ . '/cek_admin.php';
require_once __DIR__ . '/upload_foto.php';

$id_provider = (int) ($_POST['id_provider'] ?? 0);
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);
$nama_provider = trim($_POST['nama_provider'] ?? '');
$detail = trim($_POST['detail'] ?? '');
$nominal = (int) ($_POST['nominal'] ?? 0);
$harga = (int) ($_POST['harga'] ?? 0);

if ($id_kategori <= 0 || $nama_provider === '' || $nominal <= 0 || $harga <= 0) {
    echo "<script>alert('Data provider belum lengkap / nominal dan harga harus berupa angka'); window.location = 'provider.php';</script>";
    exit;
}

if ($harga < $nominal) {
    echo "<script>alert('Harga jual tidak boleh lebih kecil dari nominal pulsa'); window.location = 'provider.php';</script>";
    exit;
}

$foto = upload_foto_produk('foto');
if ($foto === false) {
    echo "<script>alert('Foto tidak valid (jpg/png/gif/webp, maks 2MB)'); window.location = 'provider.php';</script>";
    exit;
}

if ($foto === null) {
    // foto tidak diganti, foto lama tetap dipakai
    $stmt = mysqli_prepare($koneksi, "UPDATE proveder SET id_kategori = ?, nama_provider = ?, detail = ?, nominal = ?, harga = ? WHERE id_provider = ?");
    mysqli_stmt_bind_param($stmt, 'issiii', $id_kategori, $nama_provider, $detail, $nominal, $harga, $id_provider);
} else {
    $stmt = mysqli_prepare($koneksi, "UPDATE proveder SET id_kategori = ?, nama_provider = ?, detail = ?, nominal = ?, harga = ?, foto = ? WHERE id_provider = ?");
    mysqli_stmt_bind_param($stmt, 'issiisi', $id_kategori, $nama_provider, $detail, $nominal, $harga, $foto, $id_provider);
}
mysqli_stmt_execute($stmt);
header("location: provider.php");
exit;

<?php
require_once __DIR__ . '/cek_admin.php';
require_once __DIR__ . '/upload_foto.php';

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
if ($foto === false || $foto === null) {
    echo "<script>alert('Foto wajib diisi (jpg/png/gif/webp, maks 2MB)'); window.location = 'provider.php';</script>";
    exit;
}

$stmt = mysqli_prepare($koneksi, "INSERT INTO proveder (id_kategori, nama_provider, detail, nominal, harga, foto) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'issiis', $id_kategori, $nama_provider, $detail, $nominal, $harga, $foto);
if (mysqli_stmt_execute($stmt)) {
    header("location: provider.php");
} else {
    echo "<script>alert('Data Gagal Disimpan'); window.location = 'provider.php';</script>";
}
exit;

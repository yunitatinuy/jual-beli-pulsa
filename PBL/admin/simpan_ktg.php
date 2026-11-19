<?php
require_once __DIR__ . '/cek_admin.php';
$nama_kategori = trim($_POST['nama_kategori'] ?? '');
if ($nama_kategori === '') {
    echo "<script>alert('Nama kategori wajib diisi'); window.location = 'index.php';</script>";
    exit;
}
$stmt = mysqli_prepare($koneksi, "INSERT INTO kategori (nama_kategori) VALUES (?)");
mysqli_stmt_bind_param($stmt, 's', $nama_kategori);
if (mysqli_stmt_execute($stmt)) {
    header("location: index.php");
} else {
    echo "<script>alert('Data Gagal Disimpan'); window.location = 'index.php';</script>";
}
exit;

<?php
require_once __DIR__ . '/cek_admin.php';
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);
$nama_kategori = trim($_POST['nama_kategori'] ?? '');
if ($nama_kategori !== '') {
    $stmt = mysqli_prepare($koneksi, "UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?");
    mysqli_stmt_bind_param($stmt, 'si', $nama_kategori, $id_kategori);
    mysqli_stmt_execute($stmt);
}
header("location: index.php");
exit;

<?php
require_once __DIR__ . '/cek_admin.php';
$id_kategori = (int) ($_GET['id_kategori'] ?? 0);

// cegah provider kehilangan kategori (data yatim)
$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) FROM proveder WHERE id_kategori = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_kategori);
mysqli_stmt_execute($stmt);
$jumlah = (int) mysqli_fetch_row(mysqli_stmt_get_result($stmt))[0];

if ($jumlah > 0) {
    echo "<script>alert('Kategori masih dipakai oleh $jumlah provider. Hapus atau pindahkan provider tersebut terlebih dahulu.');
    window.location = 'index.php';</script>";
    exit;
}

$stmt = mysqli_prepare($koneksi, "DELETE FROM kategori WHERE id_kategori = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_kategori);
mysqli_stmt_execute($stmt);
header("location: index.php");
exit;

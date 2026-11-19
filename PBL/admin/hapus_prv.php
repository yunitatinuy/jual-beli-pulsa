<?php
require_once __DIR__ . '/cek_admin.php';
$id_provider = (int) ($_GET['id_provider'] ?? 0);

// provider yang sudah pernah dibeli tidak boleh dihapus, agar invoice & riwayat pembeli tetap utuh
$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) FROM transaksi WHERE id_provider = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_provider);
mysqli_stmt_execute($stmt);
$jumlah = (int) mysqli_fetch_row(mysqli_stmt_get_result($stmt))[0];
if ($jumlah > 0) {
    echo "<script>alert('Provider ini sudah dipakai di $jumlah transaksi sehingga tidak dapat dihapus (agar invoice pembeli tetap utuh). Ubah datanya saja jika perlu.');
    window.location = 'provider.php';</script>";
    exit;
}

$stmt = mysqli_prepare($koneksi, "DELETE FROM proveder WHERE id_provider = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_provider);
mysqli_stmt_execute($stmt);
header("location: provider.php");
exit;

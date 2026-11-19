<?php
require_once __DIR__ . '/cek_admin.php';
$id_user = (int) ($_GET['id_user'] ?? 0);

// admin tidak boleh menghapus akun yang sedang dipakai login
if ($id_user === (int) $_SESSION['user']['id_user']) {
    echo "<script>alert('Tidak dapat menghapus akun yang sedang digunakan');
    window.location = 'user.php';</script>";
    exit;
}

// pengguna yang punya riwayat transaksi tidak boleh dihapus, agar data transaksi tetap utuh
$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) FROM transaksi_penjualan WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_user);
mysqli_stmt_execute($stmt);
$jumlah = (int) mysqli_fetch_row(mysqli_stmt_get_result($stmt))[0];
if ($jumlah > 0) {
    echo "<script>alert('Pengguna ini memiliki $jumlah transaksi sehingga tidak dapat dihapus (agar laporan transaksi tetap utuh).');
    window.location = 'user.php';</script>";
    exit;
}

$stmt = mysqli_prepare($koneksi, "DELETE FROM user WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_user);
mysqli_stmt_execute($stmt);
header("location: user.php");
exit;

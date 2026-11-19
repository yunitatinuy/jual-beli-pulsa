<?php
require_once __DIR__ . '/../sesi.php';
wajib_login();

//mendapatkan id_produk dari url
$id_provider = (int) ($_GET['id'] ?? 0);

//pastikan produk benar-benar ada
$stmt = mysqli_prepare($koneksi, "SELECT id_provider FROM proveder WHERE id_provider = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_provider);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) === 0) {
	echo "<script>alert('Produk tidak ditemukan');</script>";
	echo "<script>location='dashboard.php';</script>";
	exit;
}

//jika sudah ada produk itu di keranjang, jumlahnya tidak ditambah (maksimal satu)
if (isset($_SESSION['keranjang'][$id_provider])) {
	echo "<script>alert('Produk tidak boleh lebih dari satu');</script>";
	echo "<script>location='keranjang.php';</script>";
}

//selain itu (belum ada di keranjang), maka produk itu dianggap dibeli 1
else {
	$_SESSION['keranjang'][$id_provider] = 1;
	echo "<script>alert('Produk telah masuk di keranjang')</script>";
	echo "<script>location='keranjang.php';</script>";
}

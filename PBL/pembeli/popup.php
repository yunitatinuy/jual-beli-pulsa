<?php
session_start();
//mendapatkan id_produk dari url
$id_provider = $_GET['id'];

//jika sudah ada produk itu di keranjang, maka produk itu jumlahnya +1
if (isset($_SESSION['keranjang'][$id_provider])) {
	$_SESSION['keranjang'][$id_provider] = 1;
	echo "<script>alert('Produk telah masuk di keranjang')</script>";
}


//selain itu (belum ada di keranjang), maka produk itu dianggap dibeli 1
else {
	$_SESSION['keranjang'][$id_provider] > 1;
	echo "<script>alert('Produk tidak boleh lebih dari satu')</script>";
}

//larikan ke halaman keranjang
echo "<script>location='keranjang.php';</script>";
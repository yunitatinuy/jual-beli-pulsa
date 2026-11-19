<?php
require_once __DIR__ . '/../sesi.php';
wajib_login();

$id_provider = (int) ($_GET["id"] ?? 0);
unset($_SESSION["keranjang"][$id_provider]);

echo "<script>alert('Produk dihapus dari keranjang')</script>";
echo "<script>location='keranjang.php';</script>";

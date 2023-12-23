<?php
session_start();

$id_provider = $_GET["id"];
unset($_SESSION["keranjang"][$id_provider]);

echo "<script>alert('Produk dihapus dari keranjang')</script>";
echo "<script>location='keranjang.php';</script>";

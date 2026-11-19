<?php
// Mengecek status pembayaran ke Midtrans, lalu mengarahkan pembeli ke halaman yang sesuai.
require_once __DIR__ . '/../sesi.php';
require_once __DIR__ . '/../midtrans.php';
require_once __DIR__ . '/data_transaksi.php';
wajib_login();

$id_transaksi = (int) ($_GET['id'] ?? 0);
$id_user = (int) $_SESSION['user']['id_user'];
list($detail) = ambil_transaksi_user($koneksi, $id_transaksi, $id_user);
if (!$detail) {
    echo "<script>alert('Transaksi tidak ditemukan');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit;
}

$error = sinkronkan_status_transaksi($koneksi, $detail);
list($detail) = ambil_transaksi_user($koneksi, $id_transaksi, $id_user);

switch ($detail['status_bayar']) {
    case 'menunggu':
        $pesan = $error !== '' ? 'Status belum dapat dicek: ' . $error : 'Pembayaran belum diterima. Silahkan selesaikan pembayaran Anda.';
        $tujuan = "pembayaran.php?id=$id_transaksi";
        break;
    case 'dibayar':
        $pesan = $detail['status_pulsa'] === 'berhasil'
            ? 'Pembayaran berhasil! Pulsa sudah terkirim ke ' . $detail['no_telp'] . '.'
            : 'Pembayaran berhasil, namun pengisian pulsa gagal. Dana akan dikembalikan.';
        $tujuan = "nota.php?id=$id_transaksi";
        break;
    case 'kedaluwarsa':
        $pesan = 'Batas waktu pembayaran sudah habis. Silahkan lakukan pembelian ulang.';
        $tujuan = "nota.php?id=$id_transaksi";
        break;
    default:
        $pesan = 'Pembayaran tidak berhasil (' . label_status_bayar($detail['status_bayar'])[0] . ').';
        $tujuan = "nota.php?id=$id_transaksi";
}

echo "<script>alert(" . json_encode($pesan) . "); location=" . json_encode($tujuan) . ";</script>";

<?php
// ------------------------------------------------------------
// Endpoint notifikasi (webhook) Midtrans.
// Daftarkan URL ini di Dashboard Sandbox Midtrans:
//   Settings > Payment > Notification URL  ->  https://<alamat-publik>/notifikasi.php
// (localhost tidak bisa dijangkau Midtrans; gunakan ngrok saat uji lokal)
// ------------------------------------------------------------
require_once __DIR__ . '/midtrans.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['pesan' => 'Gunakan metode POST']);
    exit;
}

$notif = json_decode(file_get_contents('php://input'), true);
if (!is_array($notif) || !midtrans_signature_valid($notif)) {
    http_response_code(403);
    echo json_encode(['pesan' => 'Signature tidak valid']);
    exit;
}

$trx = ambil_transaksi_order($koneksi, $notif['order_id']);
if (!$trx) {
    // order tidak dikenal (misalnya notifikasi uji dari dashboard) - tetap jawab 200 agar tidak dikirim ulang
    echo json_encode(['pesan' => 'Order tidak ditemukan, diabaikan']);
    exit;
}

// demi keamanan, status diambil ulang langsung dari API Midtrans
list($data, $error) = midtrans_cek_status($trx['order_id']);
if ($error !== '' || !$data) {
    http_response_code(500);
    echo json_encode(['pesan' => 'Gagal mengecek status ke Midtrans']);
    exit;
}

terapkan_status_midtrans($koneksi, $trx, $data);
echo json_encode(['pesan' => 'OK']);

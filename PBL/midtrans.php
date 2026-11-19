<?php
// ------------------------------------------------------------
// Integrasi Midtrans Snap (tanpa composer, memakai cURL)
// Dokumentasi: https://docs.midtrans.com/reference/snap-api
// ------------------------------------------------------------
require_once __DIR__ . '/koneksi.php';
require_once __DIR__ . '/supplier_pulsa.php';

function midtrans_config()
{
    static $config = null;
    if ($config === null) {
        $file = __DIR__ . '/config_midtrans.php';
        $config = is_file($file) ? (array) require $file : [];
        $config += ['server_key' => '', 'client_key' => '', 'is_production' => false, 'batas_bayar_menit' => 15];
    }
    return $config;
}

// true jika Server Key & Client Key sudah diisi (bukan contoh)
function midtrans_siap()
{
    $c = midtrans_config();
    return $c['server_key'] !== '' && $c['client_key'] !== ''
        && strpos($c['server_key'], 'XXXX') === false && strpos($c['client_key'], 'XXXX') === false;
}

function midtrans_url_snap_js()
{
    return midtrans_config()['is_production']
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
}

function midtrans_url_api($jalur)
{
    $prod = midtrans_config()['is_production'];
    if ($jalur === 'snap') {
        return $prod ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }
    return ($prod ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com') . $jalur;
}

// Kirim request ke Midtrans. Mengembalikan [kode_http, data_json_array, pesan_error]
function midtrans_request($method, $url, $body = null)
{
    $ch = curl_init($url);
    $header = [
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(midtrans_config()['server_key'] . ':'),
    ];
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $header,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
    ]);
    if ($body !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }
    $respon = curl_exec($ch);
    $kode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($respon === false) {
        return [0, null, 'Tidak dapat terhubung ke Midtrans: ' . $error];
    }
    $data = json_decode($respon, true);
    return [$kode, is_array($data) ? $data : null, ''];
}

// URL dasar aplikasi, contoh: http://localhost:8000
function url_dasar_aplikasi()
{
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $folder = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    // halaman pembeli ada di subfolder /pembeli
    $folder = preg_replace('#/pembeli$#', '', $folder);
    return ($https ? 'https' : 'http') . '://' . $host . $folder;
}

// Membuat transaksi Snap. Mengembalikan [snap_token, pesan_error]
function midtrans_buat_snap($trx, $produk, $user, $no_telp)
{
    $items = [];
    foreach ($produk as $p) {
        $items[] = [
            'id' => 'PRV-' . $p['id_provider'],
            'price' => (int) $p['harga'],
            'quantity' => max(1, (int) $p['jumlah']),
            'name' => mb_substr($p['nama_provider'] . ' ' . rupiah_singkat($p['nominal']), 0, 50),
        ];
    }

    $body = [
        'transaction_details' => [
            'order_id' => $trx['order_id'],
            'gross_amount' => (int) $trx['total_pembelian'],
        ],
        'item_details' => $items,
        'customer_details' => [
            'first_name' => mb_substr($user['nama'], 0, 50),
            'email' => $user['email'],
            'phone' => $no_telp,
        ],
        'expiry' => [
            'start_time' => date('Y-m-d H:i:s O'),
            'unit' => 'minutes',
            'duration' => (int) midtrans_config()['batas_bayar_menit'],
        ],
        'callbacks' => [
            'finish' => url_dasar_aplikasi() . '/pembeli/cek_status.php?id=' . (int) $trx['id_transaksi_penjualan'],
        ],
    ];

    list($kode, $data, $error) = midtrans_request('POST', midtrans_url_api('snap'), $body);
    if ($error !== '') {
        return [null, $error];
    }
    if ($kode === 201 && !empty($data['token'])) {
        return [$data['token'], ''];
    }
    $pesan = isset($data['error_messages']) ? implode(', ', (array) $data['error_messages']) : 'HTTP ' . $kode;
    return [null, 'Midtrans menolak permintaan: ' . $pesan];
}

// Mengambil status transaksi dari Midtrans. Mengembalikan [data|null, pesan_error]
function midtrans_cek_status($order_id)
{
    list($kode, $data, $error) = midtrans_request('GET', midtrans_url_api('/v2/' . rawurlencode($order_id) . '/status'));
    if ($error !== '') {
        return [null, $error];
    }
    if (!$data) {
        return [null, 'Respon Midtrans tidak dapat dibaca (HTTP ' . $kode . ')'];
    }
    return [$data, ''];
}

// Verifikasi signature notifikasi: SHA512(order_id + status_code + gross_amount + server_key)
function midtrans_signature_valid($notif)
{
    if (empty($notif['order_id']) || !isset($notif['status_code'], $notif['gross_amount'], $notif['signature_key'])) {
        return false;
    }
    $hitung = hash('sha512', $notif['order_id'] . $notif['status_code'] . $notif['gross_amount'] . midtrans_config()['server_key']);
    return hash_equals($hitung, (string) $notif['signature_key']);
}

// Ubah status Midtrans menjadi status aplikasi
function petakan_status_midtrans($data)
{
    $status = $data['transaction_status'] ?? '';
    $fraud = $data['fraud_status'] ?? 'accept';
    switch ($status) {
        case 'capture':
            return $fraud === 'accept' ? 'dibayar' : 'menunggu';
        case 'settlement':
            return 'dibayar';
        case 'pending':
            return 'menunggu';
        case 'expire':
            return 'kedaluwarsa';
        case 'cancel':
            return 'dibatalkan';
        case 'deny':
        case 'failure':
            return 'gagal';
        case 'refund':
        case 'partial_refund':
            return 'refund';
        default:
            return null;
    }
}

// Nama metode pembayaran yang mudah dibaca, dari data Midtrans
function nama_metode_midtrans($data)
{
    $tipe = $data['payment_type'] ?? '';
    switch ($tipe) {
        case 'qris':
            return 'QRIS' . (!empty($data['issuer']) ? ' (' . ucfirst($data['issuer']) . ')' : '');
        case 'gopay':
            return 'GoPay';
        case 'shopeepay':
            return 'ShopeePay';
        case 'credit_card':
            return 'Kartu Kredit/Debit';
        case 'echannel':
            return 'Mandiri Bill Payment';
        case 'bank_transfer':
            if (!empty($data['va_numbers'][0]['bank'])) {
                return 'Virtual Account ' . strtoupper($data['va_numbers'][0]['bank']);
            }
            if (!empty($data['permata_va_number'])) {
                return 'Virtual Account PERMATA';
            }
            return 'Transfer Bank';
        case 'cstore':
            return ucfirst($data['store'] ?? 'Gerai Retail');
        case '':
            return null;
        default:
            return ucwords(str_replace('_', ' ', $tipe));
    }
}

// Ambil satu baris transaksi berdasarkan order_id
function ambil_transaksi_order($koneksi, $order_id)
{
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM transaksi_penjualan WHERE order_id = ?");
    mysqli_stmt_bind_param($stmt, 's', $order_id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

// Menerapkan status dari Midtrans ke database, lalu memproses pengisian pulsa jika lunas.
// Aman dipanggil berkali-kali (dari webhook maupun tombol cek status).
function terapkan_status_midtrans($koneksi, $trx, $data)
{
    $id = (int) $trx['id_transaksi_penjualan'];
    $status_baru = petakan_status_midtrans($data);
    $metode = nama_metode_midtrans($data);

    if ($metode !== null) {
        $stmt = mysqli_prepare($koneksi, "UPDATE transaksi_penjualan SET metode_pembayaran = ? WHERE id_transaksi_penjualan = ?");
        mysqli_stmt_bind_param($stmt, 'si', $metode, $id);
        mysqli_stmt_execute($stmt);
    }
    if ($status_baru === null || $status_baru === 'menunggu') {
        return;
    }

    if ($status_baru === 'dibayar') {
        // nominal yang dibayar harus sama dengan total tagihan
        if ((int) round((float) ($data['gross_amount'] ?? 0)) !== (int) $trx['total_pembelian']) {
            return;
        }
        $waktu = $data['settlement_time'] ?? ($data['transaction_time'] ?? date('Y-m-d H:i:s'));
        // hanya satu proses yang berhasil mengubah ke "dibayar" (mencegah pulsa terkirim dua kali)
        $stmt = mysqli_prepare($koneksi, "UPDATE transaksi_penjualan SET status_bayar = 'dibayar', waktu_bayar = ?
            WHERE id_transaksi_penjualan = ? AND status_bayar <> 'dibayar'");
        mysqli_stmt_bind_param($stmt, 'si', $waktu, $id);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt) === 1) {
            proses_pengisian_pulsa($koneksi, $id);
        }
        return;
    }

    // status akhir lain (kedaluwarsa, dibatalkan, gagal, refund) tidak menimpa transaksi yang sudah lunas,
    // kecuali refund
    $syarat = $status_baru === 'refund' ? "status_bayar = 'dibayar'" : "status_bayar = 'menunggu'";
    $stmt = mysqli_prepare($koneksi, "UPDATE transaksi_penjualan SET status_bayar = ? WHERE id_transaksi_penjualan = ? AND $syarat");
    mysqli_stmt_bind_param($stmt, 'si', $status_baru, $id);
    mysqli_stmt_execute($stmt);
}

// Kirim pulsa lewat supplier (simulasi) untuk transaksi yang sudah lunas
function proses_pengisian_pulsa($koneksi, $id_transaksi)
{
    $stmt = mysqli_prepare($koneksi, "SELECT tp.*, n.no_telp FROM transaksi_penjualan tp
        JOIN nohp n ON tp.id_nohp = n.id_nohp WHERE tp.id_transaksi_penjualan = ? AND tp.status_pulsa = 'menunggu'");
    mysqli_stmt_bind_param($stmt, 'i', $id_transaksi);
    mysqli_stmt_execute($stmt);
    $trx = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if (!$trx) {
        return;
    }

    $stmt = mysqli_prepare($koneksi, "SELECT p.* FROM transaksi t JOIN proveder p ON t.id_provider = p.id_provider WHERE t.id_transaksi_penjualan = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id_transaksi);
    mysqli_stmt_execute($stmt);
    $produk = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    $hasil = supplier_isi_pulsa($trx['no_telp'], $produk, $trx['order_id']);
    $stmt = mysqli_prepare($koneksi, "UPDATE transaksi_penjualan SET status_pulsa = ?, sn = ? WHERE id_transaksi_penjualan = ? AND status_pulsa = 'menunggu'");
    mysqli_stmt_bind_param($stmt, 'ssi', $hasil['status'], $hasil['sn'], $id_transaksi);
    mysqli_stmt_execute($stmt);
}

// Cek status ke Midtrans untuk transaksi yang masih menunggu, lalu simpan hasilnya.
// Mengembalikan pesan error (string kosong jika berhasil dicek).
function sinkronkan_status_transaksi($koneksi, $trx)
{
    if ($trx['status_bayar'] !== 'menunggu' || empty($trx['order_id'])) {
        return '';
    }
    if (!midtrans_siap()) {
        return 'Kunci Midtrans belum diatur di config_midtrans.php';
    }
    list($data, $error) = midtrans_cek_status($trx['order_id']);
    if ($error !== '') {
        return $error;
    }

    // 404 = pembeli belum memilih metode pembayaran di Midtrans
    if (($data['status_code'] ?? '') === '404') {
        if (!empty($trx['kedaluwarsa']) && strtotime($trx['kedaluwarsa']) < time()) {
            $stmt = mysqli_prepare($koneksi, "UPDATE transaksi_penjualan SET status_bayar = 'kedaluwarsa' WHERE id_transaksi_penjualan = ? AND status_bayar = 'menunggu'");
            $id = (int) $trx['id_transaksi_penjualan'];
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
        }
        return '';
    }
    terapkan_status_midtrans($koneksi, $trx, $data);
    return '';
}

// Label & warna status untuk tampilan
function label_status_bayar($status)
{
    $daftar = [
        'menunggu' => ['Menunggu Pembayaran', 'kuning'],
        'dibayar' => ['Lunas', 'hijau'],
        'kedaluwarsa' => ['Kedaluwarsa', 'abu'],
        'dibatalkan' => ['Dibatalkan', 'abu'],
        'gagal' => ['Pembayaran Gagal', 'merah'],
        'refund' => ['Dana Dikembalikan', 'abu'],
    ];
    return $daftar[$status] ?? [ucfirst((string) $status), 'abu'];
}

function label_status_pulsa($status_pulsa, $status_bayar)
{
    if ($status_bayar !== 'dibayar' && $status_pulsa === 'menunggu') {
        return ['Menunggu pembayaran', 'abu'];
    }
    $daftar = [
        'menunggu' => ['Sedang diproses', 'kuning'],
        'berhasil' => ['Pulsa Terkirim', 'hijau'],
        'gagal' => ['Pengisian Gagal', 'merah'],
    ];
    return $daftar[$status_pulsa] ?? [ucfirst((string) $status_pulsa), 'abu'];
}

function rupiah_singkat($angka)
{
    return 'Rp' . number_format((float) $angka, 0, ',', '.');
}

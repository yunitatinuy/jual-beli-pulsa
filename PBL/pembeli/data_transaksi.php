<?php
// Mengambil data satu transaksi milik user yang sedang login (dipakai nota.php dan cetak.php).
// Mengembalikan [detail_transaksi, daftar_produk] atau [null, []] jika tidak ditemukan / bukan milik user.
function ambil_transaksi_user($koneksi, $id_transaksi_penjualan, $id_user)
{
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM transaksi_penjualan
        JOIN user ON transaksi_penjualan.id_user = user.id_user
        LEFT JOIN metode_bayar ON transaksi_penjualan.id_metode_bayar = metode_bayar.id_metode_bayar
        JOIN nohp ON transaksi_penjualan.id_nohp = nohp.id_nohp
        WHERE transaksi_penjualan.id_transaksi_penjualan = ? AND transaksi_penjualan.id_user = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $id_transaksi_penjualan, $id_user);
    mysqli_stmt_execute($stmt);
    $detail = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if (!$detail) {
        return [null, []];
    }

    $stmt = mysqli_prepare($koneksi, "SELECT * FROM transaksi
        INNER JOIN proveder ON transaksi.id_provider = proveder.id_provider
        WHERE transaksi.id_transaksi_penjualan = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id_transaksi_penjualan);
    mysqli_stmt_execute($stmt);
    $produk = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

    return [$detail, $produk];
}

// Nama metode pembayaran untuk ditampilkan (Midtrans, atau metode lama untuk transaksi sebelum Midtrans)
function metode_tampil($detail)
{
    if (!empty($detail['metode_pembayaran'])) {
        return $detail['metode_pembayaran'];
    }
    if (!empty($detail['jenis'])) {
        return $detail['jenis'];
    }
    return '-';
}

// Nomor invoice, contoh: INV/20261119/000059
function nomor_invoice($detail)
{
    return 'INV/' . date('Ymd', strtotime($detail['tanggal_pembelian'])) . '/' . str_pad($detail['id_transaksi_penjualan'], 6, '0', STR_PAD_LEFT);
}

// Format rupiah, contoh: Rp7.000
function rupiah($angka)
{
    return 'Rp' . number_format((float) $angka, 0, ',', '.');
}

// Format tanggal Indonesia, contoh: 19 November 2026
function tanggal_indo($tanggal)
{
    $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $waktu = strtotime($tanggal);
    return date('j', $waktu) . ' ' . $bulan[(int) date('n', $waktu)] . ' ' . date('Y', $waktu);
}

// Rincian angka invoice: subtotal nominal, biaya layanan, dan total
function rincian_invoice($detail, $daftar_produk)
{
    $subtotal = 0;
    $biaya = 0;
    foreach ($daftar_produk as $p) {
        $jumlah = max(1, (int) $p['jumlah']);
        $subtotal += (int) $p['nominal'] * $jumlah;
        $biaya += max(0, (int) $p['harga'] - (int) $p['nominal']) * $jumlah;
    }
    return [
        'subtotal'      => $subtotal,
        'biaya'         => $biaya,
        'biaya_layanan' => $biaya,
        'total'         => (int) $detail['total_pembelian']
    ];
}

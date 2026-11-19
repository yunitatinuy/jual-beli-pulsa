<?php
require_once __DIR__ . '/../sesi.php';
require_once __DIR__ . '/../midtrans.php';
require_once __DIR__ . '/data_transaksi.php';
wajib_login();

$id_pembelian_barusan = (int) ($_GET['id'] ?? 0);
list($detail, $daftar_produk) = ambil_transaksi_user($koneksi, $id_pembelian_barusan, (int) $_SESSION['user']['id_user']);
if (!$detail) {
    echo "<script>alert('Transaksi tidak ditemukan'); location='riwayat.php';</script>";
    exit;
}
// perbarui status dari Midtrans jika masih menunggu pembayaran
if ($detail['status_bayar'] === 'menunggu') {
    sinkronkan_status_transaksi($koneksi, $detail);
    list($detail, $daftar_produk) = ambil_transaksi_user($koneksi, $id_pembelian_barusan, (int) $_SESSION['user']['id_user']);
}
$label_bayar = label_status_bayar($detail['status_bayar']);
$label_pulsa = label_status_pulsa($detail['status_pulsa'], $detail['status_bayar']);
$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));
$no_invoice = nomor_invoice($detail);
$rincian = rincian_invoice($detail, $daftar_produk);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Invoice <?php echo e($no_invoice); ?> — QUICK.TOP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="invoice.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="theme.js?v=<?php echo time(); ?>"></script>
</head>
<body>

    <!-- SIDEBAR -->
    <section class="sidebar" id="sidebar">
        <div class="nav-header">
            <div class="brand-icon">&#9889;</div>
            <span class="logo">QUICK.TOP</span>
            <button class="btn-menu" onclick="toggleSidebar()">
                <i class="bx bx-menu-alt-right" id="menuIcon"></i>
            </button>
        </div>

        <div class="sidebar-user">
            <div class="avatar"><?php echo $inisial; ?></div>
            <div class="user-info">
                <div class="user-name"><?php echo $pengguna; ?></div>
                <div class="user-role">Pembeli</div>
            </div>
        </div>

        <ul class="nav-links">
            <li>
                <a href="dashboard.php">
                    <i class="bi bi-house-fill"></i>
                    <span class="title">Beranda</span>
                </a>
                <span class="tooltip">Beranda</span>
            </li>
            <li class="active">
                <a href="riwayat.php">
                    <i class="bi bi-journal-text"></i>
                    <span class="title">Riwayat</span>
                </a>
                <span class="tooltip">Riwayat</span>
            </li>
            <li>
                <a href="pengaturan.php">
                    <i class="bi bi-gear-fill"></i>
                    <span class="title">Pengaturan</span>
                </a>
                <span class="tooltip">Pengaturan</span>
            </li>
            <li>
                <a href="tentang_kami.php">
                    <i class="bi bi-question-circle-fill"></i>
                    <span class="title">Tentang Kami</span>
                </a>
                <span class="tooltip">Tentang Kami</span>
            </li>
        </ul>

        <!-- THEME RADIAL MENU -->
        <div class="sidebar-theme-wrap">
            <div class="radial-theme-menu" id="radialThemeMenu">
                <button type="button" class="radial-trigger-btn" id="themeRadialTrigger" title="Mode Tampilan" onclick="toggleRadialTheme(event)">
                    <i class="bi bi-circle-half" id="currentThemeIcon"></i>
                    <span class="title">Mode Tema</span>
                </button>
                <div class="radial-options">
                    <button type="button" class="radial-item" onclick="setAppTheme('light')" data-mode="light" title="Mode Terang">
                        <i class="bi bi-sun-fill text-warning"></i>
                        <span class="radial-tooltip">Terang</span>
                    </button>
                    <button type="button" class="radial-item" onclick="setAppTheme('auto')" data-mode="auto" title="Sesuai Device">
                        <i class="bi bi-laptop text-info"></i>
                        <span class="radial-tooltip">Sistem</span>
                    </button>
                    <button type="button" class="radial-item" onclick="setAppTheme('dark')" data-mode="dark" title="Mode Gelap">
                        <i class="bi bi-moon-stars-fill text-success"></i>
                        <span class="radial-tooltip">Gelap</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="sidebar-logout">
            <a href="../logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span class="title">Keluar</span>
            </a>
        </div>
    </section>

    <!-- MAIN -->
    <section class="home">
        <!-- TOP BAR -->
        <div class="nav-top">
            <div class="nav-name">Invoice Pembelian</div>
            <div class="nav-top-actions">
                <a href="keranjang.php" title="Keranjang">
                    <i class="bi bi-cart2"></i>
                </a>
                <a href="profile.php" title="Profil">
                    <i class="bi bi-person-circle"></i>
                </a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <div class="invoice-wrap">
                <div class="invoice">
                    <div class="invoice-head">
                        <div class="invoice-brand">
                            <img src="logo/quicktop.png" alt="QUICK.TOP" onerror="this.src='../logoo.png'">
                            <div>
                                <div class="nama">QUICK.TOP</div>
                                <div class="tagline">Bukti Pembelian Pulsa Resmi</div>
                            </div>
                        </div>
                        <div class="invoice-title">
                            <h1>INVOICE</h1>
                            <div class="nomor"><?php echo e($no_invoice); ?></div>
                        </div>
                    </div>

                    <div class="invoice-body">
                        <div class="invoice-meta">
                            <div class="invoice-box">
                                <div class="label"><i class="bi bi-calendar3 me-1"></i> Tanggal Transaksi</div>
                                <div class="isi">
                                    <strong><?php echo e(tanggal_indo($detail['tanggal_pembelian'])); ?></strong>
                                </div>
                            </div>

                            <div class="invoice-box">
                                <div class="label"><i class="bi bi-person me-1"></i> Pembeli & Nomor Tujuan</div>
                                <div class="isi">
                                    <strong><?php echo $pengguna; ?></strong><br>
                                    <span style="font-family: monospace; font-size: 15px; color: var(--green); font-weight: 700;">
                                        <i class="bi bi-phone"></i> <?php echo e($detail['no_telp']); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="invoice-box">
                                <div class="label"><i class="bi bi-shield-check me-1"></i> Status Transaksi</div>
                                <div class="isi">
                                    <span class="status-badge <?php echo $label_bayar[1]; ?>">
                                        <i class="bi bi-check-circle-fill"></i> <?php echo e($label_bayar[0]); ?>
                                    </span>
                                    <?php if ($detail['status_bayar'] === 'dibayar'): ?>
                                        <br><span class="status-badge <?php echo $label_pulsa[1]; ?> mt-1">
                                            <i class="bi bi-broadcast"></i> <?php echo e($label_pulsa[0]); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Item Sesuai Format Cetak PDF -->
                        <table class="invoice-table">
                            <thead>
                                <tr>
                                    <th>Deskripsi Produk</th>
                                    <th class="angka">Nominal Pulsa</th>
                                    <th class="angka">Biaya Layanan</th>
                                    <th class="tengah">Jumlah</th>
                                    <th class="angka">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($daftar_produk as $item):
                                    $qty = max(1, (int) $item['jumlah']);
                                    $sub = (int) $item['harga'] * $qty;
                                    $fee = max(0, (int) $item['harga'] - (int) $item['nominal']) * $qty;
                                ?>
                                <tr>
                                    <td>
                                        <div class="produk"><?php echo e($item['nama_provider']); ?></div>
                                        <div class="keterangan"><?php echo e($item['detail']); ?></div>
                                    </td>
                                    <td class="angka"><?php echo rupiah($item['nominal']); ?></td>
                                    <td class="angka"><?php echo rupiah($fee); ?></td>
                                    <td class="tengah"><?php echo $qty; ?></td>
                                    <td class="angka"><strong><?php echo rupiah($sub); ?></strong></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- Bagian Bawah Ringkasan -->
                        <div class="invoice-bottom">
                            <div class="invoice-bayar">
                                <div class="invoice-box">
                                    <div class="label"><i class="bi bi-credit-card me-1"></i> Metode Pembayaran</div>
                                    <div class="isi">
                                        <strong style="color: var(--teal);"><?php echo e(metode_tampil($detail)); ?></strong>
                                        <?php if (!empty($detail['waktu_bayar'])): ?>
                                            <div style="font-size: 12.5px; color: var(--text-muted); margin-top: 4px;">
                                                <i class="bi bi-clock me-1"></i> Dibayar: <?php echo e(tanggal_indo($detail['waktu_bayar'])); ?>, <?php echo date('H:i', strtotime($detail['waktu_bayar'])); ?> WIB
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($detail['order_id'])): ?>
                                            <div style="font-size: 12px; color: var(--text-dim); font-family: monospace; margin-top: 2px;">
                                                Order ID: <?php echo e($detail['order_id']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="invoice-total">
                                <div class="baris">
                                    <span>Subtotal Produk:</span>
                                    <span><?php echo rupiah($rincian['subtotal']); ?></span>
                                </div>
                                <div class="baris">
                                    <span>Biaya Layanan:</span>
                                    <span><?php echo rupiah($rincian['biaya']); ?></span>
                                </div>
                                <div class="baris total">
                                    <span>Total Pembayaran:</span>
                                    <span><?php echo rupiah($rincian['total']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="invoice-foot">
                        <div class="terima-kasih">Terima Kasih Atas Kepercayaan Anda!</div>
                        <div>QUICK.TOP &mdash; Solusi Pembelian Pulsa Murah, Cepat, dan Terpercaya</div>
                    </div>
                </div>

                <div class="invoice-actions">
                    <a href="cetak.php?id=<?php echo $id_pembelian_barusan; ?>" target="_blank" class="btn-beli" style="width: auto; padding: 10px 22px;">
                        <i class="bi bi-printer-fill me-1"></i> Cetak / Simpan PDF
                    </a>
                    <?php if ($detail['status_bayar'] === 'menunggu'): ?>
                        <a href="pembayaran.php?id=<?php echo $id_pembelian_barusan; ?>" class="btn-action pay">
                            <i class="bi bi-credit-card me-1"></i> Lanjut Bayar
                        </a>
                    <?php endif; ?>
                    <a href="riwayat.php" class="btn-action detail">
                        <i class="bi bi-journal-text me-1"></i> Riwayat Transaksi
                    </a>
                    <a href="dashboard.php" class="btn-action" style="background: rgba(255,255,255,0.06); color: var(--text-light);">
                        <i class="bi bi-house me-1"></i> Beranda
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer mt-4">
                <div class="footer-links">
                    <span><i class="bi bi-envelope"></i> quicktop.top@gmail.com</span>
                    <span><i class="bi bi-telephone"></i> 0000-0000-0000</span>
                    <span><i class="bi bi-geo-alt-fill"></i> Batam, Indonesia</span>
                </div>
                <div class="copyright">
                    &copy; 2024 QUICK.TOP &mdash; All Rights Reserved
                </div>
            </footer>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar  = document.getElementById('sidebar');
            const menuIcon = document.getElementById('menuIcon');
            sidebar.classList.toggle('expand');
            menuIcon.className = sidebar.classList.contains('expand')
                ? 'bx bx-menu-alt-right'
                : 'bx bx-menu';
        }
    </script>
</body>
</html>

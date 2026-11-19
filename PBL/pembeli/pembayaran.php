<?php
require_once __DIR__ . '/../sesi.php';
require_once __DIR__ . '/../midtrans.php';
require_once __DIR__ . '/data_transaksi.php';
wajib_login();

$id_transaksi = (int) ($_GET['id'] ?? 0);
list($detail, $daftar_produk) = ambil_transaksi_user($koneksi, $id_transaksi, (int) $_SESSION['user']['id_user']);
if (!$detail) {
    echo "<script>alert('Transaksi tidak ditemukan'); location='riwayat.php';</script>";
    exit;
}

// perbarui status dari Midtrans (jika masih menunggu)
$pesan_error = sinkronkan_status_transaksi($koneksi, $detail);
list($detail, $daftar_produk) = ambil_transaksi_user($koneksi, $id_transaksi, (int) $_SESSION['user']['id_user']);

// pembayaran sudah selesai (lunas / kedaluwarsa / batal) -> tampilkan invoice
if ($detail['status_bayar'] !== 'menunggu') {
    header("location:nota.php?id=$id_transaksi");
    exit;
}

$no_invoice = nomor_invoice($detail);
$rincian = rincian_invoice($detail, $daftar_produk);
$sisa_detik = max(0, strtotime((string) $detail['kedaluwarsa']) - time());
$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Pembayaran <?php echo e($no_invoice); ?> — QUICK.TOP</title>

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
            <div class="nav-name">Gerbang Pembayaran</div>
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
            <div class="invoice-wrap" style="max-width: 650px;">
                <div class="invoice">
                    <div class="invoice-head">
                        <div class="invoice-brand">
                            <img src="logo/quicktop.png" alt="QUICK.TOP" onerror="this.src='../logoo.png'">
                            <div>
                                <div class="nama">Pembayaran Pulsa</div>
                                <div class="tagline">ID Transaksi: <?php echo e($no_invoice); ?></div>
                            </div>
                        </div>
                        <div class="invoice-title">
                            <span class="status-badge kuning">
                                <i class="bi bi-hourglass-split"></i> Menunggu Pembayaran
                            </span>
                        </div>
                    </div>

                    <div class="invoice-body">
                        <div class="bayar-total">
                            <div class="label">Total Yang Harus Dibayar:</div>
                            <div class="nominal"><?php echo e(rupiah($rincian['total'])); ?></div>
                            <div class="hitung-mundur">
                                Selesaikan pembayaran dalam:
                                <strong id="hitung-mundur" data-sisa="<?php echo (int) $sisa_detik; ?>">--:--</strong>
                            </div>
                        </div>

                        <div class="invoice-box" style="margin-bottom: 20px;">
                            <div class="label"><i class="bi bi-receipt me-1"></i> Rincian Pesanan</div>
                            <div class="isi">
                                <?php foreach ($daftar_produk as $p): ?>
                                    <div style="font-size: 15px; font-weight: 700; color: var(--text-light);">
                                        <?php echo e($p['nama_provider'] . ' — ' . rupiah($p['nominal'])); ?>
                                    </div>
                                    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">
                                        <?php echo e($p['detail']); ?>
                                    </div>
                                <?php endforeach; ?>
                                <div style="padding-top: 6px; border-top: 1px dashed var(--border-glass);">
                                    Nomor Handphone Tujuan: <strong style="color: var(--green); font-family: monospace; font-size: 15px;"><?php echo e($detail['no_telp']); ?></strong>
                                </div>
                            </div>
                        </div>

                        <?php if ($pesan_error !== ''): ?>
                            <div class="alert alert-warning" style="border-radius: 12px; font-size: 14px;">
                                <i class="bi bi-exclamation-triangle"></i> <?php echo e($pesan_error); ?>
                            </div>
                        <?php endif; ?>

                        <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 24px;">
                            <button type="button" id="tombol-bayar" class="btn-beli" style="padding: 15px; font-size: 16px;" <?php echo empty($detail['snap_token']) || !midtrans_siap() ? 'disabled' : ''; ?>>
                                <i class="bi bi-wallet2 me-1"></i> Buka Pembayaran (Midtrans)
                            </button>
                            <a href="cek_status.php?id=<?php echo $id_transaksi; ?>" class="btn-action detail" style="justify-content: center; padding: 12px;">
                                <i class="bi bi-arrow-repeat me-1"></i> Cek Status Pembayaran
                            </a>
                        </div>

                        <?php if (!midtrans_config()['is_production']): ?>
                            <div class="info-sandbox">
                                <div class="label"><i class="bi bi-info-circle-fill"></i> Mode Uji Coba (Sandbox)</div>
                                <ul>
                                    <li><strong>QRIS / GoPay / ShopeePay:</strong> salin URL QR code lalu bayar di <a href="https://simulator.sandbox.midtrans.com/" target="_blank" rel="noopener">Simulator Midtrans</a>.</li>
                                    <li><strong>Virtual Account:</strong> salin nomor VA dan bayar di simulator bank.</li>
                                    <li><strong>Kartu Kredit:</strong> <code>4811 1111 1111 1114</code>, CVV: <code>123</code>, OTP: <code>112233</code>.</li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="invoice-foot">
                        Pembayaran diproses secara aman & terverifikasi otomatis oleh Midtrans.
                    </div>
                </div>

                <div class="invoice-actions">
                    <a href="riwayat.php" class="btn-action detail"><i class="bi bi-journal-text me-1"></i> Riwayat Transaksi</a>
                    <a href="dashboard.php" class="btn-action" style="background: rgba(255,255,255,0.06); color: var(--text-light);"><i class="bi bi-house me-1"></i> Beranda</a>
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

    <?php if (!empty($detail['snap_token']) && midtrans_siap()): ?>
        <script src="<?php echo e(midtrans_url_snap_js()); ?>" data-client-key="<?php echo e(midtrans_config()['client_key']); ?>"></script>
    <?php endif; ?>
    <script>
        // hitung mundur batas waktu pembayaran
        (function() {
            const el = document.getElementById('hitung-mundur');
            if (!el) return;
            let sisa = parseInt(el.dataset.sisa, 10) || 0;

            function tampil() {
                const m = String(Math.floor(sisa / 60)).padStart(2, '0');
                const d = String(sisa % 60).padStart(2, '0');
                el.textContent = m + ':' + d;
                if (sisa <= 0) {
                    clearInterval(timer);
                    window.location = 'cek_status.php?id=<?php echo $id_transaksi; ?>';
                }
                sisa--;
            }
            const timer = setInterval(tampil, 1000);
            tampil();
        })();

        // membuka popup pembayaran Midtrans Snap
        const tombolBayar = document.getElementById('tombol-bayar');
        if (tombolBayar) {
            tombolBayar.addEventListener('click', function() {
                if (!window.snap) {
                    alert('Halaman pembayaran Midtrans belum termuat, periksa koneksi internet lalu muat ulang halaman.');
                    return;
                }
                const cekStatus = function() {
                    window.location = 'cek_status.php?id=<?php echo $id_transaksi; ?>';
                };
                window.snap.pay(<?php echo json_encode((string) $detail['snap_token']); ?>, {
                    onSuccess: cekStatus,
                    onPending: cekStatus,
                    onError: function() {
                        alert('Pembayaran gagal atau dibatalkan.');
                        cekStatus();
                    },
                    onClose: function() {}
                });
            });
        }

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

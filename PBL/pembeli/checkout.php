<?php
require_once __DIR__ . '/../sesi.php';
require_once __DIR__ . '/../midtrans.php';

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
    exit;
}
//jika isi keranjang kosong
if (empty($_SESSION["keranjang"]) || !isset($_SESSION["keranjang"])) {
    echo "<script>alert('Keranjang kosong, silahkan berbelanja dahulu'); location='dashboard.php';</script>";
    exit;
}

$id_provider = (int) ($_GET['id'] ?? 0);

//produk harus ada di keranjang dan nomor HP harus sudah diisi di halaman konfirmasi
if (!isset($_SESSION["keranjang"][$id_provider])) {
    echo "<script>alert('Produk tidak ada di keranjang'); location='keranjang.php';</script>";
    exit;
}
if (empty($_SESSION['checkout']) || (int) $_SESSION['checkout']['id_provider'] !== $id_provider) {
    echo "<script>alert('Silahkan masukkan nomor handphone terlebih dahulu'); location='konfirmasi.php?id=$id_provider';</script>";
    exit;
}

//data produk yang dibeli
$stmt = mysqli_prepare($koneksi, "SELECT * FROM proveder WHERE id_provider = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_provider);
mysqli_stmt_execute($stmt);
$pecah = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$pecah) {
    unset($_SESSION["keranjang"][$id_provider]);
    echo "<script>alert('Produk sudah tidak tersedia'); location='keranjang.php';</script>";
    exit;
}

//nomor HP milik transaksi ini (disimpan di sesi saat konfirmasi)
$id_nohp = (int) $_SESSION['checkout']['id_nohp'];
$stmt = mysqli_prepare($koneksi, "SELECT * FROM nohp WHERE id_nohp = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_nohp);
mysqli_stmt_execute($stmt);
$detail = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (isset($_POST['konfirmasi'])) {
    $id_user = (int) $_SESSION["user"]["id_user"];

    if (!$detail) {
        echo "<script>alert('Nomor handphone tidak ditemukan, silahkan isi ulang'); location='konfirmasi.php?id=$id_provider';</script>";
        exit;
    }
    if (!midtrans_siap()) {
        echo "<script>alert('Pembayaran belum dapat digunakan: kunci Midtrans belum diatur di config_midtrans.php'); location='checkout.php?id=$id_provider';</script>";
        exit;
    }

    $jumlah = 1;
    $tanggal_pembelian = date("Y-m-d");
    $total_pembelian = (int) $pecah["harga"] * $jumlah;
    $kedaluwarsa = date('Y-m-d H:i:s', time() + 60 * (int) midtrans_config()['batas_bayar_menit']);

    //1. menyimpan pesanan dengan status "menunggu pembayaran"
    $stmt = mysqli_prepare($koneksi, "INSERT INTO transaksi_penjualan (id_user, id_nohp, tanggal_pembelian, total_pembelian, status_bayar, kedaluwarsa) VALUES (?, ?, ?, ?, 'menunggu', ?)");
    mysqli_stmt_bind_param($stmt, 'iisis', $id_user, $id_nohp, $tanggal_pembelian, $total_pembelian, $kedaluwarsa);
    mysqli_stmt_execute($stmt);
    $id_pembelian_barusan = mysqli_insert_id($koneksi);

    //order_id unik untuk Midtrans
    $order_id = 'QT-' . $id_pembelian_barusan . '-' . time();
    $stmt = mysqli_prepare($koneksi, "UPDATE transaksi_penjualan SET order_id = ? WHERE id_transaksi_penjualan = ?");
    mysqli_stmt_bind_param($stmt, 'si', $order_id, $id_pembelian_barusan);
    mysqli_stmt_execute($stmt);

    //2. menyimpan produk yang dibeli
    $stmt = mysqli_prepare($koneksi, "INSERT INTO transaksi (id_transaksi_penjualan, id_provider, jumlah) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'iii', $id_pembelian_barusan, $id_provider, $jumlah);
    mysqli_stmt_execute($stmt);

    //3. membuat tagihan di Midtrans Snap
    $trx = [
        'id_transaksi_penjualan' => $id_pembelian_barusan,
        'order_id' => $order_id,
        'total_pembelian' => $total_pembelian,
    ];
    $produk = [array_merge($pecah, ['jumlah' => $jumlah])];
    list($snap_token, $error) = midtrans_buat_snap($trx, $produk, $_SESSION['user'], $detail['no_telp']);

    if (!$snap_token) {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM transaksi WHERE id_transaksi_penjualan = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id_pembelian_barusan);
        mysqli_stmt_execute($stmt);
        $stmt = mysqli_prepare($koneksi, "DELETE FROM transaksi_penjualan WHERE id_transaksi_penjualan = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id_pembelian_barusan);
        mysqli_stmt_execute($stmt);
        echo "<script>alert(" . json_encode('Gagal membuat tagihan pembayaran. ' . $error) . "); location='checkout.php?id=$id_provider';</script>";
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "UPDATE transaksi_penjualan SET snap_token = ? WHERE id_transaksi_penjualan = ?");
    mysqli_stmt_bind_param($stmt, 'si', $snap_token, $id_pembelian_barusan);
    mysqli_stmt_execute($stmt);

    //produk dipindahkan dari keranjang ke pesanan
    unset($_SESSION["keranjang"][$id_provider]);
    unset($_SESSION['checkout']);

    header("location:pembayaran.php?id=$id_pembelian_barusan");
    exit;
}

$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));
$biaya_layanan = max(0, (int) $pecah["harga"] - (int) $pecah["nominal"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Konfirmasi Checkout â€” QUICK.TOP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
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
            <li class="active">
                <a href="dashboard.php">
                    <i class="bi bi-house-fill"></i>
                    <span class="title">Dashboard</span>
                </a>
                <span class="nav-tooltip">Dashboard</span>
            </li>
            <li>
                <a href="riwayat.php">
                    <i class="bi bi-journal-text"></i>
                    <span class="title">Riwayat</span>
                </a>
                <span class="nav-tooltip">Riwayat</span>
            </li>
            <li>
                <a href="pengaturan.php">
                    <i class="bi bi-gear-fill"></i>
                    <span class="title">Pengaturan</span>
                </a>
                <span class="nav-tooltip">Pengaturan</span>
            </li>
            <li>
                <a href="tentang_kami.php">
                    <i class="bi bi-question-circle-fill"></i>
                    <span class="title">Tentang Kami</span>
                </a>
                <span class="nav-tooltip">Tentang Kami</span>
            </li>
        </ul>

        <!-- THEME RADIAL MENU -->
        <div class="sidebar-theme-wrap">
      <span class="nav-tooltip">Mode Tema</span>
            <div class="radial-theme-menu" id="radialThemeMenu">
                <button type="button" class="radial-trigger-btn" id="themeRadialTrigger" title="Mode Tampilan" onclick="toggleRadialTheme(event)">
                    <i class="bi bi-circle-half" id="currentThemeIcon"></i>
                    <span class="title">Mode Tema</span>
                </button>
                <div class="radial-options">
                    <button type="button" class="radial-item" onclick="setAppTheme('light')" data-mode="light" title="Mode Terang">
                        <i class="bi bi-sun-fill"></i>
                        <span class="radial-tooltip">Terang</span>
                    </button>
                    <button type="button" class="radial-item" onclick="setAppTheme('auto')" data-mode="auto" title="Sesuai Device">
                        <i class="bi bi-laptop"></i>
                        <span class="radial-tooltip">Sistem</span>
                    </button>
                    <button type="button" class="radial-item" onclick="setAppTheme('dark')" data-mode="dark" title="Mode Gelap">
                        <i class="bi bi-moon-stars-fill"></i>
                        <span class="radial-tooltip">Gelap</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="sidebar-logout">
      <span class="nav-tooltip">Keluar</span>
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
            <div class="nav-name">Ringkasan Checkout</div>
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
            <div class="page-header">
                <div>
                    <a href="konfirmasi.php?id=<?php echo $id_provider; ?>" class="btn-action detail mb-2" style="font-size: 13px;">
                        <i class="bi bi-arrow-left"></i> Ubah Nomor Tujuan
                    </a>
                    <h1 class="page-title mt-2">
                        <i class="bi bi-shield-check"></i> Konfirmasi Pesanan & Rincian
                    </h1>
                    <p class="page-subtitle">Langkah 2 dari 2: Periksa rincian sebelum masuk ke gerbang pembayaran</p>
                </div>
            </div>

            <div class="glass-panel purchase-card">
                <!-- Info Nomor & Pembeli -->
                <div class="d-flex align-items-center justify-content-between p-3 mb-4 rounded-3" style="background: var(--bg-card-sub); border: 1px solid var(--border-glass);">
                    <div>
                        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Nomor Tujuan Pengisian:</div>
                        <div style="font-size: 18px; font-weight: 800; color: var(--green); font-family: monospace; letter-spacing: 1px;">
                            <i class="bi bi-telephone-fill me-1"></i> <?php echo e($detail["no_telp"]); ?>
                        </div>
                    </div>
                    <a href="konfirmasi.php?id=<?php echo $id_provider; ?>" class="btn-action detail" style="font-size: 12px; padding: 5px 12px;">
                        Ubah
                    </a>
                </div>

                <!-- Info Produk -->
                <div class="detail-row">
                    <span class="label"><i class="bi bi-box-seam me-1"></i> Produk Pulsa</span>
                    <span class="val"><?php echo e($pecah["nama_provider"]); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label"><i class="bi bi-credit-card-2-front me-1"></i> Metode Pembayaran</span>
                    <span class="val" style="color: var(--teal);">
                        QRIS, GoPay, ShopeePay, VA Bank
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label"><i class="bi bi-cash me-1"></i> Nominal Pulsa</span>
                    <span class="val">Rp <?php echo number_format($pecah["nominal"], 0, ',', '.'); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label"><i class="bi bi-receipt me-1"></i> Biaya Admin & Layanan</span>
                    <span class="val">Rp <?php echo number_format($biaya_layanan, 0, ',', '.'); ?></span>
                </div>

                <div class="detail-row" style="border-bottom: 2px solid var(--border-glass); padding-bottom: 16px;">
                    <span class="label" style="font-size: 16px; font-weight: 700; color: var(--text-light);">Total Pembayaran</span>
                    <span class="val" style="font-size: 22px; font-weight: 800; color: var(--green);">
                        Rp <?php echo number_format($pecah["harga"], 0, ',', '.'); ?>
                    </span>
                </div>

                <form method="post" action="" class="mt-4 pt-2">
                    <button type="submit" name="konfirmasi" class="btn-beli" style="padding: 15px; font-size: 16px;">
                        <i class="bi bi-lock-fill me-1"></i> Bayar Sekarang via Midtrans
                    </button>
                    <p style="text-align: center; color: var(--text-muted); font-size: 12px; margin-top: 12px;">
                        <i class="bi bi-shield-lock-fill text-success me-1"></i> Pembayaran aman dan terenkripsi otomatis
                    </p>
                </form>
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


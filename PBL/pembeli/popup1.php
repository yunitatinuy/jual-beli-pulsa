<?php
require_once __DIR__ . '/../sesi.php';
if (!isset($_SESSION['user'])) {
    header('location:../login.php');
    exit;
}

$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));
$id_provider = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare($koneksi, "SELECT * FROM proveder WHERE id_provider = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_provider);
mysqli_stmt_execute($stmt);
$detail = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$detail) {
    echo "<script>alert('Produk pulsa tidak ditemukan'); location='dashboard.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Detail <?php echo e($detail['nama_provider']); ?> â€” QUICK.TOP</title>

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
            <div class="nav-name">Detail Pulsa</div>
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
                    <a href="dashboard.php" class="btn-action detail mb-2" style="font-size: 13px;">
                        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                    </a>
                    <h1 class="page-title mt-2">
                        <i class="bi bi-phone-fill"></i> Detail Pembelian Produk
                    </h1>
                </div>
            </div>

            <div class="glass-panel purchase-card">
                <div class="product-detail-hero">
                    <div class="product-detail-img">
                        <img src="foto_produk/<?php echo e($detail['foto']); ?>"
                             alt="<?php echo e($detail['nama_provider']); ?>"
                             onerror="this.src='https://placehold.co/120x80/0A3D1F/71E398?text=<?php echo urlencode($detail['nama_provider']); ?>'">
                    </div>
                    <div class="product-detail-header">
                        <h2><?php echo e($detail['nama_provider']); ?></h2>
                        <span class="product-nominal-badge">
                            Nominal Pulsa Rp <?php echo number_format($detail['nominal'], 0, ',', '.'); ?>
                        </span>
                    </div>
                </div>

                <div class="detail-row">
                    <span class="label"><i class="bi bi-tag me-1"></i> Provider</span>
                    <span class="val"><?php echo e($detail['nama_provider']); ?></span>
                </div>

                <div class="detail-row">
                    <span class="label"><i class="bi bi-cash-stack me-1"></i> Harga Pembelian</span>
                    <span class="val" style="color: var(--teal); font-size: 18px; font-weight: 700;">
                        Rp <?php echo number_format($detail['harga'], 0, ',', '.'); ?>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label"><i class="bi bi-info-circle me-1"></i> Keterangan & Deskripsi</span>
                    <span class="val" style="max-width: 340px; font-weight: normal; color: var(--text-muted);">
                        <?php echo !empty($detail['detail']) ? e($detail['detail']) : 'Pulsa reguler all operator langsung masuk ke nomor tujuan.'; ?>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label"><i class="bi bi-shield-check me-1"></i> Jaminan Layanan</span>
                    <span class="val text-success">
                        <i class="bi bi-check-circle-fill"></i> Proses Instan 24 Jam
                    </span>
                </div>

                <div class="mt-4 pt-2">
                    <a href="popup.php?halaman=beli&id=<?php echo (int) $detail['id_provider']; ?>" class="btn-beli" style="padding: 14px; font-size: 15px;">
                        <i class="bi bi-cart-plus-fill me-1"></i> Masukkan ke Keranjang & Beli
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


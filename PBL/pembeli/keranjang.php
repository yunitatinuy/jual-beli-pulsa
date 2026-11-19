<?php
require_once __DIR__ . '/../sesi.php';
if (!isset($_SESSION['user'])) {
    header('location:../login.php');
    exit;
}

$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Keranjang Belanja â€” QUICK.TOP</title>

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
            <li>
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
            <div class="nav-name">Keranjang Belanja</div>
            <div class="nav-top-actions">
                <a href="keranjang.php" title="Keranjang" style="color: var(--green); border-color: var(--green); background: rgba(34,197,94,0.12);">
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
                    <h1 class="page-title">
                        <i class="bi bi-cart-check-fill"></i> Keranjang Pulsa Anda
                    </h1>
                    <p class="page-subtitle">Periksa pesanan pulsa sebelum melanjutkan ke proses pengisian nomor</p>
                </div>
                <div>
                    <a href="dashboard.php" class="btn-action detail">
                        <i class="bi bi-plus-circle"></i> Tambah Produk Lain
                    </a>
                </div>
            </div>

            <div class="glass-panel">
                <?php if (empty($_SESSION["keranjang"]) || !isset($_SESSION["keranjang"])): ?>
                    <div style="text-align: center; padding: 48px 20px;">
                        <i class="bi bi-cart-x" style="font-size: 54px; color: var(--text-muted); opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                        <h4 style="font-weight: 700; color: var(--text-light); margin-bottom: 6px;">Keranjang Masih Kosong</h4>
                        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">Anda belum memilih produk pulsa untuk dibeli.</p>
                        <a href="dashboard.php" class="btn-beli" style="display: inline-flex !important; width: auto; padding: 10px 24px;">
                            <i class="bi bi-grid me-1"></i> Lihat Daftar Pulsa
                        </a>
                    </div>
                <?php else: ?>
                    <div class="custom-table-container">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Produk & Provider</th>
                                    <th>Nominal Pulsa</th>
                                    <th>Harga</th>
                                    <th style="text-align: center;">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION["keranjang"] as $id_provider => $jumlah):
                                    $ambil = $koneksi->query("SELECT * FROM proveder WHERE id_provider=" . (int) $id_provider);
                                    while ($pecah = $ambil->fetch_assoc()):
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width: 48px; height: 48px; border-radius: 10px; background: var(--bg-card-sub); border: 1px solid var(--border-glass); display: flex; align-items: center; justify-content: center; padding: 4px;">
                                                <img src="foto_produk/<?php echo e($pecah['foto']); ?>"
                                                     alt="<?php echo e($pecah['nama_provider']); ?>"
                                                     style="max-width: 100%; max-height: 100%; object-fit: contain;"
                                                     onerror="this.src='https://placehold.co/80x50/0A3D1F/71E398?text=Pulsa'">
                                            </div>
                                            <div>
                                                <span style="font-weight: 700; font-size: 15px; color: var(--text-light);">
                                                    <?php echo e($pecah["nama_provider"]); ?>
                                                </span>
                                                <div style="font-size: 12px; color: var(--text-muted);">Pulsa Reguler</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge hijau" style="font-size: 14px;">
                                            Rp <?php echo number_format($pecah["nominal"], 0, ',', '.'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--teal); font-size: 16px;">
                                            Rp <?php echo number_format($pecah["harga"], 0, ',', '.'); ?>
                                        </strong>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="btn-action-group">
                                            <a href="hapuskeranjang.php?id=<?php echo (int) $id_provider; ?>" class="btn-action danger" onclick="return confirm('Hapus produk ini dari keranjang?')" title="Hapus">
                                                <i class="bi bi-trash3"></i> Hapus
                                            </a>
                                            <a href="konfirmasi.php?id=<?php echo (int) $id_provider; ?>" class="btn-action pay" title="Lanjut ke Pengisian Nomor">
                                                <i class="bi bi-arrow-right-circle"></i> Checkout Sekarang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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


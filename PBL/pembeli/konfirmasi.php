<?php
require_once __DIR__ . '/../sesi.php';
if (!isset($_SESSION['user'])) {
    header('location:../login.php');
    exit;
}
$id_provider = (int) ($_GET['id'] ?? 0);

//jika isi keranjang kosong
if (empty($_SESSION["keranjang"]) || !isset($_SESSION["keranjang"])) {
    echo "<script>alert('Keranjang kosong, silahkan berbelanja dahulu'); location='dashboard.php';</script>";
    exit;
}
//produk yang di-checkout harus ada di keranjang
if (!isset($_SESSION["keranjang"][$id_provider])) {
    echo "<script>alert('Produk tidak ada di keranjang'); location='keranjang.php';</script>";
    exit;
}

//ambil data produk untuk preview
$stmt = mysqli_prepare($koneksi, "SELECT * FROM proveder WHERE id_provider = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_provider);
mysqli_stmt_execute($stmt);
$produk = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

//menyimpan nomor handphone tujuan
if (isset($_POST['konfirmasi'])) {
    $no_telp = preg_replace('/[^0-9]/', '', $_POST['no_telp'] ?? '');
    //format nomor HP Indonesia: diawali 08 atau 628, panjang 10-13 digit
    if (!preg_match('/^(08|628)[0-9]{8,11}$/', $no_telp) || strlen($no_telp) > 13) {
        echo "<script>alert('Nomor handphone tidak valid. Gunakan format 08xxxxxxxxxx (10-13 digit)'); location='konfirmasi.php?id=$id_provider';</script>";
        exit;
    }
    $stmt = mysqli_prepare($koneksi, "INSERT INTO nohp (id_provider, no_telp) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, 'is', $id_provider, $no_telp);
    mysqli_stmt_execute($stmt);

    //simpan id nomor milik user ini di sesi
    $_SESSION['checkout'] = [
        'id_provider' => $id_provider,
        'id_nohp' => mysqli_insert_id($koneksi),
    ];
    header("location:checkout.php?id=$id_provider");
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

    <title>Isi Nomor Tujuan â€” QUICK.TOP</title>

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
            <div class="nav-name">Konfirmasi Nomor</div>
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
                    <a href="keranjang.php" class="btn-action detail mb-2" style="font-size: 13px;">
                        <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
                    </a>
                    <h1 class="page-title mt-2">
                        <i class="bi bi-telephone-plus-fill"></i> Masukkan Nomor Handphone Tujuan
                    </h1>
                    <p class="page-subtitle">Langkah 1 dari 2: Nomor tujuan yang akan diisi pulsa</p>
                </div>
            </div>

            <div class="glass-panel purchase-card">
                <?php if ($produk): ?>
                <div class="d-flex align-items-center gap-3 p-3 mb-4 rounded-3" style="background: var(--bg-card-sub); border: 1px solid var(--border-glass);">
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(34,197,94,0.1); display: flex; align-items: center; justify-content: center; padding: 4px;">
                        <img src="foto_produk/<?php echo e($produk['foto']); ?>" alt="" style="max-width: 100%; max-height: 100%;" onerror="this.src='https://placehold.co/80x50/0A3D1F/71E398?text=Pulsa'">
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--text-light); font-size: 15px;"><?php echo e($produk['nama_provider']); ?></div>
                        <div style="font-size: 13px; color: var(--teal); font-weight: 600;">Nominal: Rp <?php echo number_format($produk['nominal'], 0, ',', '.'); ?> &bull; Total: Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <form method="post" action="konfirmasi.php?id=<?php echo (int) $id_provider; ?>">
                    <div class="form-group-qt">
                        <label><i class="bi bi-phone me-1"></i> Nomor Handphone Tujuan</label>
                        <input type="text"
                               name="no_telp"
                               placeholder="Contoh: 081234567890"
                               required
                               maxlength="13"
                               pattern="^(08|628)[0-9]{8,11}$"
                               title="Nomor handphone harus diawali 08 atau 628 (10-13 digit angka)"
                               style="font-size: 17px; font-weight: 600; letter-spacing: 1px; font-family: monospace;">
                        <small style="color: var(--text-muted); font-size: 12px; margin-top: 6px; display: block;">
                            <i class="bi bi-info-circle me-1"></i> Format: Diawali <strong>08</strong> atau <strong>628</strong> dengan panjang 10-13 digit angka.
                        </small>
                    </div>

                    <div class="mt-4 pt-2">
                        <button type="submit" name="konfirmasi" class="btn-beli" style="padding: 14px; font-size: 15px;">
                            <i class="bi bi-arrow-right-circle me-1"></i> Lanjut ke Ringkasan Checkout
                        </button>
                    </div>
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


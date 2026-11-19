<?php
require_once __DIR__ . '/../sesi.php';
if (!isset($_SESSION['user'])) {
  header('location:../login.php');
  exit;
}

$pengguna = e($_SESSION['user']['nama']);
$inisial   = strtoupper(substr($pengguna, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard â€” QUICK.TOP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
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
      <div class="nav-name">Dashboard</div>
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
      <!-- Hero Banner -->
      <div class="garis">
        <div class="text_garis">
          <h1>Ayo beli pulsa di <span>QUICK.TOP!!</span></h1>
          <p>Mau beli pulsa yang murah dan terjangkau? Disinilah solusinya.<br>
             Dijamin prosesnya cepat, aman, terjangkau, dan terpercaya.</p>
        </div>
        <img src="logo/hp.png" alt="Pulsa" onerror="this.style.display='none'">
      </div>

      <!-- Section Title -->
      <div class="section-label">
        <i class="bi bi-grid-fill"></i> Pilih Produk Pulsa
      </div>

      <!-- Products -->
      <div class="row">
        <?php
          $ambil = $koneksi->query("SELECT * FROM proveder");
          while ($perproduk = $ambil->fetch_assoc()):
            $nama_enc = urlencode($perproduk['nama_provider']);
        ?>
        <div class="card">
          <div class="card-img-wrap">
            <img src="foto_produk/<?php echo e($perproduk['foto']); ?>"
                 class="card-img"
                 alt="<?php echo e($perproduk['nama_provider']); ?>"
                 onerror="this.src='https://placehold.co/120x80/0A3D1F/71E398?text=<?php echo $nama_enc; ?>'">
          </div>
          <div class="card-body">
            <h5 class="card-title"><?php echo e($perproduk['nama_provider']); ?></h5>
            <p class="card-text">Rp <?php echo number_format($perproduk['nominal'], 0, ',', '.'); ?></p>
            <a href="popup1.php?halaman=detail&id=<?php echo e($perproduk['id_provider']); ?>"
               class="btn-beli">
              <i class="bi bi-lightning-charge-fill"></i> Beli Sekarang
            </a>
          </div>
        </div>
        <?php endwhile; ?>
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


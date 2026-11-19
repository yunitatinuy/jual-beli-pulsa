<?php
require_once __DIR__ . '/../sesi.php';
if (!isset($_SESSION['user'])) {
  header('location:../login.php');
  exit;
}

//proses ganti password
if (isset($_POST['ganti_password'])) {
  $id_user = (int) $_SESSION['user']['id_user'];
  $password_lama = $_POST['password_lama'] ?? '';
  $password_baru = $_POST['password_baru'] ?? '';
  $password_baru2 = $_POST['password_baru2'] ?? '';

  $stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE id_user = ?");
  mysqli_stmt_bind_param($stmt, 'i', $id_user);
  mysqli_stmt_execute($stmt);
  $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

  if (!$row || !password_verify($password_lama, $row['password'])) {
    $pesan = 'Password lama salah!';
    $status_notif = 'error';
  } elseif ($password_baru === '' || $password_baru !== $password_baru2) {
    $pesan = 'Konfirmasi password baru tidak sesuai!';
    $status_notif = 'error';
  } else {
    $pass_acak = password_hash($password_baru, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($koneksi, "UPDATE user SET password = ? WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, 'si', $pass_acak, $id_user);
    mysqli_stmt_execute($stmt);
    $_SESSION['user']['password'] = $pass_acak;
    if (!empty($_COOKIE[COOKIE_INGAT])) {
      set_cookie_ingat($_SESSION['user']);
    }
    $pesan = 'Password berhasil diganti!';
    $status_notif = 'success';
  }
  echo "<script>alert(" . json_encode($pesan) . "); location='pengaturan.php';</script>";
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

  <title>Pengaturan Akun â€” QUICK.TOP</title>

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
      <li class="active">
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
  <!-- SIDEBAR END -->

  <!-- MAIN -->
  <section class="home">
    <!-- TOP BAR -->
    <div class="nav-top">
      <div class="nav-name">Pengaturan</div>
      <div class="nav-top-actions">
        <a href="keranjang.php" title="Keranjang">
          <i class="bi bi-cart2"></i>
        </a>
        <a href="profile.php" title="Profil">
          <i class="bi bi-person-circle"></i>
        </a>
      </div>
    </div>
    <!-- TOP BAR END -->

    <!-- CONTENT -->
    <div class="content">
      <div class="page-header">
        <div>
          <h1 class="page-title">
            <i class="bi bi-sliders"></i> Pengaturan Akun
          </h1>
          <p class="page-subtitle">Kelola informasi akun, keamanan password, dan bantuan layanan</p>
        </div>
      </div>

      <div class="row" style="display: flex !important; flex-direction: column; gap: 24px;">
        <div class="glass-panel" style="max-width: 680px;">
          <div class="settings-list">
            <!-- Profil -->
            <a href="profile.php" class="settings-card">
              <div class="settings-card-left">
                <div class="settings-icon-wrap">
                  <i class="bi bi-person-badge"></i>
                </div>
                <div class="settings-card-info">
                  <h4>Informasi Profil</h4>
                  <p>Ubah nama lengkap, username, dan alamat email Anda</p>
                </div>
              </div>
              <div class="settings-card-arrow">
                <i class="bi bi-chevron-right"></i>
              </div>
            </a>

            <!-- Ganti Password -->
            <a href="#popup2" class="settings-card">
              <div class="settings-card-left">
                <div class="settings-icon-wrap" style="background: rgba(251, 191, 36, 0.15); color: var(--amber);">
                  <i class="bi bi-shield-lock"></i>
                </div>
                <div class="settings-card-info">
                  <h4>Keamanan & Sandi</h4>
                  <p>Perbarui password akun Anda secara berkala agar tetap aman</p>
                </div>
              </div>
              <div class="settings-card-arrow">
                <i class="bi bi-chevron-right"></i>
              </div>
            </a>

            <!-- Bantuan -->
            <a href="tentang_kami.php" class="settings-card">
              <div class="settings-card-left">
                <div class="settings-icon-wrap" style="background: rgba(45, 212, 191, 0.15); color: var(--teal);">
                  <i class="bi bi-question-diamond"></i>
                </div>
                <div class="settings-card-info">
                  <h4>Pusat Bantuan & Tim</h4>
                  <p>Informasi tentang QUICK.TOP, tim pengembang, dan kontak kami</p>
                </div>
              </div>
              <div class="settings-card-arrow">
                <i class="bi bi-chevron-right"></i>
              </div>
            </a>

            <!-- Keluar -->
            <a href="../logout.php" class="settings-card" style="border-color: rgba(248, 113, 113, 0.2);">
              <div class="settings-card-left">
                <div class="settings-icon-wrap" style="background: rgba(248, 113, 113, 0.15); color: var(--red);">
                  <i class="bi bi-box-arrow-right"></i>
                </div>
                <div class="settings-card-info">
                  <h4 style="color: var(--red);">Keluar dari Akun</h4>
                  <p>Akhiri sesi masuk Anda di perangkat ini</p>
                </div>
              </div>
              <div class="settings-card-arrow" style="color: var(--red);">
                <i class="bi bi-chevron-right"></i>
              </div>
            </a>
          </div>
        </div>
      </div>

      <!-- POPUP GANTI PASSWORD -->
      <div class="popup2" id="popup2">
        <form class="popup2_content" action="pengaturan.php" method="post">
          <a href="#" class="popup2_close" title="Tutup">&times;</a>
          <span class="product"><i class="bi bi-key-fill text-warning me-2"></i> Ganti Password</span>
          <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">
            Pastikan password baru Anda kuat dan belum pernah dipakai sebelumnya.
          </p>

          <div class="popup2-field">
            <label><i class="bi bi-lock me-1"></i> Password Saat Ini</label>
            <input type="password" name="password_lama" placeholder="Ketik password lama Anda" required autocomplete="current-password">
          </div>

          <div class="popup2-field">
            <label><i class="bi bi-shield-check me-1"></i> Password Baru</label>
            <input type="password" name="password_baru" placeholder="Ketik password baru" required autocomplete="new-password">
          </div>

          <div class="popup2-field">
            <label><i class="bi bi-shield-fill-check me-1"></i> Konfirmasi Password Baru</label>
            <input type="password" name="password_baru2" placeholder="Ulangi password baru" required autocomplete="new-password">
          </div>

          <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="#" class="btn-action" style="flex: 1; text-align: center; justify-content: center; background: rgba(255,255,255,0.08); color: var(--text-light);">
              Batal
            </a>
            <button type="submit" name="ganti_password" class="btn-beli" style="flex: 2; margin: 0;">
              <i class="bi bi-check2-circle"></i> Simpan Password
            </button>
          </div>
        </form>
      </div>
      <!-- POPUP GANTI PASSWORD END -->

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


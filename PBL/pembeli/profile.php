<?php
require_once __DIR__ . '/../sesi.php';
wajib_login();

$id_user = (int) $_SESSION['user']['id_user'];

//menyimpan perubahan profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = trim($_POST['nama'] ?? '');
  $username = trim($_POST['username'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $password2 = $_POST['password2'] ?? '';
  $pesan = '';

  if ($nama === '' || $username === '') {
    $pesan = 'Nama dan username wajib diisi';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $pesan = 'Format email tidak valid';
  } elseif ($password !== $password2) {
    $pesan = 'Konfirmasi password tidak sesuai';
  } else {
    //username tidak boleh dipakai user lain
    $stmt = mysqli_prepare($koneksi, "SELECT id_user FROM user WHERE username = ? AND id_user <> ?");
    mysqli_stmt_bind_param($stmt, 'si', $username, $id_user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
      $pesan = 'Username telah terdaftar, Coba yang lain!';
    }
  }

  if ($pesan === '') {
    if ($password !== '') {
      $pass_acak = password_hash($password, PASSWORD_DEFAULT);
      $stmt = mysqli_prepare($koneksi, "UPDATE user SET nama = ?, username = ?, email = ?, password = ? WHERE id_user = ?");
      mysqli_stmt_bind_param($stmt, 'ssssi', $nama, $username, $email, $pass_acak, $id_user);
    } else {
      $stmt = mysqli_prepare($koneksi, "UPDATE user SET nama = ?, username = ?, email = ? WHERE id_user = ?");
      mysqli_stmt_bind_param($stmt, 'sssi', $nama, $username, $email, $id_user);
    }
    mysqli_stmt_execute($stmt);

    //perbarui data sesi
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id_user);
    mysqli_stmt_execute($stmt);
    $_SESSION['user'] = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if ($password !== '' && !empty($_COOKIE[COOKIE_INGAT])) {
      set_cookie_ingat($_SESSION['user']);
    }
    $pesan = 'Profil berhasil disimpan';
  }
  echo "<script>alert(" . json_encode($pesan) . "); location='profile.php';</script>";
  exit;
}

$data_user = $_SESSION['user'];
$pengguna  = e($data_user['nama']);
$inisial   = strtoupper(substr($pengguna, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Profil Saya â€” QUICK.TOP</title>

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
  <!-- SIDEBAR END -->

  <!-- MAIN -->
  <section class="home">
    <!-- TOP BAR -->
    <div class="nav-top">
      <div class="nav-name">Profil Saya</div>
      <div class="nav-top-actions">
        <a href="keranjang.php" title="Keranjang">
          <i class="bi bi-cart2"></i>
        </a>
        <a href="profile.php" title="Profil" style="color: var(--green); border-color: var(--green); background: rgba(34,197,94,0.12);">
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
            <i class="bi bi-person-circle"></i> Edit Informasi Profil
          </h1>
          <p class="page-subtitle">Perbarui data diri akun Anda untuk kenyamanan transaksi</p>
        </div>
      </div>

      <div class="glass-panel" style="max-width: 620px;">
        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom: 1px solid var(--border-glass);">
          <div class="avatar" style="width: 60px; height: 60px; font-size: 24px; border-radius: 50%; background: linear-gradient(135deg, var(--green), var(--teal)); display: flex; align-items: center; justify-content: center; font-weight: 700; color: #052E16;">
            <?php echo $inisial; ?>
          </div>
          <div>
            <h4 style="font-size: 18px; font-weight: 700; color: var(--text-light); margin: 0;"><?php echo $pengguna; ?></h4>
            <span class="status-badge hijau mt-1">
              <i class="bi bi-check-circle-fill"></i> Akun Pembeli Aktif
            </span>
          </div>
        </div>

        <form action="profile.php" method="post">
          <div class="form-group-qt">
            <label><i class="bi bi-person me-1"></i> Nama Lengkap</label>
            <input type="text" name="nama" value="<?php echo e($data_user['nama']); ?>" required placeholder="Nama lengkap Anda">
          </div>

          <div class="form-group-qt">
            <label><i class="bi bi-at me-1"></i> Username</label>
            <input type="text" name="username" value="<?php echo e($data_user['username']); ?>" required placeholder="Username Anda">
          </div>

          <div class="form-group-qt">
            <label><i class="bi bi-envelope me-1"></i> Alamat Email</label>
            <input type="email" name="email" value="<?php echo e($data_user['email']); ?>" required placeholder="nama@email.com">
          </div>

          <div class="form-group-qt">
            <label><i class="bi bi-lock me-1"></i> Password Baru <small style="color: var(--text-muted); font-weight: normal;">(Kosongkan jika tidak ingin mengubah)</small></label>
            <input type="password" name="password" placeholder="Masukkan password baru" autocomplete="new-password">
          </div>

          <div class="form-group-qt">
            <label><i class="bi bi-shield-lock me-1"></i> Konfirmasi Password Baru</label>
            <input type="password" name="password2" placeholder="Ulangi password baru" autocomplete="new-password">
          </div>

          <div style="display: flex; gap: 12px; margin-top: 24px; flex-wrap: wrap;">
            <button type="submit" class="btn-beli" style="flex: 2; min-width: 160px; padding: 13px;">
              <i class="bi bi-check2-circle"></i> Simpan Perubahan
            </button>
            <a href="pengaturan.php" class="btn-action" style="flex: 1; min-width: 140px; justify-content: center; background: rgba(255,255,255,0.06); color: var(--text-light);">
              Kembali
            </a>
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


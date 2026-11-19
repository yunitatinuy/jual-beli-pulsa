<?php
require_once __DIR__ . '/cek_admin.php';
require_once __DIR__ . '/../midtrans.php';
$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));
$active_menu = 'dashboard';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard Admin — QUICK.TOP</title>

  <!-- CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">

  <script src="theme.js?v=<?php echo time(); ?>"></script>
</head>
<body>

  <!-- SIDEBAR -->
  <section class="sidebar" id="sidebar">
    <div class="nav-header">
      <div class="brand-icon">&#9889;</div>
      <span class="logo">QUICK.TOP <small style="font-size:10px; background:rgba(34,197,94,0.2); padding:2px 6px; border-radius:6px; color:var(--green); margin-left:4px;">ADMIN</small></span>
      <button class="btn-menu" onclick="toggleSidebar()" aria-label="Menu">
        <i class="bx bx-menu-alt-right" id="menuIcon"></i>
      </button>
    </div>

    <div class="sidebar-user">
      <div class="avatar"><?php echo $inisial; ?></div>
      <div class="user-info">
        <div class="user-name"><?php echo $pengguna; ?></div>
        <div class="user-role">Administrator</div>
      </div>
    </div>

    <ul class="nav-links">
      <li class="<?php echo ($active_menu == 'dashboard' ? 'active' : ''); ?>">
        <a href="dashboard.php">
          <i class="bi bi-speedometer2"></i>
          <span class="title">Dashboard</span>
        </a>
        <span class="nav-tooltip">Dashboard</span>
      </li>
      <li class="<?php echo ($active_menu == 'kategori' ? 'active' : ''); ?>">
        <a href="index.php">
          <i class="bi bi-tags-fill"></i>
          <span class="title">Daftar Kategori</span>
        </a>
        <span class="nav-tooltip">Daftar Kategori</span>
      </li>
      <li class="<?php echo ($active_menu == 'provider' ? 'active' : ''); ?>">
        <a href="provider.php">
          <i class="bi bi-sim-fill"></i>
          <span class="title">Daftar Provider</span>
        </a>
        <span class="nav-tooltip">Daftar Provider</span>
      </li>
      <li class="<?php echo ($active_menu == 'user' ? 'active' : ''); ?>">
        <a href="user.php">
          <i class="bi bi-people-fill"></i>
          <span class="title">Daftar Pengguna</span>
        </a>
        <span class="nav-tooltip">Daftar Pengguna</span>
      </li>
      <li class="<?php echo ($active_menu == 'transaksi' ? 'active' : ''); ?>">
        <a href="transaksi.php">
          <i class="bi bi-receipt"></i>
          <span class="title">Daftar Transaksi</span>
        </a>
        <span class="nav-tooltip">Daftar Transaksi</span>
      </li>
    </ul>

    <!-- THEME RADIAL DOCK -->
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
      <a href="logout.php">
        <i class="bi bi-box-arrow-right"></i>
        <span class="title">Keluar</span>
      </a>
    </div>
  </section>

  <!-- MAIN -->
  <section class="home">
    <!-- TOP BAR -->
    <div class="nav-top">
      <div class="nav-name">
        <i class="bi bi-speedometer2"></i> Dashboard Admin
      </div>
      <div class="nav-top-actions">
        <a href="../pembeli/dashboard.php" title="Buka Toko / Tampilan Pembeli" target="_blank">
          <i class="bi bi-shop"></i> <span>Lihat Toko</span>
        </a>
        <a href="logout.php" title="Logout" style="color:var(--red);">
          <i class="bi bi-box-arrow-right"></i> <span>Keluar</span>
        </a>
      </div>
    </div>

    <!-- CONTENT -->
    <div class="content">

      <?php
      include 'koneksi.php';
      // Ringkasan angka untuk kartu dashboard
      $ringkas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT
          (SELECT COUNT(*) FROM transaksi_penjualan WHERE status_bayar = 'dibayar') AS transaksi_lunas,
          (SELECT COALESCE(SUM(total_pembelian), 0) FROM transaksi_penjualan WHERE status_bayar = 'dibayar') AS pendapatan,
          (SELECT COUNT(*) FROM transaksi_penjualan WHERE status_bayar = 'menunggu') AS menunggu,
          (SELECT COUNT(*) FROM user WHERE role = 0) AS pembeli,
          (SELECT COUNT(*) FROM proveder) AS produk"));
      ?>

      <!-- STATS CARDS -->
      <div class="stats-grid animate-fade-up">
        <div class="kartu-ringkasan kartu-amber delay-1">
          <div>
            <div class="icon-wrap"><i class="bi bi-wallet2"></i></div>
            <div class="judul">Total Pendapatan</div>
            <div class="angka">Rp <?php echo number_format($ringkas['pendapatan'], 0, ',', '.'); ?></div>
          </div>
          <small style="color:var(--text-muted); font-size:11.5px; margin-top:8px;">
            <i class="bi bi-check-circle-fill text-success me-1"></i> Dari transaksi lunas
          </small>
        </div>

        <div class="kartu-ringkasan kartu-hijau delay-2">
          <div>
            <div class="icon-wrap"><i class="bi bi-check2-circle"></i></div>
            <div class="judul">Transaksi Lunas</div>
            <div class="angka"><?php echo (int) $ringkas['transaksi_lunas']; ?></div>
          </div>
          <a href="transaksi.php" style="color:var(--green); font-size:12px; font-weight:600; margin-top:8px;">
            Lihat semua transaksi &raquo;
          </a>
        </div>

        <div class="kartu-ringkasan kartu-teal delay-3">
          <div>
            <div class="icon-wrap"><i class="bi bi-hourglass-split"></i></div>
            <div class="judul">Menunggu Bayar</div>
            <div class="angka"><?php echo (int) $ringkas['menunggu']; ?></div>
          </div>
          <small style="color:var(--text-muted); font-size:11.5px; margin-top:8px;">
            <i class="bi bi-clock-history me-1"></i> Belum dibayar pembeli
          </small>
        </div>

        <div class="kartu-ringkasan kartu-purple delay-4">
          <div>
            <div class="icon-wrap"><i class="bi bi-people-fill"></i></div>
            <div class="judul">Pengguna & Produk</div>
            <div class="angka"><?php echo (int) $ringkas['pembeli']; ?> <span style="font-size:16px; font-weight:500; color:var(--text-muted);">/ <?php echo (int) $ringkas['produk']; ?></span></div>
          </div>
          <small style="color:var(--text-muted); font-size:11.5px; margin-top:8px;">
            Pengguna aktif / total provider
          </small>
        </div>
      </div>

      <!-- DAFTAR KATEGORI TABLE -->
      <div class="glass-panel animate-fade-up delay-2">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <h4 style="font-size:18px; font-weight:700; color:var(--text-light); margin:0;">
            <i class="bi bi-tags-fill text-success me-2"></i> Daftar Kategori
          </h4>
          <a href="index.php" class="btn-action edit" style="padding:6px 16px;">
            Kelola Kategori &raquo;
          </a>
        </div>
        <div class="table-responsive-custom">
          <table class="table-modern">
            <thead>
              <tr>
                <th style="width:70px;">NO</th>
                <th>ID KATEGORI</th>
                <th>NAMA KATEGORI</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = mysqli_query($koneksi, "SELECT * FROM kategori LIMIT 5");
              $no = 1;
              while ($data = mysqli_fetch_assoc($query)) {
              ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><code><?php echo e($data['id_kategori']); ?></code></td>
                  <td><strong><?php echo e($data['nama_kategori']); ?></strong></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- DAFTAR PROVIDER TABLE -->
      <div class="glass-panel animate-fade-up delay-3">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <h4 style="font-size:18px; font-weight:700; color:var(--text-light); margin:0;">
            <i class="bi bi-sim-fill text-teal me-2"></i> Daftar Provider & Produk
          </h4>
          <a href="provider.php" class="btn-action edit" style="padding:6px 16px;">
            Kelola Provider &raquo;
          </a>
        </div>
        <div class="table-responsive-custom">
          <table class="table-modern">
            <thead>
              <tr>
                <th style="width:70px;">NO</th>
                <th>KATEGORI</th>
                <th>NAMA PROVIDER</th>
                <th>DETAIL</th>
                <th>NOMINAL</th>
                <th>HARGA</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $query = mysqli_query($koneksi, "SELECT * FROM proveder
                      INNER JOIN kategori ON proveder.id_kategori = kategori.id_kategori LIMIT 5");
              while ($data = mysqli_fetch_array($query)) {
              ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><span class="badge" style="background:rgba(34,197,94,0.15); color:var(--green);"><?php echo e($data['nama_kategori']); ?></span></td>
                  <td><strong><?php echo e($data['nama_provider']); ?></strong></td>
                  <td><small style="color:var(--text-muted);"><?php echo e($data['detail']); ?></small></td>
                  <td>Rp <?php echo number_format($data['nominal'], 0, ',', '.'); ?></td>
                  <td><strong style="color:var(--green);">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></strong></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- DAFTAR TRANSAKSI TABLE -->
      <div class="glass-panel animate-fade-up delay-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <h4 style="font-size:18px; font-weight:700; color:var(--text-light); margin:0;">
            <i class="bi bi-receipt text-warning me-2"></i> Transaksi Terakhir
          </h4>
          <a href="transaksi.php" class="btn-action edit" style="padding:6px 16px;">
            Semua Transaksi &raquo;
          </a>
        </div>
        <div class="table-responsive-custom">
          <table class="table-modern">
            <thead>
              <tr>
                <th>ID</th>
                <th>PENGGUNA</th>
                <th>NO HP</th>
                <th>METODE</th>
                <th>TANGGAL</th>
                <th>TOTAL</th>
                <th>STATUS</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = mysqli_query($koneksi, "SELECT * FROM transaksi_penjualan
              INNER JOIN user ON transaksi_penjualan.id_user = user.id_user
              INNER JOIN nohp ON transaksi_penjualan.id_nohp = nohp.id_nohp
              LEFT JOIN metode_bayar ON transaksi_penjualan.id_metode_bayar = metode_bayar.id_metode_bayar
              ORDER BY transaksi_penjualan.id_transaksi_penjualan DESC LIMIT 5");
              while ($data = mysqli_fetch_assoc($query)) {
                $warna_badge = ['hijau' => 'lunas', 'kuning' => 'menunggu', 'merah' => 'batal', 'abu' => 'menunggu'];
                $lb = label_status_bayar($data['status_bayar']);
              ?>
                <tr>
                  <td><code>#<?php echo e($data['id_transaksi_penjualan']); ?></code></td>
                  <td><strong><?php echo e($data['nama']); ?></strong></td>
                  <td><?php echo e($data['no_telp']); ?></td>
                  <td><small><?php echo e($data['metode_pembayaran'] ?: ($data['jenis'] ?: '-')); ?></small></td>
                  <td><small style="color:var(--text-muted);"><?php echo e($data['tanggal_pembelian']); ?></small></td>
                  <td><strong>Rp <?php echo number_format($data['total_pembelian'], 0, ',', '.'); ?></strong></td>
                  <td>
                    <span class="status-badge <?php echo $warna_badge[$lb[1]]; ?>">
                      <?php echo e($lb[0]); ?>
                    </span>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>

  <!-- SCRIPTS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>

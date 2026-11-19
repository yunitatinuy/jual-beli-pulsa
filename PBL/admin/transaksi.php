<?php
require_once __DIR__ . '/cek_admin.php';
require_once __DIR__ . '/../midtrans.php';
$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));
$active_menu = 'transaksi';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daftar Transaksi — Admin QUICK.TOP</title>

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
        <i class="bi bi-receipt"></i> Riwayat & Daftar Transaksi Penjualan
      </div>
      <div class="nav-top-actions">
        <input type="search" id="tableSearchInput" placeholder="Cari transaksi / no hp..." class="form-control" style="width:230px; height:38px; background:var(--input-bg); border:1px solid var(--border-glass); color:var(--text-light); border-radius:10px;">
        <a href="../pembeli/dashboard.php" title="Buka Toko / Tampilan Pembeli" target="_blank">
          <i class="bi bi-shop"></i> <span>Toko</span>
        </a>
      </div>
    </div>

    <!-- CONTENT -->
    <div class="content">

      <div class="glass-panel animate-fade-up">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
          <div>
            <h3 style="font-size:20px; font-weight:800; color:var(--text-light); margin:0;">
              <i class="bi bi-clock-history text-success me-2"></i> Rekap Seluruh Transaksi Pembelian
            </h3>
            <p style="color:var(--text-muted); font-size:13px; margin:4px 0 0;">
              Pantau status verifikasi pembayaran Midtrans, nomor seri pulsa, dan detail pesanan.
            </p>
          </div>
        </div>

        <div class="table-responsive-custom">
          <table class="table-modern">
            <thead>
              <tr>
                <th style="width:60px;">NO</th>
                <th>ID</th>
                <th>PENGGUNA</th>
                <th>NO TUJUAN</th>
                <th>PRODUK</th>
                <th>METODE BAYAR</th>
                <th>TANGGAL</th>
                <th>TOTAL</th>
                <th style="width:140px; text-align:center;">STATUS</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include 'koneksi.php';

              $query = mysqli_query($koneksi, "SELECT *,
                (SELECT GROUP_CONCAT(CONCAT(CONVERT(p.nama_provider USING utf8mb4), ' Rp', FORMAT(p.nominal, 0, 'id_ID')) SEPARATOR ', ')
                   FROM transaksi t JOIN proveder p ON t.id_provider = p.id_provider
                  WHERE t.id_transaksi_penjualan = transaksi_penjualan.id_transaksi_penjualan) AS produk
              FROM transaksi_penjualan
              INNER JOIN user ON transaksi_penjualan.id_user = user.id_user
              INNER JOIN nohp ON transaksi_penjualan.id_nohp = nohp.id_nohp
              LEFT JOIN metode_bayar ON transaksi_penjualan.id_metode_bayar = metode_bayar.id_metode_bayar
              ORDER BY transaksi_penjualan.id_transaksi_penjualan DESC");
              
              $warna_badge = ['hijau' => 'lunas', 'kuning' => 'menunggu', 'merah' => 'batal', 'abu' => 'menunggu'];
              $no = 1;
              while ($data = mysqli_fetch_assoc($query)) {
                $lb = label_status_bayar($data['status_bayar']);
              ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><code>#<?php echo e($data['id_transaksi_penjualan']); ?></code></td>
                  <td><strong><?php echo e($data['nama']); ?></strong></td>
                  <td><code><?php echo e($data['no_telp']); ?></code></td>
                  <td><small style="color:var(--teal); font-weight:600;"><?php echo e($data['produk'] ?: '-'); ?></small></td>
                  <td><span class="badge" style="background:var(--bg-card-sub); color:var(--text-muted); border:1px solid var(--border-glass);"><?php echo e($data['metode_pembayaran'] ?: ($data['jenis'] ?: '-')); ?></span></td>
                  <td><small style="color:var(--text-muted);"><?php echo e($data['tanggal_pembelian']); ?></small></td>
                  <td><strong style="color:var(--text-light);">Rp <?php echo number_format($data['total_pembelian'], 0, ',', '.'); ?></strong></td>
                  <td style="text-align:center;">
                    <span class="status-badge <?php echo $warna_badge[$lb[1]]; ?>">
                      <?php echo e($lb[0]); ?>
                    </span>
                    <?php if ($data['status_bayar'] === 'dibayar') {
                      $lp = label_status_pulsa($data['status_pulsa'], $data['status_bayar']); ?>
                      <div class="mt-1">
                        <span class="badge" style="background:rgba(34,197,94,0.14); color:var(--green); font-size:11px;">
                          <?php echo e($lp[0]); ?>
                        </span>
                      </div>
                      <?php if (!empty($data['sn'])) { ?>
                        <div class="mt-1"><small style="font-size:10px; color:var(--text-muted);">SN: <?php echo e($data['sn']); ?></small></div>
                      <?php } ?>
                    <?php } ?>
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

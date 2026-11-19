<?php
require_once __DIR__ . '/../sesi.php';
require_once __DIR__ . '/../midtrans.php';
if (!isset($_SESSION['user'])) {
  header('location:../login.php');
  exit;
}

$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));

// perbarui status transaksi yang masih menunggu pembayaran
$id_user_sync = (int) $_SESSION['user']['id_user'];
$menunggu = mysqli_query($koneksi, "SELECT * FROM transaksi_penjualan WHERE id_user=$id_user_sync AND status_bayar='menunggu' ORDER BY id_transaksi_penjualan DESC LIMIT 5");
while ($trx_menunggu = mysqli_fetch_assoc($menunggu)) {
  sinkronkan_status_transaksi($koneksi, $trx_menunggu);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Riwayat Transaksi â€” QUICK.TOP</title>

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
          <span class="title">Dashboard</span>
        </a>
        <span class="nav-tooltip">Dashboard</span>
      </li>
      <li class="active">
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
      <div class="nav-name">Riwayat Transaksi</div>
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
            <i class="bi bi-clock-history"></i> Riwayat Pembelian Pulsa
          </h1>
          <p class="page-subtitle">Pantau seluruh status pesanan dan transaksi Anda di sini</p>
        </div>
        <div>
          <a href="dashboard.php" class="btn-beli" style="width: auto; padding: 10px 20px;">
            <i class="bi bi-plus-circle-fill"></i> Beli Pulsa Baru
          </a>
        </div>
      </div>

      <div class="glass-panel">
        <div class="custom-table-container">
          <table class="custom-table">
            <thead>
              <tr>
                <th style="width: 50px; text-align: center;">No</th>
                <th>Nomor Handphone</th>
                <th>Tanggal Transaksi</th>
                <th>Total Pembayaran</th>
                <th>Status Pembayaran</th>
                <th style="text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $id_user = (int) $_SESSION['user']['id_user'];
              $query = mysqli_query($koneksi, "SELECT * FROM transaksi_penjualan INNER JOIN nohp ON transaksi_penjualan.id_nohp = nohp.id_nohp
                WHERE id_user=$id_user ORDER BY id_transaksi_penjualan DESC");

              if (mysqli_num_rows($query) === 0):
              ?>
              <tr>
                <td colspan="6" style="text-align: center; padding: 48px 20px;">
                  <i class="bi bi-receipt" style="font-size: 48px; color: var(--text-muted); opacity: 0.5; display: block; margin-bottom: 12px;"></i>
                  <p style="font-weight: 600; color: var(--text-light); margin-bottom: 4px;">Belum Ada Riwayat Transaksi</p>
                  <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 16px;">Anda belum melakukan pembelian pulsa sama sekali.</p>
                  <a href="dashboard.php" class="btn-beli" style="display: inline-flex !important; width: auto; padding: 8px 18px;">
                    Mulai Belanja Sekarang
                  </a>
                </td>
              </tr>
              <?php
              else:
                while ($data = mysqli_fetch_assoc($query)):
                  $lb = label_status_bayar($data['status_bayar']);
              ?>
              <tr>
                <td style="text-align: center; color: var(--text-muted); font-weight: 600;"><?php echo $no++; ?></td>
                <td>
                  <span style="font-weight: 600; font-family: monospace; font-size: 15px; color: var(--text-light);">
                    <i class="bi bi-phone me-1" style="color: var(--green);"></i><?php echo e($data['no_telp']); ?>
                  </span>
                </td>
                <td style="color: var(--text-muted); font-size: 13px;">
                  <i class="bi bi-calendar3 me-1"></i><?php echo e($data['tanggal_pembelian']); ?>
                </td>
                <td>
                  <strong style="color: var(--teal); font-size: 15px;">
                    Rp <?php echo number_format($data['total_pembelian'], 0, ',', '.'); ?>
                  </strong>
                </td>
                <td>
                  <span class="status-badge <?php echo $lb[1]; ?>">
                    <i class="bi bi-check-circle-fill"></i> <?php echo e($lb[0]); ?>
                  </span>
                  <?php if ($data['status_bayar'] === 'dibayar'):
                    $lp = label_status_pulsa($data['status_pulsa'], $data['status_bayar']); ?>
                    <br><span class="status-badge <?php echo $lp[1]; ?> mt-1">
                      <i class="bi bi-broadcast"></i> <?php echo e($lp[0]); ?>
                    </span>
                  <?php endif; ?>
                </td>
                <td style="text-align: center;">
                  <div class="btn-action-group">
                    <?php if ($data['status_bayar'] === 'menunggu'): ?>
                      <a href="pembayaran.php?id=<?php echo (int) $data['id_transaksi_penjualan']; ?>" class="btn-action pay" title="Bayar Sekarang">
                        <i class="bi bi-credit-card"></i> Bayar
                      </a>
                    <?php endif; ?>
                    <a href="nota.php?id=<?php echo (int) $data['id_transaksi_penjualan']; ?>" class="btn-action detail" title="Lihat Invoice">
                      <i class="bi bi-file-earmark-text"></i> Detail
                    </a>
                    <a href="cetak.php?id=<?php echo (int) $data['id_transaksi_penjualan']; ?>" target="_blank" class="btn-action print" title="Cetak PDF / Struk">
                      <i class="bi bi-printer"></i> Cetak
                    </a>
                  </div>
                </td>
              </tr>
              <?php
                endwhile;
              endif;
              ?>
            </tbody>
          </table>
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


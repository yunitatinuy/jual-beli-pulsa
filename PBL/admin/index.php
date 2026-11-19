<?php
require_once __DIR__ . '/cek_admin.php';
$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));
$active_menu = 'kategori';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daftar Kategori — Admin QUICK.TOP</title>

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
        <i class="bi bi-tags-fill"></i> Daftar Kategori
      </div>
      <div class="nav-top-actions">
        <input type="search" id="tableSearchInput" placeholder="Cari kategori..." class="form-control" style="width:200px; height:38px; background:var(--input-bg); border:1px solid var(--border-glass); color:var(--text-light); border-radius:10px;">
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
              <i class="bi bi-tags text-success me-2"></i> Manajemen Kategori Produk
            </h3>
            <p style="color:var(--text-muted); font-size:13px; margin:4px 0 0;">
              Kelola kategori voucher, pulsa, dan paket data pada aplikasi.
            </p>
          </div>
          <button type="button" class="btn-primary-custom" data-toggle="modal" data-target="#tambahktg">
            <i class="bi bi-plus-circle-fill"></i> Tambah Kategori
          </button>
        </div>

        <div class="table-responsive-custom">
          <table class="table-modern">
            <thead>
              <tr>
                <th style="width:70px;">NO</th>
                <th>ID KATEGORI</th>
                <th>NAMA KATEGORI</th>
                <th style="width:180px; text-align:center;">AKSI</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include 'koneksi.php';
              $query = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id_kategori ASC");
              $modal_html = '';
              $no = 1;
              while ($data = mysqli_fetch_assoc($query)) {
              ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><code><?php echo e($data['id_kategori']); ?></code></td>
                  <td><strong><?php echo e($data['nama_kategori']); ?></strong></td>
                  <td style="text-align:center;">
                    <button type="button" class="btn-action edit" data-toggle="modal" data-target="#editktg<?php echo e($data['id_kategori']); ?>">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button type="button" class="btn-action danger" data-toggle="modal" data-target="#deletektg<?php echo e($data['id_kategori']); ?>">
                      <i class="bi bi-trash"></i> Hapus
                    </button>
                  </td>
                </tr>

                <?php ob_start(); ?>
                <!-- Modal Edit Kategori -->
                <div class="modal fade" id="editktg<?php echo e($data['id_kategori']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-pencil-square text-teal me-2"></i> Edit Data Kategori</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" style="background:none; border:none; font-size:24px;">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="update_ktg.php" method="post">
                        <div class="modal-body">
                          <?php
                          $id_kategori = $data['id_kategori'];
                          $query1 = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori=" . (int) $id_kategori);
                          while ($data1 = mysqli_fetch_assoc($query1)) {
                          ?>
                            <div class="form-group-qt">
                              <label>ID Kategori</label>
                              <input type="text" name="id_kategori" value="<?php echo e($data1['id_kategori']); ?>" readonly>
                            </div>
                            <div class="form-group-qt">
                              <label>Nama Kategori</label>
                              <input type="text" name="nama_kategori" required value="<?php echo e($data1['nama_kategori']); ?>">
                            </div>
                          <?php } ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn-action" data-dismiss="modal">Batal</button>
                          <button type="submit" name="submit" class="btn-primary-custom">Simpan Perubahan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Modal Delete Kategori -->
                <div class="modal fade" id="deletektg<?php echo e($data['id_kategori']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" style="background:none; border:none; font-size:24px;">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body text-center py-4">
                        <p style="font-size:15px; margin:0;">
                          Apakah Anda yakin ingin menghapus kategori <strong>"<?php echo e($data['nama_kategori']); ?>"</strong>?
                        </p>
                        <small style="color:var(--red); font-size:12px;">Tindakan ini tidak dapat dibatalkan.</small>
                      </div>
                      <div class="modal-footer justify-content-center">
                        <button type="button" class="btn-action" data-dismiss="modal">Batal</button>
                        <a href="hapus_ktg.php?id_kategori=<?php echo e($data['id_kategori']); ?>" class="btn-action danger" style="padding:10px 24px;">
                          <i class="bi bi-trash"></i> Ya, Hapus
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                $modal_html .= ob_get_clean();
              }
              ?>
            </tbody>
          </table>
        </div>
        <?php echo $modal_html; ?>
      </div>

    </div>
  </section>

  <!-- Modal Tambah Kategori -->
  <div class="modal fade" id="tambahktg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-plus-circle text-success me-2"></i> Tambah Kategori Baru</h5>
          <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" style="background:none; border:none; font-size:24px;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="simpan_ktg.php" method="post">
          <div class="modal-body">
            <div class="form-group-qt">
              <label>Nama Kategori</label>
              <input type="text" name="nama_kategori" placeholder="Contoh: Paket Data, Pulsa Reguler" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-action" data-dismiss="modal">Batal</button>
            <button type="submit" name="submit" class="btn-primary-custom">Simpan Kategori</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- SCRIPTS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>

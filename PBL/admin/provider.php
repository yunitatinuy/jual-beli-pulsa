<?php
require_once __DIR__ . '/cek_admin.php';
$pengguna = e($_SESSION['user']["nama"]);
$inisial  = strtoupper(substr($pengguna, 0, 1));
$active_menu = 'provider';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daftar Provider — Admin QUICK.TOP</title>

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
        <i class="bi bi-sim-fill"></i> Daftar Provider & Produk Pulsa
      </div>
      <div class="nav-top-actions">
        <input type="search" id="tableSearchInput" placeholder="Cari provider / nominal..." class="form-control" style="width:220px; height:38px; background:var(--input-bg); border:1px solid var(--border-glass); color:var(--text-light); border-radius:10px;">
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
              <i class="bi bi-sim text-success me-2"></i> Katalog Provider & Nominal Pulsa
            </h3>
            <p style="color:var(--text-muted); font-size:13px; margin:4px 0 0;">
              Kelola daftar produk, nominal pulsa, harga beli, serta ikon provider.
            </p>
          </div>
          <button type="button" class="btn-primary-custom" data-toggle="modal" data-target="#tambahprv">
            <i class="bi bi-plus-circle-fill"></i> Tambah Provider
          </button>
        </div>

        <div class="table-responsive-custom">
          <table class="table-modern">
            <thead>
              <tr>
                <th style="width:60px;">NO</th>
                <th>KATEGORI</th>
                <th>NAMA PROVIDER</th>
                <th>DETAIL</th>
                <th>NOMINAL</th>
                <th>HARGA</th>
                <th>FOTO</th>
                <th style="width:170px; text-align:center;">AKSI</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include 'koneksi.php';
              $daftar_kategori = mysqli_fetch_all(mysqli_query($koneksi, "SELECT * FROM kategori"), MYSQLI_ASSOC);
              $modal_html = '';
              $no = 1;
              $query = mysqli_query($koneksi, "SELECT * FROM proveder
                      INNER JOIN kategori ON proveder.id_kategori = kategori.id_kategori ORDER BY proveder.id_provider ASC");
              while ($data = mysqli_fetch_array($query)) {
              ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><span class="badge" style="background:rgba(34,197,94,0.15); color:var(--green); font-size:12px;"><?php echo e($data['nama_kategori']); ?></span></td>
                  <td><strong><?php echo e($data['nama_provider']); ?></strong></td>
                  <td><small style="color:var(--text-muted);"><?php echo e($data['detail']); ?></small></td>
                  <td>Rp <?php echo number_format($data['nominal'], 0, ',', '.'); ?></td>
                  <td><strong style="color:var(--green);">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></strong></td>
                  <td>
                    <img src="../pembeli/foto_produk/<?php echo e($data['foto']); ?>" alt="<?php echo e($data['foto']); ?>" style="width:48px; height:48px; object-fit:contain; border-radius:10px; background:var(--bg-card-sub); padding:4px;" onerror="this.src='https://placehold.co/48x48/0A3D1F/71E398?text=SIM'">
                  </td>
                  <td style="text-align:center;">
                    <button type="button" class="btn-action edit" data-toggle="modal" data-target="#editprv<?php echo e($data['id_provider']); ?>">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button type="button" class="btn-action danger" data-toggle="modal" data-target="#deleteprv<?php echo e($data['id_provider']); ?>">
                      <i class="bi bi-trash"></i> Hapus
                    </button>
                  </td>
                </tr>

                <?php ob_start(); ?>
                <!-- Modal Edit Provider -->
                <div class="modal fade" id="editprv<?php echo e($data['id_provider']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-pencil-square text-teal me-2"></i> Edit Data Provider</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" style="background:none; border:none; font-size:24px;">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="update_prv.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                          <?php
                          $id_provider = $data['id_provider'];
                          $query1 = mysqli_query($koneksi, "SELECT * FROM proveder WHERE id_provider=" . (int) $id_provider);
                          while ($data1 = mysqli_fetch_assoc($query1)) {
                          ?>
                            <input type="hidden" name="id_provider" value="<?php echo e($data1['id_provider']); ?>">
                            
                            <div class="form-group-qt">
                              <label>Kategori</label>
                              <select name="id_kategori" required>
                                <?php foreach ($daftar_kategori as $ktg) { ?>
                                  <option value="<?php echo (int) $ktg['id_kategori']; ?>" <?php echo ((int) $ktg['id_kategori'] === (int) $data1['id_kategori']) ? 'selected' : ''; ?>>
                                    <?php echo e($ktg['nama_kategori']); ?>
                                  </option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="form-group-qt">
                              <label>Nama Provider</label>
                              <input type="text" name="nama_provider" required value="<?php echo e($data1['nama_provider']); ?>">
                            </div>

                            <div class="form-group-qt">
                              <label>Detail / Keterangan</label>
                              <input type="text" name="detail" required value="<?php echo e($data1['detail']); ?>">
                            </div>

                            <div class="form-row">
                              <div class="col-md-6 form-group-qt">
                                <label>Nominal (Rp)</label>
                                <input type="number" name="nominal" required value="<?php echo e($data1['nominal']); ?>">
                              </div>
                              <div class="col-md-6 form-group-qt">
                                <label>Harga Jual (Rp)</label>
                                <input type="number" name="harga" required value="<?php echo e($data1['harga']); ?>">
                              </div>
                            </div>

                            <div class="form-group-qt">
                              <label>Ganti Foto Produk (Opsional)</label>
                              <input type="file" name="foto" accept="image/*">
                              <small style="color:var(--text-muted); font-size:11.5px;">Biarkan kosong jika tidak ingin mengubah foto.</small>
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

                <!-- Modal Delete Provider -->
                <div class="modal fade" id="deleteprv<?php echo e($data['id_provider']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                          Yakin ingin menghapus provider <strong>"<?php echo e($data['nama_provider']); ?>" (Rp <?php echo number_format($data['nominal'], 0, ',', '.'); ?>)</strong>?
                        </p>
                        <small style="color:var(--red); font-size:12px;">Produk ini akan dihapus dari katalog pembeli.</small>
                      </div>
                      <div class="modal-footer justify-content-center">
                        <button type="button" class="btn-action" data-dismiss="modal">Batal</button>
                        <a href="hapus_prv.php?id_provider=<?php echo e($data['id_provider']); ?>" class="btn-action danger" style="padding:10px 24px;">
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

  <!-- Modal Tambah Provider -->
  <div class="modal fade" id="tambahprv" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-plus-circle text-success me-2"></i> Tambah Provider Baru</h5>
          <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" style="background:none; border:none; font-size:24px;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="simpan_prv.php" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group-qt">
              <label>Kategori</label>
              <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($daftar_kategori as $ktg) { ?>
                  <option value="<?php echo (int) $ktg['id_kategori']; ?>"><?php echo e($ktg['nama_kategori']); ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group-qt">
              <label>Nama Provider</label>
              <input type="text" name="nama_provider" placeholder="Contoh: Telkomsel, Indosat, XL" required>
            </div>

            <div class="form-group-qt">
              <label>Detail / Keterangan</label>
              <input type="text" name="detail" placeholder="Contoh: Masa aktif 30 hari" required>
            </div>

            <div class="form-row">
              <div class="col-md-6 form-group-qt">
                <label>Nominal Pulsa (Rp)</label>
                <input type="number" name="nominal" placeholder="Contoh: 50000" required>
              </div>
              <div class="col-md-6 form-group-qt">
                <label>Harga Jual (Rp)</label>
                <input type="number" name="harga" placeholder="Contoh: 51500" required>
              </div>
            </div>

            <div class="form-group-qt">
              <label>Foto / Logo Provider</label>
              <input type="file" name="foto" accept="image/*" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-action" data-dismiss="modal">Batal</button>
            <button type="submit" name="submit" class="btn-primary-custom">Simpan Provider</button>
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

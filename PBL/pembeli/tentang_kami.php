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

  <title>Tentang Kami — QUICK.TOP</title>

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
      <button class="btn-menu" onclick="toggleSidebar()" aria-label="Menu">
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
      <li class="active">
        <a href="tentang_kami.php">
          <i class="bi bi-question-circle-fill"></i>
          <span class="title">Tentang Kami</span>
        </a>
        <span class="nav-tooltip">Tentang Kami</span>
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
      <div class="nav-name">Tentang Kami</div>
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

      <!-- Hero About dengan animasi fade-up -->
      <div class="garis animate-fade-up">
        <div class="text_garis">
          <span class="badge-pill-accent mb-3">
            <i class="bi bi-mortarboard-fill"></i> PBL Informatika Politeknik Negeri Batam
          </span>
          <h1>Tentang <span>QUICK.TOP</span></h1>
          <p>
            Platform jual beli pulsa online karya mahasiswa Politeknik Negeri Batam yang mengedepankan kecepatan transaksi, integrasi payment gateway otomatis 24 jam, dan tampilan antarmuka yang modern serta nyaman.
          </p>
          <div class="d-flex gap-2 flex-wrap mt-3">
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(34,197,94,0.18); color: var(--green); border: 1px solid var(--border-glass);">
              <i class="bi bi-lightning-charge-fill me-1"></i> Transaksi Instan 24/7
            </span>
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(45,212,191,0.18); color: var(--teal); border: 1px solid var(--border-glass);">
              <i class="bi bi-shield-check me-1"></i> Terintegrasi Midtrans
            </span>
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(251,191,36,0.18); color: var(--amber); border: 1px solid var(--border-glass);">
              <i class="bi bi-people-fill me-1"></i> Tim D IF-Malam
            </span>
          </div>
        </div>
        <img src="../logoo.png" alt="QUICK.TOP Logo" class="logo-floating" style="width: 130px; border-radius: 50%; box-shadow: 0 12px 35px rgba(0,0,0,0.4);" onerror="this.src='logo/quicktop.png'">
      </div>

      <!-- Tentang Proyek Cards dengan animasi muncul bertahap -->
      <div class="row mb-4" style="display: grid !important; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important; gap: 20px !important;">
        <div class="glass-panel animate-fade-up delay-1">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(34,197,94,0.15); display: flex; align-items: center; justify-content: center; color: var(--green); font-size: 22px;">
              <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h4 style="font-size: 17px; font-weight: 700; margin: 0; color: var(--text-light);">Project Based Learning</h4>
          </div>
          <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.7; margin: 0;">
            Aplikasi ini dibangun sebagai pemenuhan tugas Project Based Learning (PBL) oleh Tim D kelas Informatika D Malam Politeknik Negeri Batam untuk menghadirkan solusi digital yang nyata.
          </p>
        </div>

        <div class="glass-panel animate-fade-up delay-2">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(45,212,191,0.15); display: flex; align-items: center; justify-content: center; color: var(--teal); font-size: 22px;">
              <i class="bi bi-clock-history"></i>
            </div>
            <h4 style="font-size: 17px; font-weight: 700; margin: 0; color: var(--text-light);">Layanan Fleksibel 24/7</h4>
          </div>
          <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.7; margin: 0;">
            Pengguna dapat mengisi pulsa di saat darurat tanpa perlu cemas konter fisik tutup. Layanan online kami siap melayani transaksi kapan pun Anda butuh secara instan.
          </p>
        </div>

        <div class="glass-panel animate-fade-up delay-3">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(251,191,36,0.15); display: flex; align-items: center; justify-content: center; color: var(--amber); font-size: 22px;">
              <i class="bi bi-shield-check"></i>
            </div>
            <h4 style="font-size: 17px; font-weight: 700; margin: 0; color: var(--text-light);">Mudah, Cepat & Aman</h4>
          </div>
          <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.7; margin: 0;">
            Dilengkapi integrasi payment gateway Midtrans Snap otomatis yang memastikan status pembayaran langsung terverifikasi seketika dan data transaksi Anda terlindungi.
          </p>
        </div>
      </div>

      <!-- Tim Pengembang dengan animasi muncul -->
      <div class="glass-panel mb-4 animate-fade-up delay-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
          <div>
            <h3 style="font-size: 21px; font-weight: 800; color: var(--text-light); margin: 0;">
              <i class="bi bi-people-fill text-success me-2"></i> Tim Pengembang
            </h3>
            <p style="color: var(--text-muted); font-size: 13.5px; margin: 4px 0 0;">
              Informatika D Malam — Politeknik Negeri Batam (PBL 2024)
            </p>
          </div>
          <span class="status-badge hijau">
            <i class="bi bi-stars"></i> Tim D PBL
          </span>
        </div>

        <!-- FRONTEND TEAM -->
        <div class="d-flex align-items-center gap-2 mb-3 mt-2">
          <div style="width: 28px; height: 28px; border-radius: 8px; background: rgba(45,212,191,0.15); display: flex; align-items: center; justify-content: center; color: var(--teal); font-size: 14px;">
            <i class="bi bi-laptop"></i>
          </div>
          <h5 style="font-size: 14px; font-weight: 700; color: var(--teal); letter-spacing: 0.6px; margin: 0;">
            FRONT-END DEVELOPER
          </h5>
        </div>

        <div class="team-grid mb-5" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
          
          <!-- Card 1: Firjatullah Anang -->
          <div class="team-card-modern animate-scale delay-5">
            <div class="team-avatar-frame">
              <img src="https://img.freepik.com/free-vector/young-businessman-showing-ok-sign-hand-drawn-cartoon-art-illustration_56104-1093.jpg?size=626" 
                   alt="Firjatullah Anang"
                   onerror="this.src='https://ui-avatars.com/api/?name=Firjatullah+Anang&background=15803d&color=fff&size=200&bold=true'">
            </div>
            <div class="team-name" style="font-size: 16px; font-weight: 800; color: var(--text-light); margin-bottom: 3px;">
              Firjatullah Anang
            </div>
            <div class="team-nim" style="font-size: 12.5px; color: var(--teal); font-weight: 600; margin-bottom: 8px;">
              NIM: 3312311111
            </div>
            <span class="team-role-tag" style="background: rgba(45,212,191,0.15); color: var(--teal); border: 1px solid rgba(45,212,191,0.3); font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px;">
              <i class="bi bi-star-fill me-1"></i> Frontend Lead
            </span>
          </div>

          <!-- Card 2: Nailah Dipa -->
          <div class="team-card-modern animate-scale delay-6">
            <div class="team-avatar-frame">
              <img src="https://img.freepik.com/premium-vector/muslim-woman-hijab-working-laptop-computer-showing-thumbs-up-flat-vector-illustration_852896-1429.jpg?size=626" 
                   alt="Nailah Dipa"
                   onerror="this.src='https://ui-avatars.com/api/?name=Nailah+Dipa&background=0d9488&color=fff&size=200&bold=true'">
            </div>
            <div class="team-name" style="font-size: 16px; font-weight: 800; color: var(--text-light); margin-bottom: 3px;">
              Nailah Dipa
            </div>
            <div class="team-nim" style="font-size: 12.5px; color: var(--teal); font-weight: 600; margin-bottom: 8px;">
              NIM: 3312311101
            </div>
            <span class="team-role-tag" style="background: rgba(168,85,247,0.15); color: #c084fc; border: 1px solid rgba(168,85,247,0.3); font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px;">
              <i class="bi bi-palette-fill me-1"></i> UI/UX Designer
            </span>
          </div>

          <!-- Card 3: Siti Zahwa -->
          <div class="team-card-modern animate-scale delay-7">
            <div class="team-avatar-frame">
              <img src="https://img.freepik.com/free-vector/illustration-female-character-wearing-hijab-working-office_10045-686.jpg?w=740" 
                   alt="Siti Zahwa"
                   onerror="this.src='https://ui-avatars.com/api/?name=Siti+Zahwa&background=16a34a&color=fff&size=200&bold=true'">
            </div>
            <div class="team-name" style="font-size: 16px; font-weight: 800; color: var(--text-light); margin-bottom: 3px;">
              Siti Zahwa
            </div>
            <div class="team-nim" style="font-size: 12.5px; color: var(--teal); font-weight: 600; margin-bottom: 8px;">
              NIM: 3312311108
            </div>
            <span class="team-role-tag" style="background: rgba(34,197,94,0.15); color: var(--green); border: 1px solid rgba(34,197,94,0.3); font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px;">
              <i class="bi bi-code-slash me-1"></i> Frontend Dev
            </span>
          </div>
        </div>

        <!-- BACKEND TEAM -->
        <div class="d-flex align-items-center gap-2 mb-3 mt-4">
          <div style="width: 28px; height: 28px; border-radius: 8px; background: rgba(251,191,36,0.15); display: flex; align-items: center; justify-content: center; color: var(--amber); font-size: 14px;">
            <i class="bi bi-server"></i>
          </div>
          <h5 style="font-size: 14px; font-weight: 700; color: var(--amber); letter-spacing: 0.6px; margin: 0;">
            BACK-END DEVELOPER
          </h5>
        </div>

        <div class="team-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
          
          <!-- Card 4: M. Dafa Putra -->
          <div class="team-card-modern animate-scale delay-6">
            <div class="team-avatar-frame" style="border-color: rgba(251,191,36,0.3); background: linear-gradient(135deg, rgba(251,191,36,0.2), rgba(249,115,22,0.2));">
              <img src="https://img.freepik.com/premium-vector/concept-delight-thumbs-up_605305-33.jpg?w=740" 
                   alt="M. Dafa Putra"
                   onerror="this.src='https://ui-avatars.com/api/?name=M+Dafa+Putra&background=d97706&color=fff&size=200&bold=true'">
            </div>
            <div class="team-name" style="font-size: 16px; font-weight: 800; color: var(--text-light); margin-bottom: 3px;">
              M. Dafa Putra
            </div>
            <div class="team-nim" style="font-size: 12.5px; color: var(--amber); font-weight: 600; margin-bottom: 8px;">
              NIM: 3312311114
            </div>
            <span class="team-role-tag" style="background: rgba(251,191,36,0.15); color: var(--amber); border: 1px solid rgba(251,191,36,0.3); font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px;">
              <i class="bi bi-hdd-network-fill me-1"></i> Backend Lead
            </span>
          </div>

          <!-- Card 5: Yunita Caroline -->
          <div class="team-card-modern animate-scale delay-7">
            <div class="team-avatar-frame" style="border-color: rgba(251,191,36,0.3); background: linear-gradient(135deg, rgba(251,191,36,0.2), rgba(249,115,22,0.2));">
              <img src="https://img.freepik.com/free-vector/hand-drawn-korean-drawing-style-character-illustration_23-2149601874.jpg?w=740" 
                   alt="Yunita Caroline"
                   onerror="this.src='https://ui-avatars.com/api/?name=Yunita+Caroline&background=b45309&color=fff&size=200&bold=true'">
            </div>
            <div class="team-name" style="font-size: 16px; font-weight: 800; color: var(--text-light); margin-bottom: 3px;">
              Yunita Caroline
            </div>
            <div class="team-nim" style="font-size: 12.5px; color: var(--amber); font-weight: 600; margin-bottom: 8px;">
              NIM: 3312311104
            </div>
            <span class="team-role-tag" style="background: rgba(251,191,36,0.15); color: var(--amber); border: 1px solid rgba(251,191,36,0.3); font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px;">
              <i class="bi bi-database-fill-gear me-1"></i> Database & Backend
            </span>
          </div>
        </div>
      </div>

      <!-- Form Kontak dengan animasi muncul -->
      <div class="glass-panel animate-fade-up delay-7">
        <div class="contact-glass">
          <div class="text-center mb-4">
            <h3 style="font-size: 20px; font-weight: 800; color: var(--text-light); margin-bottom: 6px;">
              <i class="bi bi-chat-dots-fill text-success me-2"></i> Hubungi Kami
            </h3>
            <p style="color: var(--text-muted); font-size: 13.5px; margin: 0;">
              Punya masukan atau pertanyaan terkait transaksi di QUICK.TOP? Kirim pesan langsung kepada tim kami.
            </p>
          </div>

          <form onsubmit="event.preventDefault(); alert('Terima kasih! Pesan Anda telah terkirim.'); this.reset();">
            <div class="form-group-qt">
              <label><i class="bi bi-person me-1"></i> Nama Lengkap</label>
              <input type="text" placeholder="Masukkan nama Anda" value="<?php echo $pengguna; ?>" required>
            </div>

            <div class="form-group-qt">
              <label><i class="bi bi-envelope me-1"></i> Alamat Email</label>
              <input type="email" placeholder="nama@email.com" required>
            </div>

            <div class="form-group-qt">
              <label><i class="bi bi-chat-text me-1"></i> Pesan / Masukan</label>
              <textarea rows="4" placeholder="Tuliskan pertanyaan atau kendala Anda di sini..." required></textarea>
            </div>

            <button type="submit" class="btn-beli" style="width: 100%; padding: 13px;">
              <i class="bi bi-send-fill me-1"></i> Kirim Pesan Sekarang
            </button>
          </form>
        </div>
      </div>

      <!-- Footer -->
      <footer class="footer mt-4 animate-fade-up delay-8">
        <div class="footer-links">
          <span><i class="bi bi-envelope"></i> quicktop.top@gmail.com</span>
          <span><i class="bi bi-telephone"></i> 0000-0000-0000</span>
          <span><i class="bi bi-geo-alt-fill"></i> Batam, Indonesia</span>
        </div>
        <div class="copyright">
          &copy; 2024 QUICK.TOP &mdash; Politeknik Negeri Batam
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

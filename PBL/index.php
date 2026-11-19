<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QUICK.TOP — Jual Beli Pulsa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/global.css?v=<?php echo time(); ?>">
  <script src="assets/theme.js?v=<?php echo time(); ?>"></script>
  <style>
    /* ── HERO ── */
    .hero {
      position: relative;
      z-index: 1;
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 100px 40px 60px;
      max-width: 1200px;
      margin: 0 auto;
      gap: 60px;
    }

    .hero-content { flex: 1; }

    .hero h1 {
      font-size: clamp(2.4rem, 5vw, 3.8rem);
      font-weight: 800;
      line-height: 1.15;
      margin-bottom: 20px;
    }

    .hero p.lead {
      font-size: 17px;
      color: var(--text-muted);
      line-height: 1.8;
      max-width: 500px;
      margin-bottom: 36px;
    }

    .hero-btns { display: flex; gap: 14px; flex-wrap: wrap; }

    .hero-visual {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50%       { transform: translateY(-20px); }
    }

    .hero-visual img {
      width: 100%;
      max-width: 440px;
      border-radius: 24px;
      filter: drop-shadow(0 20px 60px rgba(34,197,94,0.3));
    }

    /* Stats strip */
    .stats-strip {
      position: relative;
      z-index: 1;
      border-top: 1px solid var(--border-glass);
      border-bottom: 1px solid var(--border-glass);
      padding: 32px 40px;
      display: flex;
      justify-content: center;
      gap: 0;
      background: rgba(255,255,255,0.03);
    }

    .stat-item {
      flex: 1;
      max-width: 220px;
      text-align: center;
      padding: 0 24px;
      border-right: 1px solid var(--border-glass);
    }
    .stat-item:last-child { border-right: none; }

    .stat-number {
      font-size: 2rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .stat-label {
      font-size: 13px;
      color: var(--text-muted);
      margin-top: 4px;
    }

    /* ── FEATURES ── */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-top: 48px;
    }

    .feature-card {
      background: var(--bg-glass);
      border: 1px solid var(--border-glass);
      border-radius: var(--radius-lg);
      padding: 32px 28px;
      transition: var(--transition);
      cursor: default;
    }

    .feature-card:hover {
      border-color: rgba(108,99,255,0.4);
      transform: translateY(-6px);
      box-shadow: 0 20px 50px rgba(108,99,255,0.15);
    }

    .feature-icon {
      width: 54px;
      height: 54px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .feature-card h3 {
      font-size: 17px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .feature-card p {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.7;
    }

    /* ── HOW IT WORKS ── */
    .steps-row {
      display: flex;
      gap: 0;
      margin-top: 48px;
      position: relative;
    }

    .steps-row::before {
      content: '';
      position: absolute;
      top: 36px;
      left: calc(16.6% + 24px);
      right: calc(16.6% + 24px);
      height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      z-index: 0;
    }

    .step-item {
      flex: 1;
      text-align: center;
      padding: 0 16px;
      position: relative;
      z-index: 1;
    }

    .step-num {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      font-weight: 800;
      margin: 0 auto 20px;
      box-shadow: 0 8px 25px rgba(108,99,255,0.4);
    }

    .step-item h4 {
      font-size: 15px;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .step-item p {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.6;
    }

    /* ── CTA BANNER ── */
    .cta-banner {
      position: relative;
      z-index: 1;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 40px 100px;
    }

    .cta-inner {
      background: linear-gradient(135deg, #064E3B, #065F46 50%, #047857);
      border-radius: 28px;
      padding: 60px 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
      box-shadow: 0 20px 60px rgba(108,99,255,0.35);
      overflow: hidden;
      position: relative;
    }

    .cta-inner::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 300px; height: 300px;
      background: rgba(255,255,255,0.05);
      border-radius: 50%;
    }

    .cta-inner h2 {
      font-size: 2rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 12px;
    }

    .cta-inner p {
      color: rgba(255,255,255,0.75);
      font-size: 15px;
    }

    .cta-inner .btn-cta {
      background: #fff;
      color: #15803D;
      padding: 16px 36px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 15px;
      white-space: nowrap;
      transition: var(--transition);
      display: inline-block;
      text-decoration: none;
      flex-shrink: 0;
    }

    .cta-inner .btn-cta:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    /* Section title */
    .section-title {
      text-align: center;
      margin-bottom: 10px;
    }
    .section-title h2 {
      font-size: 2.2rem;
      font-weight: 800;
      margin-top: 10px;
    }

    /* Hero anim */
    .hero-content { animation: fadeInLeft 0.8s ease both; }
    .hero-visual  { animation: fadeInRight 0.8s ease 0.3s both; }

    @keyframes fadeInLeft {
      from { opacity: 0; transform: translateX(-50px); }
      to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
      from { opacity: 0; transform: translateX(50px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    @media (max-width: 768px) {
      .hero { flex-direction: column; text-align: center; padding: 80px 20px 40px; }
      .hero p.lead { margin: 0 auto 36px; }
      .hero-btns { justify-content: center; }
      .features-grid { grid-template-columns: 1fr; }
      .steps-row { flex-direction: column; gap: 30px; }
      .steps-row::before { display: none; }
      .cta-inner { flex-direction: column; text-align: center; padding: 40px 30px; }
      .qt-footer .footer-grid { grid-template-columns: 1fr; }
      .stats-strip { flex-wrap: wrap; gap: 20px; }
      .stat-item { border-right: none; min-width: 150px; }
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="qt-nav">
    <a href="index.php" class="brand">⚡ QUICK.TOP</a>
    <ul class="nav-links">
      <li><a href="#beranda">Beranda</a></li>
      <li><a href="#fitur">Fitur</a></li>
      <li><a href="#cara-kerja">Cara Kerja</a></li>
      <li><a href="#kontak">Kontak</a></li>

      <!-- THEME SWITCHER DOCK -->
      <li class="nav-theme-wrap">
        <div class="radial-theme-menu" id="navThemeMenu">
          <button type="button" class="nav-theme-btn" id="currentThemeBtn" title="Mode Tampilan" onclick="toggleNavTheme(event)">
            <i class="bi bi-circle-half" id="currentThemeIcon"></i>
          </button>
          <div class="radial-options" id="navRadialOptions">
            <button type="button" class="radial-item" onclick="setAppTheme('light')" data-mode="light" title="Mode Terang">
              <i class="bi bi-sun-fill"></i>
              <span>Terang</span>
            </button>
            <button type="button" class="radial-item" onclick="setAppTheme('auto')" data-mode="auto" title="Sesuai Device">
              <i class="bi bi-laptop"></i>
              <span>Sistem</span>
            </button>
            <button type="button" class="radial-item" onclick="setAppTheme('dark')" data-mode="dark" title="Mode Gelap">
              <i class="bi bi-moon-stars-fill"></i>
              <span>Gelap</span>
            </button>
          </div>
        </div>
      </li>

      <li><a href="login.php" class="btn-nav">Masuk</a></li>
      <li><a href="registrasi.php" class="btn-nav" style="background:linear-gradient(135deg,#00D4AA,#00A880);box-shadow:0 4px 15px rgba(0,212,170,0.4)">Daftar</a></li>
    </ul>
  </nav>

  <!-- HERO -->
  <section id="beranda">
    <div class="hero">
      <div class="hero-content">
        <span class="badge-pill">✦ Terpercaya & Termurah</span>
        <h1>Beli Pulsa <span class="grad-text">Semua Operator</span> Kapanpun & Dimanapun</h1>
        <p class="lead">Platform jual beli pulsa online terbaik. Proses cepat, harga bersaing, mendukung semua operator di Indonesia.</p>
        <div class="hero-btns">
          <a href="registrasi.php" class="btn-primary-qt"><i class="bi bi-lightning-charge-fill"></i> Mulai Sekarang</a>
          <a href="#fitur"         class="btn-secondary-qt"><i class="bi bi-play-circle"></i> Pelajari Lebih</a>
        </div>
      </div>
      <div class="hero-visual">
        <img src="https://img.freepik.com/free-vector/hand-drawn-credit-assessment-concept_23-2149171651.jpg?w=826"
             alt="Ilustrasi Jual Beli Pulsa">
      </div>
    </div>
  </section>

  <!-- STATS -->
  <div class="stats-strip reveal">
    <div class="stat-item">
      <div class="stat-number">10K+</div>
      <div class="stat-label">Pengguna Aktif</div>
    </div>
    <div class="stat-item">
      <div class="stat-number">50K+</div>
      <div class="stat-label">Transaksi Sukses</div>
    </div>
    <div class="stat-item">
      <div class="stat-number">99.9%</div>
      <div class="stat-label">Uptime Server</div>
    </div>
    <div class="stat-item">
      <div class="stat-number">6</div>
      <div class="stat-label">Operator Didukung</div>
    </div>
  </div>

  <!-- FITUR -->
  <section id="fitur" class="qt-section">
    <div class="section-title reveal">
      <span class="badge-pill">Keunggulan Kami</span>
      <h2>Kenapa Pilih <span class="grad-text">QUICK.TOP</span>?</h2>
    </div>

    <div class="features-grid">
      <div class="feature-card reveal" style="transition-delay:0.1s">
        <div class="feature-icon" style="background:rgba(108,99,255,0.15); color:var(--primary)">
          <i class="bi bi-lightning-charge-fill"></i>
        </div>
        <h3>Proses Instan</h3>
        <p>Transaksi diproses dalam hitungan detik. Pulsa langsung masuk tanpa perlu menunggu lama.</p>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.2s">
        <div class="feature-icon" style="background:rgba(0,212,170,0.15); color:var(--secondary)">
          <i class="bi bi-tags-fill"></i>
        </div>
        <h3>Harga Terbaik</h3>
        <p>Harga pulsa paling kompetitif di pasaran. Hemat lebih banyak untuk setiap pembelian.</p>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.3s">
        <div class="feature-icon" style="background:rgba(255,101,132,0.15); color:var(--accent)">
          <i class="bi bi-shield-check-fill"></i>
        </div>
        <h3>100% Aman</h3>
        <p>Sistem keamanan berlapis dengan enkripsi data. Transaksi Anda selalu terlindungi.</p>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.4s">
        <div class="feature-icon" style="background:rgba(108,99,255,0.15); color:var(--primary)">
          <i class="bi bi-phone-fill"></i>
        </div>
        <h3>Semua Operator</h3>
        <p>Mendukung Telkomsel, XL, Indosat, Tri, Smartfren, dan operator lainnya.</p>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.5s">
        <div class="feature-icon" style="background:rgba(0,212,170,0.15); color:var(--secondary)">
          <i class="bi bi-credit-card-2-front-fill"></i>
        </div>
        <h3>Banyak Metode Bayar</h3>
        <p>Transfer bank, e-wallet (GoPay, Dana, ShopeePay), dan berbagai metode lainnya.</p>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.6s">
        <div class="feature-icon" style="background:rgba(255,101,132,0.15); color:var(--accent)">
          <i class="bi bi-headset"></i>
        </div>
        <h3>Layanan 24/7</h3>
        <p>Tim support siap membantu Anda kapan saja. Respon cepat untuk setiap pertanyaan.</p>
      </div>
    </div>
  </section>

  <!-- CARA KERJA -->
  <section id="cara-kerja" class="qt-section" style="padding-top:0">
    <div class="section-title reveal">
      <span class="badge-pill">Mudah & Cepat</span>
      <h2>Cara <span class="grad-text">Pembelian</span></h2>
    </div>
    <div class="steps-row">
      <div class="step-item reveal" style="transition-delay:0.1s">
        <div class="step-num">1</div>
        <h4>Daftar Akun</h4>
        <p>Buat akun gratis dengan email dan nomor HP Anda</p>
      </div>
      <div class="step-item reveal" style="transition-delay:0.2s">
        <div class="step-num">2</div>
        <h4>Pilih Produk</h4>
        <p>Pilih operator dan nominal pulsa yang diinginkan</p>
      </div>
      <div class="step-item reveal" style="transition-delay:0.3s">
        <div class="step-num">3</div>
        <h4>Lakukan Pembayaran</h4>
        <p>Bayar dengan metode pembayaran favorit Anda</p>
      </div>
      <div class="step-item reveal" style="transition-delay:0.4s">
        <div class="step-num">4</div>
        <h4>Pulsa Terkirim</h4>
        <p>Pulsa langsung masuk ke nomor tujuan secara instan</p>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <div class="cta-banner reveal">
    <div class="cta-inner">
      <div>
        <h2>Siap Mulai Bertransaksi?</h2>
        <p>Daftar sekarang dan nikmati kemudahan beli pulsa online kapan saja.</p>
      </div>
      <a href="registrasi.php" class="btn-cta">Daftar Gratis →</a>
    </div>
  </div>

  <!-- FOOTER -->
  <footer id="kontak" class="qt-footer">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">⚡ QUICK.TOP</div>
        <p style="color:var(--text-muted);font-size:14px;line-height:1.8;max-width:280px">
          Platform jual beli pulsa online terpercaya. Layanan cepat, aman, dan harga terbaik untuk semua operator.
        </p>
      </div>
      <div>
        <h4>Kontak</h4>
        <a href="#"><i class="bi bi-envelope me-2"></i>quick.top@gmail.com</a>
        <a href="#"><i class="bi bi-telephone me-2"></i>0000-0000-0000</a>
        <a href="#"><i class="bi bi-geo-alt-fill me-2"></i>Batam, Indonesia</a>
      </div>
      <div>
        <h4>Navigasi</h4>
        <a href="login.php">Masuk</a>
        <a href="registrasi.php">Daftar</a>
        <a href="#fitur">Fitur</a>
        <a href="#cara-kerja">Cara Kerja</a>
      </div>
    </div>
    <div class="footer-bottom">
      © 2024 QUICK.TOP — Dibuat untuk kemudahan transaksi Anda
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Scroll reveal
    const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
        }
      });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));

    // Animated counter
    function animateCounter(el) {
      const target = parseFloat(el.dataset.target);
      const isPercent = el.dataset.target.includes('%');
      const isDecimal = target % 1 !== 0;
      let start = 0;
      const duration = 1500;
      const step = timestamp => {
        if (!start) start = timestamp;
        const progress = Math.min((timestamp - start) / duration, 1);
        const val = progress * target;
        el.textContent = (isDecimal ? val.toFixed(1) : Math.floor(val)).toLocaleString('id') + (isPercent ? '%' : (el.dataset.suffix || ''));
        if (progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    }
  </script>
</body>
</html>

<?php
session_start();
if (isset($_SESSION['id_user'])) {
    header('Location: pembeli/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — QUICK.TOP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/global.css?v=<?php echo time(); ?>">
  <script src="assets/theme.js?v=<?php echo time(); ?>"></script>
  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .auth-container {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 100px 20px 60px;
      position: relative;
      z-index: 1;
    }

    .auth-box {
      width: 100%;
      max-width: 480px;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 24px;
      padding: 48px 44px;
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      animation: popIn 0.6s cubic-bezier(0.34,1.56,0.64,1) both;
    }

    @keyframes popIn {
      from { opacity: 0; transform: scale(0.9) translateY(20px); }
      to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    .auth-logo {
      text-align: center;
      margin-bottom: 28px;
    }

    .auth-logo .logo-icon {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, #00D4AA, #00A880);
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      margin-bottom: 14px;
      box-shadow: 0 10px 30px rgba(0,212,170,0.4);
      animation: glow 3s ease-in-out infinite;
    }

    @keyframes glow {
      0%, 100% { box-shadow: 0 10px 30px rgba(34,197,94,0.4); }
      50%       { box-shadow: 0 10px 50px rgba(34,197,94,0.7); }
    }

    .auth-logo .brand-name {
      display: block;
      font-size: 22px;
      font-weight: 800;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .auth-box h2 {
      font-size: 24px;
      font-weight: 700;
      text-align: center;
      margin-bottom: 6px;
    }

    .auth-box .subtitle {
      text-align: center;
      color: var(--text-muted);
      font-size: 14px;
      margin-bottom: 28px;
    }

    .input-group-qt {
      position: relative;
      margin-bottom: 16px;
    }

    .input-group-qt label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-muted);
      margin-bottom: 7px;
      letter-spacing: 0.5px;
    }

    .input-group-qt .input-wrap { position: relative; }

    .input-group-qt input {
      width: 100%;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 13px 46px 13px 46px;
      font-size: 15px;
      color: var(--text-light);
      font-family: 'Poppins', sans-serif;
      outline: none;
      transition: var(--transition);
    }

    .input-group-qt input::placeholder { color: rgba(255,255,255,0.3); }

    .input-group-qt input:focus {
      border-color: var(--secondary);
      background: rgba(0,212,170,0.07);
      box-shadow: 0 0 0 3px rgba(0,212,170,0.12);
    }

    .input-group-qt .icon-left {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 18px;
      pointer-events: none;
      transition: var(--transition);
    }

    .input-group-qt .input-wrap:focus-within .icon-left { color: var(--secondary); }

    .input-group-qt .toggle-pass {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 18px;
      cursor: pointer;
      background: none;
      border: none;
      padding: 0;
      transition: var(--transition);
    }

    .input-group-qt .toggle-pass:hover { color: var(--secondary); }

    /* Password strength */
    .strength-bar {
      height: 4px;
      border-radius: 2px;
      background: rgba(255,255,255,0.08);
      margin-top: 8px;
      overflow: hidden;
    }

    .strength-fill {
      height: 100%;
      border-radius: 2px;
      transition: width 0.4s ease, background 0.4s ease;
      width: 0%;
    }

    .strength-text {
      font-size: 11px;
      margin-top: 4px;
      transition: color 0.4s;
    }

    /* Terms */
    .terms-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin: 16px 0 22px;
      font-size: 13px;
      color: var(--text-muted);
    }

    .terms-row input[type="checkbox"] {
      accent-color: var(--secondary);
      width: 16px; height: 16px;
      flex-shrink: 0;
      margin-top: 2px;
    }

    .terms-row a { color: var(--secondary); }

    .btn-auth {
      width: 100%;
      background: linear-gradient(135deg, var(--secondary), #00A880);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 15px;
      font-size: 16px;
      font-weight: 700;
      font-family: 'Poppins', sans-serif;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 6px 20px rgba(0,212,170,0.35);
    }

    .btn-auth:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(0,212,170,0.5);
    }

    .btn-auth:active { transform: translateY(0); }

    .auth-footer {
      text-align: center;
      font-size: 14px;
      color: var(--text-muted);
      margin-top: 20px;
    }

    .auth-footer a {
      color: var(--primary);
      font-weight: 600;
      transition: var(--transition);
    }

    .alert-qt {
      background: rgba(255,101,132,0.12);
      border: 1px solid rgba(255,101,132,0.3);
      color: #FF6584;
      border-radius: 12px;
      padding: 12px 16px;
      font-size: 14px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: shake 0.4s ease;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60%  { transform: translateX(-6px); }
      40%, 80%  { transform: translateX(6px); }
    }

    /* Stagger */
    .input-group-qt:nth-child(1) { animation: slideUp 0.5s ease 0.1s both; }
    .input-group-qt:nth-child(2) { animation: slideUp 0.5s ease 0.2s both; }
    .input-group-qt:nth-child(3) { animation: slideUp 0.5s ease 0.3s both; }
    .input-group-qt:nth-child(4) { animation: slideUp 0.5s ease 0.4s both; }
    .input-group-qt:nth-child(5) { animation: slideUp 0.5s ease 0.5s both; }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="qt-nav">
    <a href="index.php" class="brand">⚡ QUICK.TOP</a>
    <ul class="nav-links">
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
    </ul>
  </nav>

  <div class="auth-container">
    <div class="auth-box">

      <div class="auth-logo">
        <div class="logo-icon">✦</div>
        <span class="brand-name">QUICK.TOP</span>
      </div>

      <h2>Buat Akun Baru</h2>
      <p class="subtitle">Daftar gratis dan mulai beli pulsa sekarang</p>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert-qt">
          <i class="bi bi-exclamation-circle-fill"></i>
          <?php
            $err = $_GET['error'];
            if ($err === 'exist')     echo 'Username atau email sudah digunakan.';
            elseif ($err === 'passno') echo 'Password tidak cocok.';
            else                       echo htmlspecialchars($err);
          ?>
        </div>
      <?php endif; ?>

      <form action="cek_registrasi.php" method="POST">
        <div class="input-group-qt">
          <label>Nama Lengkap</label>
          <div class="input-wrap">
            <input type="text" name="nama" placeholder="Masukkan nama lengkap" autocomplete="off" required>
            <i class="bx bxs-id-card icon-left"></i>
          </div>
        </div>

        <div class="input-group-qt">
          <label>Username</label>
          <div class="input-wrap">
            <input type="text" name="username" placeholder="Pilih username unik" autocomplete="off" required>
            <i class="bx bxs-user icon-left"></i>
          </div>
        </div>

        <div class="input-group-qt">
          <label>Email</label>
          <div class="input-wrap">
            <input type="email" name="email" placeholder="Masukkan email aktif" autocomplete="off" required>
            <i class="bx bxs-envelope icon-left"></i>
          </div>
        </div>

        <div class="input-group-qt">
          <label>Password</label>
          <div class="input-wrap">
            <input type="password" name="password" id="passInput" placeholder="Minimal 8 karakter"
                   autocomplete="off" required oninput="checkStrength(this.value)">
            <i class="bx bxs-lock-open-alt icon-left"></i>
            <button type="button" class="toggle-pass" onclick="togglePass('passInput','eyeIcon1')">
              <i class="bi bi-eye-slash" id="eyeIcon1"></i>
            </button>
          </div>
          <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
          <div class="strength-text" id="strengthText"></div>
        </div>

        <div class="input-group-qt">
          <label>Konfirmasi Password</label>
          <div class="input-wrap">
            <input type="password" name="password2" id="passInput2" placeholder="Ulangi password"
                   autocomplete="off" required>
            <i class="bx bxs-lock-alt icon-left"></i>
            <button type="button" class="toggle-pass" onclick="togglePass('passInput2','eyeIcon2')">
              <i class="bi bi-eye-slash" id="eyeIcon2"></i>
            </button>
          </div>
        </div>

        <div class="terms-row">
          <input type="checkbox" required id="terms">
          <label for="terms">Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a></label>
        </div>

        <button type="submit" class="btn-auth">
          <i class="bi bi-person-plus-fill me-2"></i>Buat Akun Sekarang
        </button>
      </form>

      <div class="auth-footer">
        Sudah punya akun? <a href="login.php">Masuk di sini</a>
      </div>
    </div>
  </div>

  <script>
    function togglePass(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon  = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye';
      } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-slash';
      }
    }

    function checkStrength(val) {
      const fill = document.getElementById('strengthFill');
      const text = document.getElementById('strengthText');
      let score = 0;
      if (val.length >= 8)              score++;
      if (/[A-Z]/.test(val))            score++;
      if (/[0-9]/.test(val))            score++;
      if (/[^A-Za-z0-9]/.test(val))     score++;

      const levels = [
        { width: '0%',   color: 'transparent',   label: '' },
        { width: '25%',  color: '#FF6584',        label: '⚠ Lemah' },
        { width: '50%',  color: '#FFB347',        label: '→ Cukup' },
        { width: '75%',  color: '#6C63FF',        label: '✓ Kuat' },
        { width: '100%', color: '#00D4AA',        label: '✓✓ Sangat Kuat' },
      ];

      fill.style.width      = levels[score].width;
      fill.style.background = levels[score].color;
      text.style.color      = levels[score].color;
      text.textContent      = levels[score].label;
    }
  </script>
</body>
</html>

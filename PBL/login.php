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
  <title>Login — QUICK.TOP</title>
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
      max-width: 440px;
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
      margin-bottom: 32px;
    }

    .auth-logo .logo-icon {
      width: 70px; height: 70px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      margin-bottom: 14px;
      box-shadow: 0 10px 30px rgba(108,99,255,0.4);
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
      margin-bottom: 32px;
    }

    /* Input Group */
    .input-group-qt {
      position: relative;
      margin-bottom: 18px;
    }

    .input-group-qt label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-muted);
      margin-bottom: 8px;
      letter-spacing: 0.5px;
    }

    .input-group-qt .input-wrap {
      position: relative;
    }

    .input-group-qt input {
      width: 100%;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 14px 46px 14px 46px;
      font-size: 15px;
      color: var(--text-light);
      font-family: 'Poppins', sans-serif;
      outline: none;
      transition: var(--transition);
    }

    .input-group-qt input::placeholder { color: rgba(255,255,255,0.3); }

    .input-group-qt input:focus {
      border-color: var(--primary);
      background: rgba(34,197,94,0.07);
      box-shadow: 0 0 0 3px rgba(34,197,94,0.15);
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

    .input-group-qt input:focus ~ .icon-left,
    .input-group-qt .input-wrap:focus-within .icon-left {
      color: var(--primary);
    }

    .input-group-qt .toggle-pass {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 18px;
      cursor: pointer;
      transition: var(--transition);
      background: none;
      border: none;
      padding: 0;
    }

    .input-group-qt .toggle-pass:hover { color: var(--primary); }

    /* Remember & Forgot */
    .auth-extra {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 4px 0 24px;
      font-size: 13px;
    }

    .auth-extra label {
      display: flex;
      align-items: center;
      gap: 7px;
      color: var(--text-muted);
      cursor: pointer;
    }

    .auth-extra input[type="checkbox"] {
      accent-color: var(--primary);
      width: 15px; height: 15px;
    }

    .auth-extra a {
      color: var(--primary);
      transition: var(--transition);
    }

    .auth-extra a:hover { opacity: 0.8; }

    /* Submit Button */
    .btn-auth {
      width: 100%;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 15px;
      font-size: 16px;
      font-weight: 700;
      font-family: 'Poppins', sans-serif;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 6px 20px rgba(34,197,94,0.35);
      position: relative;
      overflow: hidden;
    }

    .btn-auth::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.1));
      opacity: 0;
      transition: var(--transition);
    }

    .btn-auth:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(34,197,94,0.45);
    }

    .btn-auth:hover::after { opacity: 1; }
    .btn-auth:active { transform: translateY(0); }

    /* Divider */
    .auth-divider {
      text-align: center;
      color: var(--text-muted);
      font-size: 13px;
      margin: 24px 0;
      position: relative;
    }

    .auth-divider::before, .auth-divider::after {
      content: '';
      position: absolute;
      top: 50%;
      width: calc(50% - 50px);
      height: 1px;
      background: var(--border-glass);
    }

    .auth-divider::before { left: 0; }
    .auth-divider::after  { right: 0; }

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

    .auth-footer a:hover { opacity: 0.8; }

    /* Alert error */
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

    /* Stagger input animations */
    .input-group-qt:nth-child(1) { animation: slideUp 0.5s ease 0.2s both; }
    .input-group-qt:nth-child(2) { animation: slideUp 0.5s ease 0.3s both; }
    .auth-extra                  { animation: slideUp 0.5s ease 0.4s both; }
    .btn-auth                    { animation: slideUp 0.5s ease 0.5s both; }

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
      <li><a href="registrasi.php" class="btn-nav" style="background:linear-gradient(135deg,#00D4AA,#00A880);box-shadow:0 4px 15px rgba(0,212,170,0.4)">Daftar</a></li>
    </ul>
  </nav>

  <!-- AUTH CONTAINER -->
  <div class="auth-container">
    <div class="auth-box">

      <div class="auth-logo">
        <div class="logo-icon">⚡</div>
        <span class="brand-name">QUICK.TOP</span>
      </div>

      <h2>Selamat Datang!</h2>
      <p class="subtitle">Masuk ke akun Anda untuk melanjutkan</p>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert-qt">
          <i class="bi bi-exclamation-circle-fill"></i>
          <?php
            $err = $_GET['error'];
            if ($err === 'wrong')    echo 'Username atau password salah.';
            elseif ($err === 'empty') echo 'Harap isi semua kolom.';
            else                     echo htmlspecialchars($err);
          ?>
        </div>
      <?php endif; ?>

      <form action="cek_login.php" method="POST">
        <div class="input-group-qt">
          <label>Username</label>
          <div class="input-wrap">
            <input type="text" name="username" placeholder="Masukkan username" autocomplete="off" required>
            <i class="bx bxs-user icon-left"></i>
          </div>
        </div>

        <div class="input-group-qt">
          <label>Password</label>
          <div class="input-wrap">
            <input type="password" name="password" id="passInput" placeholder="Masukkan password" required>
            <i class="bx bxs-lock-alt icon-left"></i>
            <button type="button" class="toggle-pass" onclick="togglePass()">
              <i class="bi bi-eye-slash" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <div class="auth-extra">
          <label>
            <input type="checkbox" name="ingat" value="1">
            Ingat saya
          </label>
          <a href="lupa_password.php">Lupa password?</a>
        </div>

        <button type="submit" class="btn-auth">
          <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
        </button>
      </form>

      <div class="auth-divider">atau</div>

      <div class="auth-footer">
        Belum punya akun? <a href="registrasi.php">Daftar Sekarang</a>
      </div>
    </div>
  </div>

  <script>
    function togglePass() {
      const input = document.getElementById('passInput');
      const icon  = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye';
      } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-slash';
      }
    }
  </script>
</body>
</html>

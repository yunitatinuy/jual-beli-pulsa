<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $password2 = $_POST['password2'] ?? '';

  $stmt = mysqli_prepare($koneksi, "SELECT id_user FROM user WHERE username = ? AND email = ?");
  mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
  mysqli_stmt_execute($stmt);
  $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

  if (!$row) {
    $pesan = 'Username dan email tidak cocok';
    $tujuan = 'lupa_password.php';
  } elseif ($password === '' || $password !== $password2) {
    $pesan = 'Konfirmasi password tidak sesuai';
    $tujuan = 'lupa_password.php';
  } else {
    $pass_acak = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($koneksi, "UPDATE user SET password = ? WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, 'si', $pass_acak, $row['id_user']);
    mysqli_stmt_execute($stmt);
    $pesan = 'Password berhasil diubah, silahkan login';
    $tujuan = 'login.php';
  }
  echo "<script>alert(" . json_encode($pesan) . "); window.location = " . json_encode($tujuan) . ";</script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password — QUICK.TOP</title>
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
      border-radius: 24px;
      padding: 48px 44px;
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      animation: popIn 0.6s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes popIn {
      from { opacity: 0; transform: scale(0.9) translateY(20px); }
      to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    .auth-logo { text-align: center; margin-bottom: 32px; }
    .auth-logo .logo-icon {
      width: 70px; height: 70px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      margin-bottom: 14px;
      box-shadow: 0 10px 30px rgba(34,197,94,0.4);
    }
    .auth-logo .brand-name {
      display: block; font-size: 22px; font-weight: 800;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .auth-box h2 { font-size: 24px; font-weight: 700; text-align: center; margin-bottom: 6px; }
    .auth-box .subtitle { text-align: center; font-size: 14px; margin-bottom: 32px; }
    .input-group-qt { position: relative; margin-bottom: 18px; }
    .input-group-qt label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; }
    .input-group-qt .input-wrap { position: relative; }
    .input-group-qt input {
      width: 100%; border-radius: 12px; padding: 14px 46px 14px 46px;
      font-size: 15px; font-family: 'Poppins', sans-serif; outline: none;
    }
    .input-group-qt .icon-left {
      position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
      font-size: 18px; pointer-events: none;
    }
    .btn-auth {
      width: 100%;
      background: linear-gradient(135deg, var(--green), var(--green-dark));
      color: #fff; border: none; border-radius: 12px; padding: 15px;
      font-size: 16px; font-weight: 700; font-family: 'Poppins', sans-serif;
      cursor: pointer; transition: var(--transition);
      box-shadow: 0 6px 20px rgba(34,197,94,0.35);
    }
    .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(34,197,94,0.45); }
    .auth-footer { text-align: center; font-size: 14px; margin-top: 20px; }
  </style>
</head>
<body>
  <!-- NAVBAR -->
  <nav class="qt-nav">
    <a href="index.php" class="brand">⚡ QUICK.TOP</a>
    <ul class="nav-links">
      <li class="nav-theme-wrap">
        <div class="radial-theme-menu" id="navThemeMenu">
          <button type="button" class="nav-theme-btn" id="currentThemeBtn" title="Mode Tampilan" onclick="toggleNavTheme(event)">
            <i class="bi bi-circle-half" id="currentThemeIcon"></i>
          </button>
          <div class="radial-options" id="navRadialOptions">
            <button type="button" class="radial-item" onclick="setAppTheme('light')" data-mode="light" title="Mode Terang">
              <i class="bi bi-sun-fill"></i><span>Terang</span>
            </button>
            <button type="button" class="radial-item" onclick="setAppTheme('auto')" data-mode="auto" title="Sesuai Device">
              <i class="bi bi-laptop"></i><span>Sistem</span>
            </button>
            <button type="button" class="radial-item" onclick="setAppTheme('dark')" data-mode="dark" title="Mode Gelap">
              <i class="bi bi-moon-stars-fill"></i><span>Gelap</span>
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
        <div class="logo-icon">🔑</div>
        <span class="brand-name">QUICK.TOP</span>
      </div>
      <h2>Reset Password</h2>
      <p class="subtitle">Masukkan data akun untuk memperbarui kata sandi</p>

      <form action="lupa_password.php" method="POST">
        <div class="input-group-qt">
          <label>Username</label>
          <div class="input-wrap">
            <input type="text" name="username" placeholder="Masukkan username" autocomplete="off" required>
            <i class="bx bxs-user icon-left"></i>
          </div>
        </div>
        <div class="input-group-qt">
          <label>Email Terdaftar</label>
          <div class="input-wrap">
            <input type="email" name="email" placeholder="Masukkan email" autocomplete="off" required>
            <i class="bx bxs-envelope icon-left"></i>
          </div>
        </div>
        <div class="input-group-qt">
          <label>Password Baru</label>
          <div class="input-wrap">
            <input type="password" name="password" placeholder="Password baru" autocomplete="off" required>
            <i class="bx bxs-lock-open-alt icon-left"></i>
          </div>
        </div>
        <div class="input-group-qt">
          <label>Konfirmasi Password Baru</label>
          <div class="input-wrap">
            <input type="password" name="password2" placeholder="Ulangi password baru" autocomplete="off" required>
            <i class="bx bxs-lock-alt icon-left"></i>
          </div>
        </div>

        <button type="submit" class="btn-auth mt-2">
          <i class="bi bi-arrow-repeat me-2"></i>Reset Password
        </button>
      </form>

      <div class="auth-footer">
        Ingat password Anda? <a href="login.php">Masuk di sini</a>
      </div>
    </div>
  </div>
</body>
</html>

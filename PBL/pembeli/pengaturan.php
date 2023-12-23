<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('location:../login.php');
  exit;
}

$pengguna = $_SESSION['user']["nama"];

//koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_admin");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <title>QUICK.TOP</title>

  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>

  <!-- navbarside -->
  <section class="sidebar">
    <div class="nav-header">
      <p class="logo ps-4"><?php echo $pengguna ?></p>
      <i class="bx bx-menu-alt-right btn-menu"></i>
    </div>
    <ul class="nav-links">
      <li>
        <a href="dashboard.php">
          <i class="bi bi-house"></i>
          <span class="title">Halaman Utama</span>
        </a>
        <span class="tooltip">Halaman Utama</span>
      </li>
      <li>
        <a href="tentang_kami.php">
          <i class="bi bi-question-circle"></i>
          <span class="title">Tentang kami</span>
        </a>
        <span class="tooltip">Tentang Kami</span>
      </li>
      <li>
        <a href="riwayat.php">
          <i class="bi bi-journal-text"></i>
          <span class="title">Riwayat</span>
        </a>
        <span class="tooltip">Riwayat</span>
      </li>
      <li>
        <a href="pengaturan.php">
          <i class="bi bi-gear"></i>
          <span class="title">Pengaturan</span>
        </a>
        <span class="tooltip">Pengaturan</span>
      </li>
      <br>
      <li>
        <a href="../logout.php">
          <i class="bi bi-box-arrow-right"></i>
          <span class="title">Keluar</span>
        </a>
        <span class="tooltip">Keluar</span>
      </li>
    </ul>
    </div>
  </section>
  <!-- navside end -->

  <!-- navtop -->
  <section class="home">
    <div class="nav-top">
      <div class="nav-name">QUICK.TOP</div>
      <a href="keranjang.php"><i class="bi bi-cart2"></i></a>
    </div>
    <!-- navtop end -->

    <!-- dashboard -->
    <div class="content1">
      <div class="kelas">
        <img src="logo/quicktop.png" width="70" class="rounded-circle" alt="..."><span class="kelas1"> QUICK.TOP</span>
      </div>
    </div>

    <div class="dashboard-content px-3 pt-2">
      <div class="dropdown">
        <div class="dropdown1 p-2">
          <a href="profile.php" class="text-decoration-none px-3 py-2 d-block text-black"><i class="bi bi-person-circle"></i> Pengaturan Profile</a>
        </div>
        <div class="dropdown1 p-2">
          <a href="#popup2" class="text-decoration-none px-3 py-2 d-block text-black"><i class="bi bi-lock"></i> Ganti Password</a></li>
        </div>
        <div class="dropdown1 p-2">
          <a href="#" class="text-decoration-none px-3 py-2 d-block text-black"><i class="bi bi-info-circle"></i> Pusat Bantuan</a></li>
        </div>
        <div class="dropdown1 p-2">
          <a href="dashboard.html" class="text-decoration-none px-3 py-2 d-block text-black"><i class="bi bi-box-arrow-right"></i> Keluar</a></li>
        </div><br>
      </div>
    </div>
    <!-- popup2 -->
    <div class="popup2" id="popup2">
      <div class="popup2_content">
        <a class="product">Ganti Password</a>
        <a href="#" class="popup2_close">&times;</a> <!--tanda silang-->
        <div class="popup2_header">
          Username<br>
          <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="popup2_text">
          Password<br>
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <center><a href="#popup" class="btn popup_btn">Konfirmasi</a> </center>
      </div>
    </div>
    <!-- popup2 end -->



  </section>
  <!-- dashboard end -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <script>
    const btn_menu = document.querySelector(".btn-menu");
    const side_bar = document.querySelector(".sidebar");

    btn_menu.addEventListener("click", function() {
      side_bar.classList.toggle("expand");
      changebtn();
    });

    function changebtn() {
      if (side_bar.classList.contains("expand")) {
        btn_menu.classList.replace("bx-menu", "bx-menu-alt-right");
      } else {
        btn_menu.classList.replace("bx-menu-alt-right", "bx-menu");
      }
    }
  </script>
</body>

</html>
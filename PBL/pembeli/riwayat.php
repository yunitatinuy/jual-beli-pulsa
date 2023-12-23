<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('location:../login.php');
  exit;
}

$pengguna = $_SESSION['user']["nama"];

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

    <div class="dashboard-content1" style="background-color: #d1ffe0; height: 100%; width: 100%; padding-left: 70px; margin-top: 65px;">
      <div class="riwayat">
        <div class="riwayat0" style="text-align: center;"><a href="">Riwayat Transaksi <?php echo $_SESSION['user']['nama']; ?></a></div>
        <table class="riwayat1" style="border: solid;">
          <thead style="border: solid 2px;">
            <tr>
              <th style="border: solid; background-color: #008000; color: white; border-color: black;">No</th>
              <th style="border: solid; background-color: #008000; color: white; border-color: black;">User</th>
              <th style="border: solid; background-color: #008000; color: white; border-color: black;">Nomor Handphone</th>
              <th style="border: solid; background-color: #008000; color: white; border-color: black;">Tanggal Pembelian</th>
              <th style="border: solid; background-color: #008000; color: white; border-color: black;">Total</th>
            </tr>
          </thead>
          <?php
          include '..//koneksi.php';

          $no = 1;
          $id_user = $_SESSION['user']['id_user'];
          $query = mysqli_query($koneksi, "SELECT * FROM transaksi_penjualan INNER JOIN nohp ON transaksi_penjualan.id_nohp = nohp.id_nohp
  WHERE id_user='$id_user' ");
          while ($data = mysqli_fetch_assoc($query)) {
          ?>
            <tbody>
              <tr>
                <td style="border-right: solid 2px; "><?php echo $no++; ?></td>
                <td style="border-right: solid 2px;"><?php echo $_SESSION['user']['nama']; ?></td>
                <td style="border-right: solid 2px;">
                  <?php echo $data['no_telp'];

                  ?>
                </td>
                <td style="border-right: solid 2px;"><?php echo $data['tanggal_pembelian']; ?></td>
                <td style="border-right: solid 2px;">Rp <?php echo number_format($data['total_pembelian']); ?></td>
              </tr>
            </tbody>
          <?php
          }
          ?>
        </table>
      </div>
    </div>
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
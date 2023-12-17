<?php
session_start();
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

  <title>Jual Beli Pulsa</title>

  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body style="background-color: #F2FFE9;">

  <!-- navbarside -->
  <section class="sidebar">
    <div class="nav-header">
      <p class="logo">Nama Profil</p>
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
        <a href="#">
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
    <div class="content">
      <div class="garis btn-danger">

      </div>

      <!-- card -->

      <div class="row">

        <?php $ambil = $koneksi->query("SELECT * FROM proveder"); ?>
        <?php while ($perproduk = $ambil->fetch_assoc()) {
        ?>
          <div class="card" style="width: 13rem;">
            <center><img src="foto_produk/<?php echo $perproduk['foto']; ?>" class="card-img" width="200"></center>
            <div class="card-body bg-none">
              <h5 class="card-title"><?php echo $perproduk['nama_provider']; ?></h5>
              <p class="card-text">Rp<?php echo number_format($perproduk['nominal']); ?></p><br>
              <a href="popup1.php?halaman=detail&id=<?php echo $perproduk['id_provider'] ?>" class="btn btn-light btn-danger">Beli</a>
            </div>
          </div>
        <?php } ?>
      </div>

      <!-- card end -->

      <!-- popup 1 -->
      <?php
      $ambil = $koneksi->query("SELECT * FROM proveder WHERE id_provider='$_GET[id]'");
      $detail = $ambil->fetch_assoc();
      $id_provider = $_GET['id'];

      if (isset($_GET['halaman'])) {
        if ($_GET['halaman'] == "detail") {
            include 'popup1.php';
        } elseif ($_GET['halaman'] == "beli") {
            include 'popup.php';
        }
    } else {
        include 'dasboard.php';
    }
      ?>


      <div class="popup1" id="popup1">
        <div class="popup1_content">
          <center><a class="product">Detail Product</a></center>
          <div class="popup1_img">
            <img src="" alt="">
            <a href="#" class="popup1_close">&times;</a>
          </div>

          <?php
          $ambil = $koneksi->query("SELECT * FROM proveder WHERE id_provider='$_GET[id]'");
          $detail = $ambil->fetch_assoc();
          $id_provider = $_GET['id'];
          ?>

          <div class="popup1_header">
            <a class="operator"><?php echo $detail['nama_provider']; ?></a><br>
            <a class="harga">Rp<?php echo number_format($detail['nominal']); ?></a>
          </div>
          <div class="popup1_text">
            <a>
              <h4>Deskripsi</h4>
              <p><?php echo $detail['detail']; ?></p>
            </a>
            <a>
              <h5>Harga</h5>
              <p>Rp<?php echo number_format($detail['harga']); ?></p>
            </a>
          </div>
          <center><a href="#popup" class="btn popup_btn">Beli</a> </center>
        </div>
      </div>
      <!-- popup 1 end -->

      <!-- popup -->
      <div class="popup" id="popup">
        <div class="popup_content">
          <a href="#popup1" class="text-black">
            <h3><i class="bi bi-arrow-left"></i>
          </a> Pembayaran</h3>
          <div class="popup_img">
            <img src="" alt="">
            <a href="#" class="popup_close">&times;</a>
          </div>
          <div class="popup_header">
            Nomor Handphone
            <div class="konfirmasi">
              <input type="number" inputmode="numeric" name="nomorhp" class="nomorhp">
            </div>
            Pulsa
            <div class="konfirmasi"></div>
            Operator
            <div class="konfirmasi"></div>
            <div class="logo_bayar">Pilih Operator Pembayaran
              <a href=""><img src="gopay.png" width="60" class="rounded-circle" alt="..."></a>
              <a href=""><img src="shoppe.png" width="60" class="rounded-circle" alt="..."></a>
              <a href=""><img src="dana.png" width="60" class="rounded-circle" alt="..."></a>
            </div>
          </div>
          <div class="popup_text">
            <div class="popup_left">
              <img src="logo/quicktop.png" width="100" class="rounded-circle" alt="...">
            </div>
            <div class="popup_center">
              <a>Rincian Pembayaran:<br>
                Subtotal Produk<br>
                Biaya Layanan<br>
                Metode Pembayaran<br>
                Total Pembayaran</a>
            </div>
            <div class="popup_right">
              <a><br>1<br>100<br>dana<br>Rp10.100</a>
            </div>
          </div>
          <center><a href="#" class="btn popup_btn">Konfirmasi</a> </center>
        </div>
      </div>
      <!-- popup end -->


      <!-- logo -->
      <center class="mt-5" style="font-size: large; font-family: Arial sans-serif;">QUICK.TOP<br><img src="logo/quicktop.png" width="60" class="rounded-circle mt-2" alt="...">
        <br>
        <div class="py-2">
          <i class="bi bi-facebook"></i><i class="bi bi-twitter-x px-4"></i><i class="bi bi-instagram"></i>
        </div>
      </center>
    </div>
    <!-- logo end -->


    <!-- footer -->
    <footer class="footer">
      <div class="row mb-4 mt-3 text-center justify-content-between">
        <div class="col-md-3 pt-3">
          <p><i class="bi bi-envelope px-2"></i>quicktop.top@gmail.com</p>
        </div>
        <div class="col-md-3 pt-3">
          <p><i class="bi bi-telephone px-2"></i>0000-0000-0000</p>
        </div>
        <div class="col-md-3 pt-3">
          <p><i class="bi bi-house-door px-2"></i>Batam, Indonesia</p>
        </div>
      </div>
      <div class="copyright text-center p-2">
        <i class="bi bi-c-circle"></i>All Copyright Reserved
      </div>
    </footer>
    <!-- footer end -->
    <!-- dashboar end -->
  </section>


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
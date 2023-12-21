<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
    exit;
}
$koneksi = new mysqli("localhost", "root", "", "db_admin");
$id_provider = $_GET['id'];
$id_nohp = $_GET['id'];

//jika isi keranjang kosong
if (empty($_SESSION["keranjang"]) or !isset($_SESSION["keranjang"])) {
    echo "<script>alert('Keranjang kosong, silahkan berbelanja dahulu')</script>";
    echo "<script>location='dashboard.php';</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css" />
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
                <a href="dashboard.html">
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
                <a href="pengaturan.html">
                    <i class="bi bi-gear"></i>
                    <span class="title">Pengaturan</span>
                </a>
                <span class="tooltip">Pengaturan</span>
            </li>
            <br>
            <li>
                <a href="#">
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
            <a href=""><i class="bi bi-cart2"></i></a>
        </div>
        <!-- navtop end -->

        <!-- dashboard -->
        <div class="content">

            <!-- popup -->
            <a href="keranjang.php" class="text-black"><br>
                <h2><i class="bi bi-arrow-left"></i></h2>
            </a>
            <center>
                <h3>Masukkan Nomor Handphone</h3>
            </center>
            </h3>

            <form action="" method="post">
                <div class="popup_header">
                    Nomor Handphone
                    <div class="konfirmasi">
                        <input type="number" inputmode="numeric" class="nomorhp" name="no_telp" placeholder="Masukkan nomor anda">
                    </div>
                    <br>
                    <center><button class="btn btn-success" name="konfirmasi">Selanjutnya</button>
                </div>
            </form>
        </div>
    </section>



    <?php
    if (isset($_POST['konfirmasi'])) {
        $id_user = $_SESSION['user'];
        mysqli_query($koneksi, "INSERT INTO nohp SET no_telp = '$_POST[no_telp]', id_provider='$id_provider' ");
        echo "<script>location='checkout.php?id=$id_provider';</script>";
    }
    ?>

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
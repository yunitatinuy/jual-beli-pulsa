<?php
session_start();

$koneksi = new mysqli("localhost", "root", "", "db_admin");

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
    exit;
}
//jika isi keranjang kosong
if (empty($_SESSION["keranjang"]) or !isset($_SESSION["keranjang"])) {
    echo "<script>alert('Keranjang kosong, silahkan berbelanja dahulu')</script>";
    echo "<script>location='dashboard.php';</script>";
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
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <title>Jual Beli Pulsa</title>

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body style="background-color: #F2FFE9;">

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
        </div>
        <!-- navtop end -->

        <!-- dashboard -->
        <div class="content">

            <!-- popup -->
            <?php $ambil = $koneksi->query("SELECT * FROM proveder"); ?>
            <?php $perproduk = $ambil->fetch_assoc();
            ?>
            <a href="konfirmasi.php?halaman=detail&id=<?php echo $perproduk['id_provider'] ?>" class="text-black"><br>
                <h2><i class="bi bi-arrow-left"></i></h2>
            </a>
            <center>
                <h3>Transaksi Pembayaran</h3>
            </center>
            </h3>


            <form action="" method="post">
                <?php
                $nomor = $koneksi->query("SELECT * FROM nohp ORDER BY id_nohp DESC LIMIT 1");
                $detail = $nomor->fetch_assoc();
                ?>
                <div class="popup_header">
                    Nomor Handphone
                    <div class="konfirmasi" style="padding-left: 10px; padding-top: 5px;">
                        <?php echo $detail["no_telp"] ?>
                    </div>
                    <div class="logo_bayar">Pilih Operator Pembayaran
                        <select class="konfirmasi" name="id_metode_bayar" style="padding-left: 5px;">
                            <option value="">Pilih Operator Pembayaran</option>
                            <?php
                            $ambil = $koneksi->query("SELECT * FROM metode_bayar");
                            while ($perbayar = $ambil->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $perbayar["id_metode_bayar"] ?>">
                                    <?php echo $perbayar['jenis'] ?> -
                                    <?php echo $perbayar['kode'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php foreach ($_SESSION["keranjang"] as $id_provider => $jumlah) : ?>
                    <?php
                    $id_provider = $_GET['id'];
                    $ambil = $koneksi->query("SELECT * FROM proveder WHERE id_provider='$id_provider'");
                    $pecah = $ambil->fetch_assoc();

                    ?>
                    <div class="popup_text">
                        <div class="popup_left">
                            <img src="logo/quicktop.png" width="100" class="rounded-circle" alt="...">
                        </div>
                        <div class="popup_center">
                            <a><strong>Rincian Pembayaran : </strong><br></a>
                            <a>Subtotal Produk<br></a>
                            <a>Biaya Layanan<br></a>
                            <a>Total Pembayaran</a>
                        </div>
                        <div class="popup_right">
                            <a><br></a>
                            <a>Rp<?php echo number_format($pecah["nominal"]) ?><br></a>
                            <a>Rp2,000<br></a>
                            <a>Rp<?php echo number_format($pecah["harga"]) ?></a>
                        </div>
                    </div>
                    <br>
                    <center><button class="btn btn-success" name="konfirmasi">Konfirmasi</button>
        </div>
        </div>
        </form>
        <!-- popup end -->

        <?php
                    $ambil = $koneksi->query("SELECT * FROM proveder WHERE id_provider='$id_provider'");
                    $pecah = $ambil->fetch_assoc();
                    $nomor = $koneksi->query("SELECT * FROM nohp ORDER BY id_nohp DESC LIMIT 1");
                    $detail = $nomor->fetch_assoc();

                    if (isset($_POST['konfirmasi'])) {
                        $id_user = $_SESSION["user"]["id_user"];
                        $id_nohp = $detail["id_nohp"];
                        $id_metode_bayar = $_POST["id_metode_bayar"];
                        $tanggal_pembelian = date("Y-m-d");
                        $total_pembelian = $pecah["harga"];



                        //1. menyiimpan data ke tabel pembelian
                        $koneksi->query("INSERT INTO transaksi_penjualan (id_user, id_nohp, id_metode_bayar, tanggal_pembelian, total_pembelian) VALUES ('$id_user', '$id_nohp', '$id_metode_bayar', '$tanggal_pembelian', '$total_pembelian')");

                        //mendapatkan id_pembelian barusan terjadi
                        $id_pembelian_barusan = $koneksi->insert_id;
                        foreach ($_SESSION["keranjang"] as $id_provider => $jumlah) {
                            $koneksi->query("INSERT INTO transaksi (id_transaksi_penjualan, id_provider, jumlah) VALUES('$id_pembelian_barusan','$id_provider','$jumlah')");
                        }

                        //mengosongkan keranjang belanja
                        unset($_SESSION["keranjang"]);

                        //tampilan dialihkan ke halaman nota, nota dari pembelian yang barusan
                        echo "<script>alert('Pembelian Sukses')</script>";
                        echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";
                    }
        ?>
    <?php endforeach  ?>
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
<?php
$koneksi = new mysqli("localhost", "root", "", "db_admin");

$id_pembelian_barusan = $_GET['id'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" style="text/css" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <title>Jual Beli Pulsa</title>

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>

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


            <section class="konten">
                <div class="container">


                    <center>
                        <h2>Detail Pembelian</h2>
                    </center>
                    <br>
                    <?php
                    $ambil = $koneksi->query("SELECT * FROM transaksi_penjualan 
                    JOIN user ON transaksi_penjualan.id_user=user.id_user
                    JOIN metode_bayar ON transaksi_penjualan.id_metode_bayar=metode_bayar.id_metode_bayar 
                    JOIN nohp ON transaksi_penjualan.id_nohp=nohp.id_nohp
                    ORDER BY id_transaksi_penjualan DESC LIMIT 1");
                    $detail = $ambil->fetch_assoc();
                    ?>

                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?php echo $detail['nama']; ?></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td><?php echo $detail['username']; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo $detail['email']; ?></td>
                        </tr>
                        <tr>
                            <td>Nomor Handphone</td>
                            <td>:</td>
                            <td><?php echo $detail['no_telp']; ?></td>
                        </tr>
                        <tr>
                            <td>Metode Bayar</td>
                            <td>:</td>
                            <td><?php echo $detail['jenis'] ?> - <?php echo $detail['kode']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Pembelian</td>
                            <td>:</td>
                            <td><?php echo $detail['tanggal_pembelian']; ?></td>
                        </tr>
                        <tr>
                            <td>Total Pembelian</td>
                            <td>:</td>
                            <td><?php echo $detail['total_pembelian']; ?></td>
                        </tr>
                    </table>
                    <br>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Provider</th>
                                <th>Nominal</th>
                                <th>Detail</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomor = 1;
                            $ambil = $koneksi->query("SELECT * FROM transaksi 
                            INNER JOIN proveder ON transaksi.id_provider = proveder.id_provider 
                            ORDER BY id_transaksi DESC LIMIT 1");
                            $pecah = $ambil->fetch_assoc();
                            ?>
                            <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td><?php echo $pecah['nama_provider']; ?></td>
                                <td><?php echo $pecah['nominal']; ?></td>
                                <td><?php echo $pecah['detail']; ?></td>
                                <td><?php echo $pecah['harga']; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <center><a href="dashboard.php"><button class="btn btn-danger">Kembali ke Beranda</button></a>
                        <a href="cetak.php"><button class="btn btn-success" name="cetak">Cetak</button></a>
                        <br>
                        <br>
                </div>


                <!-- <div class="row">
                        <div class="col-md-8">
                            <div class="alert alert-info">
                                <p>
                                    Silahkan melakukan pembayaran Rp <?php echo number_format($detail['total_pembelian']); ?> ke
                                    <strong>BANK MANDIRI 098-764-54325 AN. Yunita</strong>
                                </p>

                            </div>
                        </div>
                    </div> -->

        </div>
    </section>



</body>

</html>
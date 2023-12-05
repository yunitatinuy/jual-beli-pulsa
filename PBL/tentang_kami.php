<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <title>Jual Beli Pulsa</title>

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
  --color-hover: #b3b3b3;
  --transition: all 0.2s ease;
}

.body {
  background-color: #f2ffe9;
}
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  width: 78px;
  height: 100%;
  background: #60c581;
  padding: 8px 16px;
  transition: var(--transition);
}

.sidebar.expand {
  width: 250px;
  transition: var(--transition);
}

.nav-header {
  height: 60px;
  display: flex;
  align-items: center;
  position: relative;
}

.nav-header .logo {
  color: #000;
  font-size: 23px;
  font-weight: 600;
  opacity: 0;
  transition: var(--transition);
}

.sidebar.expand .nav-header .logo {
  opacity: 1;
  transition: var(--transition);
}

.nav-header .btn-menu {
  position: absolute;
  color: #000;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  font-size: 23px;
  cursor: pointer;
  margin-right: 10px;
}

.sidebar.expand .nav-header .btn-menu {
  margin-right: 0;
}

.nav-links {
  margin-top: 20px;
  height: 100%;
}

.nav-links li {
  position: relative;
  margin: 8px 0;
  list-style: none;
}

.nav-links i {
  color: #000;
  height: 50px;
  min-width: 50px;
  font-size: 23px;
  text-align: justify;
  line-height: 50px;
}

.nav-links li a {
  display: flex;
  height: 100%;
  width: 100%;
  border-radius: 12px;
  align-items: center;
  text-decoration: none;
  background: #86d8ba;
}

.nav-links li:hover a {
  background: var(--color-hover);
}

.nav-links li:hover i {
  color: #fff;
}

.nav-links li a .title {
  color: #000;
  font-size: 15px;
  font-weight: 400;
  white-space: nowrap;
  display: none;
  transition: var(--transition);
}

.sidebar.expand .nav-links li a .title {
  display: block;
  transition: var(--transition);
}

.nav-links li:hover a .title {
  color: #fff;
}

.nav-links li .tooltip {
  position: absolute;
  top: -20px;
  left: calc(100% + 15px);
  z-index: 3;
  background: #fff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
  padding: 6px 14px;
  font-size: 15px;
  white-space: nowrap;
  border-radius: 3px;
  opacity: 0;
  pointer-events: none;
  transition: 0s;
}

.sidebar li:hover .tooltip {
  opacity: 1;
  pointer-events: auto;
  transition: var(--transition);
  top: 50%;
  transform: translateY(-50%);
}

.sidebar.expand .tooltip {
  display: none;
}

.home {
  position: relative;
  top: 0;
  left: 78px;
  width: calc(100% - 78px);
  min-height: 100vh;
  background: #ffffff;
  z-index: 6;
  transition: var(--transition);
}

.home .nav-top {
  background: #71e398;
  box-shadow: 1px 1px black;
}

.home .nav-top p {
  font-size: 20px;
  font-weight: 500;
  color: #000;
  display: inline-block;
  margin: 10px;
  white-space: nowrap;
  font-family: Arial sans-serif;
  font-size: xx-large;
}

#side_nav {
  background: #60c581;
  min-width: 250px;
  max-width: 250px;
  transition: all 0.3s;
}

.content {
  min-height: 100vh;
  width: 100%;
}

hr.h-color {
  background: #eee;
}

.sidebar li.active {
  background: #b3b3b3;
  border-radius: 8px;
}

.sidebar li.active a,
.sidebar li.active a:hover {
  color: #000;
}
.sidebar li a {
  color: #000000;
}

.content nav.navbar {
  background: #71e398;
}

@media (max-width: 767px) {
  #side_nav {
    margin-left: -250px;
    position: fixed;
    min-height: 100vh;
    z-index: 1;
  }
  #side_nav.active {
    margin-left: 0;
  }
}

.jumbotron {
  padding-top: 3rem;
  background-color: #f2ffe9;
}

.container {
  background-color: #71e398;
}

.container1 {
  background: #f2ffe9;
}

.footer {
  background: #b3b3b3;
}

.footer p {
  font-size: medium;
  color: black;
  font-weight: 500;
}

    </style>
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
                <a href="#">
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
                <a href="pengaturan1.html">
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
            <center>
                <p>QUICK.TOP</p>
            </center>
        </div>
        <!-- navtop end -->


        <section class="jumbotron text-center" style="background-color: #F2FFE9;">
            <img src="logoo.png" alt="" width="200" class="rounded-circle img-thumbnail">
            <h1 class="display-4" style="font-weight : bold;">QUICK.TOP</h1>
            <p class="lead" style="font-family : comic sans ms;">Website Jual Beli Pulsa</p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#71E398" fill-opacity="1" d="M0,96L40,117.3C80,139,160,181,240,170.7C320,160,400,96,480,64C560,32,640,32,720,53.3C800,75,880,117,960,117.3C1040,117,1120,75,1200,64C1280,53,1360,75,1400,85.3L1440,96L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
                </path>
            </svg>
        </section>

        <!-- Tentang kami -->
        <section id="about" style="background-color: #F2FFE9;">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col-md">
                        <h2 style="font-weight : bold;">Tentang Kami</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>Kami merancang website ini sebagai bagian dari tugas Project Base Learning (PBL).
                            Kenalkan, kami dari tim D kelas Informatika D Malam. Kami adalah mahasiswa Politeknik
                            Negeri Batam. Kelompok kami beranggotakan 5 orang, 3 diantaranya perempuan dan 2
                            laki-laki.</p>
                    </div>
                    <div class="col">
                        <p>Keuntungan dari aplikasi ini adalah waktu pembeliannya yang fleksibel. Seperti contoh,
                            ketika dalam keadaan darurat dan membutuhkan pulsa, sedangkan konter penjualan pulsa
                            sudah tutup. Oleh karena itu melalui aplikasi ini, pengguna dapat mengakses layanan
                            pengisian pulsa selama 24 jam dan tidak lagi mengkhawatirkan kehabisan pulsa di saat
                            darurat.</p>
                    </div>
                    <div class="col">
                        <p> Aplikasi jual beli pulsa ini bertujuan untuk membangun platform digital yang
                            memungkinkan pengguna untuk membeli pulsa dengan mudah dan nyaman. Tujuan dari pembuatan
                            jual beli pulsa secara online yaitu membuat akses menjadi lebih muda, meningkatkan
                            kepuasan pelanggan, pemantauan transaksi</p>
                    </div>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#71e398" fill-opacity="1" d="M0,288L30,277.3C60,267,120,245,180,213.3C240,181,300,139,360,133.3C420,128,480,160,540,186.7C600,213,660,235,720,240C780,245,840,235,900,213.3C960,192,1020,160,1080,165.3C1140,171,1200,213,1260,213.3C1320,213,1380,171,1410,149.3L1440,128L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z">
                </path>
            </svg>
        </section>

        <!-- anggota -->
        <section id="anggota" style="background-color: #F2FFE9;">
            <div class="container1">
                <div class="row text-center">
                    <div class="col">
                        <h2 style="font-weight : bold;">Anggota</h2>
                    </div>
                </div>
                <br>
                <br>
                <h3 class="ms-3">Front-end Developer</h3>
                <div class="row">
                    <div class="col mb-3 ms-4">
                        <div class="card" style="width: 18rem;">
                            <img src="https://img.freepik.com/free-vector/young-businessman-showing-ok-sign-hand-drawn-cartoon-art-illustration_56104-1093.jpg?size=626&ext=jpg&ga=GA1.1.2070552831.1701066348&semt=sph" class="card-img-top" alt="">
                            <div class="card-body">
                                <p class="card-body">Firjatullah Anang - 3312311111</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card" style="width: 18rem;">
                            <img src="https://img.freepik.com/premium-vector/muslim-woman-hijab-working-laptop-computer-showing-thumbs-up-flat-vector-illustration_852896-1429.jpg?size=626&ext=jpg&ga=GA1.1.2070552831.1701066348&semt=ais" class="card-img-top" alt="">
                            <div class="card-body">
                                <p class="card-body">Nailah Dipa - 3312311101</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card" style="width: 15rem;">
                            <img src="https://img.freepik.com/free-vector/illustration-female-character-wearing-hijab-working-office_10045-686.jpg?w=740&t=st=1701092669~exp=1701093269~hmac=bba7c677685444a514aca9b93084e25c9ec16110f6d66ec187da46da797709c0" class="card-img-top" alt="">
                            <div class="card-body">
                                <p class="card-body">Siti Zahwa - 3312311108</p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <p></p>
                    <h3 class="ms-3">Back-end Developer</h3>
                    <div class="row">
                        <div class="col mb-3 ms-4">
                            <div class="card" style="width: 18rem;">
                                <img src="https://img.freepik.com/premium-vector/concept-delight-thumbs-up_605305-33.jpg?w=740"" class=" card-img-top" alt="">
                                <div class="card-body">
                                    <p class="card-body">M. Dafa Putra - 3312311114</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card" style="width: 18rem;">
                                <img src="https://img.freepik.com/free-vector/hand-drawn-korean-drawing-style-character-illustration_23-2149601874.jpg?w=740&t=st=1701092755~exp=1701093355~hmac=d124f49ed6c04e2ea67d1eb424d18796911f2b4d1f0482f62472cd68376cb4d2" class="card-img-top" alt="">
                                <div class="card-body">
                                    <p class="card-body">Yunita Caroline - 3312311104</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#71E398" fill-opacity="1" d="M0,192L30,197.3C60,203,120,213,180,197.3C240,181,300,139,360,122.7C420,107,480,117,540,144C600,171,660,213,720,218.7C780,224,840,192,900,192C960,192,1020,224,1080,224C1140,224,1200,192,1260,165.3C1320,139,1380,117,1410,106.7L1440,96L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z">
                </path>
            </svg>
        </section>

        <!-- kontak -->
        <section id="contact" style="background-color: #F2FFE9;">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col">
                        <h2 style="font-weight : bold;">Kontak Kami</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" aria-describedby="name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" aria-describedby="email">
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea class="form-control" id="pesan" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <p></p>
                            <p></p>
                        </form>
                    </div>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#71E398" fill-opacity="1" d="M0,160L30,154.7C60,149,120,139,180,160C240,181,300,235,360,261.3C420,288,480,288,540,250.7C600,213,660,139,720,128C780,117,840,171,900,208C960,245,1020,267,1080,256C1140,245,1200,203,1260,170.7C1320,139,1380,117,1410,106.7L1440,96L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z">
                </path>
            </svg>
        </section>


        <!-- logo -->
        <center style="font-weight : bold; background-color : #F2FFE9">QUICK.TOP<br><img src="logo.jpeg" width="60" class="rounded-circle mt-2" alt="...">
            <br>
            <div class="py-3"><i class="bi bi-facebook"></i><i class="bi bi-twitter-x px-3"></i><i class="bi bi-instagram"></i></div>
        </center>
        </div>
        <!-- logo end -->
        <!-- footer -->
        <footer class="footer">
            <div class="row mb-5 text-center justify-content-between">
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
            <div class="copyright text-center font-weight-bold p-2 pb-2">
                <i class="bi bi-c-circle"></i>All Copyright Reserved
            </div>
        </footer>
        <!-- footer end -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
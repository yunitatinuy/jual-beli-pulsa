<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="admin.css">
  <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
  <title>ADMINISTRATOR</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand nav-link text-white" href="#">SELAMAT DATANG</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <form class="form-inline my-2 my-lg-0 ml-auto">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0 text-white" type="submit">Search</button>
      </form>
      <div class="icon ml-4">
        <h5>
          <i class="fas fa-envelope-square mr-3"></i>
          <i class="fas fa-bell-slash mr-3"></i>
          <a href="logout.php"><i class="fas fa-sign-out-alt mr-3"></i></a>
        </h5>
      </div>
    </div>
  </nav>
  <div class="row no-gutters mt-5">
    <div class="col col-md-2 mt-3 pr-3 pt-4">
      <ul class="nav flex-column ml-3 mb-5">
        <li class="nav-item">
          <a class="nav-link active text-white" href="dashboard.php"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
          <hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="index.php"><i class="fas fa-regular fa-layer-group mr-2"></i>Daftar Kategori</a>
          <hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="provider.php"><i class="fas fa-solid fa-sim-card mr-2"></i>Daftar Provider</a>
          <hr class="bg-secondary">
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="user.php"><i class="fas fa-solid fa-users mr-2"></i>Daftar Pengguna</a>
          <hr class="bg-secondary">
        </li>
      </ul>
    </div>

    <div class="col-md-10 p-5 pt-2">
      <h1><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</h1><br>
      <h3><i class="fas fa-regular fa-layer-group mr-2"></i> Daftar Kategori</h3>
      <hr>
      <table class="table table-striped table-bordered">
        <thread>
          <tr>
            <th scope="col">NO</th>
            <th scope="col">ID KATEGORI</th>
            <th scope="col">NAMA KATEGORI</th>
          </tr>
        </thread>
        <?php
        include 'koneksi.php';

        $query = mysqli_query($koneksi, "SELECT * FROM kategori");
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
        ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['id_kategori']; ?></td>
            <td><?php echo $data['nama_kategori']; ?></td>
          </tr>
        <?php
        }
        ?>
      </table>
      <br>

      <h3><i class="fas fa-regular fa-layer-group mr-2"></i> Daftar Provider</h3>
      <hr>
      <table class="table table-striped table-bordered">
        <thread>
          <tr>
            <th scope="col">NO</th>
            <th scope="col">KATEGORI</th>
            <th scope="col">NAMA PROVIDER</th>
            <th scope="col">DETAIL</th>
            <th scope="col">NOMINAL</th>
            <th scope="col">HARGA</th>
          </tr>
        </thread>
        <?php
        include 'koneksi.php';

        $query = mysqli_query($koneksi, "SELECT * FROM proveder");
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
        ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php
                if ($data['id_kategori'] == 1) {
                  echo 'Pulsa Elektrik';
                } else {
                  echo 'Kuota Internet';
                }
                ?></td>
            <td><?php echo $data['nama_provider']; ?></td>
            <td><?php echo $data['detail']; ?></td>
            <td><?php echo $data['nominal']; ?></td>
            <td><?php echo $data['harga']; ?></td>
          </tr>
        <?php
        }
        ?>
      </table>
      <br>

      <h3><i class="fas fa-regular fa-layer-group mr-2"></i> Daftar Pengguna</h3>
      <hr>
      <table class="table table-striped table-bordered">
        <thread>
          <tr>
            <th scope="col">NO</th>
            <th scope="col">ID PENGGUNA</th>
            <th scope="col">NAMA</th>
            <th scope="col">EMAIL</th>
            <th scope="col">STATUS</th>
          </tr>
        </thread>
        <?php
        include 'koneksi.php';

        $query = mysqli_query($koneksi, "SELECT * FROM user");
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
        ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['email']; ?></td>
            <td><?php
                if ($data['role'] == 1) {
                  echo 'admin';
                } else {
                  echo 'user';
                }
                ?></td>
          </tr>
        <?php
        }
        ?>
      </table>
      <br>




      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
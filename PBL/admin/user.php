<?php
session_start();
if(!isset($_SESSION['user'])){
header('location:../login.php');
exit;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
    <title>ADMINISTRATOR</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
      <a class="navbar-brand nav-link text-white" href="#" >SELAMAT DATANG</a>
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
        <a class="nav-link active text-white" href="dashboard.php"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a><hr class="bg-secondary">
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="index.php"><i class="fas fa-regular fa-layer-group mr-2"></i>Daftar Kategori</a><hr class="bg-secondary">
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="provider.php"><i class="fas fa-solid fa-sim-card mr-2"></i>Daftar Provider</a><hr class="bg-secondary">
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="user.php"><i class="fas fa-solid fa-users mr-2"></i>Daftar Pengguna</a><hr class="bg-secondary">
      </li>
    </ul>
  </div>

  <div class="col-md-10 p-5 pt-2">
    <h3><i class="fas fa-regular fa-layer-group mr-2"></i> Daftar Pengguna</h3><hr>
        <a href="tambah_user.php" class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahuser"> 
        <i class="fas fa-plus-circle mr-2"></i>TAMBAH DATA PENGGUNA</a>
        <table class="table table-striped table-bordered">
          <thread>
            <tr>
              <th scope="col">NO</th>
              <th scope="col">ID PENGGUNA</th>
              <th scope="col">NAMA</th>
              <th scope="col">EMAIL</th>
              <th scope="col">STATUS</th>
              <th colspan="3" scope="col">AKSI</th>
            </tr>
          </thread>
          <?php
              include 'koneksi.php';

                $query = mysqli_query($koneksi, "SELECT * FROM user");
                $no = 1;
                while ($data = mysqli_fetch_assoc($query)) {
          ?>
            <tr>
              <td><?php echo $no++;?></td>
              <td><?php echo $data['id_user'];?></td>
              <td><?php echo $data['nama'];?></td>
              <td><?php echo $data['email'];?></td>
              <td><?php 
                if ($data['role'] == 1 ){
                  echo 'admin';
                }else {
                  echo 'user';
                }
                ?></td>
              <td>
                <i class="fas fa-edit bg-success p-2 text-white rounded"></i>
                <a href="ubah_user.php" data-toggle="modal" data-target="#edituser<?php echo $data['id_user'];?>">Edit</a>
                <i class="fas fa-trash-alt bg-danger p-2 text-white rounded"></i>
                <a href="hapus_user.php" data-toggle="modal" data-target="#deleteuser<?php echo $data['id_user'];?>">Delete</a>
              </td>
            </tr>

            <!-- update modal -->
<div class="example-modal">
<div class="modal fade" id="edituser<?php echo $data['id_user'];?>" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title">Edit Data Pengguna</h3>
</div>
<div class="modal-body">
<form action="update_user.php" method="post" role="form">
<?php
$id_user = $data['id_user'];
$query1 = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id_user'"); while ($data1 = mysqli_fetch_assoc($query1)) {
?>
<div class="form-group">
<div class="row">
<label class="col-sm-3 control-label text-right">Id Pengguna</label>
<div class="col-sm-8"><input type="text" class="form-control" name="id_user" value="<?php echo
$data1['id_user']; ?>" ReadOnly></div>
</div>
</div>
<div class="form-group">
<div class="row">
<label class="col-sm-3 control-label text-right">Nama Pengguna</label>
<div class="col-sm-8"><input type="text" class="form-control" name="nama" value="<?php echo
$data1['nama']; ?>"></div>
</div>
</div>
<div class="form-group">
<div class="row">
<label class="col-sm-3 control-label text-right">Email</label>
<div class="col-sm-8"><input type="text" class="form-control" name="email" value="<?php echo
$data1['email']; ?>"></div>
</div>
</div>
<div class="form-group">
<div class="row">
<label class="col-sm-3 control-label text-right">Status</label>
<div class="col-sm-8"><input type="text" class="form-control" name="role" value="<?php echo
$data1['role']; ?>"></div>
</div>
</div>
<div class="modal-footer">
<button id="noedit" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Batal</button>
<input type="submit" name="submit" class="btn btn-primary" value="Update">
</div>
<?php
}
?>
</form> </div> </div> </div> </div></div>

            <!-- modal delete -->
<div class="example-modal">
<div id="deleteuser<?php echo $data['id_user']; ?>" class="modal fade" role="dialog" style="display:none;">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title">Konfirmasi Hapus Data</h3>
</div>
<div class="modal-body">
<h5 align="center" >Apakah anda yakin ingin menghapus Pengguna <?php echo $data['nama'];?><strong><span class="grt"></span></strong> ?</h5>
</div>
<div class="modal-footer">
<button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancle</button>
<a href="hapus_user.php?id_user=<?php echo $data['id_user']; ?>" class="btn btn-primary">Delete</a>
</div>
</div>
</div>
</div>
</div>
                <?php
                }
            ?>
        </table>
        </tbody>
      </table>
  </div>

</div>
              <!-- Simpan Modal  -->
<div class="example-modal">
<div id="tambahuser" class="modal fade" role="dialog" style="display:none;">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title">Tambah Data Baru</h3>
</div>
<div class="modal-body">
<form action="simpan_user.php" method="post" role="form">
<div class="form-group">
<div class="row">
<label class="col-sm-3 control-label text-right">Nama Pengguna</label>
<div class="col-sm-8"><input type="text" class="form-control" name="nama" placeholder="Nama Pengguna" value="" Required></div>
</div>
</div>
<div class="form-group">
<div class="row">
<label class="col-sm-3 control-label text-right">Username</label>
<div class="col-sm-8"><input type="text" class="form-control" name="username" placeholder="Username" value="" Required></div>
</div>
</div>
<div class="form-group">
<div class="row">
<label class="col-sm-3 control-label text-right">Email</label>
<div class="col-sm-8"><input type="text" class="form-control" name="email" placeholder="Email" value="" Required></div>
</div>
</div>
<div class="form-group">
<div class="row">
<label class="col-sm-3 control-label text-right">Password</label>
<div class="col-sm-8"><input type="password" class="form-control" name="password" placeholder="Password" value="" Required></div>
</div>
</div>
<div class="form-group">
<div class="row">
<label class="col-sm-3 control-label text-right">Confirm Password</label>
<div class="col-sm-8"><input type="password" class="form-control" name="password2" placeholder="Confirm Password" value="" Required></div>
</div>
</div>
<div class="modal-footer">
<button id="nosave" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Batal</button>
<input type="submit" name="submit" class="btn btn-primary" value="Simpan">
</div>
</form>
</div>
</div>
</div>
</div>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
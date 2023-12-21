<?php
session_start();
if(!isset($_SESSION['user'])){
header('location:../login.php');
exit;
}

$pengguna = $_SESSION['user']["nama"];
?>
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
    <a class="navbar-brand nav-link text-white" href="#">SELAMAT DATANG <?php echo $pengguna ?></a>
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
        <li class="nav-item">
          <a class="nav-link text-white" href="transaksi.php"><i class="fas fa-solid fa-money-bill mr-2"></i>Daftar Transaksi</a>
          <hr class="bg-secondary">
        </li>
      </ul>
    </div>

    <div class="col-md-10 p-5 pt-2">
      <h3><i class="fas fa-regular fa-layer-group mr-2"></i> Daftar Provider</h3>
      <hr>
      <a href="tambah_prv" class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahprv">
        <i class="fas fa-plus-circle mr-2"></i>TAMBAH DATA PROVIDER</a>
      <table class="table table-striped table-bordered">
        <thread>
          <tr>
            <th scope="col">NO</th>
            <th scope="col">KATEGORI</th>
            <th scope="col">NAMA PROVIDER</th>
            <th scope="col">DETAIL</th>
            <th scope="col">NOMINAL</th>
            <th scope="col">HARGA</th>
            <th scope="col">FOTO</th>
            <th colspan="3" scope="col">AKSI</th>
          </tr>
        </thread>
        <?php
        include 'koneksi.php';
        
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM proveder
                INNER JOIN kategori ON proveder.id_kategori = kategori.id_kategori");
                while ($data = mysqli_fetch_array($query)) {
        ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['nama_kategori']; ?></td>
            <td><?php echo $data['nama_provider']; ?></td>
            <td><?php echo $data['detail']; ?></td>
            <td><?php echo $data['nominal']; ?></td>
            <td><?php echo $data['harga']; ?></td>
            <td><?php echo $data['foto']; ?></td>
            <td>
              <i class="fas fa-edit bg-success p-2 text-white rounded"></i>
              <a href="ubah_prv.php" data-toggle="modal" data-target="#editprv<?php echo $data['id_provider']; ?>">Edit</a><br>
              <i class="fas fa-trash-alt bg-danger p-2 text-white rounded"></i>
              <a href="hapus_prv.php" data-toggle="modal" data-target="#deleteprv<?php echo $data['id_provider']; ?>">Delete</a>
            </td>
          </tr>

          <!-- update modal -->
          <div class="example-modal">
            <div class="modal fade" id="editprv<?php echo $data['id_provider']; ?>" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title">Edit Data Provider</h3>
                  </div>
                  <div class="modal-body">
                    <form action="update_prv.php" method="post" role="form">
                      <?php
                      $id_provider = $data['id_provider'];
                      $query1 = mysqli_query($koneksi, "SELECT * FROM proveder WHERE id_provider='$id_provider'");
                      while ($data1 = mysqli_fetch_assoc($query1)) {
                      ?>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Id Kategori </label>
                            <div class="col-sm-8"><input type="text" class="form-control" name="id_kategori" value="<?php echo
                                                                                                                    $data1['id_kategori']; ?>" ReadOnly></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Id Provider </label>
                            <div class="col-sm-8"><input type="text" class="form-control" name="id_provider" value="<?php echo
                                                                                                                    $data1['id_provider']; ?>" ReadOnly></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Nama Provider</label>
                            <div class="col-sm-8"><input type="text" class="form-control" name="nama_provider" value="<?php echo
                                                                                                                      $data1['nama_provider']; ?>"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Detail</label>
                            <div class="col-sm-8"><input type="text" class="form-control" name="detail" value="<?php echo
                                                                                                                $data1['detail']; ?>"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Nominal</label>
                            <div class="col-sm-8"><input type="text" class="form-control" name="nominal" value="<?php echo
                                                                                                                $data1['nominal']; ?>"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Harga</label>
                            <div class="col-sm-8"><input type="text" class="form-control" name="harga" value="<?php echo
                                                                                                              $data1['harga']; ?>"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-3 control-label text-right">Foto</label>
                            <img src="foto_produk/<?php echo $data1['foto']; ?>" width="200">
                          </div>
                        </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-3 control-label text-right">Ganti Foto</label>
                      <div class="col-sm-8"><input type="file" name="foto" class="form-control"></div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button id="noedit" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Batal</button>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update">
                  </div>
                <?php
                      }
                ?>
                </form>
                </div>
              </div>
            </div>
          </div>
    </div>


    <!-- modal delete -->
    <div class="example-modal">
      <div id="deleteprv<?php echo $data['id_provider']; ?>" class="modal fade" role="dialog" style="display:none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Konfirmasi Hapus Data</h3>
            </div>
            <div class="modal-body">
              <h5 align="center">Apakah anda yakin ingin menghapus Provider <?php echo $data['nama_provider']; ?><strong><span class="grt"></span></strong> ?</h5>
            </div>
            <div class="modal-footer">
              <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
              <a href="hapus_prv.php?id_provider=<?php echo $data['id_provider']; ?>" class="btn btn-primary">Delete</a>
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
  <?php
    $querykategori = mysqli_query($koneksi, "SELECT * FROM kategori");

  ?>

  <div class="example-modal">
    <div id="tambahprv" class="modal fade" role="dialog" style="display:none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Tambah Data Baru</h3>
          </div>
          <div class="modal-body">
            <form action="simpan_prv.php" method="post" role="form">
            <div class="form-group">
              <div class="row">
              <label class="col-sm-3 control-label text-right">Kategori</label>
              <div class="col-sm-8">
                <select name="id_kategori" class="form-control" placeholder="Kategori" Required >
                  <option value=""> Pilih Kategori</option>
                    <?php
                      while ($data = mysqli_fetch_array($querykategori)) {
                      ?>
                        <option value="<?php echo $data['id_kategori'];?>"> <?php echo $data['nama_kategori']; ?> </option>
                      <?php
                      }
                      ?>
              </select></div>
              </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Nama Provider</label>
                  <div class="col-sm-8"><input type="text" class="form-control" name="nama_provider" placeholder="Nama Provider" value="" Required></div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Detail</label>
                  <div class="col-sm-8"><input type="text" class="form-control" name="detail" placeholder="Detail" value="" Required></div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Nominal</label>
                  <div class="col-sm-8"><input type="text" class="form-control" name="nominal" placeholder="Nominal" value="" Required></div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Harga</label>
                  <div class="col-sm-8"><input type="text" class="form-control" name="harga" placeholder="harga" value="" Required></div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-3 control-label text-right">Foto</label>
                  <div class="col-sm-8"><input type="file" class="form-control" name="foto" placeholder="foto" value="" Required></div>
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
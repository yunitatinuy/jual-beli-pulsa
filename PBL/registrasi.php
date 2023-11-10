<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "db_admin";

$koneksi = mysqli_connect($host, $user, $pass, $db) or die(mysql_error($koneksi));

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    $cek_user = mysqli_query($koneksi,"SELECT * FROM user WHERE username = '$username' ");
    $cek_login = mysqli_num_rows($cek_user);

    if ($cek_login > 0) {
        echo "<script>
              alert('Username telah terdaftar');
              window.location = 'registrasi.php;
        </script>";
    }else {
        if ($password1 != $password2) {
          echo "<script>
              alert('Password Tidak Sesuai');
              window.location = 'registrasi.php;
        </script>";
        }else {
            mysqli_query($koneksi,"INSERT INTO user VALUES('','$nama','$username','$email','$password1')") or die(mysql_error());
            echo "<script>
            alert('Data berhasil dikirim');
            window.location = 'index.php';
        </script>";
        }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jual Beli Pulsa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg ">
    <div class="container">
      <a class="navbar-brand" href="#">QUICK.TOP</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-right" id="navbarText">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- navbar end -->

  <!-- foto -->
  <div class="mt-5">
    <center><img src="logo.jpeg" width="250" class="rounded-circle" alt="..."></center>
  </div>
  <!-- foto end -->
  
  <!-- login -->
  <div class="container1 mt-5">
    <div class="card login-form">
      <div class="card-body">
        <h5 class="card-title mt-5 text-center">CREATE ACCOUNT</h5>
        <form action="" method="POST">
          <div class="mb-0  ">
            <label for="exampleInputFullname1" class="form-label"></label>
            <input type="text" name="nama" class="form-control" id="exampleInputFullname" placeholder="FULLNAME">
          </div>
          <div class="mb-0">
            <label for="exampleInputPassword1" class="form-label"></label>
            <input type="text" name="username" class="form-control" id="exampleInputUsername" placeholder="USERNAME">
          </div>
          <div class="mb-0">
            <label for="exampleInputPassword1" class="form-label"></label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="EMAIL">
          </div>
          <div class="mb-0">
            <label for="exampleInputPassword1" class="form-label"></label>
            <input type="password" name="password1" class="form-control" id="exampleInputPassword1" placeholder="PASSWORD">
          </div>
          <div class="mb-0">
            <label for="exampleInputPassword1" class="form-label"></label>
            <input type="password" name="password2" class="form-control" id="exampleInputPassword1" placeholder="REPEAT PASSWORD">
          </div>
          <div class="d-flex justify-content-between">
            <div class="mb-2 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">I agree to the terms of User</label>
            </div>
            <!-- <div>
              <a href="#">Forgot Password?</a>
            </div> -->
          </div>
          <div class="d-grid mt-3">
          <button type="submit" name="submit" class="btn btn-primary btn-login">SIGN UP</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- login end -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
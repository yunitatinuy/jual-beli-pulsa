<?php

include 'koneksi.php';

if (isset($_POST['login'])) {
  $username = $_POST['user'];
  $password = $_POST['pass'];

  $ambil = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' ");

  if (mysqli_num_rows($ambil) === 1) {
    $data = mysqli_fetch_assoc($ambil);

    if (password_verify($password,$data['password'])) {
      header("location:admin.php");
      exit();
    }else{
      echo "<script>
      alert('Username atau Password Salah');
      window.location = 'index.php';
    </script>";
    }

  }else {
    echo "<script>
      alert('Username atau Password Salah');
      window.location = 'index.php';
    </script>";
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
            <a class="nav-link active" aria-current="page" href="registrasi.php">Registration</a>
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
        <h5 class="card-title mt-5 text-center">ACCOUNT LOGIN</h5>
        <form action="" method="POST">
          <div class="mb-0  ">
          <label for="exampleInputPassword1" class="form-label"></label>
          <input type="text" name="user" class="form-control" id="exampleInputUsername" placeholder="USERNAME">
          </div>
          <div class="mb-0">
            <label for="exampleInputPassword1" class="form-label"></label>
            <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="PASSWORD">
          </div>
          <div class="d-flex justify-content-between">
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Remember me</label>
            </div>
            <div>
              <a href="#">Forgot Password?</a>
            </div>
          </div>
          <div class="d-grid mt-5">
          <button type="submit" name="login" class="btn btn-primary btn-login" value="login">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- login end -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
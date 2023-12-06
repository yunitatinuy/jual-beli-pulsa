<?php

include 'koneksi.php';

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $pass_acak = password_hash($password, PASSWORD_DEFAULT);
    $data = mysqli_query($koneksi,"SELECT * FROM user WHERE username = '$username' and password='$password' ");
    if (mysqli_num_rows($data) > 0) {
        echo "<script>
              alert('User baru berhasil didaftarkan');
              window.location = 'registrasi.php';
        </script>";
    }else {
        if ($password == $password2) {
          $query = "INSERT INTO user VALUES('','$nama','$username','$email','$pass_acak','')";
          mysqli_query($koneksi,$query);
          echo "<script>
            alert('Data berhasil dikirim');
            window.location = 'login.php';
            </script>";
          
        }else  {
          echo "<script>
          alert('Konfirmasi password tidak sesuai');
          window.location = 'registrasi.php';
          </script>";
        }
    }

?>
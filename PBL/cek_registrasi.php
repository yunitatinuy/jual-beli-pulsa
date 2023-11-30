<?php

include 'koneksi.php';

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $data = mysqli_query($koneksi,"SELECT * FROM user WHERE username = '$username' and password='$password' ");
    if (mysqli_num_rows($data) > 0) {
        echo "<script>
              alert('Username telah terdaftar');
              window.location = 'registrasi.php';
        </script>";
    }else {
        if ($password == $password2) {
          $query = "INSERT INTO user VALUES('','$nama','$username','$email','$password','')";
          mysqli_query($koneksi,$query);
          echo "<script>
            alert('Data berhasil dikirim');
            window.location = 'login.php';
            </script>";
          
        }else  {
          echo "<script>
          alert('Password Tidak Sesuai');
          window.location = 'registrasi.php';
          </script>";
        }
    }

?>
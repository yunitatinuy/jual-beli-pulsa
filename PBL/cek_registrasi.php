<?php

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("location:registrasi.php");
  exit;
}

function kembali_registrasi($pesan)
{
  echo "<script>
        alert(" . json_encode($pesan) . ");
        window.location = 'registrasi.php';
        </script>";
  exit;
}

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';

if ($nama === '' || $username === '' || $email === '' || $password === '') {
  kembali_registrasi('Semua data wajib diisi');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  kembali_registrasi('Format email tidak valid');
}

$stmt = mysqli_prepare($koneksi, "SELECT id_user FROM user WHERE username = ?");
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
  kembali_registrasi('Username telah terdaftar, Coba yang lain!');
} elseif ($password != $password2) {
  kembali_registrasi('Konfirmasi password tidak sesuai');
} else {
  $pass_acak = password_hash($password, PASSWORD_DEFAULT);
  $role = 0;
  $stmt = mysqli_prepare($koneksi, "INSERT INTO user (nama, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, 'ssssi', $nama, $username, $email, $pass_acak, $role);
  if (mysqli_stmt_execute($stmt)) {
    echo "<script>
            alert('Data berhasil dikirim');
            window.location = 'login.php';
            </script>";
  } else {
    kembali_registrasi('Registrasi gagal, silahkan coba lagi');
  }
}

?>
<?php
require_once __DIR__ . '/cek_admin.php';

function kembali_user($pesan)
{
    echo "<script>
          alert(" . json_encode($pesan) . ");
          window.location = 'user.php';
          </script>";
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';

if ($nama === '' || $username === '' || $password === '') {
    kembali_user('Semua data wajib diisi');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    kembali_user('Format email tidak valid');
}

$stmt = mysqli_prepare($koneksi, "SELECT id_user FROM user WHERE username = ?");
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    kembali_user('Username telah terdaftar, Coba yang lain!');
} elseif ($password != $password2) {
    kembali_user('Konfirmasi password tidak sesuai');
}

$pass_acak = password_hash($password, PASSWORD_DEFAULT);
$role = 0;
$stmt = mysqli_prepare($koneksi, "INSERT INTO user (nama, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'ssssi', $nama, $username, $email, $pass_acak, $role);
kembali_user(mysqli_stmt_execute($stmt) ? 'Data berhasil dikirim' : 'Data gagal disimpan');

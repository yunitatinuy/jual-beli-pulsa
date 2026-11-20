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
$role = ((int) ($_POST['role'] ?? 0)) === 1 ? 1 : 0;

if ($nama === '' || $password === '') {
    kembali_user('Nama dan password wajib diisi');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    kembali_user('Format email tidak valid');
}
if (strlen($password) < 6) {
    kembali_user('Password minimal 6 karakter');
}
// konfirmasi password hanya dicek jika form mengirimkannya
if (isset($_POST['password2']) && $password !== $_POST['password2']) {
    kembali_user('Konfirmasi password tidak sesuai');
}

// cek apakah username sudah dipakai
function username_terpakai($koneksi, $username)
{
    $stmt = mysqli_prepare($koneksi, "SELECT id_user FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    return mysqli_stmt_num_rows($stmt) > 0;
}

if ($username !== '') {
    if (username_terpakai($koneksi, $username)) {
        kembali_user('Username telah terdaftar, Coba yang lain!');
    }
} else {
    // form tambah pengguna tidak punya kolom username: buat otomatis dari email (contoh: budi, budi2, ...)
    $dasar = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', strstr($email, '@', true)));
    if ($dasar === '') {
        $dasar = 'user';
    }
    $username = $dasar;
    $nomor = 2;
    while (username_terpakai($koneksi, $username)) {
        $username = $dasar . $nomor++;
    }
}

$pass_acak = password_hash($password, PASSWORD_DEFAULT);
$stmt = mysqli_prepare($koneksi, "INSERT INTO user (nama, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'ssssi', $nama, $username, $email, $pass_acak, $role);
kembali_user(mysqli_stmt_execute($stmt)
    ? 'Pengguna berhasil ditambahkan. Username untuk login: ' . $username
    : 'Data gagal disimpan');

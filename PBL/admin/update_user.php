<?php
require_once __DIR__ . '/cek_admin.php';

function kembali_user($pesan)
{
    echo "<script>alert(" . json_encode($pesan) . "); window.location = 'user.php';</script>";
    exit;
}

$id_user = (int) ($_POST['id_user'] ?? 0);
$nama = trim($_POST['nama'] ?? '');
// email sengaja tidak dibaca dari form: admin tidak boleh mengubah email pengguna
$role = ((int) ($_POST['role'] ?? 0)) === 1 ? 1 : 0;
$password_baru = $_POST['password_baru'] ?? ($_POST['password'] ?? ''); // form edit memakai name="password"

if ($nama === '') {
    kembali_user('Nama wajib diisi');
}

// ambil role lama
$stmt = mysqli_prepare($koneksi, "SELECT role FROM user WHERE id_user = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_user);
mysqli_stmt_execute($stmt);
$lama = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$lama) {
    kembali_user('Pengguna tidak ditemukan');
}

// admin tidak boleh menurunkan status dirinya sendiri (akan langsung terkunci dari halaman admin)
if ($id_user === (int) $_SESSION['user']['id_user'] && $role !== 1) {
    kembali_user('Anda tidak dapat mengubah status akun Anda sendiri menjadi user');
}
// minimal harus tersisa satu admin
if ((int) $lama['role'] === 1 && $role !== 1) {
    $jumlah_admin = (int) mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM user WHERE role = 1"))[0];
    if ($jumlah_admin <= 1) {
        kembali_user('Harus ada minimal satu admin');
    }
}

if ($password_baru !== '') {
    $pass_acak = password_hash($password_baru, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($koneksi, "UPDATE user SET nama = ?, role = ?, password = ? WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, 'sisi', $nama, $role, $pass_acak, $id_user);
} else {
    $stmt = mysqli_prepare($koneksi, "UPDATE user SET nama = ?, role = ? WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, 'sii', $nama, $role, $id_user);
}
mysqli_stmt_execute($stmt);

// perbarui data sesi jika admin mengubah datanya sendiri
if ($id_user === (int) $_SESSION['user']['id_user']) {
    $_SESSION['user']['nama'] = $nama;
    if (isset($pass_acak)) {
        $_SESSION['user']['password'] = $pass_acak;
    }
}
header("location: user.php");
exit;

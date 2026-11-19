<?php
//mengaktifkan session php + koneksi
require_once 'sesi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location:login.php");
    exit;
}

//menangkap data yang dikirim dari form
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

//menyeleksi data user sesuai dengan username (prepared statement, aman dari SQL injection)
$stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE username = ?");
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($row && password_verify($password, $row['password'])) {
    session_regenerate_id(true);
    $_SESSION['user'] = $row;

    //fitur Remember me
    if (!empty($_POST['ingat'])) {
        set_cookie_ingat($row);
    } else {
        hapus_cookie_ingat();
    }

    if ((int) $row['role'] === 1) {
        header("location:./admin/dashboard.php");
    } else {
        header("location:./pembeli/dashboard.php");
    }
    exit;
} else {
    echo "<script> alert('Data Anda Tidak Valid');
    window.location = 'login.php';
    </script>";
}
?>
<?php
//mengaktifkan session php
session_start();

include 'koneksi.php';

//menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];

//menyeleksi data admin sesuai dengan username dan password
$data = mysqli_query($koneksi, "SELECT * FROM user where username='$username'");
$row = mysqli_fetch_assoc($data);
if (password_verify($password, $row['password'])) {
    if(mysqli_num_rows($data)==1) {
        $_SESSION['user'] = $row;
    if ($row['role'] == 1) {
        header("location:./admin/dashboard.php");
    } else if ($row['role'] == 0) {
        header("location:./pembeli/dashboard.php");
    }
}
}else {
    echo "<script> alert('Data Anda Tidak Valid');
    window.location = 'login.php'; 
    </script>";
}
?>
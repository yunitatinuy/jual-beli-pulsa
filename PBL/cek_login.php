<?php
//mengaktifkan session php
session_start();

include 'koneksi.php';

//menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];

//menyeleksi data admin sesuai dengan username dan password
$data = mysqli_query($koneksi, "SELECT * FROM user where username='$username' and password='$password'");
if(mysqli_num_rows($data)>0) {
    $row = mysqli_fetch_assoc($data); 

        $_SESSION['user'] = $row['username'];
        $_SESSION['pass'] = $row['password'];
    header("location:admin.php");
}else {
    echo "<script> alert('Data Anda Tidak Valid');
    window.location = 'index.php'; 
    </script>";
}
?>
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbjualbelipulsa";

// kunci rahasia untuk menandatangani cookie "Remember me"
if (!defined('APP_KEY')) {
    define('APP_KEY', 'quicktop-4f9b2c7e1a8d6035b2e9c4f7a1d8e6b3');
}

date_default_timezone_set('Asia/Jakarta');

$koneksi = mysqli_connect($host, $user, $pass, $db) or die("Koneksi Gagal: " . mysqli_connect_error());
mysqli_set_charset($koneksi, 'utf8mb4');

if (!function_exists('e')) {
    // mengamankan output HTML dari XSS
    function e($teks)
    {
        return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
    }
}
?>
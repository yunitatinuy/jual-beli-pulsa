<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_admin";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if(!$koneksi){
    echo "Koneksi Gagal: " . die(mysql_error($koneksi));
}
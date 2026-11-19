<?php
// Wajib dipanggil di setiap halaman/aksi admin: hanya user dengan role admin (1) yang boleh masuk.
require_once __DIR__ . '/../sesi.php';
wajib_admin('../login.php');

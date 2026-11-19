<?php
// Inisialisasi sesi + koneksi + login otomatis lewat cookie "Remember me".
// Dipanggil di awal setiap halaman yang butuh sesi.
if (session_status() === PHP_SESSION_NONE) {
    if (!@session_start()) {
        // tanpa sesi, login tidak akan pernah tersimpan; tampilkan penyebabnya dengan jelas
        http_response_code(500);
        die('Sesi PHP tidak bisa disimpan di folder "' . htmlspecialchars(session_save_path()) . '" (akses ditolak). '
            . 'Hentikan semua server PHP yang sedang berjalan, lalu jalankan ulang satu server saja.');
    }
}
require_once __DIR__ . '/koneksi.php';

if (!defined('COOKIE_INGAT')) {
    define('COOKIE_INGAT', 'quicktop_ingat');
}

if (!function_exists('buat_token_ingat')) {
    function buat_token_ingat($user)
    {
        $kadaluarsa = time() + 60 * 60 * 24 * 30; // 30 hari
        $tanda = hash_hmac('sha256', $user['id_user'] . '|' . $kadaluarsa . '|' . $user['password'], APP_KEY);
        return $user['id_user'] . '|' . $kadaluarsa . '|' . $tanda;
    }

    function set_cookie_ingat($user)
    {
        $token = buat_token_ingat($user);
        $kadaluarsa = (int) explode('|', $token)[1];
        setcookie(COOKIE_INGAT, $token, ['expires' => $kadaluarsa, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
    }

    function hapus_cookie_ingat()
    {
        setcookie(COOKIE_INGAT, '', ['expires' => time() - 3600, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
        unset($_COOKIE[COOKIE_INGAT]);
    }

    function wajib_login($lokasi_login = '../login.php')
    {
        if (!isset($_SESSION['user'])) {
            header('location:' . $lokasi_login);
            exit;
        }
    }

    function wajib_admin($lokasi_login = '../login.php')
    {
        wajib_login($lokasi_login);
        if ((int) $_SESSION['user']['role'] !== 1) {
            header('location:../pembeli/dashboard.php');
            exit;
        }
    }
}

// login otomatis dari cookie
if (!isset($_SESSION['user']) && !empty($_COOKIE[COOKIE_INGAT])) {
    $bagian = explode('|', $_COOKIE[COOKIE_INGAT]);
    if (count($bagian) === 3 && (int) $bagian[1] > time()) {
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE id_user = ?");
        $id_cookie = (int) $bagian[0];
        mysqli_stmt_bind_param($stmt, 'i', $id_cookie);
        mysqli_stmt_execute($stmt);
        $user_cookie = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        if ($user_cookie) {
            $tanda = hash_hmac('sha256', $user_cookie['id_user'] . '|' . $bagian[1] . '|' . $user_cookie['password'], APP_KEY);
            if (hash_equals($tanda, $bagian[2])) {
                session_regenerate_id(true);
                $_SESSION['user'] = $user_cookie;
            }
        }
    }
    if (!isset($_SESSION['user'])) {
        hapus_cookie_ingat();
    }
}

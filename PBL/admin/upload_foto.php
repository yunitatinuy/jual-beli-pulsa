<?php
// Menyimpan foto produk ke folder pembeli/foto_produk (folder yang dibaca halaman pembeli).
// Mengembalikan nama file baru, null jika tidak ada file, atau false jika file tidak valid.
function upload_foto_produk($field)
{
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 2 * 1024 * 1024) {
        return false;
    }
    $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ekstensi, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true) || @getimagesize($file['tmp_name']) === false) {
        return false;
    }
    $folder = __DIR__ . '/../pembeli/foto_produk/';
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
    $nama_dasar = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
    $nama_baru = ($nama_dasar !== '' ? $nama_dasar : 'produk') . '_' . time() . '.' . $ekstensi;
    return move_uploaded_file($file['tmp_name'], $folder . $nama_baru) ? $nama_baru : false;
}

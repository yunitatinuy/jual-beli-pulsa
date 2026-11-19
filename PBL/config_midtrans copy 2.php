<?php
// ------------------------------------------------------------
// Konfigurasi Midtrans
// 1. Salin file ini menjadi "config_midtrans.php" (di folder yang sama).
// 2. Isi Server Key & Client Key SANDBOX dari dashboard Midtrans:
//    https://dashboard.sandbox.midtrans.com > Settings > Access Keys
// File config_midtrans.php tidak ikut di-commit ke git (lihat .gitignore).
// ------------------------------------------------------------
return [
    'server_key'    => 'SB-Mid-server-UCMqixWCo~8j14FMk~v9450V',
    'client_key'    => 'Mid-client-Xroic0BFuadfjAU2',
    'is_production' => false,   // biarkan false (Sandbox / uang dummy)
    'batas_bayar_menit' => 15,  // batas waktu pembayaran
];

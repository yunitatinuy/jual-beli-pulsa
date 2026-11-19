# jual-beli-pulsa

## Pembayaran (Midtrans Sandbox)

1. **Database** – jalankan `PBL/migrasi_midtrans.sql` sekali di database `db_admin`
   (untuk instalasi baru, `PBL/db_admin.sql` sudah berisi migrasi ini).
2. **Kunci Midtrans** – daftar gratis di https://dashboard.sandbox.midtrans.com,
   buka *Settings → Access Keys*, lalu salin `PBL/config_midtrans.example.php`
   menjadi `PBL/config_midtrans.php` dan isi Server Key & Client Key sandbox.
   File ini tidak ikut di-commit.
3. **Bayar dummy** – setelah checkout, klik *Bayar Sekarang*, pilih metode, lalu bayar di
   https://simulator.sandbox.midtrans.com (QRIS/e-wallet/VA) atau pakai kartu uji
   `4811 1111 1111 1114`, CVV `123`, OTP `112233`. Klik *Cek Status Pembayaran*.
4. **Notifikasi otomatis (opsional)** – Midtrans tidak bisa menjangkau `localhost`.
   Jalankan `ngrok http 8000`, lalu isi *Settings → Payment → Notification URL* dengan
   `https://<alamat-ngrok>/notifikasi.php`.
5. **Pengisian pulsa** disimulasikan di `PBL/supplier_pulsa.php`
   (nomor tujuan berakhiran `000` = gagal, selain itu berhasil + nomor SN).

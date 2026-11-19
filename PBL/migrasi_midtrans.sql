-- ------------------------------------------------------------
-- Migrasi fitur pembayaran Midtrans (Sandbox)
-- Jalankan sekali pada database db_admin (phpMyAdmin > tab SQL).
-- Aman untuk data lama: transaksi lama ditandai sudah dibayar & pulsa berhasil.
-- ------------------------------------------------------------

ALTER TABLE `transaksi_penjualan`
  MODIFY `id_metode_bayar` int(11) NULL DEFAULT NULL,
  ADD `order_id` varchar(50) NULL DEFAULT NULL AFTER `id_transaksi_penjualan`,
  ADD `status_bayar` varchar(20) NOT NULL DEFAULT 'menunggu' AFTER `total_pembelian`,
  ADD `metode_pembayaran` varchar(50) NULL DEFAULT NULL AFTER `status_bayar`,
  ADD `snap_token` varchar(255) NULL DEFAULT NULL AFTER `metode_pembayaran`,
  ADD `kedaluwarsa` datetime NULL DEFAULT NULL AFTER `snap_token`,
  ADD `waktu_bayar` datetime NULL DEFAULT NULL AFTER `kedaluwarsa`,
  ADD `status_pulsa` varchar(20) NOT NULL DEFAULT 'menunggu' AFTER `waktu_bayar`,
  ADD `sn` varchar(50) NULL DEFAULT NULL AFTER `status_pulsa`,
  ADD UNIQUE KEY `order_id` (`order_id`);

-- transaksi lama (sebelum ada Midtrans) dianggap sudah lunas & pulsa terkirim
UPDATE `transaksi_penjualan`
  SET `status_bayar` = 'dibayar', `status_pulsa` = 'berhasil'
  WHERE `order_id` IS NULL;

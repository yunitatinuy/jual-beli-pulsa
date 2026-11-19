<?php
// ------------------------------------------------------------
// SIMULASI supplier pulsa (pengganti API supplier H2H seperti Digiflazz).
// Pulsa TIDAK benar-benar dikirim ke HP; fungsi ini hanya meniru jawaban supplier.
//
// Aturan simulasi untuk pengujian:
//  - Nomor tujuan berakhiran "000"  -> pengisian GAGAL
//  - Nomor lainnya                  -> pengisian BERHASIL + nomor SN
//
// Jika nanti memakai supplier sungguhan, cukup ganti isi fungsi ini.
// ------------------------------------------------------------
function supplier_isi_pulsa($no_telp, $produk, $ref_id)
{
    if (substr($no_telp, -3) === '000') {
        return ['status' => 'gagal', 'sn' => null];
    }
    // contoh format SN: 20261119143015 + 6 digit acak
    $sn = date('YmdHis') . str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    return ['status' => 'berhasil', 'sn' => $sn];
}

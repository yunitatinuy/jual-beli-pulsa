<?php
// memanggil library FPDF
require('fpdf/fpdf.php');
require_once __DIR__ . '/../sesi.php';
require_once __DIR__ . '/../midtrans.php';
require_once __DIR__ . '/data_transaksi.php';
wajib_login();

// ambil transaksi sesuai id di URL, dan hanya jika milik user yang login
$id_transaksi = (int) ($_GET['id'] ?? 0);
list($d, $daftar_produk) = ambil_transaksi_user($koneksi, $id_transaksi, (int) $_SESSION['user']['id_user']);
if (!$d) {
    echo "<script>alert('Transaksi tidak ditemukan');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit;
}

$no_invoice = nomor_invoice($d);
$rincian = rincian_invoice($d, $daftar_produk);

// FPDF memakai encoding Windows-1252
function teks_pdf($teks)
{
    $hasil = @iconv('UTF-8', 'windows-1252//TRANSLIT', (string) $teks);
    return $hasil === false ? (string) $teks : $hasil;
}

// warna tema QUICK.TOP
const HIJAU_MUDA = [113, 227, 152];   // #71e398
const HIJAU_TUA = [0, 128, 0];        // #008000
const HIJAU_LATAR = [242, 255, 233];  // #f2ffe9
const HIJAU_GARIS = [207, 233, 214];
const TEKS = [31, 45, 36];
const TEKS_REDUP = [91, 107, 96];

class InvoicePDF extends FPDF
{
    public $no_invoice = '';

    function warnaIsi($rgb)
    {
        $this->SetFillColor($rgb[0], $rgb[1], $rgb[2]);
    }
    function warnaTeks($rgb)
    {
        $this->SetTextColor($rgb[0], $rgb[1], $rgb[2]);
    }
    function warnaGaris($rgb)
    {
        $this->SetDrawColor($rgb[0], $rgb[1], $rgb[2]);
    }

    function Header()
    {
        // pita hijau di kepala halaman
        $this->warnaIsi(HIJAU_MUDA);
        $this->Rect(0, 0, 210, 42, 'F');

        // logo + nama toko
        $this->Image(__DIR__ . '/../html/logo/quicktop.png', 15, 10, 22, 22);
        $this->SetXY(41, 12);
        $this->warnaTeks([0, 0, 0]);
        $this->SetFont('Helvetica', 'B', 20);
        $this->Cell(80, 9, 'QUICK.TOP', 0, 2);
        $this->SetFont('Helvetica', '', 9);
        $this->warnaTeks([31, 77, 46]);
        $this->Cell(80, 5, 'Isi Ulang Pulsa & Paket Data', 0, 2);
        $this->Cell(80, 5, 'quicktop.top@gmail.com  |  Batam, Indonesia', 0, 2);

        // judul invoice
        $this->SetXY(120, 12);
        $this->warnaTeks([0, 0, 0]);
        $this->SetFont('Helvetica', 'B', 26);
        $this->Cell(75, 11, 'INVOICE', 0, 2, 'R');
        $this->SetFont('Helvetica', 'B', 10);
        $this->warnaTeks([31, 77, 46]);
        $this->Cell(75, 6, $this->no_invoice, 0, 2, 'R');

        $this->SetY(52);
    }

    function Footer()
    {
        $this->SetY(-22);
        $this->warnaGaris(HIJAU_GARIS);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(3);
        $this->SetFont('Helvetica', '', 8);
        $this->warnaTeks(TEKS_REDUP);
        $this->Cell(0, 4, 'Invoice ini dibuat secara otomatis oleh sistem dan sah tanpa tanda tangan.', 0, 1, 'C');
        $this->Cell(0, 4, 'Halaman ' . $this->PageNo() . ' dari {nb}', 0, 0, 'C');
    }

    // kotak informasi berlabel (Ditagihkan Kepada, dll)
    function KotakInfo($x, $y, $w, $h, $label, $baris)
    {
        $this->warnaIsi(HIJAU_LATAR);
        $this->warnaGaris(HIJAU_GARIS);
        $this->RoundedRect($x, $y, $w, $h, 3, 'DF');

        $this->SetXY($x + 4, $y + 4);
        $this->SetFont('Helvetica', 'B', 7.5);
        $this->warnaTeks(HIJAU_TUA);
        $this->Cell($w - 8, 4, strtoupper($label), 0, 2);
        $this->Ln(1);
        foreach ($baris as $i => $teks) {
            $this->SetX($x + 4);
            $this->SetFont('Helvetica', $i === 0 ? 'B' : '', $i === 0 ? 10 : 9);
            $this->warnaTeks(TEKS);
            $this->Cell($w - 8, 5, teks_pdf($teks), 0, 2);
        }
    }

    // persegi dengan sudut membulat
    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        $op = $style == 'F' ? 'f' : ($style == 'FD' || $style == 'DF' ? 'B' : 'S');
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }
}

$pdf = new InvoicePDF('P', 'mm', 'A4');
$pdf->no_invoice = $no_invoice;
$pdf->SetTitle('Invoice ' . $no_invoice);
$pdf->SetAuthor('QUICK.TOP');
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(true, 28);
$pdf->AliasNbPages();
$pdf->AddPage();

// ===== kotak informasi =====
$y = $pdf->GetY();
$pdf->KotakInfo(15, $y, 57, 35, 'Ditagihkan Kepada', [$d['nama'], '@' . $d['username'], $d['email']]);
$baris_tujuan = [$d['no_telp'], 'Operator: ' . ($daftar_produk[0]['nama_provider'] ?? '-'), 'Pulsa: ' . label_status_pulsa($d['status_pulsa'], $d['status_bayar'])[0]];
if (!empty($d['sn'])) {
    $baris_tujuan[] = 'SN: ' . $d['sn'];
}
$pdf->KotakInfo(76.5, $y, 57, 35, 'Nomor Tujuan', $baris_tujuan);
$pdf->KotakInfo(138, $y, 57, 35, 'Detail Invoice', [tanggal_indo($d['tanggal_pembelian']), 'ID Transaksi: #' . $d['id_transaksi_penjualan'], 'Status: ' . label_status_bayar($d['status_bayar'])[0]]);
$pdf->SetY($y + 43);

// ===== tabel produk =====
$kolom = [
    ['No', 12, 'C'],
    ['Produk', 68, 'L'],
    ['Nominal', 26, 'R'],
    ['Biaya Layanan', 28, 'R'],
    ['Jumlah', 16, 'C'],
    ['Subtotal', 30, 'R'],
];
$pdf->warnaIsi(HIJAU_TUA);
$pdf->warnaTeks([255, 255, 255]);
$pdf->SetFont('Helvetica', 'B', 9);
foreach ($kolom as $k) {
    $pdf->Cell($k[1], 9, $k[0], 0, 0, $k[2], true);
}
$pdf->Ln();

$pdf->SetFont('Helvetica', '', 9);
$pdf->warnaGaris(HIJAU_GARIS);
$no = 1;
foreach ($daftar_produk as $i => $p) {
    $jumlah = max(1, (int) $p['jumlah']);
    $isi_latar = $i % 2 === 1;
    $pdf->warnaIsi([247, 255, 242]);
    $y_baris = $pdf->GetY();

    // baris pertama: nama produk; baris kedua: keterangan
    $pdf->warnaTeks(TEKS);
    $pdf->SetFont('Helvetica', '', 9);
    $pdf->Cell($kolom[0][1], 12, $no++, 'B', 0, 'C', $isi_latar);
    $x_produk = $pdf->GetX();
    $pdf->Cell($kolom[1][1], 12, '', 'B', 0, 'L', $isi_latar);
    $pdf->Cell($kolom[2][1], 12, rupiah($p['nominal']), 'B', 0, 'R', $isi_latar);
    $pdf->Cell($kolom[3][1], 12, rupiah(max(0, $p['harga'] - $p['nominal'])), 'B', 0, 'R', $isi_latar);
    $pdf->Cell($kolom[4][1], 12, $jumlah, 'B', 0, 'C', $isi_latar);
    $pdf->Cell($kolom[5][1], 12, rupiah($p['harga'] * $jumlah), 'B', 1, 'R', $isi_latar);

    $pdf->SetXY($x_produk + 1, $y_baris + 1.5);
    $pdf->SetFont('Helvetica', 'B', 9);
    $pdf->Cell($kolom[1][1] - 2, 5, teks_pdf($p['nama_provider'] . ' ' . rupiah($p['nominal'])), 0, 2);
    $pdf->SetFont('Helvetica', '', 7.5);
    $pdf->warnaTeks(TEKS_REDUP);
    $pdf->Cell($kolom[1][1] - 2, 4, teks_pdf($p['detail']), 0, 0);
    $pdf->SetY($y_baris + 12);
}

// ===== metode pembayaran & total =====
$pdf->Ln(8);
$y = $pdf->GetY();
if ($d['status_bayar'] === 'dibayar') {
    $baris_bayar = [metode_tampil($d)];
    if (!empty($d['waktu_bayar'])) {
        $baris_bayar[] = 'Dibayar: ' . tanggal_indo($d['waktu_bayar']) . ', ' . date('H:i', strtotime($d['waktu_bayar'])) . ' WIB';
    }
    if (!empty($d['order_id'])) {
        $baris_bayar[] = 'Order ID: ' . $d['order_id'];
    }
} elseif ($d['status_bayar'] === 'menunggu') {
    $baris_bayar = ['Belum dibayar', 'Selesaikan pembayaran sebelum ' . date('H:i', strtotime((string) $d['kedaluwarsa'])) . ' WIB'];
} else {
    $baris_bayar = [label_status_bayar($d['status_bayar'])[0], 'Transaksi ini tidak dibayar.'];
}
$pdf->KotakInfo(15, $y, 95, 30, 'Metode Pembayaran', $baris_bayar);

$x_total = 120;
$lebar_total = 75;
$pdf->SetXY($x_total, $y);
$pdf->warnaTeks(TEKS);
$pdf->warnaGaris(HIJAU_GARIS);
$pdf->SetFont('Helvetica', '', 9.5);
foreach ([['Subtotal Produk', $rincian['subtotal']], ['Biaya Layanan', $rincian['biaya']]] as $baris) {
    $pdf->SetX($x_total);
    $pdf->Cell($lebar_total / 2, 8, $baris[0], 'B', 0, 'L');
    $pdf->Cell($lebar_total / 2, 8, rupiah($baris[1]), 'B', 1, 'R');
}
$pdf->Ln(3);
$y_total = $pdf->GetY();
$pdf->warnaIsi(HIJAU_MUDA);
$pdf->RoundedRect($x_total, $y_total, $lebar_total, 11, 3, 'F');
$pdf->SetXY($x_total + 3, $y_total);
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->warnaTeks([0, 0, 0]);
$pdf->Cell($lebar_total / 2 - 3, 11, 'Total Pembayaran', 0, 0, 'L');
$pdf->Cell($lebar_total / 2 - 3, 11, rupiah($rincian['total']), 0, 1, 'R');

// ===== ucapan terima kasih =====
$pdf->SetY(max($pdf->GetY(), $y + 30) + 14);
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->warnaTeks(TEKS);
$pdf->Cell(0, 6, 'Terima kasih telah berbelanja di QUICK.TOP!', 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 9);
$pdf->warnaTeks(TEKS_REDUP);
$pdf->Cell(0, 5, 'Butuh bantuan? Hubungi quicktop.top@gmail.com', 0, 1, 'C');

$pdf->Output('I', 'Invoice-' . str_replace('/', '-', $no_invoice) . '.pdf');

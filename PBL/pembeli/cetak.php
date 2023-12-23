<?php
// memanggil library FPDF
require('fpdf/fpdf.php');
include '../koneksi.php';

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();


//nama web - menggunakan class
class pdf extends FPDF
{

    function Header()
    {
        $this->ln(4);
        $this->Image('../html/logo/quicktop.png', 10, 10, 20, 20);
        $this->Cell(75);
        $this->SetFont('Times', 'B', '14');
        $this->Cell(50, 10, 'QUICK.TOP', 0, 1, 'C');

        //garis bawah
        $this->SetLineWidth(1);
        $this->Line(0, 31, 345, 31);
        $this->SetLineWidth(0);
        $this->Line(0, 32, 345, 32);
    }
    function logo($gambar)
    {
        $this->Image($gambar, 10, 10, 20, 20);
    }
}

//menampilkan data
$pdf = new pdf();
$pdf->AddPage('P', 'A4');
$pdf->logo('../html/logo/quicktop.png');


//
$pdf->ln(15);
$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(200, 10, 'DETAIL TRANSAKSI', 0, 0, 'C');
$pdf->ln();
$pdf->ln();

// nama & username
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(100, 7, 'NAMA', 2, 0, 'C');
$pdf->Cell(100, 7, 'USERNAME', 2, 1, 'C');
$pdf->SetFont('Times', '', 10);
$no = 1;
$data = mysqli_query($koneksi, "SELECT * FROM transaksi_penjualan 
JOIN user ON transaksi_penjualan.id_user=user.id_user
JOIN metode_bayar ON transaksi_penjualan.id_metode_bayar=metode_bayar.id_metode_bayar 
JOIN nohp ON transaksi_penjualan.id_nohp=nohp.id_nohp
ORDER BY id_transaksi_penjualan DESC LIMIT 1");
while ($d = mysqli_fetch_array($data)) {
    $pdf->Cell(100, 6, $d['nama'], 2, 0, 'C');
    $pdf->Cell(100, 6, $d['username'], 2, 1, 'C');
}

// email & no hp
$pdf->ln();
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(100, 7, 'EMAIL', 2, 0, 'C');
$pdf->Cell(100, 7, 'NO. TELP', 2, 1, 'C');
$pdf->SetFont('Times', '', 10);
$no = 1;
$data = mysqli_query($koneksi, "SELECT * FROM transaksi_penjualan 
JOIN user ON transaksi_penjualan.id_user=user.id_user
JOIN metode_bayar ON transaksi_penjualan.id_metode_bayar=metode_bayar.id_metode_bayar 
JOIN nohp ON transaksi_penjualan.id_nohp=nohp.id_nohp
ORDER BY id_transaksi_penjualan DESC LIMIT 1");
while ($d = mysqli_fetch_array($data)) {
    $pdf->Cell(100, 6, $d['email'], 2, 0, 'C');
    $pdf->Cell(100, 6, $d['no_telp'], 2, 1, 'C');
}

// metode bayar & tanggal beli
$pdf->ln();
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(100, 7, 'METODE BAYAR', 2, 0, 'C');
$pdf->Cell(100, 7, 'TANGGAL PEMBELIAN', 2, 1, 'C');
$pdf->SetFont('Times', '', 10);
$no = 1;
$data = mysqli_query($koneksi, "SELECT * FROM transaksi_penjualan 
JOIN user ON transaksi_penjualan.id_user=user.id_user
JOIN metode_bayar ON transaksi_penjualan.id_metode_bayar=metode_bayar.id_metode_bayar 
JOIN nohp ON transaksi_penjualan.id_nohp=nohp.id_nohp
ORDER BY id_transaksi_penjualan DESC LIMIT 1");
while ($d = mysqli_fetch_array($data)) {
    $pdf->Cell(100, 6, $d['jenis'], 2, 0, 'C');
    $pdf->Cell(100, 6, $d['tanggal_pembelian'], 2, 1, 'C');
}

// total pembelian
$pdf->ln();
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(200, 7, 'TOTAL PEMBELIAN :', 2, 1, 'C');
$pdf->SetFont('Times', '', 10);
$no = 1;
$data = mysqli_query($koneksi, "SELECT * FROM transaksi_penjualan 
JOIN user ON transaksi_penjualan.id_user=user.id_user
JOIN metode_bayar ON transaksi_penjualan.id_metode_bayar=metode_bayar.id_metode_bayar 
JOIN nohp ON transaksi_penjualan.id_nohp=nohp.id_nohp
ORDER BY id_transaksi_penjualan DESC LIMIT 1");
while ($d = mysqli_fetch_array($data)) {
    $pdf->Cell(200, 6, number_format($d['total_pembelian']), 2, 1, 'C');
}

//tabel
$pdf->ln();
$pdf->ln();
$pdf->Cell(2);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(40, 7, 'PRODUK YANG DIBELI :', 2, 1, 'C');
$pdf->ln(0.5);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(40, 7, 'NAMA PROVIDER', 1, 0, 'C');
$pdf->Cell(32, 7, 'NOMINAL', 1, 0, 'C');
$pdf->Cell(85, 7, 'DETAIL', 1, 0, 'C');
$pdf->Cell(32, 7, 'HARGA', 1, 0, 'C');

$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Times', '', 10);
$no = 1;
$data = mysqli_query($koneksi, "SELECT * FROM transaksi 
INNER JOIN proveder ON transaksi.id_provider = proveder.id_provider 
ORDER BY id_transaksi DESC LIMIT 1");
while ($d = mysqli_fetch_array($data)) {
    $pdf->Cell(40, 6, $d['nama_provider'], 1, 0, 'C');
    $pdf->Cell(32, 6, number_format($d['nominal']), 1, 0, 'C');
    $pdf->Cell(85, 6, $d['detail'], 1, 0, 'C');
    $pdf->Cell(32, 6, number_format($d['harga']), 1, 1, 'C');
}


$pdf->Output("detail_transaksi.pdf", "I");

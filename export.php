<?php
require('fpdf/fpdf.php'); // Menggunakan path relatif ke file fpdf.php

// Fungsi untuk mengurutkan data berdasarkan waktu
function sortTableByTime($array, $key) {
    usort($array, function($a, $b) {
        return strtotime($a[$key]) - strtotime($b[$key]);
    });
    return $array;
}

// Ambil data dari database (sesuaikan dengan cara Anda mengambil data)
include 'koneksi.php'; // Sertakan file koneksi database
$sql = $koneksi->query("SELECT * FROM barang_keluar as bk JOIN barang as b ON bk.barang_id=b.id_barang LEFT JOIN satuan as st ON st.id_satuan=b.satuan_id JOIN history as h ON h.bmk_id=bk.id_bk WHERE role='BK' group by id_bk");
$data = $sql->fetch_all(MYSQLI_ASSOC);

// Sortir data berdasarkan waktu
$data = sortTableByTime($data, 'tanggal_keluar');

// Buat objek PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Judul
$pdf->Cell(0, 10, 'Laporan Data Barang Keluar', 0, 1, 'C');

// Tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, 'No', 1);
$pdf->Cell(60, 10, 'Nama Barang', 1);
$pdf->Cell(40, 10, 'Jumlah', 1);
$pdf->Cell(50, 10, 'Tanggal Keluar', 1);
$pdf->Cell(60, 10, 'Tujuan', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
$no = 1;
foreach ($data as $row) {
    $pdf->Cell(20, 10, $no, 1);
    $pdf->Cell(60, 10, $row['nama_barang'], 1);
    $pdf->Cell(40, 10, $row['jumlah_keluar'], 1);
    $pdf->Cell(50, 10, date('d/m/Y H:i', strtotime($row['tanggal_keluar'])), 1);
    $pdf->Cell(60, 10, $row['tujuan'], 1);
    $pdf->Ln();
    $no++;
}

// Simpan file PDF
$pdf->Output('barang-keluar.pdf', 'D');
?>

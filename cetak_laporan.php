<?php
// Include TCPDF library
require_once('tcpdf/tcpdf.php');

if (isset($_GET['start']) && isset($_GET['end'])) {
    $start_date = $_GET['start'];
    $end_date = $_GET['end'];

    // Query database untuk mendapatkan data yang sesuai dengan tanggal yang telah difilter
    // Simpan data yang diambil dari database dalam array atau variabel $data
    // Contoh: $data = fetchDataFromDatabase($start_date, $end_date);
    $data = array(); // Gantilah ini dengan data yang sesuai dari database
} else {
    // Jika tanggal tidak ada, tampilkan pesan kesalahan atau alihkan ke halaman lain
    echo "Tanggal tidak valid atau tidak ditemukan.";
    exit;
}

// Buat instance TCPDF
$pdf = new TCPDF();

// Atur beberapa properti PDF, seperti judul, margin, dll.
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Data Cetak PDF');
$pdf->SetMargins(10, 10, 10, true);

// Buat halaman PDF
$pdf->AddPage();

// Tambahkan isi PDF
$pdf->SetFont('helvetica', '', 12);

// Tampilkan data dalam PDF
$html = "<h1>Data yang akan dicetak</h1>";
$html .= "<table border='1'>";
$html .= "<thead><tr><th>No</th><th>Nama Barang</th><th>Supplier</th><th>Jumlah</th><th>Tanggal Masuk</th></tr></thead>";
$html .= "<tbody>";

$no = 1;
foreach ($data as $item) {
    $html .= "<tr>";
    $html .= "<td>$no</td>";
    $html .= "<td>{$item['nama_barang']}</td>";
    $html .= "<td>{$item['nama_sup']}</td>";
    $html .= "<td>+ {$item['jumlah_masuk']}</td>";
    $html .= "<td>" . date('d/m/Y H:i', strtotime($item['tanggal_masuk'])) . "</td>";
    $html .= "</tr>";
    $no++;
}

$html .= "</tbody></table>";

// Output file PDF ke browser
$pdf->writeHTML($html, true, 0, true, 0);
$pdf->Output('data_cetak.pdf', 'I');
?>

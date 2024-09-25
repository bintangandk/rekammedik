<?php
session_start();
include '../koneksi.php';
require('../fpdf/fpdf.php');

$conn = new koneksi();

$tanggal_awal = $_POST['tanggal_awal'];
$tanggal_akhir = $_POST['tanggal_akhir'];
$tanggal_awall = date('Y-m-d', strtotime($tanggal_awal));
$tanggal_akhirr = date('Y-m-d', strtotime($tanggal_akhir));

if ($tanggal_awall == $tanggal_akhirr) {
    $filename = "Laporan Aktivitas dari tanggal" . $tanggal_awall . ".pdf";
    $query = "SELECT * FROM aktivitas JOIN unit ON aktivitas.id_unit = unit.id WHERE tanggal = '$tanggal_awall'";
} else {
    $filename = "Laporan Aktivitas dari tanggal" . $tanggal_awall . " sampai " . $tanggal_akhirr . ".pdf";
    $query = "SELECT * FROM aktivitas JOIN unit ON aktivitas.id_unit = unit.id WHERE tanggal BETWEEN '$tanggal_awall' AND '$tanggal_akhirr'";
}

$result = $conn->execute($query);
$data = $result->fetch_all(MYSQLI_ASSOC);

// Buat dokumen PDF
$pdf = new FPDF();
$pdf->AddPage();

// Judul PDF
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Laporan Aktivitas', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'Periode: ' . date('d-m-Y', strtotime($tanggal_awall)) . ' s/d ' . date('d-m-Y', strtotime($tanggal_akhirr)), 0, 1, 'C');

// Spasi
$pdf->Ln(10);

// Buat header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(30, 10, 'Tanggal', 1);
$pdf->Cell(30, 10, 'Jam', 1);
$pdf->Cell(70, 10, 'Kegiatan', 1);
$pdf->Cell(50, 10, 'Tempat', 1);
$pdf->Ln();

// Isi tabel dengan data dari database
$pdf->SetFont('Arial', '', 12);
$no = 1;
if ($data) {
    foreach ($data as $row) {
        $pdf->Cell(10, 10, $no++, 1);
        $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['tanggal'])), 1);
        $pdf->Cell(30, 10, $row['jam'], 1);
        $pdf->Cell(70, 10, $row['kegiatan'], 1);
        $pdf->Cell(50, 10, $row['instalasi'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(190, 10, 'Data Tidak Ditemukan', 1, 1, 'C');
    $_SESSION['error'] = 'DATA tidak ditemukan.';
    header("Location: ../view/admin/riwayat-file/index.php");
    exit();
}

// Output PDF
$pdf->Output('D', $filename); // Download PDF
exit();

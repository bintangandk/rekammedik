<?php
require_once __DIR__ . '/../vendor/autoload.php'; 
include '../koneksi.php'; 


$db = new koneksi();
$conn = $db->prepareKoneksi();


$id = $_GET['id'];


$sqlPasien = "
    SELECT p.no_rm, p.nama, p.tanggal_lahir, p.jenis_kelamin
    FROM pasien p
    JOIN konsultasi k ON k.id_pasien = p.id_pasien
    WHERE k.id_konsultasi = '$id'
";
$pasien = $conn->query($sqlPasien)->fetch_assoc();


$sqlKonsul = "
    SELECT k.tanggal, k.durasi, k.nama_dokter, d.nama_diagnosis, m.nama_generik, k.catatan_dokter
    FROM konsultasi k
    JOIN dic_diagnosis d ON k.id_diagnosis = d.id_diagnosis
    JOIN dic_medikamentosa m ON k.id_medikamentosa = m.id_medikamentosa
    WHERE k.id_konsultasi = '$id'
";
$konsul = $conn->query($sqlKonsul)->fetch_assoc();


$html = "
<h2 style='text-align:center; text-decoration: underline;'>Laporan Konsultasi</h2>
<br><br>

<table width='100%' cellpadding='5' cellspacing='0'>
    <tr>
        <td width='25%'><b>Nama Pasien</b></td>
        <td>: {$pasien['nama']}</td>
    </tr>
    <tr>
        <td><b>No. Rekam Medis</b></td>
        <td>: {$pasien['no_rm']}</td>
    </tr>
    <tr>
        <td><b>Tgl. Lahir</b></td>
        <td>: " . date('d-m-Y', strtotime($pasien['tanggal_lahir'])) . "</td>
    </tr>
    <tr>
        <td><b>Jenis Kelamin</b></td>
        <td>: {$pasien['jenis_kelamin']}</td>
    </tr>
</table>

<br><br>

<table border='1' cellpadding='6' cellspacing='0' width='100%' style='border-collapse: collapse; text-align:center;'>
    <thead>
        <tr style='font-weight:bold; background-color:#f2f2f2;'>
            <td width='15%'>Tanggal</td>
            <td width='10%'>Durasi</td>
            <td width='20%'>Nama Dokter/Perawat</td>
            <td width='20%'>Diagnosis</td>
            <td width='20%'>Medikamentosa</td>
            <td width='15%'>Catatan</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>".date('d-m-Y', strtotime($konsul['tanggal']))."</td>
            <td>{$konsul['durasi']}</td>
            <td>{$konsul['nama_dokter']}</td>
            <td>{$konsul['nama_diagnosis']}</td>
            <td>{$konsul['nama_generik']}</td>
            <td>{$konsul['catatan_dokter']}</td>
        </tr>
    </tbody>
</table>
";


$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);


$mpdf->SetHTMLFooter("
    <div style='text-align: right; font-size: 10pt;'>
        Dicetak pada: ".date('d-m-Y H:i:s')."
    </div>
");

$mpdf->Output("konsultasi_{$id}.pdf", "I");

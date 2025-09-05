<?php
require_once __DIR__ . '/../vendor/autoload.php'; 
include '../koneksi.php'; 


$db = new koneksi();
$conn = $db->prepareKoneksi();


$id = $_GET['id'];


$sqlPasien = "
    SELECT p.no_rm, p.nama, p.tanggal_lahir, p.jenis_kelamin
    FROM pasien p
    JOIN tindakan t ON t.id_pasien = p.id_pasien
    WHERE t.id_tindakan = '$id'
";
$pasien = $conn->query($sqlPasien)->fetch_assoc();

// ambil data tindakan
$sqlTindakan = "
    SELECT t.tanggal, t.durasi, d.nama_diagnosis, 
           m.nama_generik AS nama_medikamentosa, 
           dt.nama_tindakan, t.catatan_dokter
    FROM tindakan t
    LEFT JOIN dic_diagnosis d ON t.id_diagnosis = d.id_diagnosis
    LEFT JOIN dic_medikamentosa m ON t.id_medikamentosa = m.id_medikamentosa
    LEFT JOIN dic_tindakan dt ON t.id_dctindakan = dt.id_dctindakan
    WHERE t.id_tindakan = '$id'
";
$tindakan = $conn->query($sqlTindakan)->fetch_assoc();


$html = "
<h2 style='text-align:center; text-decoration: underline;'>Laporan Tindakan</h2>
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
            <td width='12%'>Tanggal</td>
            <td width='10%'>Durasi</td>
            <td width='20%'>Diagnosis</td>
            <td width='20%'>Medikamentosa</td>
            <td width='20%'>Tindakan</td>
            <td width='18%'>Catatan</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>".date('d-m-Y', strtotime($tindakan['tanggal']))."</td>
            <td>{$tindakan['durasi']}</td>
            <td>{$tindakan['nama_diagnosis']}</td>
            <td>{$tindakan['nama_medikamentosa']}</td>
            <td>{$tindakan['nama_tindakan']}</td>
            <td>{$tindakan['catatan_dokter']}</td>
        </tr>
    </tbody>
</table>
";

// generate PDF
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);

// footer: tanggal print
$mpdf->SetHTMLFooter("
    <div style='text-align: right; font-size: 10pt;'>
        Dicetak pada: ".date('d-m-Y H:i:s')."
    </div>
");

$mpdf->Output("tindakan_{$id}.pdf", "I");

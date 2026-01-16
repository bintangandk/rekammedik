<?php
require_once __DIR__ . '/../vendor/autoload.php';
include '../koneksi.php';

$db = new koneksi();
$conn = $db->prepareKoneksi();

$tglAwal  = $_GET['tgl_awal'];
$tglAkhir = $_GET['tgl_akhir'];
$idPasien = $_GET['id_pasien'] ?? null;

// =====================
// WHERE DINAMIS
// =====================
$where = "k.tanggal BETWEEN '$tglAwal' AND '$tglAkhir'";

if (!empty($idPasien)) {
    $where .= " AND k.id_pasien = '$idPasien'";
}

// =====================
// QUERY
// =====================
$sql = "
    SELECT 
        k.tanggal,
        k.durasi,
        k.nama_dokter,
        p.no_rm,
        p.nama AS nama_pasien,
        d.nama_diagnosis,
        m.nama_generik,
        k.catatan_dokter
    FROM konsultasi k
    JOIN pasien p ON k.id_pasien = p.id_pasien
    JOIN dic_diagnosis d ON k.id_diagnosis = d.id_diagnosis
    JOIN dic_medikamentosa m ON k.id_medikamentosa = m.id_medikamentosa
    WHERE $where
    ORDER BY k.tanggal ASC
";

$result = $conn->query($sql);

// =====================
// DATA KOSONG
// =====================
if ($result->num_rows == 0) {
    echo "
        <!DOCTYPE html>
        <html>
        <body>
            <div id='no-data'
                 data-message='Tidak ada data konsultasi sesuai filter yang dipilih'>
            </div>
        </body>
        </html>
    ";
    exit;
}

// =====================
// HTML PDF
// =====================
$html = "
<h2 style='text-align:center; text-decoration: underline;'>
    Laporan Konsultasi Pasien
</h2>

<p style='text-align:center;'>
    Periode: " . date('d-m-Y', strtotime($tglAwal)) . " s/d " . date('d-m-Y', strtotime($tglAkhir)) . "
</p>
";

if (!empty($idPasien)) {
    $html .= "<p style='text-align:center;'><b>Filter Pasien</b></p>";
}

$html .= "
<br>

<table border='1' cellpadding='6' cellspacing='0' width='100%' 
       style='border-collapse: collapse; font-size: 10pt;'>
    <thead>
        <tr style='background-color:#f2f2f2; font-weight:bold; text-align:center;'>
            <th>No</th>
            <th>Tanggal</th>
            <th>No. RM</th>
            <th>Nama Pasien</th>
            <th>Dokter</th>
            <th>Durasi</th>
            <th>Diagnosis</th>
            <th>Medikamentosa</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
";

$no = 1;
while ($row = $result->fetch_assoc()) {
    $html .= "
        <tr>
            <td align='center'>{$no}</td>
            <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
            <td>{$row['no_rm']}</td>
            <td>{$row['nama_pasien']}</td>
            <td>{$row['nama_dokter']}</td>
            <td align='center'>{$row['durasi']}</td>
            <td>{$row['nama_diagnosis']}</td>
            <td>{$row['nama_generik']}</td>
            <td>{$row['catatan_dokter']}</td>
        </tr>
    ";
    $no++;
}

$html .= "</tbody></table>";

// =====================
// PDF
// =====================
$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4-L',
    'margin_top' => 10,
    'margin_bottom' => 15
]);

$mpdf->WriteHTML($html);

$mpdf->SetHTMLFooter("
    <div style='text-align:right; font-size:9pt;'>
        Dicetak pada: " . date('d-m-Y H:i') . "
    </div>
");

$mpdf->Output("laporan_konsultasi_{$tglAwal}_{$tglAkhir}.pdf", "I");

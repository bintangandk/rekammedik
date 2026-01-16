<?php
require_once __DIR__ . '/../vendor/autoload.php';
include '../koneksi.php';

$db = new koneksi();
$conn = $db->prepareKoneksi();

$tglAwal  = $_GET['tgl_awal'];
$tglAkhir = $_GET['tgl_akhir'];

// =====================
// FILTER TAMBAHAN (OPTIONAL)
// =====================
$where = "t.tanggal BETWEEN '$tglAwal' AND '$tglAkhir'";

if (!empty($_GET['id_pasien'])) {
    $idPasien = $_GET['id_pasien'];
    $where .= " AND t.id_pasien = '$idPasien'";
}

// =====================
// QUERY
// =====================
$sql = "
    SELECT 
        t.tanggal,
        t.durasi,
        p.no_rm,
        p.nama AS nama_pasien,
        d.nama_diagnosis,
        m.nama_generik AS nama_medikamentosa,
        dt.nama_tindakan,
        t.catatan_dokter
    FROM tindakan t
    JOIN pasien p ON t.id_pasien = p.id_pasien
    LEFT JOIN dic_diagnosis d ON t.id_diagnosis = d.id_diagnosis
    LEFT JOIN dic_medikamentosa m ON t.id_medikamentosa = m.id_medikamentosa
    LEFT JOIN dic_tindakan dt ON t.id_dctindakan = dt.id_dctindakan
    WHERE $where
    ORDER BY t.tanggal ASC
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
                 data-message='Tidak ada data tindakan sesuai filter yang dipilih'>
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
    Laporan Tindakan Pasien
</h2>

<p style='text-align:center;'>
    Periode: " . date('d-m-Y', strtotime($tglAwal)) . " s/d " . date('d-m-Y', strtotime($tglAkhir)) . "
</p>
";

$idPasien = $_GET['id_pasien'] ?? null;

if ($idPasien) {
    $sqlPasien = "SELECT nama, no_rm, tanggal_lahir, jenis_kelamin FROM pasien WHERE id_pasien = '$idPasien'";
    $resultPasien = $conn->query($sqlPasien);
    $pasien = $resultPasien->fetch_assoc();

    if ($pasien) {
        $html .= "<table width='100%' cellpadding='5' cellspacing='0'>
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
</table>";
    }
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
            <th>Diagnosis</th>
            <th>Medikamentosa</th>
            <th>Tindakan</th>
            <th>Durasi</th>
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
            <td>{$row['nama_diagnosis']}</td>
            <td>{$row['nama_medikamentosa']}</td>
            <td>{$row['nama_tindakan']}</td>
            <td align='center'>{$row['durasi']}</td>
            <td>{$row['catatan_dokter']}</td>
        </tr>
    ";
    $no++;
}

$html .= "</tbody></table>";

// =====================
// PDF
// =====================
$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
$mpdf->WriteHTML($html);

$mpdf->SetHTMLFooter("
    <div style='text-align:right; font-size:9pt;'>
        Dicetak pada: " . date('d-m-Y H:i') . "
    </div>
");

$mpdf->Output("laporan_tindakan_{$tglAwal}_{$tglAkhir}.pdf", "I");

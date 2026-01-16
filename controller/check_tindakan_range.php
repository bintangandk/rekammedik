<?php
include '../koneksi.php';

$db = new koneksi();
$conn = $db->prepareKoneksi();

$tglAwal  = $_GET['tgl_awal'];
$tglAkhir = $_GET['tgl_akhir'];
$idPasien = $_GET['id_pasien'] ?? null;

$where = "tanggal BETWEEN '$tglAwal' AND '$tglAkhir'";

if (!empty($idPasien)) {
    $where .= " AND id_pasien = '$idPasien'";
}

$sql = "
    SELECT COUNT(*) AS total
    FROM tindakan
    WHERE $where
";

$result = $conn->query($sql)->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($result);

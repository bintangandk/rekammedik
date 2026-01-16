<?php
include '../koneksi.php';

$db = new koneksi();
$conn = $db->prepareKoneksi();

$tglAwal  = $_GET['tgl_awal'];
$tglAkhir = $_GET['tgl_akhir'];

$sql = "
    SELECT COUNT(*) AS total
    FROM konsultasi
    WHERE tanggal BETWEEN '$tglAwal' AND '$tglAkhir'
";

$result = $conn->query($sql)->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($result);

<?php
session_start();
include '../koneksi.php';
$conn = new koneksi();

function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

$tanggal_awal = $_POST['tanggal_awal'];
$tanggal_akhir = $_POST['tanggal_akhir'];
$tanggal_awall = date('Y-m-d', strtotime($tanggal_awal));
$tanggal_akhirr = date('Y-m-d', strtotime($tanggal_akhir));

$filename = "Laporan Aktivitas dari tanggal" . $tanggal_awall . "sampai" . $tanggal_akhirr . ".xls";

$field = ["No", "Tanggal", "Jam", "Kegiatan", "Tempat"];
if ($tanggal_awall == $tanggal_akhirr) {
    $filename = "Laporan Aktivitas dari tanggal" . $tanggal_awall . ".xls";
    $query = "SELECT * 
FROM aktivitas 
JOIN unit ON aktivitas.id_unit = unit.id 
WHERE tanggal = '$tanggal_awall'
";
} else {
    $query = "SELECT * FROM aktivitas  JOIN unit on aktivitas.id_unit = unit.id  WHERE tanggal BETWEEN '$tanggal_awall' AND '$tanggal_akhirr'";
}

$result = $conn->execute($query);
$data = $result->fetch_all(MYSQLI_ASSOC);

$excelData = implode("\t", array_values($field)) . "\n";
$no = 1;

if ($data) {
    foreach ($data as $key) {
        $lineData = array($no++, date('d-m-Y', strtotime($key['tanggal'])), $key['jam'], $key['kegiatan'], $key['instalasi']);
        $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
} else {
    $excelData .= "No Data Found\n";
    $_SESSION['error'] = 'DATA tidak ditemukan.';
    header("Location: ../view/admin/riwayat-file/index.php");
    exit();
}

// Move headers before any output
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");

echo $excelData;
exit();

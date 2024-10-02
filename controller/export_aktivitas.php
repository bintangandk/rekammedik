<?php
session_start();
include '../koneksi.php';
require '../vendor/autoload.php'; // Pastikan Dompdf sudah diinstall dan di-autoload
require '../controller/Pegawai.php';
use Dompdf\Dompdf;

$conn = new koneksi();
$users= new Pegawai();
$user= $users->profile_peruser();
$id_user = $_SESSION['id_user'];
$tanggal_awal = $_POST['tanggal_awal'];
$tanggal_akhir = $_POST['tanggal_akhir'];
$tanggal_awall = date('Y-m-d', strtotime($tanggal_awal));
$tanggal_akhirr = date('Y-m-d', strtotime($tanggal_akhir));

if ($tanggal_awall == $tanggal_akhirr) {
    $filename = "Laporan Aktivitas dari tanggal " . $tanggal_awall . ".pdf";
    $query = "SELECT * FROM aktivitas 
              JOIN unit ON aktivitas.id_unit = unit.id 
              JOIN users ON aktivitas.id_user = users.id_user 
              WHERE aktivitas.id_user = '$id_user' 
              AND tanggal = '$tanggal_awall'";
} else {
    $filename = "Laporan Aktivitas dari tanggal " . $tanggal_awall . " sampai " . $tanggal_akhirr . ".pdf";
    $query = "SELECT * FROM aktivitas 
              JOIN unit ON aktivitas.id_unit = unit.id  
              JOIN users ON aktivitas.id_user = users.id_user 
              WHERE aktivitas.id_user = '$id_user' 
              AND tanggal BETWEEN '$tanggal_awall' AND '$tanggal_akhirr'";
}

$result = $conn->execute($query);
$data = $result->fetch_all(MYSQLI_ASSOC);

// Mulai membangun HTML untuk laporan PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        
        /* Agar teks terbungkus dan turun baris otomatis di semua kolom */
        th, td { 
            border: 1px solid black; 
            padding: 8px; 
            text-align: center; 
            word-wrap: break-word; /* Membungkus kata panjang */
            word-break: break-word; /* Memecah kata panjang */
            white-space: normal; /* Mengizinkan teks turun ke baris berikutnya */
        }
        
        th { background-color: #f2f2f2; }
        
        /* Tentukan lebar kolom agar tetap proporsional */
        td:nth-child(1), th:nth-child(1) { 
            width: 8%;  /* Lebar lebih besar untuk kolom No */
            white-space: nowrap;  /* Menjaga teks No tetap dalam satu baris */
        }
        
        td:nth-child(2) { width: 15%; } /* Tanggal */
        td:nth-child(3) { width: 10%; } /* Jam */
        td:nth-child(4) { width: 55%; } /* Kegiatan */
        td:nth-child(5) { width: 15%; } /* Tempat */
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Aktivitas</h2>
    <p style="text-align: center;">Periode: ' . date('d-m-Y', strtotime($tanggal_awall)) . ' s/d ' . date('d-m-Y', strtotime($tanggal_akhirr)) . '</p>
  
            Nama       : ' . htmlspecialchars($user['Nama']) . '
            <br>
            NIP        : ' . htmlspecialchars($user['nip']) . '
            <br>
            UNIT       : ' . htmlspecialchars($user['instalasi']) . '
           
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Kegiatan</th>
                <th>Tempat</th>
            </tr>
        </thead>
        <tbody>';

// Isi tabel dengan data dari database
$no = 1;
if ($data) {
    foreach ($data as $row) {
        $html .= '<tr>';
        $html .= '<td>' . $no++ . '</td>';
        $html .= '<td>' . date('d-m-Y', strtotime($row['tanggal'])) . '</td>';
        $html .= '<td>' . $row['jam'] . '</td>';
        $html .= '<td>' . $row['kegiatan'] . '</td>';
        $html .= '<td>' . $row['instalasi'] . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="5">Data Tidak Ditemukan</td></tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Inisialisasi Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'portrait');

// Render HTML menjadi PDF
$dompdf->render();

// Output ke browser
$dompdf->stream($filename, array("Attachment" => 1)); // 1 untuk download otomatis
exit();

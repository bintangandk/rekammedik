<?php
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();

// Hitung konsultasi bulan ini (reset tiap bulan)
function countKonsultasiBulanIni($db)
{
    $bulan = date('m');
    $tahun = date('Y');

    $sql = "
        SELECT COUNT(*) AS total 
        FROM konsultasi 
        WHERE MONTH(tanggal) = '$bulan' 
          AND YEAR(tanggal) = '$tahun'
    ";
    $result = $db->showData($sql);

    return !empty($result) ? (int)$result[0]['total'] : 0;
}

// Hitung total semua konsultasi (tidak reset)
function countTotalKonsultasi($db)
{
    $sql = "SELECT COUNT(*) AS total FROM konsultasi";
    $result = $db->showData($sql);

    return !empty($result) ? (int)$result[0]['total'] : 0;
}

// Hitung konsultasi milik pasien tertentu (reset tiap bulan)
function countKonsultasiPasienBulanIni($db, $id_user)
{
    $bulan = date('m');
    $tahun = date('Y');

    $sql = "
        SELECT COUNT(*) AS total 
        FROM konsultasi 
        WHERE id_user = '$id_user'
          AND MONTH(tanggal) = '$bulan' 
          AND YEAR(tanggal) = '$tahun'
    ";
    $result = $db->showData($sql);

    return !empty($result) ? (int)$result[0]['total'] : 0;
}

// Hitung total semua konsultasi milik pasien
function countTotalKonsultasiPasien($db, $id_user)
{
    $sql = "SELECT COUNT(*) AS total FROM konsultasi WHERE id_user = '$id_user'";
    $result = $db->showData($sql);

    return !empty($result) ? (int)$result[0]['total'] : 0;
}



function getAllKonsultasi($db)
{
    $sql = "
        SELECT konsultasi.*, 
               pasien.nama AS nama_pasien, 
               pasien.no_rm, 
               diagnosis.nama_diagnosis, 
               medikamentosa.nama_generik AS nama_medikamentosa
        FROM konsultasi
        LEFT JOIN pasien ON konsultasi.id_pasien = pasien.id_pasien
        LEFT JOIN dic_diagnosis AS diagnosis ON konsultasi.id_diagnosis = diagnosis.id_diagnosis
        LEFT JOIN dic_medikamentosa AS medikamentosa ON konsultasi.id_medikamentosa = medikamentosa.id_medikamentosa
        ORDER BY konsultasi.id_konsultasi DESC
    ";
    return $db->showData($sql);
}


function createKonsultasi($db, $id_pasien, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $nama_dokter, $catatan_dokter)
{

    $id_pasien = $db->escapeString($id_pasien);
    $id_diagnosis = $db->escapeString($id_diagnosis);
    $id_medikamentosa = $db->escapeString($id_medikamentosa);
    $tanggal = $db->escapeString($tanggal);
    $durasi = $db->escapeString($durasi);
    $nama_dokter = $db->escapeString($nama_dokter);
    $catatan_dokter = $db->escapeString($catatan_dokter);

    $sql = "INSERT INTO konsultasi (id_pasien, id_diagnosis, id_medikamentosa, tanggal, durasi, nama_dokter, catatan_dokter)
    VALUE ('$id_pasien', '$id_diagnosis', '$id_medikamentosa', '$tanggal', '$durasi', '$nama_dokter', '$catatan_dokter')";

    $result = $db->insertData($sql);

    if ($result) {
        header("Location: /view/users/konsultasi/index.php");
        exit;
    } else {
        echo "Gagal menambahkan konsultasi!";
    }
}

function updateKonsultasi($db, $id, $id_pasien, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $nama_dokter, $catatan_dokter)
{
    // Pastikan tidak ada output sampah
    if (ob_get_length()) {
        ob_end_clean();
    }

    $id = intval($id);
    $id_pasien = $db->escapeString($id_pasien);
    $id_diagnosis = $db->escapeString($id_diagnosis);
    $id_medikamentosa = $db->escapeString($id_medikamentosa);
    $tanggal = $db->escapeString($tanggal);
    $durasi = $db->escapeString($durasi);
    $nama_dokter = $db->escapeString($nama_dokter);
    $catatan_dokter = $db->escapeString($catatan_dokter);

    $sql = "UPDATE konsultasi
            SET id_pasien = '$id_pasien',
                id_diagnosis = '$id_diagnosis',
                id_medikamentosa = '$id_medikamentosa',
                tanggal = '$tanggal',
                durasi = '$durasi',
                nama_dokter = '$nama_dokter',
                catatan_dokter = '$catatan_dokter'
            WHERE id_konsultasi = $id";

    $result = $db->updateData($sql);

    header('Content-Type: application/json; charset=utf-8');
    if ($result) {
        echo json_encode([
            "status" => "success",
            "message" => "Data berhasil diperbarui!"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal memperbarui data!"
        ]);
    }
    exit;
}


function deletekonsultasi($db, $id)
{

    $id = (int) $id;
    $sql = "DELETE FROM konsultasi WHERE id_konsultasi = $id";
    $result = $db->deleteData($sql);

    if ($result) {
        header("Location: /view/admin/konsultasi/index.php");
        exit;
    } else {
        echo "Gagal menambahkan konsultasi!";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'tambah_data') {
        $id_pasien = $_POST['id_pasien'];
        $id_diagnosis = $_POST['id_diagnosis'];
        $id_medikamentosa = $_POST['id_medikamentosa'];
        $tanggal = $_POST['tanggal'];
        $durasi = $_POST['durasi'];
        $nama_dokter = $_POST['nama_dokter'];
        $catatan_dokter = $_POST['catatan_dokter'];

        createKonsultasi($db, $id_pasien, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $nama_dokter, $catatan_dokter);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update_data') {
        $id = $_POST['id_konsultasi'];
        $id_pasien = $_POST['id_pasien'];
        $id_diagnosis = $_POST['id_diagnosis'];
        $id_medikamentosa = $_POST['id_medikamentosa'];
        $tanggal = $_POST['tanggal'];
        $durasi = $_POST['durasi'];
        $nama_dokter = $_POST['nama_dokter'];
        $catatan_dokter = $_POST['catatan_dokter'];
        updateKonsultasi($db, $id, $id_pasien, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $nama_dokter, $catatan_dokter);
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'tambah_data') {
            createKonsultasi($db, $_POST['id_pasien'], $_POST['id_diagnosis'], $_POST['id_medikamentosa'], $_POST['tanggal'], $_POST['durasi'], $_POST['nama_dokter'], $_POST['catatan_dokter']);
        } elseif ($_POST['action'] === 'update_data') {
            updateKonsultasi($db, $_POST['id_konsultasi'], $_POST['id_pasien'], $_POST['id_diagnosis'], $_POST['id_medikamentosa'], $_POST['tanggal'], $_POST['durasi'], $_POST['nama_dokter'], $_POST['catatan_dokter']);
        } elseif ($_POST['action'] === 'delete_data') {
            deletekonsultasi($db, $_POST['id_konsultasi']);
        }
    }
}

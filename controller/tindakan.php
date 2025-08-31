<?php
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();


function getAllTindakan($db)
{
    $sql = "
        SELECT tindakan.*, 
               pasien.nama AS nama_pasien, 
               pasien.no_rm, 
               diagnosis.nama_diagnosis, 
               medikamentosa.nama_generik AS nama_medikamentosa,
               dctindakan.nama_tindakan
        FROM tindakan
        LEFT JOIN pasien ON tindakan.id_pasien = pasien.id_pasien
        LEFT JOIN dic_diagnosis AS diagnosis ON tindakan.id_diagnosis = diagnosis.id_diagnosis
        LEFT JOIN dic_medikamentosa AS medikamentosa ON tindakan.id_medikamentosa = medikamentosa.id_medikamentosa
        LEFT JOIN dic_tindakan AS dctindakan ON tindakan.id_dctindakan = dctindakan.id_dctindakan
        ORDER BY tindakan.id_tindakan DESC
    ";
    return $db->showData($sql);
}

function createTindakan($db, $id_pasien, $id_dctindakan, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $catatan_dokter)
{
    $id_pasien = $db->escapeString($id_pasien);
    $id_dctindakan = $db->escapeString($id_dctindakan);
    $id_diagnosis = $db->escapeString($id_diagnosis);
    $id_medikamentosa = $db->escapeString($id_medikamentosa);
    $tanggal = $db->escapeString($tanggal);
    $durasi = $db->escapeString($durasi);
    $catatan_dokter = $db->escapeString($catatan_dokter);

    $sql = "INSERT INTO tindakan (id_pasien, id_dctindakan, id_diagnosis, id_medikamentosa, tanggal, durasi, catatan_dokter)
    VALUE ('$id_pasien', '$id_dctindakan', '$id_diagnosis', '$id_medikamentosa', '$tanggal', '$durasi', '$catatan_dokter')";

    $result = $db->insertData($sql);

    if ($result) {
        header("Location: /view/users/tindakan/index.php");
        exit;
    } else {
        echo "Gagal menambahkan konsultasi!";
    }
}

function updateTindakan($db, $id, $id_pasien, $id_dctindakan, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $catatan_dokter)
{
    $id = intval($id);
    $id_pasien = $db->escapeString($id_pasien);
    $id_dctindakan = $db->escapeString($id_dctindakan);
    $id_diagnosis = $db->escapeString($id_diagnosis);
    $id_medikamentosa = $db->escapeString($id_medikamentosa);
    $tanggal = $db->escapeString($tanggal);
    $durasi = $db->escapeString($durasi);
    $catatan_dokter = $db->escapeString($catatan_dokter);

    $sql = "UPDATE tindakan
            SET id_pasien = '$id_pasien',
                id_dctindakan = '$id_dctindakan',
                id_diagnosis = '$id_diagnosis',
                id_mmedikamentisa = '$id_medikamentosa',
                tanggal = '$tanggal',
                durasi = '$durasi',
                catatan_dokter = '$catatan_dokter'
            WHERE id_tindakan = $id";

    $result = $db->updateData($sql);

    if ($result) {
        header("Location: /view/users/tindakan/index.php");
        exit;
    } else {
        echo "Gagal menambahkan konsultasi!";
    }
}

function deleteTindakan($db, $id)
{
    $id = (int) $id;
    $sql = "DELETE FROM tindakan WHERE id_tindakan = $id";
    $result = $db->deleteData($sql);

    if ($result) {
        header("Location: /view/users/tindakan/index.php");
        exit;
    } else {
        echo "Gagal menambahkan konsultasi!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'tambah_data') {
        $id_pasien = $_POST['id_pasien'];
        $id_dctindakan = $_POST['id_tindakan'];
        $id_diagnosis = $_POST['id_dcdiagnosis'];
        $id_medikamentosa = $_POST['id_medikamentosa'];
        $tanggal = $_POST['tanggal'];
        $durasi = $_POST['durasi'];
        $catatan_dokter = $_POST['catatan_dokter'];

        createTindakan($db, $id_pasien, $id_dctindakan, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $catatan_dokter);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update_data') {
        $id = $_POST['id_tindakan'];
        $id_pasien = $_POST['id_pasien'];
        $id_dctindakan = $_POST['id_dctindakan'];
        $id_diagnosis = $_POST['id_diagnosis'];
        $id_medikamentosa = $_POST['id_medikamentosa'];
        $tanggal = $_POST['tanggal'];
        $durasi = $_POST['durasi'];
        $catatan_dokter = $_POST['catatan_dokter'];

        updateTindakan($db, $id, $id_pasien, $id_dctindakan, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $catatan_dokter);
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'tambah_data') {
            createTindakan($db, $_POST['id_pasien'], $_POST['id_dctindakan'], $_POST['id_diagnosis'], $_POST['id_medikamentosa'], $_POST['tanggal'], $_POST['durasi'], $_POST['catatan_dokter']);
        } elseif ($_POST['action'] === 'update_data') {
            updateTindakan($db, $_POST['id_tindakan'], $_POST['id_pasien'], $_POST['id_dctindakan'], $_POST['id_diagnosis'], $_POST['id_medikamentosa'], $_POST['tanggal'], $_POST['durasi'], $_POST['catatan_dokter']);
        } elseif ($_POST['action'] === 'delete_data') {
            deleteTindakan($db, $_POST['id_tindakan']);
        }
        
    }
}

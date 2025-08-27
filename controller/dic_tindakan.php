<?php
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();

function getAllTindakan($db)
{
    $sql = "SELECT * FROM dic_tindakan ORDER BY id_dctindakan DESC";
    return $db->showData($sql);
}

function createDicTindakan($db, $kode_dctindakan, $nama_tindakan, $kategori = null, $durasi = null, $keterangan = null, $perlengkapan = null)
{
    // Escape input
    $kode_dctindakan = $db->escapeString($kode_dctindakan);
    $nama_tindakan = $db->escapeString($nama_tindakan);
    $kategori = $kategori !== null ? "'" . $db->escapeString($kategori) . "'" : "NULL";
    $durasi = $durasi !== null ? "'" . $db->escapeString($durasi) . "'" : "NULL";
    $keterangan = $keterangan !== null ? "'" . $db->escapeString($keterangan) . "'" : "NULL";
    $perlengkapan = $perlengkapan !== null ? "'" . $db->escapeString($perlengkapan) . "'" : "NULL";

    $sql = "INSERT INTO dic_tindakan (kode_dctindakan, nama_tindakan, kategori, durasi, keterangan, perlengkapan)
    VALUES ('$kode_dctindakan', '$nama_tindakan', $kategori, $durasi, $keterangan, $perlengkapan)";

    $result = $db->insertData($sql);

    if ($result) {
        header("Location: /view/admin/dic-tindakan/index.php");
        exit;
    } else {
        echo "Gagal menambahkan tindakan";
    }
}

function updateDicTindakan($db, $id_dctindakan, $kode_dctindakan, $nama_tindakan, $kategori = null, $durasi = null, $keterangan = null, $perlengkapan = null)
{

    $id_dctindakan = intval($id_dctindakan);
    $kode_dctindakan = $db->escapeString($kode_dctindakan);
    $nama_tindakan = $db->escapeString($nama_tindakan);
    $kategori = $kategori !== null ?
        "'" . $db->escapeString($kategori) . "'" : "NULL";
    $durasi = $durasi !== null ?
        "'" . $db->escapeString($durasi) . "'" : "NULL";
    $keterangan = $keterangan !== null ?
        "'" . $db->escapeString($keterangan) . "'" : "NULL";
    $perlengkapan = $perlengkapan !== null ?
        "'" . $db->escapeString($perlengkapan) . "'" : "NULL";

    $sql = "UPDATE dic_tindakan 
            SET kode_dctindakan = '$kode_dctindakan',
                nama_tindakan = '$nama_tindakan', 
                kategori = $kategori, 
                durasi = $durasi, 
                keterangan = $keterangan, 
                perlengkapan = $perlengkapan
            WHERE id_dctindakan = $id_dctindakan";

    $result = $db->updateData($sql);

    if ($result) {
        header("Location: /view/admin/dic-tindakan/index.php");
        exit;
    } else {
        echo "Gagal menambahkan tindakan";
    }
}

function deleteDcTindakan($db, $id_dctindakan)
{
    $id_dctindakan = (int) $id_dctindakan;
    $sql = "DELETE FROM dic_tindakan WHERE id_dctindakan = $id_dctindakan";
    $result = $db->deleteData($sql);

    if ($result) {
        header("Location: /view/admin/dic-tindakan/index.php");
        exit;
    } else {
        echo "Gagal menambahkan tindakan";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'tambah_data') {
        $kode_dctindakan = $_POST['kode_dctindakan'];
        $nama_tindakan = $_POST['nama_tindakan'];
        $kategori = $_POST['kategori'];
        $durasi = $_POST['durasi'];
        $keterangan = $_POST['keterangan'];
        $perlengkapan = $_POST['perlengkapan'];

        createDicTindakan($db, $kode_dctindakan, $nama_tindakan, $kategori, $durasi, $keterangan, $perlengkapan);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update_data') {
        $id_dctindakan = $_POST['id_dctindakan'];
        $kode_dctindakan = $_POST['kode_dctindakan'];
        $nama_tindakan = $_POST['nama_tindakan'];
        $kategori = $_POST['kategori'];
        $durasi = $_POST['durasi'];
        $keterangan = $_POST['keterangan'];
        $perlengkapan = $_POST['perlengkapan'];

        updateDicTindakan($db, $id_dctindakan, $kode_dctindakan, $nama_tindakan, $kategori, $durasi, $keterangan, $perlengkapan);
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'tambah_data') {
            createDicTindakan($db, $_POST['kode_dctindakan'], $_POST['nama_tindakan'], $_POST['kategori'], $_POST['durasi'], $_POST['keterangan'], $_POST['perlengkapan']);
        } elseif ($_POST['action'] === 'update_data') {
            updateDicTindakan($db, $_POST['id_dctindakan'], $_POST['kode_dctindakan'], $_POST['nama_tindakan'], $_POST['kategori'], $_POST['durasi'], $_POST['keterangan'], $_POST['perlengkapan']);
        } elseif ($_POST['action'] === 'delete_data') {
            deleteDcTindakan($db, $_POST['id_dctindakan']);
        }
    }
}

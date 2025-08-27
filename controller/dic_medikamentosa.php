<?php
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();

function getAllMedikamentosa($db)
{
    $sql = "SELECT * FROM dic_medikamentosa ORDER BY id_medikamentosa DESC";
    return $db->showData($sql);
}

function createMedikamentosa($db, $kode_obat, $nama_generik, $nama_dagang = null, $bentuk_sediaan = null, $satuan = null, $golongan = null, $keterangan = null)
{

    $kode_obat = $db->escapeString($kode_obat);
    $nama_generik = $db->escapeString($nama_generik);
    $nama_dagang = $nama_dagang !== null ?
        "'" . $db->escapeString($nama_dagang) . "'" : "NULL";
    $bentuk_sediaan = $bentuk_sediaan !== null ?
        "'" . $db->escapeString($bentuk_sediaan) . "'" : "NULL";
    $satuan = $satuan !== null ?
        "'" . $db->escapeString($satuan) . "'" : "NULL";
    $golongan = $golongan !== null ?
        "'" . $db->escapeString($golongan) . "'" : "NULL";
    $keterangan = $keterangan !== null ?
        "'" . $db->escapeString($keterangan) . "'" : "NULL";

    $sql = "INSERT INTO dic_medikamentosa (kode_obat, nama_generik, nama_dagang, bentuk_sediaan, satuan, golongan, keterangan)
        VALUE ('$kode_obat', '$nama_generik', $nama_dagang, $bentuk_sediaan, $satuan, $golongan, $keterangan)";

    $result = $db->insertData($sql);

    if ($result) {
        header("Location: /view/admin/dic-medikamentosa/index.php");
        exit;
    } else {
        echo "Gagal menambahkan diagnosis!";
    }
}

function updateMedikammentosa($db, $id_medikamentosa, $kode_obat, $nama_generik, $nama_dagang = null, $bentuk_sediaan = null, $satuan = null, $golongan = null, $keterangan = null)
{

    $id_medikamentosa = intval($id_medikamentosa);
    $kode_obat = $db->escapeString($kode_obat);
    $nama_generik = $db->escapeString($nama_generik);
    $nama_dagang = $nama_dagang !== null ?
        "'" . $db->escapeString($nama_dagang) . "'" : "NULL";
    $bentuk_sediaan = $bentuk_sediaan !== null ?
        "'" . $db->escapeString($bentuk_sediaan) . "'" : "NULL";
    $satuan = $satuan !== null ?
        "'" . $db->escapeString($satuan) . "'" : "NULL";
    $golongan = $golongan !== null ?
        "'" . $db->escapeString($golongan) . "'" : "NULL";
    $keterangan = $keterangan !== null ?
        "'" . $db->escapeString($keterangan) . "'" : "NULL";

    $sql = "UPDATE dic_medikamentosa
            SET kode_obat = '$kode_obat',
                nama_generik = '$nama_generik',
                nama_dagang = $nama_dagang,
                bentuk_sediaan = $bentuk_sediaan,
                satuan = $satuan,
                golongan = $golongan,
                keterangan = $keterangan
            WHERE id_medikamentosa = $id_medikamentosa ";

    $result = $db->updateData($sql);

    if ($result) {
        header("Location: /view/admin/dic-medikamentosa/index.php");
        exit;
    } else {
        echo "Gagal menambahkan diagnosis!";
    }
}

function deleteMedikamentosa($db, $id_medikamentosa)
{
    $id_medikamentosa = (int) $id_medikamentosa;
    $sql = "DELETE FROM dic_medikamentosa WHERE id_medikamentosa = $id_medikamentosa";
    $result = $db->deleteData($sql);

    if ($result) {
        header("Location: /view/admin/dic-medikamentosa/index.php");
        exit;
    } else {
        echo "Gagal menambahkan diagnosis!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'tambah_data') {
        $kode_obat = $_POST['kode_obat'];
        $nama_generik = $_POST['nama_generik'];
        $nama_dagang = $_POST['nama_dagang'];
        $bentuk_sediaan = $_POST['bentuk_sediaan'];
        $satuan = $_POST['satuan'];
        $golongan = $_POST['golongan'];
        $keterangan = $_POST['keterangan'];

        createMedikamentosa($db, $kode_obat, $nama_generik, $nama_dagang, $bentuk_sediaan, $satuan, $golongan, $keterangan);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update_data') {
        $id_medikamentosa = $_POST['id_medikamentosa'];
        $kode_obat = $_POST['kode_obat'];
        $nama_generik = $_POST['nama_generik'];
        $nama_dagang = $_POST['nama_dagang'];
        $bentuk_sediaan = $_POST['bentuk_sediaan'];
        $satuan = $_POST['satuan'];
        $golongan = $_POST['golongan'];
        $keterangan = $_POST['keterangan'];

        updateMedikammentosa($db, $id_medikamentosa, $kode_obat, $nama_generik, $nama_dagang, $bentuk_sediaan, $satuan, $golongan, $keterangan);
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'tambah_data') {
            createMedikamentosa($db, $_POST['kode_obat'], $_POST['nama_generik'], $_POST['nama_dagang'], $_POST['bentuk_sediaan'], $_POST['satuan'], $_POST['golongan'],$_POST['keterangan']);
        } elseif ($_POST['action'] === 'update_data') {
            updateMedikammentosa($db, $_POST['id_medikamentosa'], $_POST['kode_obat'], $_POST['nama_generik'], $_POST['nama_dagang'], $_POST['bentuk_sediaan'], $_POST['satuan'], $_POST['golongan'], $_POST['keterangan']);
        } elseif ($_POST['action'] === 'delete_data') {
            deleteMedikamentosa($db, $_POST['id_medikamentosa']);
        }
    }
}


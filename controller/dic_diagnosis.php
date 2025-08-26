<?php
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();

function getAllDiagnosis($db)
{
    $sql = "SELECT * FROM dic_diagnosis ORDER BY id_diagnosis DESC";
    return $db->showData($sql);
}

function createDiagnosis($db, $kode, $nama_diagnosis, $kategori_penyakit = null)
{
    // Escape input biar aman
    $kode = $db->escapeString($kode);
    $nama_diagnosis = $db->escapeString($nama_diagnosis);
    $kategori_penyakit = $kategori_penyakit !== null ?
        "'" . $db->escapeString($kategori_penyakit) . "'" : "NULL";

    $sql = "INSERT INTO dic_diagnosis (kode, nama_diagnosis, kategori_penyakit) 
            VALUES ('$kode', '$nama_diagnosis', $kategori_penyakit)";

    $result = $db->insertData($sql);

    if ($result) {
        header("Location: /view/admin/dic-diagnosis/index.php");
        exit;
    } else {
        echo "Gagal menambahkan diagnosis!";
    }
}

function updateDiagnosis($db, $id, $kode, $nama_diagnosis, $kategori_penyakit = null)
{
    // Escape input biar aman
    $id = intval($id); // pastikan integer
    $kode = $db->escapeString($kode);
    $nama_diagnosis = $db->escapeString($nama_diagnosis);
    $kategori_penyakit = $kategori_penyakit !== null ?
        "'" . $db->escapeString($kategori_penyakit) . "'" : "NULL";

    $sql = "UPDATE dic_diagnosis 
            SET kode = '$kode', 
                nama_diagnosis = '$nama_diagnosis', 
                kategori_penyakit = $kategori_penyakit
            WHERE id_diagnosis = $id";

    $result = $db->updateData($sql);

    if ($result) {
        header("Location: /view/admin/dic-diagnosis/index.php");
        exit;
    } else {
        echo "Gagal mengupdate diagnosis!";
    }
}

function deleteDiagnosis($db, $id)
{
    $id = (int) $id; // pastikan integer untuk keamanan
    $sql = "DELETE FROM dic_diagnosis WHERE id_diagnosis = $id";
    $result = $db->deleteData($sql);

    if ($result) {
        header("Location: /view/admin/dic-diagnosis/index.php");
        exit;
    } else {
        echo "Gagal menghapus diagnosis!";
    }
}


// 🔹 Handler form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'tambah_data') {
        $kode = $_POST['kode'];
        $nama_diagnosis = $_POST['nama_diagnosis'];
        $kategori = $_POST['kategori_penyakit'];

        createDiagnosis($db, $kode, $nama_diagnosis, $kategori);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update_data') {
        $id = $_POST['id_diagnosis']; // ambil id dari form
        $kode = $_POST['kode'];
        $nama_diagnosis = $_POST['nama_diagnosis'];
        $kategori = $_POST['kategori_penyakit'];

        updateDiagnosis($db, $id, $kode, $nama_diagnosis, $kategori);
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'tambah_data') {
            createDiagnosis($db, $_POST['kode'], $_POST['nama_diagnosis'], $_POST['kategori_penyakit']);
        } elseif ($_POST['action'] === 'update_data') {
            updateDiagnosis($db, $_POST['id_diagnosis'], $_POST['kode'], $_POST['nama_diagnosis'], $_POST['kategori_penyakit']);
        } elseif ($_POST['action'] === 'delete_data') {
            deleteDiagnosis($db, $_POST['id_diagnosis']);
        }
    }
}






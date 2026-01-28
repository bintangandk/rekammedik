<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();

// Hitung tindakan bulan ini (reset tiap bulan)
function countTindakanBulanIni($db)
{
    $bulan = date('m');
    $tahun = date('Y');

    $sql = "
        SELECT COUNT(*) AS total 
        FROM tindakan 
        WHERE MONTH(tanggal) = '$bulan' 
          AND YEAR(tanggal) = '$tahun'
    ";
    $result = $db->showData($sql);

    return !empty($result) ? (int)$result[0]['total'] : 0;
}

// Hitung total semua tindakan (tidak reset)
function countTotalTindakan($db)
{
    $sql = "SELECT COUNT(*) AS total FROM tindakan";
    $result = $db->showData($sql);

    return !empty($result) ? (int)$result[0]['total'] : 0;
}

// Hitung tindakan bulan ini (untuk pasien tertentu)
function countTindakanBulanIniByPasien($db, $id_pasien)
{
    $bulan = date('m');
    $tahun = date('Y');
    $id_pasien = (int) $id_pasien;

    $sql = "
        SELECT COUNT(*) AS total 
        FROM tindakan 
        WHERE MONTH(tanggal) = '$bulan' 
          AND YEAR(tanggal) = '$tahun'
          AND id_pasien = $id_pasien
    ";
    $result = $db->showData($sql);

    return !empty($result) ? (int) $result[0]['total'] : 0;
}

// Hitung total semua tindakan (untuk pasien tertentu)
function countTotalTindakanByPasien($db, $id_pasien)
{
    $id_pasien = (int) $id_pasien;

    $sql = "SELECT COUNT(*) AS total FROM tindakan WHERE id_pasien = $id_pasien";
    $result = $db->showData($sql);

    return !empty($result) ? (int) $result[0]['total'] : 0;
}


function getTindakansByIdPasien($db, $id_pasien)
{
    $id_pasien = (int)$id_pasien;
    $sql = "
        SELECT t.*, 
               p.nama AS nama_pasien, 
               p.no_rm, 
               d.nama_diagnosis, 
               m.nama_generik AS nama_medikamentosa,
               dt.nama_tindakan
        FROM tindakan t
        LEFT JOIN pasien p ON t.id_pasien = p.id_pasien
        LEFT JOIN dic_diagnosis d ON t.id_diagnosis = d.id_diagnosis
        LEFT JOIN dic_medikamentosa m ON t.id_medikamentosa = m.id_medikamentosa
        LEFT JOIN dic_tindakan dt ON t.id_dctindakan = dt.id_dctindakan
        WHERE t.id_pasien = $id_pasien
        ORDER BY t.id_tindakan DESC
    ";
    return $db->showData($sql);
}



function getAllTindakans($db)
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

function createTindakan($db, $id_pasien, $id_dctindakan, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $catatan_dokter, $redirect_path = null)
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

    // Tentukan redirect path
    if (!$redirect_path) {
        $redirect_path = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
            ? '../view/admin/tindakan/index.php'
            : '../view/users/tindakan/index.php';
    }

    if ($result) {
        $_SESSION['success'] = "Data tindakan berhasil ditambahkan!";
        header("Location: " . $redirect_path);
        exit;
    } else {
        $_SESSION['error'] = "Gagal menambahkan tindakan!";
        header("Location: " . $redirect_path);
        exit;
    }
}


function updateTindakan($db, $id, $id_pasien, $id_dctindakan, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $catatan_dokter, $redirect_path = null)
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
                id_medikamentosa = '$id_medikamentosa',
                tanggal = '$tanggal',
                durasi = '$durasi',
                catatan_dokter = '$catatan_dokter'
            WHERE id_tindakan = $id";

    $result = $db->updateData($sql);

    // Cek apakah request dari AJAX
    $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    if ($is_ajax) {
        // Return JSON untuk AJAX
        header('Content-Type: application/json; charset=utf-8');

        // Debug: log result
        error_log("Update result: " . var_export($result, true));

        if ($result) {
            echo json_encode([
                "status" => "success",
                "message" => "Data tindakan berhasil diperbarui!"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal memperbarui data tindakan! Error: " . $db->prepareKoneksi()->error
            ]);
        }
        exit;
    } else {
        // Redirect untuk form biasa
        if (!$redirect_path) {
            $redirect_path = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
                ? '../view/admin/tindakan/index.php'
                : '../view/users/tindakan/index.php';
        }

        if ($result) {
            $_SESSION['success'] = "Data tindakan berhasil diperbarui!";
            header("Location: " . $redirect_path);
            exit;
        } else {
            $_SESSION['error'] = "Gagal memperbarui data tindakan!";
            header("Location: " . $redirect_path);
            exit;
        }
    }
}

function deleteTindakan($db, $id, $redirect_path = null)
{
    $id = (int) $id;
    $sql = "DELETE FROM tindakan WHERE id_tindakan = $id";
    $result = $db->deleteData($sql);

    // Tentukan redirect path
    if (!$redirect_path) {
        $redirect_path = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
            ? '../view/admin/tindakan/index.php'
            : '../view/users/tindakan/index.php';
    }

    if ($result) {
        $_SESSION['success'] = "Data tindakan berhasil dihapus!";
        header("Location: " . $redirect_path);
        exit;
    } else {
        $_SESSION['error'] = "Gagal menghapus tindakan!";
        header("Location: " . $redirect_path);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'tambah_data') {
        $id_pasien = $_POST['id_pasien'];
        $id_dctindakan = $_POST['id_dctindakan'];
        $id_diagnosis = $_POST['id_diagnosis'];
        $id_medikamentosa = $_POST['id_medikamentosa'];
        $tanggal = $_POST['tanggal'];
        $durasi = $_POST['durasi'];
        $catatan_dokter = $_POST['catatan_dokter'];
        $redirect_path = isset($_POST['redirect_path']) ? $_POST['redirect_path'] : null;

        createTindakan($db, $id_pasien, $id_dctindakan, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $catatan_dokter, $redirect_path);
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
        $redirect_path = isset($_POST['redirect_path']) ? $_POST['redirect_path'] : null;

        updateTindakan($db, $id, $id_pasien, $id_dctindakan, $id_diagnosis, $id_medikamentosa, $tanggal, $durasi, $catatan_dokter, $redirect_path);
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'tambah_data') {
            $redirect_path = isset($_POST['redirect_path']) ? $_POST['redirect_path'] : null;
            createTindakan($db, $_POST['id_pasien'], $_POST['id_dctindakan'], $_POST['id_diagnosis'], $_POST['id_medikamentosa'], $_POST['tanggal'], $_POST['durasi'], $_POST['catatan_dokter'], $redirect_path);
        } elseif ($_POST['action'] === 'update_data') {
            $redirect_path = isset($_POST['redirect_path']) ? $_POST['redirect_path'] : null;
            updateTindakan($db, $_POST['id_tindakan'], $_POST['id_pasien'], $_POST['id_dctindakan'], $_POST['id_diagnosis'], $_POST['id_medikamentosa'], $_POST['tanggal'], $_POST['durasi'], $_POST['catatan_dokter'], $redirect_path);
        } elseif ($_POST['action'] === 'delete_data') {
            $redirect_path = isset($_POST['redirect_path']) ? $_POST['redirect_path'] : null;
            deleteTindakan($db, $_POST['id_tindakan'], $redirect_path);
        }
    }
}

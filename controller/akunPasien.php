<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();

function getAllAkun($db)
{
    $sql = "SELECT * FROM users WHERE role = 'pasien' ORDER BY id_user DESC";
    return $db->showData($sql);
}

function getPasienWithoutAkun($db)
{
    $sql = "SELECT id_pasien, nama FROM pasien WHERE id_user IS NULL ORDER BY nama ASC";
    return $db->showData($sql);
}


function createAkunPasien($db, $id_pasien, $email, $password, $role, $no_telfon, $gambar)
{
    $email = $db->escapeString($email);
    $password = password_hash($db->escapeString($password), PASSWORD_BCRYPT);
    $role = $db->escapeString($role);
    $no_telfon = $db->escapeString($no_telfon);
    $gambar = $db->escapeString($gambar);

    $pasien = $db->showData("SELECT nama FROM pasien WHERE id_pasien = $id_pasien LIMIT 1");
    if (!$pasien) {
        echo "Pasien tidak ditemukan!";
        return;
    }
    $nama = $db->escapeString($pasien[0]['nama']);

    $sql = "INSERT INTO users (email, password, role, no_telfon, Nama, gambar)
            VALUES ('$email', '$password', '$role', '$no_telfon', '$nama', '$gambar')";
    $result = $db->insertData($sql);

    if ($result) {
        $id_user = $db->getlastId();

        $update = "UPDATE pasien SET id_user = $id_user WHERE id_pasien = $id_pasien";
        $db->updateData($update);

        $_SESSION['success'] = 'Akun pasien berhasil ditambahkan';
        header("Location: ../view/admin/akun-pasien/index.php");
        exit;
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan saat menambahkan akun pasien';
        header("Location: ../view/admin/akun-pasien/index.php");
        exit;
    }
}



function updateAkunPasien($db, $id_user, $email, $password, $role, $no_telfon, $Nama, $gambar)
{

    $id_user = intval($id_user);
    $email = $db->escapeString($email);
    $password = $db->escapeString($password);
    $role = $db->escapeString($role);
    $no_telfon = $db->escapeString($no_telfon);
    $Nama = $db->escapeString($Nama);
    $gambar = $db->escapeString($gambar);

    $sql = "UPDATE users 
            SET email = '$email',
                password = '$password', 
                role = '$role', 
                no_telfon = '$no_telfon', 
                Nama = '$Nama', 
                gambar = '$gambar'
            WHERE id_user = $id_user";

    $result = $db->updateData($sql);

    // Check if this is an AJAX request
    $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    if ($is_ajax) {
        header('Content-Type: application/json; charset=utf-8');
        ob_clean();
        if ($result) {
            echo json_encode([
                "status" => "success",
                "message" => "Data akun berhasil diperbarui!"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal memperbarui data akun!"
            ]);
        }
    } else {
        // Session-based alert for form submission
        if ($result) {
            $_SESSION['success'] = 'Akun pasien berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Terjadi kesalahan saat memperbarui akun pasien';
        }
        header("Location: ../view/admin/akun-pasien/index.php");
    }
    exit;
}

function deleteAkunPasien($db, $id_user)
{

    $id_user = (int) $id_user;
    $sql = "DELETE FROM users WHERE id_user = $id_user";
    $result = $db->deleteData($sql);

    if ($result) {
        $_SESSION['success'] = 'Akun pasien berhasil dihapus';
        header("Location: ../view/admin/akun-pasien/index.php");
        exit;
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan saat menghapus akun pasien';
        header("Location: ../view/admin/akun-pasien/index.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['action']) && $_POST['action'] === 'tambah_data') {
        $id_pasien = $_POST['id_pasien'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $no_telfon = $_POST['no_telfon'];
        $gambar = $_POST['gambar'];

        createAkunPasien($db, $id_pasien, $email, $password, $role, $no_telfon, $gambar);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update_data') {
        $id_user = $_POST['id_user'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $no_telfon = $_POST['no_telfon'];
        $Nama = $_POST['Nama'];
        $gambar = $_POST['gambar'];

        updateAkunPasien($db, $id_user, $email, $password, $role, $no_telfon, $Nama, $gambar);
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'tambah_data') {
            createAkunPasien($db, $_POST['email'], $_POST['password'], $_POST['role'], $_POST['no_telfon'], $_POST['Nama'], $_POST['gambar']);
        } elseif ($_POST['action'] === 'update_data') {
            updateAkunPasien($db, $_POST['id_user'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['no_telfon'], $_POST['Nama'], $_POST['gambar']);
        } elseif ($_POST['action'] === 'delete_data') {
            deleteAkunPasien($db, $_POST['id_user']);
        }
    }
}

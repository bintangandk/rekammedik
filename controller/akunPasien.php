<?php
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

    // Ambil nama pasien dari tabel pasien
    $pasien = $db->showData("SELECT nama FROM pasien WHERE id_pasien = $id_pasien LIMIT 1");
    if (!$pasien) {
        echo "Pasien tidak ditemukan!";
        return;
    }
    $nama = $db->escapeString($pasien[0]['nama']);

    // 1. Insert ke tabel users (termasuk Nama)
    $sql = "INSERT INTO users (email, password, role, no_telfon, Nama, gambar)
            VALUES ('$email', '$password', '$role', '$no_telfon', '$nama', '$gambar')";
    $result = $db->insertData($sql);

    if ($result) {
        // Ambil id_user terakhir
        $id_user = $db->getlastId();

        // 2. Update tabel pasien agar terhubung dengan user
        $update = "UPDATE pasien SET id_user = $id_user WHERE id_pasien = $id_pasien";
        $db->updateData($update);

        header("Location: /view/admin/akun-pasien/index.php");
        exit;
    } else {
        echo "Gagal menambahkan akun pasien";
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

    if ($result) {
        header("Location: /view/admin/akun-pasien/index.php");
        exit;
    } else {
        echo "Gagal menambahkan tindakan";
    }
}

function deleteAkunPasien($db, $id_user)
{

    $id_user = (int) $id_user;
    $sql = "DELETE FROM users WHERE id_user = $id_user";
    $result = $db->deleteData($sql);

    if ($result) {
        header("Location: /view/admin/akun-pasien/index.php");
        exit;
    } else {
        echo "Gagal menambahkan tindakan";
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

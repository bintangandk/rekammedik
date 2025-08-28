<?php
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();

function getAllAkun($db)
{
    $sql = "SELECT * FROM users WHERE role = 'pasien' ORDER BY id_user DESC";
    return $db->showData($sql);
}


function createAkunPasien($db, $email, $password, $role, $no_telfon, $Nama, $gambar)
{

    $email = $db->escapeString($email);
    $password = $db->escapeString($password);
    $role = $db->escapeString($role);
    $no_telfon = $db->escapeString($no_telfon);
    $Nama = $db->escapeString($Nama);
    $gambar = $db->escapeString($gambar);

    $sql = "INSERT INTO users (email, password, role, no_telfon, Nama, gambar)
    VALUES ('$email', '$password', '$role', '$no_telfon', '$Nama', '$gambar')";

    $result = $db->insertData($sql);

    if ($result) {
        header("Location: /view/admin/akun-pasien/index.php");
        exit;
    } else {
        echo "Gagal menambahkan tindakan";
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
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $no_telfon = $_POST['no_telfon'];
        $Nama = $_POST['Nama'];
        $gambar = $_POST['gambar'];

        createAkunPasien($db, $email, $password, $role, $no_telfon, $Nama, $gambar);
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

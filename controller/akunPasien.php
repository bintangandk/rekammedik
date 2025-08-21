<?php
session_start();
include __DIR__ . '/../koneksi.php'; // load class koneksi

$db = new koneksi(); // buat objek koneksi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Cek apakah ini update atau insert
    if (!empty($_POST['id_user'])) {
        // === UPDATE DATA PASIEN ===
        $id_user    = $db->escapeString($_POST['id_user']);
        $nama       = $db->escapeString($_POST['Nama']);
        $email      = $db->escapeString($_POST['email']);
        $no_telfon  = $db->escapeString($_POST['no_telfon']);
        $nip        = !empty($_POST['nip']) ? $db->escapeString($_POST['nip']) : NULL;
        $id_unit    = !empty($_POST['id_unit']) ? $db->escapeString($_POST['id_unit']) : NULL;
        $role       = $db->escapeString($_POST['role']); // "pasien"
        $gambar     = !empty($_POST['gambar']) ? $db->escapeString($_POST['gambar']) : NULL; // optional

        // Buat query update
        $query = "UPDATE users SET
                    Nama = '$nama',
                    email = '$email',
                    no_telfon = '$no_telfon',
                    nip = " . ($nip ? "'$nip'" : "NULL") . ",
                    id_unit = " . ($id_unit ? "'$id_unit'" : "NULL") . ",
                    role = '$role'" .
                    ($gambar ? ", gambar = '$gambar'" : "") . "
                  WHERE id_user = '$id_user'";

        if ($db->updateData($query) !== false) {
            $_SESSION['success'] = "Data pasien berhasil diperbarui.";
        } else {
            $_SESSION['error'] = "Gagal memperbarui data pasien.";
        }

        header("Location: ../view/admin/akun-pasien/index.php");
        exit();

    } else {
        // === INSERT DATA PASIEN ===
        $nama       = $db->escapeString($_POST['Nama']);
        $email      = $db->escapeString($_POST['email']);
        $password   = password_hash($_POST['password'], PASSWORD_BCRYPT); // hash password
        $role       = $db->escapeString($_POST['role']);   // harus "pasien"
        $nip        = !empty($_POST['nip']) ? $db->escapeString($_POST['nip']) : NULL;
        $no_telfon  = $db->escapeString($_POST['no_telfon']);
        $id_unit    = !empty($_POST['id_unit']) ? $db->escapeString($_POST['id_unit']) : NULL;
        $gambar     = !empty($_POST['gambar']) ? $db->escapeString($_POST['gambar']) : 'profile.jpg';

        $query = "INSERT INTO users (email, password, role, Nama, nip, no_telfon, id_unit, gambar) 
                  VALUES (
                    '$email', 
                    '$password', 
                    '$role', 
                    '$nama', 
                    " . ($nip ? "'$nip'" : "NULL") . ", 
                    '$no_telfon', 
                    " . ($id_unit ? "'$id_unit'" : "NULL") . ", 
                    '$gambar'
                  )";

        if ($db->insertData($query) !== false) {
            $_SESSION['success'] = "Akun pasien berhasil ditambahkan.";
        } else {
            $_SESSION['error'] = "Gagal menambahkan akun pasien.";
        }

        header("Location: ../view/admin/akun-pasien/index.php");
        exit();
    }
}
?>

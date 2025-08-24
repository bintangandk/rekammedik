<?php
session_start();
include __DIR__ . '/../koneksi.php';

$db = new koneksi();

// === HANDLE INSERT / UPDATE ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input form
    $id_user   = !empty($_POST['id_user']) ? $db->escapeString($_POST['id_user']) : null;
    $nama      = $db->escapeString($_POST['Nama']);
    $email     = $db->escapeString($_POST['email']);
    $no_telfon = $db->escapeString($_POST['no_telfon']);
    $role      = $db->escapeString($_POST['role']);
    $nip       = !empty($_POST['nip']) ? $db->escapeString($_POST['nip']) : NULL;
    $id_unit   = !empty($_POST['id_unit']) ? $db->escapeString($_POST['id_unit']) : NULL;
    $gambar    = !empty($_POST['gambar']) ? $db->escapeString($_POST['gambar']) : 'profile.jpg';

    // === UPDATE DATA ===
    if ($id_user) {
        $updateQuery = "UPDATE users SET
            Nama = '$nama',
            email = '$email',
            no_telfon = '$no_telfon',
            nip = " . ($nip ? "'$nip'" : "NULL") . ",
            id_unit = " . ($id_unit ? "'$id_unit'" : "NULL") . ",
            role = '$role'";

        // Jika password diisi → update password
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $updateQuery .= ", password = '$password'";
        }

        // Jika gambar diisi → update gambar
        if (!empty($_POST['gambar'])) {
            $updateQuery .= ", gambar = '$gambar'";
        }

        $updateQuery .= " WHERE id_user = '$id_user'";

        if ($db->updateData($updateQuery) !== false) {
            $_SESSION['success'] = "Data pasien berhasil diperbarui.";
        } else {
            $_SESSION['error'] = "Gagal memperbarui data pasien.";
        }

        // === INSERT DATA BARU ===
    } else {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

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
    }

    // Redirect setelah insert/update
    header("Location: ../view/admin/akun-pasien/index.php");
    exit();
}

// === HANDLE DELETE ===
if (isset($_GET['delete'])) {
    $id_user = $db->escapeString($_GET['delete']);

    $query = "DELETE FROM users WHERE id_user = '$id_user'";

    if ($db->deleteData($query) !== false) {
        $_SESSION['success'] = "Data pasien berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus data pasien.";
    }

    header("Location: ../view/admin/akun-pasien/index.php");
    exit();
}

<?php
session_start();
include '../koneksi.php'; // Menyertakan file koneksi dari folder luar

function login($email, $password)
{
    $conn = new koneksi();
    $email = $conn->escapeString($email);
    $password = $conn->escapeString($password);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->execute($query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login'] = 'Login berhasil!';
            header("Location: ../view/admin/dashboard/index.php");
            exit();
        }
    }



    $_SESSION['error'] = 'Login gagal, email atau password salah!';
    header("Location: ../view/auth/login.php");
    
    exit();
}

function register($Nama, $email, $no_telfon, $nip, $role, $id_unit, $password)
{
    $conn = new koneksi();
    $errors = [];

    // Validasi input
    if (empty($Nama)) {
        $errors[] = 'Nama Pegawai harus diisi.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email tidak valid.';
    } else {
        // Cek apakah email sudah ada di database
        $email = $conn->escapeString($email);
        $query = "SELECT COUNT(*) AS count FROM users WHERE email = '$email'";
        $result = $conn->execute($query);
        if ($result->fetch_assoc()['count'] > 0) {
            $errors[] = 'Email sudah terdaftar.';
        }
    }
    if (empty($no_telfon) || !preg_match('/^[0-9]+$/', $no_telfon)) {
        $errors[] = 'Nomor Telepon harus berupa angka.';
    }
    if (empty($nip) || !preg_match('/^[0-9]+$/', $nip)) {
        $errors[] = 'NIP harus berupa angka.';
    }
    if (empty($role)) {
        $errors[] = 'Jabatan/Peranan harus diisi.';
    }
    if (empty($id_unit)) {
        $errors[] = 'id_unit harus diisi.';
    }
    if (empty($password)) {
        $errors[] = 'Password harus diisi.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        return false;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan data ke database
    $query = "INSERT INTO users ( Nama,email, no_telfon, nip, role, id_unit, password) VALUES ('$Nama', '$email', '$no_telfon', '$nip', '$role', '$id_unit', '$hashed_password')";
    return $conn->execute($query);
}

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        login($email, $password);
    }


    if (isset($_POST['action']) && $_POST['action'] == 'register') {
        $Nama = $_POST['Nama'];
        $email = $_POST['email'];
        $no_telfon = $_POST['no_telfon'];
        $nip = $_POST['nip'];
        $role = $_POST['role'];
        $id_unit = $_POST['id_unit'];
        $password = $_POST['password'];

        if (register($Nama, $email, $no_telfon, $nip, $role, $id_unit, $password)) {
            unset($_SESSION['form_data']);
            $_SESSION['success'] = 'Registrasi berhasil!';
            header('Location: ../view/auth/login.php');
            exit();
        } else {
            // $_SESSION['error'] = 'Registrasi gagal!';
            header("Location: ../view/auth/register.php");
            exit();
        }
    }

}



function logout() {
    // Hapus semua variabel sesi
    $_SESSION = array();

    // Hapus cookie sesi jika ada
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }

    // Hancurkan sesi
    session_destroy();
}

// Panggil fungsi logout jika parameter 'action' di-set
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logout();
    // Simpan pesan notifikasi di sesi
    $_SESSION['logout'] = 'Anda telah berhasil logout.';
    // var_dump($_SESSION['success']);
    // Redirect ke halaman login setelah logout
    header("Location: ../view/auth/login.php");
    exit();
}
?>

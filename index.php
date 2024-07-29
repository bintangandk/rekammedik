<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: view/auth/login.php");
    exit();
}

// Jika sudah login, tampilkan halaman utama atau redirect ke dashboard
header("Location: view/admin/dashboard/index.php");
exit();
?>

<?php

session_start();


include '../koneksi.php';
$conn = new koneksi();
$email = $_SESSION["email1"];
date_default_timezone_set('Asia/Jakarta');
$token = htmlspecialchars($_POST["token"]);

$cek = "SELECT * FROM users where email='$email' AND reset_token_hash='$token'";
// $cek="SELECT * FROM users where email='$email'";
$existingData = $conn->execute($cek);
if ($existingData->num_rows == 0) {

    $_SESSION['error'] = 'Token Salah';
    header("Location: ../view/auth/token.php");
} else {
    $data = $existingData->fetch_assoc();

    $waktu = date('Y-m-d H:i:s');
    $xpird = $data["reset_token_expires_at"];
    if ($waktu > $xpird) {

        $_SESSION['error'] = 'Token Sudah Kadaluarsa';
        header("Location: ../view/auth/token.php");
    } else {

        // $_SESSION['error'] = 'Token Salah';
        header("Location: ../view/auth/new_password.php");
    }
}

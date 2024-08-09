<?php
session_start();

include '../koneksi.php';
$conn = new koneksi();

$email=$_SESSION["email"];
$password=htmlspecialchars($_POST["password"]);
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$query="UPDATE users SET password='$hashedPassword' where email='$email'";
$conn->execute($query);
unset($_SESSION['email1']);
$_SESSION['success'] = 'Berhasil Ubah Password.';
header("Location: ../view/auth/login.php");
exit();


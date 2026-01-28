<?php
session_start();
require_once '../koneksi.php';
if (!is_dir('uploads/profile')) {
    mkdir('uploads/profile', 0777, true);
}
require_once '../controller/Pegawai.php';
$kon = new koneksi();
$pegawai = new Pegawai();

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {

    $id = htmlspecialchars($_GET['id']);

    $row = $kon->execute("SELECT * FROM users WHERE id_user = '$id'")->fetch_assoc();

    // Hapus file gambar jika ada
    if ($row && isset($row['gambar']) && !empty($row['gambar'])) {
        $file_path = "uploads/profile/" . $row['gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $query = "DELETE FROM users WHERE id_user ='$id'";
    $result = $kon->execute($query);

    if ($result) {
        $_SESSION['success'] = "Data berhasil dihapus!";
        header("Location: ../view/admin/data-pegawai/index.php");
        exit();
    } else {
        $_SESSION['error'] = "Gagal menghapus data";
        header("Location: ../view/admin/data-pegawai/index.php");
        exit();
    }
}

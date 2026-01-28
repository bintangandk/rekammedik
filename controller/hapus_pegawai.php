<?php
// var_dump("dsdsdsds");
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

    unlink("uploads/profile/" . $row['gambar']);
    $query = "DELETE FROM users WHERE id_user ='$id'";
    $result = $kon->execute($query);
    // var_dump($result);
    try {


        if ($result) {
            # code...
            $_SESSION['success'] = "Data berhasil dihapus!";
            header("Location: ../view/admin/data-pegawai/index.php");
        } else {
            // # code...
            header("Location: ../view/admin/data-pegawai/index.php?message=Gagal menghapus data");
        }
    } catch (\Throwable $th) {
        // var_dump($th);
    }
} else {
    // Logika lain untuk controller utama
}

<?php
// var_dump("dsdsdsds");
session_start() ;
require_once '../koneksi.php';
$conn = mysqli_connect("localhost", "root", "", "rekammedik");
// if (!is_dir('uploads/laboratorium')) {
//     mkdir('uploads/laboratorium', 0777, true);
// }
require_once '../controller/Pegawai.php';
$kon = new koneksi();
$pegawai = new Pegawai();

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    // var_dump($_GET['id']);

    $id = htmlspecialchars($_GET['id']);
// var_dump($id);

    $query = "DELETE FROM users WHERE id_user ='$id'";
    $result = mysqli_query($conn, $query);
    // var_dump($result);
    try {
        
  
    if ($result) {
        # code...
        $_SESSION['success'] = "Data berhasil dihapus!";
        header("Location: ../view/admin/data-pegawai/index.php");


    }else {
        // # code...
        header("Location: ../view/admin/data-pegawai/index.php?message=Gagal menghapus data");
    }
} catch (\Throwable $th) {
    // var_dump($th);
}

    $response = $pegawai->delete($_GET['id']);
// var_dump($response);
    if ($response['status'] === 'success') {
        // var_dump($response);
        $_SESSION['success'] = "Data berhasil dihapus!";
        header("Location: ../view/admin/data-pegawai/index.php");
    } else {
        header("Location: path/to/your/view/admin/data-pegawai/index.php?message=Gagal menghapus data");
    }
} else {
    // Logika lain untuk controller utama
}
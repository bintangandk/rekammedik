<?php
session_start();
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'tambah') {
        $id_pasien = $_POST['id_pasien'];
        $id_diagnosis = $_POST['diagnosis'];
        $id_medikamentosa = $_POST['medikamentosa'];
        $tanggal = $_POST['tanggal'];
        $durasi = $_POST['durasi'];
        $nama_dokter = $_POST['dokter']; // karena dokter diubah jadi input text
        $catatan_dokter = $_POST['catatan'];

        $query = "INSERT INTO konsultasi 
                (id_pasien, id_diagnosis, id_medikamentosa, tanggal, durasi, nama_dokter, catatan_dokter) 
                VALUES 
                ('$id_pasien', '$id_diagnosis', '$id_medikamentosa', '$tanggal', '$durasi', '$nama_dokter', '$catatan_dokter')";

        if (mysqli_query($conn, $query)) {
            header("Location: ../views/users/konsultasi/index.php?status=success");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

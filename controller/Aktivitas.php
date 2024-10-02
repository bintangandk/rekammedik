<?php
session_start();
include '../koneksi.php';

date_default_timezone_set('Asia/Jakarta');

function tambah($data)
{
    $conn = new koneksi();
    $errors = [];
    $id_user=$_SESSION['id_user'];
    // Mendapatkan data dari parameter dan mengamankannya dari serangan XSS
    $kegiatan = htmlspecialchars($data['kegiatan'], ENT_QUOTES, 'UTF-8');
    $tanggal = htmlspecialchars($data['tanggal'], ENT_QUOTES, 'UTF-8');
    $tanggall = date('Y-m-d', strtotime($tanggal));
    $id_unit = htmlspecialchars($data['id_unit'], ENT_QUOTES, 'UTF-8');

    // Validasi input
    if (empty($kegiatan)) {
        $errors[] = 'Kegiatan harus diisi.';
    }
    if (empty($id_unit)) {
        $errors[] = 'Unit harus diisi.';
    }
    if (empty($tanggal)) {
        $errors[] = 'Tanggal harus diisi.';
    }

    // Cek apakah ada error dalam validasi
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        return false;
    }

    // Cek apakah id_unit ada di tabel unit
    $query = "SELECT COUNT(*) AS unit FROM unit WHERE id = '$id_unit'";
    $existingData = $conn->execute($query);

    // Cek apakah query gagal
    if (!$existingData) {
        return [
            'status' => 'error',
            'message' => 'Query gagal dijalankan'
        ];
    }

    // Cek apakah id_unit ditemukan
    if ($existingData->num_rows == 0) {
        return [
            'status' => 'error',
            'message' => 'Tidak ada data yang ditemukan untuk ID Unit tersebut'
        ];
    }

    // Jika semua validasi sukses, tambahkan data
    $waktu = convertTo24HourFormat($tanggal = htmlspecialchars($data['jam'], ENT_QUOTES, 'UTF-8'));
    $query = "INSERT INTO aktivitas (tanggal, jam, kegiatan, id_unit,id_user) VALUES ('$tanggall', '$waktu', '$kegiatan', '$id_unit','$id_user')";

    // Eksekusi query dan cek hasilnya
    if ($conn->execute($query)) {
        return true;
    } else {
        return [
            'status' => 'error',
            'message' => 'Gagal menambahkan data ke database.'
        ];
    }
}



function update($data)
{
    $conn = new koneksi();
    $errors = [];

    // Mendapatkan data dari parameter dan mengamankannya dari serangan XSS
    $kegiatan = htmlspecialchars($data['kegiatan'], ENT_QUOTES, 'UTF-8');
    $tanggal = htmlspecialchars($data['tanggal'], ENT_QUOTES, 'UTF-8');
    $tanggall = date('Y-m-d', strtotime($tanggal));
    $id_unit = htmlspecialchars($data['id_unit'], ENT_QUOTES, 'UTF-8');
    $id_aktivitas = htmlspecialchars($data['id_aktivitas'], ENT_QUOTES, 'UTF-8');

    // Validasi input
    if (empty($kegiatan)) {
        $errors[] = 'Kegiatan harus diisi.';
    }
    if (empty($id_unit)) {
        $errors[] = 'Unit harus diisi.';
    }
    if (empty($tanggal)) {
        $errors[] = 'Tanggal harus diisi.';
    }

    // Cek apakah ada error dalam validasi
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        return false;
    }

    // Cek apakah id_unit ada di tabel unit
    $query = "SELECT COUNT(*) AS unit FROM unit WHERE id = '$id_unit'";
    $existingData = $conn->execute($query);

    // Cek apakah query gagal
    if (!$existingData) {
        return [
            'status' => 'error',
            'message' => 'Query gagal dijalankan'
        ];
    }

    // Cek apakah id_unit ditemukan
    if ($existingData->num_rows == 0) {
        return [
            'status' => 'error',
            'message' => 'Tidak ada data yang ditemukan untuk ID Unit tersebut'
        ];
    }

    // Jika semua validasi sukses, tambahkan data
    $waktu = convertTo24HourFormat($tanggal = htmlspecialchars($data['jam'], ENT_QUOTES, 'UTF-8'));
    $query = "UPDATE aktivitas SET tanggal = '$tanggall', jam = '$waktu', kegiatan = '$kegiatan', id_unit = '$id_unit' WHERE id_aktivitas = '$id_aktivitas'";

    // Eksekusi query dan cek hasilnya
    if ($conn->execute($query)) {
        return true;
    } else {
        return [
            'status' => 'error',
            'message' => 'Gagal menambahkan data ke database.'
        ];
    }
}
 function convertTo24HourFormat($time)
    {
        // Pisahkan jam, menit, dan AM/PM
        list($hour, $minute, $ampm) = sscanf($time, "%d:%d %s");

        // Jika waktu di atas 12 (PM), tambahkan 12 jam
        if (strcasecmp($ampm, 'pm') == 0) {
            $hour += 12;
        }

        // Jika waktu adalah 12 AM (midnight), ubah menjadi 00 jam
        if ($hour == 12 && strcasecmp($ampm, 'am') == 0) {
            $hour = 0;
        }

        // Kembalikan waktu dalam format 24 jam
        return sprintf("%02d:%02d", $hour, $minute);
    }

function hapus($id)
{
    $conn = new koneksi();

     $query=("DELETE FROM aktivitas WHERE id_aktivitas = '$id'");
    // $_SESSION['success'] = 'Berhasil hapus data!';

    if ($conn->execute($query)) {
        return true;
    } else {
        return [
            'status' => 'error',
            'message' => 'Gagal menambahkan data ke database.'
        ];
    }
    // header("Location: ../view/admin/data-pasien/index.php");
    // exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['action']) && $_POST['action'] == 'tambah') {
        // Cek hasil dari fungsi tambah
        $result = tambah($_POST);

        if ($result === true) {
            $_SESSION['success'] = 'Data berhasil ditambahkan.';
        } else {
            // Jika gagal, simpan pesan error di dalam session
            if (isset($_SESSION['errors'])) {
                $_SESSION['errors'][] = 'Data gagal ditambahkan.';
            } else {
                $_SESSION['errors'] = ['Data gagal ditambahkan.'];
            }

            // Jika `tambah` mengembalikan array dengan pesan error, tambahkan ke session
            if (is_array($result) && isset($result['message'])) {
                $_SESSION['errors'][] = $result['message'];
            }
        }

        // Redirect ke halaman yang diinginkan
        header("Location: ../view/users/aktivitas/index.php");
        exit(); // Pastikan exit setelah redirect
    }
    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        // Cek hasil dari fungsi edit
        $result = update($_POST);

        if ($result === true) {
            $_SESSION['success'] = 'Data berhasil diubah.';
        } else {
            // Jika gagal, simpan pesan error di dalam session
            if (isset($_SESSION['errors'])) {
                $_SESSION['errors'][] = 'Data gagal diubah.';
            } else {
                $_SESSION['errors'] = ['Data gagal diubah.'];
            }

            // Jika `tambah` mengembalikan array dengan pesan error, tambahkan ke session
            if (is_array($result) && isset($result['message'])) {
                $_SESSION['errors'][] = $result['message'];
            }
        }

        // Redirect ke halaman yang diinginkan
        header("Location: ../view/users/aktivitas/index.php");
        exit(); // Pastikan exit setelah redirect
    }
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = htmlspecialchars($_POST['id']);
        if (hapus($id)) {
            $_SESSION['success'] = 'Berhasil hapus data!';
        } else {
            $_SESSION['errors'][] = 'Gagal menghapus data. Silakan periksa kembali inputan Anda.';
        }

        header("Location: ../view/users/aktivitas/index.php");
        exit; // Ensure the script stops executing after the redirect
    } else {
        $_SESSION['errors'] = 'Invalid request.';
        header("Location: ../view/users/aktivitas/index.php");
        exit; // Ensure the script stops executing after the redirect
    }
}

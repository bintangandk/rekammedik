<?php
session_start();
include '../koneksi.php';

if (!is_dir('uploads/rekammedis')) {
    mkdir('uploads/rekammedis', 0777, true);
}
if (!is_dir('uploads/rontgen')) {
    mkdir('uploads/rontgen', 0777, true);
}
if (!is_dir('uploads/laboratorium')) {
    mkdir('uploads/laboratorium', 0777, true);
}

function tambah_data(
    $nama,
    $nik,
    $no_rm,
    $jenis_kelamin,
    $jenis_kepesertaan,
    $tanggal_lahir,
    $alamat,
    $riwayat_tindakan,
    $diagnosis,
    $alergi,
    $obat,
    $id_unit,
    $td,
    $t,
    $hr,
    $rr,
    $tb,
    $bb,
    $note_dokter,
    $tgl_masuk,
    $tgl_keluar,
    $file_rekammedis,
    $file_hasilrontgen,
    $hasil_laboratorium
) {
    $conn = new koneksi();
    $errors = [];

    if (empty($nama)) {
        $errors[] = 'Nama harus diisi.';
    }
    if (empty($nik)) {
        $errors[] = 'NIK harus diisi.';
    } elseif (!preg_match('/^[0-9]+$/', $nik)) {
        $errors[] = "NIK harus berupa angka.";
    }
    if (empty($no_rm)) {
        $errors[] = 'No. Rekam Medis harus diisi.';
    }
    if (empty($id_unit)) {
        $errors[] = 'Unit harus diisi.';
    }
    if (empty($tgl_masuk)) {
        $errors[] = 'Tgl. Masuk harus diisi.';
    }
    if (empty($jenis_kelamin)) {
        $errors[] = 'Jenis Kelamin Harus diisi';
    }
    if (empty($jenis_kepesertaan)) {
        $errors[] = 'Jenis Kepesertaan Harus diisi';
    }
    if (empty($tanggal_lahir)) {
        $errors[] = 'Tanggal Lahir Harus diisi';
    }
    if (empty($alamat)) {
        $errors[] = 'Alamat Harus diisi';
    }
    if (empty($riwayat_tindakan)) {
        $errors[] = 'Riwayat Tindakan Harus diisi';
    }
    if (empty($diagnosis)) {
        $errors[] = 'Diagnosis Harus diisi';
    }
    if (empty($alergi)) {
        $errors[] = 'Alergi Harus diisi';
    }
    if (empty($obat)) {
        $errors[] = 'Obat Harus diisi';
    }
    if (empty($td)) {
        $errors[] = 'Tensi Darah Harus diisi';
    }
    if (empty($t)) {
        $errors[] = 'Tekanan Jantung Harus diisi';
    }
    if (empty($hr)) {
        $errors[] = 'Harapan Harus diisi';
    }
    if (empty($rr)) {
        $errors[] = 'Respirasi Harus diisi';
    }
    if (empty($tb)) {
        $errors[] = 'Tinggi Badan Harus diisi';
    }
    if (empty($bb)) {
        $errors[] = 'Berat Badan Harus diisi';
    }
    if (empty($note_dokter)) {
        $errors[] = 'Note Dokter Harus diisi';
    }
    if (empty($file_rekammedis['name'])) {
        $errors[] = 'File Rekam Medis Harus diisi';
    } else {
        $fileExtension = pathinfo($file_rekammedis['name'], PATHINFO_EXTENSION);
        if (!in_array($fileExtension, array('pdf', 'doc', 'docx', 'xls', 'xlsx'))) {
            $errors[] = 'File Rekam Medis hanya boleh berupa pdf, word, dan excel.';
        }
    }
    if (empty($file_hasilrontgen['name'])) {
        $errors[] = 'File Hasil Rontgen Harus diisi';
    } else {
        $fileExtension = pathinfo($file_hasilrontgen['name'], PATHINFO_EXTENSION);
        if (!in_array($fileExtension, array('pdf', 'doc', 'docx', 'xls', 'xlsx'))) {
            $errors[] = 'File Hasil Rontgen hanya boleh berupa pdf, word, dan excel.';
        }
    }
    if (empty($hasil_laboratorium['name'])) {
        $errors[] = 'Hasil Laboratorium Harus diisi';
    } else {
        $fileExtension = pathinfo($hasil_laboratorium['name'], PATHINFO_EXTENSION);
        if (!in_array($fileExtension, array('pdf', 'doc', 'docx', 'xls', 'xlsx'))) {
            $errors[] = 'Hasil Laboratorium hanya boleh berupa pdf, word, dan excel.';
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        return false;
    }

    // Upload files
    $file_rekammedis_name = uploadFile('file_rekammedis', 'uploads/rekammedis');
    $file_hasilrontgen_name = uploadFile('file_hasilrontgen', 'uploads/rontgen');
    $hasil_laboratorium_name = uploadFile('hasil_laboratorium', 'uploads/laboratorium');

    // Insert data ke database
    $query = "INSERT INTO pasien (nama, nik, no_rm, jenis_kelamin, jenis_kepesertaan, tanggal_lahir, alamat, riwayat_tindakan, diagnosis, alergi, obat, id_unit, td, t, hr, rr, tb, bb, note_dokter, tgl_masuk, tgl_keluar, file_rekammedis, file_hasilrontgen, hasil_laboratorium) 
              VALUES ('$nama', '$nik', '$no_rm', '$jenis_kelamin', '$jenis_kepesertaan', '$tanggal_lahir', '$alamat', '$riwayat_tindakan', '$diagnosis', '$alergi', '$obat', '$id_unit', '$td', '$t', '$hr', '$rr', '$tb', '$bb', '$note_dokter', '$tgl_masuk', '$tgl_keluar', '$file_rekammedis_name', '$file_hasilrontgen_name', '$hasil_laboratorium_name')";

    return $conn->execute($query);
}
function update($data)
{
    // var_dump($data);
    $conn = new koneksi();

    // Mendapatkan data dari parameter dan mengamankannya dari serangan XSS
    $id_pasien = $data['id_pasien'];
    $name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
    $nik = htmlspecialchars($data['nik'], ENT_QUOTES, 'UTF-8');
    $tanggal_lahir = htmlspecialchars($data['tanggal_lahir'], ENT_QUOTES, 'UTF-8');
    $tanggal_lahirr = date('Y-m-d', strtotime($tanggal_lahir));
    $gender = htmlspecialchars($data['gender'], ENT_QUOTES, 'UTF-8');
    $no_rm = htmlspecialchars($data['no_rm'], ENT_QUOTES, 'UTF-8');
    $alamat = htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8');
    $id_unit = htmlspecialchars($data['id_unit'], ENT_QUOTES, 'UTF-8');
    $kepesertaan = htmlspecialchars($data['jenis_kepesertaan'], ENT_QUOTES, 'UTF-8');
    $td = htmlspecialchars($data['td'], ENT_QUOTES, 'UTF-8');
    $t = htmlspecialchars($data['t'], ENT_QUOTES, 'UTF-8');
    $hr = htmlspecialchars($data['hr'], ENT_QUOTES, 'UTF-8');
    $rr = htmlspecialchars($data['rr'], ENT_QUOTES, 'UTF-8');
    $tb = htmlspecialchars($data['tb'], ENT_QUOTES, 'UTF-8');
    $bb = htmlspecialchars($data['bb'], ENT_QUOTES, 'UTF-8');
    $diagnosis = htmlspecialchars($data['diagnosis'], ENT_QUOTES, 'UTF-8');
    $riwayat_tindakan = htmlspecialchars($data['riwayat_tindakan'], ENT_QUOTES, 'UTF-8');
    $alergi = htmlspecialchars($data['alergi'], ENT_QUOTES, 'UTF-8');
    $obat = htmlspecialchars($data['obat'], ENT_QUOTES, 'UTF-8');
    $note_dokter = htmlspecialchars($data['note_dokter'], ENT_QUOTES, 'UTF-8');
    $tgl_masuk = htmlspecialchars($data['tgl_masuk'], ENT_QUOTES, 'UTF-8');
    $tanggal_masuk = date('Y-m-d', strtotime($tgl_masuk));
    $tgl_keluar = htmlspecialchars($data['tgl_keluar'], ENT_QUOTES, 'UTF-8');
    $tanggal_keluar = date('Y-m-d', strtotime($tgl_keluar));


    if (empty($name)) {
        $errors[] = 'Nama harus diisi.';
    }
    if (empty($nik)) {
        $errors[] = 'NIK harus diisi.';
    } elseif (!preg_match('/^[0-9]+$/', $nik)) {
        $errors[] = "NIK harus berupa angka.";
    }
    if (empty($no_rm)) {
        $errors[] = 'No. Rekam Medis harus diisi.';
    }
    if (empty($id_unit)) {
        $errors[] = 'Unit harus diisi.';
    }
    if (empty($tgl_masuk)) {
        $errors[] = 'Tgl. Masuk harus diisi.';
    }
    if (empty($gender)) {
        $errors[] = 'Jenis Kelamin Harus diisi';
    }
    if (empty($kepesertaan)) {
        $errors[] = 'Jenis Kepesertaan Harus diisi';
    }
    if (empty($tanggal_lahir)) {
        $errors[] = 'Tanggal Lahir Harus diisi';
    }
    if (empty($alamat)) {
        $errors[] = 'Alamat Harus diisi';
    }
    if (empty($riwayat_tindakan)) {
        $errors[] = 'Riwayat Tindakan Harus diisi';
    }
    if (empty($diagnosis)) {
        $errors[] = 'Diagnosis Harus diisi';
    }
    if (empty($alergi)) {
        $errors[] = 'Alergi Harus diisi';
    }
    if (empty($obat)) {
        $errors[] = 'Obat Harus diisi';
    }
    if (empty($td)) {
        $errors[] = 'Tensi Darah Harus diisi';
    }
    if (empty($t)) {
        $errors[] = 'Tekanan Jantung Harus diisi';
    }
    if (empty($hr)) {
        $errors[] = 'Harapan Harus diisi';
    }
    if (empty($rr)) {
        $errors[] = 'Respirasi Harus diisi';
    }
    if (empty($tb)) {
        $errors[] = 'Tinggi Badan Harus diisi';
    }
    if (empty($bb)) {
        $errors[] = 'Berat Badan Harus diisi';
    }
    if (empty($note_dokter)) {
        $errors[] = 'Note Dokter Harus diisi';
    }
    // Mendapatkan path file yang ada dari database
    $query = "SELECT file_rekammedis, file_hasilrontgen, hasil_laboratorium FROM pasien WHERE id_pasien = '$id_pasien'";
    $existingData = $conn->execute($query);
    // var_dump($query);
    // Memeriksa apakah query berhasil dan mengembalikan data
    if ($existingData && $existingData->num_rows > 0) {
        $existingFiles = $existingData->fetch_assoc();

        $file_rekammedis_name = $existingFiles['file_rekammedis'];
        $file_hasilrontgen_name = $existingFiles['file_hasilrontgen'];
        $hasil_laboratorium_name = $existingFiles['hasil_laboratorium'];
        // var_dump($file_rekammedis_name);
        // Menghapus file yang ada jika file tersebut ada
        if (!empty($_FILES['file_hasilrontgen']['name'])) {
            // Menghapus file lama
            if (file_exists('uploads/rontgen/' . $file_hasilrontgen_name)) {
                unlink('uploads/rontgen/' . $file_hasilrontgen_name);
            }
            // Mengunggah file baru
            $file_hasilrontgen_name = uploadFile('file_hasilrontgen', 'uploads/rontgen');
        }
        if (!empty($_FILES['file_rekammedis']['name'])) {
            // Menghapus file lama
            if (file_exists('uploads/rekammedis/' . $file_rekammedis_name)) {
                unlink('uploads/rekammedis/'  . $file_rekammedis_name);
            }
            // Mengunggah file baru
            $file_rekammedis_name = uploadFile('file_rekammedis', 'uploads/rekammedis');
        }

        if (!empty($_FILES['hasil_laboratorium']['name'])) {
            // Menghapus file lama
            if (file_exists('uploads/laboratorium/' . $hasil_laboratorium_name)) {
                unlink('uploads/laboratorium/' . $hasil_laboratorium_name);
            }
            // Mengunggah file baru
            $hasil_laboratorium_name = uploadFile('hasil_laboratorium', 'uploads/laboratorium');
        }
    } else {
        // Menangani kasus ketika tidak ada data yang ditemukan atau query gagal
        echo "Tidak ada file yang ditemukan atau query gagal.";
    }


    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        var_dump($errors); // Tambahkan ini untuk melihat pesan kesalahan
        return false;
    }
    // Memperbarui data di database
    $query = "UPDATE pasien SET 
                      nama = '$name', 
                      nik = '$nik', 
                      no_rm = '$no_rm', 
                      jenis_kelamin = '$gender', 
                      jenis_kepesertaan = '$kepesertaan', 
                      tanggal_lahir = '$tanggal_lahirr', 
                      alamat = '$alamat', 
                      riwayat_tindakan = '$riwayat_tindakan', 
                      diagnosis = '$diagnosis', 
                      alergi = '$alergi', 
                      obat = '$obat', 
                      id_unit = '$id_unit', 
                      td = '$td', 
                      t = '$t', 
                      hr = '$hr', 
                      rr = '$rr', 
                      tb = '$tb', 
                      bb = '$bb', 
                      note_dokter = '$note_dokter', 
                      tgl_masuk = '$tanggal_masuk', 
                      tgl_keluar = '$tanggal_keluar', 
                      file_rekammedis = '$file_rekammedis_name', 
                      file_hasilrontgen = '$file_hasilrontgen_name', 
                      hasil_laboratorium = '$hasil_laboratorium_name' 
                      WHERE id_pasien = '$id_pasien'";
    // var_dump($query);
    return $conn->execute($query);

    // var_dump($query);
}


function uploadFile($file, $directory)
{
    $fileName = $_FILES[$file]['name'];
    $tmpName = $_FILES[$file]['tmp_name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid() . '_' . $fileName;
    $targetPath = $directory . '/' . $newFileName;
    move_uploaded_file($tmpName, $targetPath);
    return $newFileName;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'insert') {
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $nik = htmlspecialchars($_POST['nik'], ENT_QUOTES, 'UTF-8');
        $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir'], ENT_QUOTES, 'UTF-8');
        $tanggal_lahirr = date('Y-m-d', strtotime($tanggal_lahir));
        $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
        $no_rm = htmlspecialchars($_POST['no_rm'], ENT_QUOTES, 'UTF-8');
        $alamat = htmlspecialchars($_POST['alamat'], ENT_QUOTES, 'UTF-8');
        $id_unit = htmlspecialchars($_POST['id_unit'], ENT_QUOTES, 'UTF-8');
        $kepesertaan = htmlspecialchars($_POST['kepesertaan'], ENT_QUOTES, 'UTF-8');
        $td = htmlspecialchars($_POST['td'], ENT_QUOTES, 'UTF-8');
        $r = htmlspecialchars($_POST['t'], ENT_QUOTES, 'UTF-8');
        $hr = htmlspecialchars($_POST['hr'], ENT_QUOTES, 'UTF-8');
        $rr = htmlspecialchars($_POST['rr'], ENT_QUOTES, 'UTF-8');
        $tb = htmlspecialchars($_POST['tb'], ENT_QUOTES, 'UTF-8');
        $bb = htmlspecialchars($_POST['bb'], ENT_QUOTES, 'UTF-8');
        $diagnosis = htmlspecialchars($_POST['diagnosis'], ENT_QUOTES, 'UTF-8');
        $riwayat_tindakan = htmlspecialchars($_POST['riwayat_tindakan'], ENT_QUOTES, 'UTF-8');
        $alergi = htmlspecialchars($_POST['alergi'], ENT_QUOTES, 'UTF-8');
        $obat = htmlspecialchars($_POST['obat'], ENT_QUOTES, 'UTF-8');
        $note_dokter = htmlspecialchars($_POST['note_dokter'], ENT_QUOTES, 'UTF-8');
        $tgl_masuk = htmlspecialchars($_POST['tgl_masuk'], ENT_QUOTES, 'UTF-8');
        $tanggal_masuk = date('Y-m-d', strtotime($tgl_masuk));
        $tgl_keluar = htmlspecialchars($_POST['tgl_keluar'], ENT_QUOTES, 'UTF-8');
        $tanggal_keluar = date('Y-m-d', strtotime($tgl_keluar));
        $file_rekammedis = $_FILES['file_rekammedis'];
        $file_hasilrontgen = $_FILES['file_hasilrontgen'];
        $hasil_laboratorium = $_FILES['hasil_laboratorium'];

        if (tambah_data($name, $nik, $no_rm, $gender, $kepesertaan, $tanggal_lahirr, $alamat, $riwayat_tindakan, $diagnosis, $alergi, $obat, $id_unit, $td, $r, $hr, $rr, $tb, $bb, $note_dokter, $tanggal_masuk, $tanggal_keluar, $file_rekammedis, $file_hasilrontgen, $hasil_laboratorium)) {
            $_SESSION['success'] = 'Berhasil tambah data!';
            header("Location: ../view/admin/data-pasien/index.php");
            exit;
        } else {
            $_SESSION['errors'][] = 'Gagal menambah data. Silakan periksa kembali inputan Anda.';
            header("Location: ../view/admin/data-pasien/index.php");
            exit;
        }
    }


    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        // var_dump($_POST);
        // var_dump(update($_POST));
        if (update($_POST)) {
            $_SESSION['success'] = 'Data berhasil diubah.';
        } else {
            $_SESSION['errors'] = 'Data gagal diubah.';
            // var_dump($_POST);
            // var_dump(update($_POST));
        }
        header("Location: ../view/admin/data-pasien/index.php");

        // Fungsi untuk mengunggah file


    }


    // <<<<<<<<<<<<<<  ✨ Codeium Command ⭐ >>>>>>>>>>>>>>>>
    function hapus($id)
    {
        $conn = new koneksi();
        $row = $conn->execute("SELECT * FROM pasien WHERE id_pasien = '$id'")->fetch_assoc();
        // <<<<<<<<<<<<<<  ✨ Codeium Command 🌟 >>>>>>>>>>>>>>>>
        unlink("uploads/rekammedis/" . $row['file_rekammedis']);
        unlink("uploads/rontgen/" . $row['file_hasilrontgen']);
        unlink("uploads/laboratorium/" . $row['hasil_laboratorium']);
        // unlink($row['file_rekammedis']);
        // unlink($row['file_hasilrontgen']);
        // unlink($row['hasil_laboratorium']);
        // <<<<<<<  b7969aa4-6011-4e6a-bf72-679f6453c9de  >>>>>>>
       return $conn->execute("DELETE FROM pasien WHERE id_pasien = '$id'");
        // $_SESSION['success'] = 'Berhasil hapus data!';
        // header("Location: ../view/admin/data-pasien/index.php");
        // exit;
    }

    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = htmlspecialchars($_POST['id_pasien']);
        if (hapus($id)) {
            $_SESSION['success'] = 'Berhasil hapus data!';
        } else {
            $_SESSION['errors'][] = 'Gagal menghapus data. Silakan periksa kembali inputan Anda.';
        }
    
        header("Location: ../view/admin/data-pasien/index.php");
        exit; // Ensure the script stops executing after the redirect
    } else {
        $_SESSION['errors'][] = 'Invalid request.';
        header("Location: ../view/admin/data-pasien/index.php");
        exit; // Ensure the script stops executing after the redirect
    }


    // <<<<<<<  32bfd995-187f-4efa-8510-223f9c6b93e3  >>>>>>>
}

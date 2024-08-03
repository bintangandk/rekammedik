<?php
session_start();
include '../koneksi.php'; // Menyertakan file koneksi dari folder luar
if (!is_dir('uploads/profile')) {
    mkdir('uploads/profile', 0777, true);
}
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
            $_SESSION['nip'] = $user['nip'];
            $_SESSION['nama'] = $user['Nama'];
            $_SESSION['no_telfon'] = $user['no_telfon'];
            $_SESSION['id_unit'] = $user['id_unit'];
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['gambar'] = $user['gambar'];
            $_SESSION['login'] = 'Login berhasil!';
            if ($user['role'] == 'admin') {
                header("Location: ../view/admin/dashboard/index.php");
                exit();
            }else {
                header("Location: ../view/users/dashboard/index.php");
                exit();
            }
         
        }
    }



    $_SESSION['error'] = 'Login gagal, email atau password salah!';
    header("Location: ../view/auth/login.php");
    
    exit();
}

function update_profile($data) {

    $conn = new koneksi();
    $email = htmlspecialchars($data['email']);
    $Nama = htmlspecialchars($data['name']);
    $nip = htmlspecialchars($data['nip']);
    $no_telfon = htmlspecialchars($data['no_telfon']);
    $id_unit = htmlspecialchars($data['id_unit']);
    $id_user = $_SESSION['id_user'];
    $password = htmlspecialchars($data['password']);
    
    
    $errors = [];

    // Validasi input
    if (empty($Nama)) {
        $errors[] = 'Nama Pegawai harus diisi.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email tidak valid.';
    }
    if (empty($no_telfon) || !preg_match('/^[0-9]+$/', $no_telfon)) {
        $errors[] = 'Nomor Telepon harus berupa angka.';
    }
    if (empty($nip) || !preg_match('/^[0-9]+$/', $nip)) {
        $errors[] = 'NIP harus berupa angka.';
    }
    
    if (empty($id_unit)) {
        $errors[] = 'id_unit harus diisi.';
    }
   

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        return false;
    }


    // Tambahan untuk menangani password

    // Mengecek apakah email sudah ada di database, kecuali email milik user itu sendiri
    $query = "SELECT id_user FROM users WHERE email = '$email' AND id_user != '$id_user'";
    $existingEmail = $conn->execute($query);
    
    if ($existingEmail->num_rows > 0) {
        // Email sudah digunakan oleh user lain
        $_SESSION['errors'][] = 'Email sudah digunakan oleh user lain.';
        return false;
    }

    // Memeriksa apakah ada file gambar yang diunggah
    $query = "SELECT gambar FROM users WHERE id_user = '$id_user'";
    $existingData = $conn->execute($query);
    
    if ($existingData && $existingData->num_rows > 0) {
        $existingFiles = $existingData->fetch_assoc();
        $gambar_name = $existingFiles['gambar'];
        
        if (!empty($_FILES['gambar']['name'])) {
            // Menghapus file lama
            if (file_exists('uploads/profile/' . $gambar_name)) {
                unlink('uploads/profile/' . $gambar_name);
            }
            // Mengunggah file baru
            $gambar_name = uploadFile('gambar', 'uploads/profile');
        }
    } else {
        // Menangani kasus ketika tidak ada data yang ditemukan atau query gagal
        $_SESSION['errors'][] = 'Gagal mendapatkan data pengguna.';
        return false;
    }

    // Menyusun query update
    $updateQuery = "UPDATE users SET email = '$email', Nama = '$Nama', nip = '$nip', id_unit = '$id_unit', gambar = '$gambar_name'";

    // Jika ada password baru, tambahkan ke query update
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateQuery .= ", password = '$hashedPassword'";
    }

    $updateQuery .= " WHERE id_user = '$id_user'";

    // Eksekusi query update
    if ($conn->execute($updateQuery)) {
        $_SESSION['success'] = 'Profil berhasil diperbarui!';
        return true;
    } else {
        $_SESSION['errors'][] = 'Gagal memperbarui profil.';
        return false;
    }
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

function update($id_user, $name, $nip, $no_tlp, $role, $id_unit)
    {
        $conn = new koneksi();
        $errors = [];
        if (empty($id_user)) {
            $errors[] = 'Nama Pegawai harus diisi.';
        }
        if (empty($name)) {
            $errors[] = 'Nama Pegawai harus diisi.';
        }
       
        if (empty($no_tlp) || !preg_match('/^[0-9]+$/', $no_tlp)) {
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
       
    
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            // $_SESSION['form_data'] = $_POST;
            return false;
        }

        $query = "UPDATE users SET Nama = '$name', nip = '$nip', no_telfon = '$no_tlp', role = '$role', id_unit = '$id_unit' WHERE id_user = '$id_user'";
        $result = $conn->execute($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


// Handling form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        login($email, $password);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        // var_dump("dfdfdfd");
        $Nama = htmlspecialchars($_POST['name']);
        $id_user = $_POST['id'];
        $no_telfon =  htmlspecialchars($_POST['no_tlp']);
        $nip = htmlspecialchars($_POST['nip']);
        $role = htmlspecialchars($_POST['role']);
        $id_unit =htmlspecialchars($_POST['id_unit']);
        // $password = $_POST['password'];
    // var_dump(update($id_user,$Nama, $nip, $no_telfon, $role, $id_unit));
        if (update($id_user,$Nama, $nip, $no_telfon, $role, $id_unit)) {
            // unset($_SESSION['form_data']);
            $_SESSION['success'] = 'update berhasil!';
            header("Location: ../view/admin/data-pegawai/index.php");
            exit();
        } else {
            $_SESSION['error'] = 'update gagal!';
            header("Location: ../view/admin/data-pegawai/index.php");
            exit();
        }
    }

    
    if (isset($_POST['action']) && $_POST['action'] == 'update_profile') {
        // var_dump(update_profile($_POST));
        if (update_profile($_POST)) {
            $_SESSION['success'] = 'Data profile berhasil diubah.';
        } else {
            $_SESSION['errors'] = 'Data profile gagal di ubah.';
            // var_dump($_POST);
            // var_dump(update($_POST));
        }
        if ($_SESSION['role'] == 'admin') {
            # code...
            header("Location: ../view/admin/profile/index.php");
        }else {
            # code...
            header("Location: ../view/users/profile/index.php");
        }
     
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

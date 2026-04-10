<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../koneksi.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class Pegawai extends koneksi
{


    public function index()
    {
        $query = "SELECT * 
            FROM users JOIN unit ON users.id_unit = unit.id WHERE users.role != 'admin'";
        return $this->showData($query);
    }

    public function jumlah_riwayatlogin()
    {
        $tanggal = date('Y-m-d');
        $query = "SELECT COUNT(*) AS total FROM harian_login WHERE tanggal = '$tanggal'";
        $existingData = $this->execute($query);

        return $existingData->fetch_assoc();
    }

    public function jumlah_riwayatfile()
    {
        $tanggal = date('Y-m-d');
        $query = "SELECT COUNT(*) AS total FROM riwayat_file WHERE tanggal = '$tanggal'";
        $existingData = $this->execute($query);

        return $existingData->fetch_assoc();
    }

    public function fileperuser()
    {
        $id_user = $_SESSION['id_user'];
        $query = "SELECT COUNT(*) AS total FROM riwayat_file WHERE id_user='$id_user'";
        $existingData = $this->execute($query);

        return $existingData->fetch_assoc();
    }

    public function jumlah_konsultasi()
    {
        $query = "SELECT COUNT(*) AS total FROM konsultasi";
        $existingData = $this->execute($query);

        return $existingData->fetch_assoc();
    }



    public function instalasi()
    {
        $query = "SELECT * FROM unit";
        return $this->showData($query);
    }

    function pasien()
    {
        $query = "SELECT pasien.*, unit.instalasi 
              FROM pasien 
              LEFT JOIN unit ON pasien.id_unit = unit.id
              ORDER BY pasien.id_pasien DESC";
        return $this->showData($query);
    }


    function aktivitas()
    {
        $id_user = $_SESSION['id_user'];

        $query = "SELECT * FROM aktivitas 
                  JOIN unit ON aktivitas.id_unit = unit.id 
                  JOIN users ON aktivitas.id_user = users.id_user 
                  WHERE aktivitas.id_user = '$id_user'";

        return $this->showData($query);
    }


    function profile()
    {
        $query = "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'";
        $existingData = $this->execute($query);

        return $existingData->fetch_assoc();
    }
    function profile_peruser()
    {
        $query = "SELECT * FROM users join unit on users.id_unit = unit.id WHERE  id_user = '$_SESSION[id_user]'";
        $existingData = $this->execute($query);

        return $existingData->fetch_assoc();
    }
    function riwayat_peruser()
    {
        $query = "SELECT * FROM riwayat_file   WHERE id_user = '$_SESSION[id_user]'";

        return $this->showData($query);
    }
    function riwayat()
    {
        $query = "SELECT * FROM riwayat_file";
        return $this->showData($query);
    }

    public function delete($id)
    {
        $id = $this->escapeString($id);
        $query = "DELETE FROM users WHERE id = '$id'";

        error_log("Query: $query");

        $result = $this->execute($query);

        if ($result) {
            return [
                'status' => 'success',
                'message' => 'Data berhasil dihapus.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Gagal menghapus data.'
            ];
        }
    }

    private function sendApprovalEmail($email, $nama)
    {
        $email_pengirim = "rekammedik700@gmail.com";
        $nama_pengirim = "DiRec";
        $subjek = "Akun Anda Telah Disetujui";
        $pesan = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #4CAF50; color: white; padding: 20px; text-align: center; }
                .content { background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                .footer { text-align: center; padding: 10px; font-size: 12px; color: #777; }
                .button { display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Selamat! Akun Anda Telah Disetujui</h2>
                </div>
                <div class='content'>
                    <p>Halo <strong>$nama</strong>,</p>
                    <p>Kami dengan senang hati menginformasikan bahwa akun Anda di sistem Rekam Medik Digital telah disetujui oleh administrator.</p>
                    <p>Anda sekarang dapat mengakses sistem dengan kredensial yang telah Anda daftarkan.</p>
                    <p><strong>Status Akun:</strong> Aktif</p>
                    <p>Silakan login untuk mulai menggunakan sistem.</p>
                </div>
                <div class='footer'>
                    <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
                    <p>&copy; 2026 DiRec - Digital Record System</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = 'tls';
            $mail->Username = $email_pengirim;
            $mail->Password = "prkv yzou wskp zolg"; // Use app-specific password
            $mail->Port = 587;
            $mail->SMTPDebug = 0; // Set to 0 to disable debug output

            $mail->setFrom($email_pengirim, $nama_pengirim);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subjek;
            $mail->Body = $pesan;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $mail->ErrorInfo);
            return false;
        }
    }

    private function sendRejectionEmail($email, $nama)
    {
        $email_pengirim = "rekammedik700@gmail.com";
        $nama_pengirim = "DiRec";
        $subjek = "Pemberitahuan Penolakan Akun";
        $pesan = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #dc3545; color: white; padding: 20px; text-align: center; }
                .content { background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                .footer { text-align: center; padding: 10px; font-size: 12px; color: #777; }
                .warning-box { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 15px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Pemberitahuan Penolakan Akun</h2>
                </div>
                <div class='content'>
                    <p>Halo <strong>$nama</strong>,</p>
                    <p>Kami informasikan bahwa pendaftaran akun Anda di sistem Rekam Medik Digital tidak dapat disetujui oleh administrator.</p>
                    <div class='warning-box'>
                        <p><strong>Status Akun:</strong> Ditolak</p>
                    </div>
                    <p>Jika Anda merasa ini adalah kesalahan atau memiliki pertanyaan lebih lanjut, silakan hubungi administrator sistem untuk klarifikasi.</p>
                    <p>Terima kasih atas pengertian Anda.</p>
                </div>
                <div class='footer'>
                    <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
                    <p>&copy; 2026 DiRec - Digital Record System</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = 'tls';
            $mail->Username = $email_pengirim;
            $mail->Password = "prkv yzou wskp zolg"; // Use app-specific password
            $mail->Port = 587;
            $mail->SMTPDebug = 0; // Set to 0 to disable debug output

            $mail->setFrom($email_pengirim, $nama_pengirim);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subjek;
            $mail->Body = $pesan;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function approve($id)
    {
        $id = $this->escapeString($id);

        // Get user info before updating
        $getUserQuery = "SELECT email, Nama FROM users WHERE id_user = '$id'";
        $userResult = $this->execute($getUserQuery);

        if ($userResult && $userResult->num_rows > 0) {
            $userData = $userResult->fetch_assoc();
            $email = $userData['email'];
            $nama = $userData['Nama'];

            // Update user status
            $query = "UPDATE users SET status = 'active' WHERE id_user = '$id'";
            error_log("Query: $query");
            $result = $this->execute($query);

            if ($result) {
                // Send email notification
                $emailSent = $this->sendApprovalEmail($email, $nama);

                $message = 'Data berhasil disetujui.';
                if ($emailSent) {
                    $message .= ' Email konfirmasi telah dikirim ke ' . $email;
                } else {
                    $message .= ' Namun email konfirmasi gagal dikirim.';
                }

                return [
                    'status' => 'success',
                    'message' => $message
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Gagal menyetujui data.'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'User tidak ditemukan.'
            ];
        }
    }

    public function reject($id)
    {
        $id = $this->escapeString($id);

        // Get user info before deleting
        $getUserQuery = "SELECT email, Nama FROM users WHERE id_user = '$id'";
        $userResult = $this->execute($getUserQuery);

        if ($userResult && $userResult->num_rows > 0) {
            $userData = $userResult->fetch_assoc();
            $email = $userData['email'];
            $nama = $userData['Nama'];

            // Delete user from database
            $query = "DELETE FROM users WHERE id_user = '$id'";
            error_log("Query: $query");
            $result = $this->execute($query);

            if ($result) {
                // Send email notification
                $emailSent = $this->sendRejectionEmail($email, $nama);

                $message = 'Data berhasil ditolak dan dihapus.';
                if ($emailSent) {
                    $message .= ' Email pemberitahuan telah dikirim ke ' . $email;
                } else {
                    $message .= ' Namun email pemberitahuan gagal dikirim.';
                }

                return [
                    'status' => 'success',
                    'message' => $message
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Gagal menolak data.'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'User tidak ditemukan.'
            ];
        }
    }
}

// Handle GET requests
if (isset($_GET['action'])) {
    $pegawai = new Pegawai();

    if ($_GET['action'] == 'approve' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = $pegawai->approve($id);

        if ($result['status'] == 'success') {
            header('Location: ../view/admin/data-pegawai/index.php?success=' . urlencode($result['message']));
        } else {
            header('Location: ../view/admin/data-pegawai/index.php?error=' . urlencode($result['message']));
        }
        exit();
    }

    if ($_GET['action'] == 'reject' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = $pegawai->reject($id);

        if ($result['status'] == 'success') {
            header('Location: ../view/admin/data-pegawai/index.php?success=' . urlencode($result['message']));
        } else {
            header('Location: ../view/admin/data-pegawai/index.php?error=' . urlencode($result['message']));
        }
        exit();
    }
}

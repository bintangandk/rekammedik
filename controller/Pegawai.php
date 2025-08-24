<?php

class Pegawai extends koneksi
{


    public function index()
    {
        $query = "SELECT * 
FROM users JOIN unit ON users.id_unit = unit.id WHERE users.role != 'admin'";
        // $conn=new koneksi();
        return $this->showData($query);
    }

    public function jumlah_riwayatlogin()
    {
        $tanggal = date('Y-m-d');
        $query = "SELECT COUNT(*) AS total FROM harian_login WHERE tanggal = '$tanggal'";
        $existingData = $this->execute($query);

        // if ($existingData && $existingData->num_rows > 0) {
        return $existingData->fetch_assoc();
    }

    public function jumlah_riwayatfile()
    {
        $tanggal = date('Y-m-d');
        $query = "SELECT COUNT(*) AS total FROM riwayat_file WHERE tanggal = '$tanggal'";
        $existingData = $this->execute($query);

        // if ($existingData && $existingData->num_rows > 0) {
        return $existingData->fetch_assoc();
    }

    public function fileperuser()
    {
        // $tanggal=date('Y-m-d');
        $id_user = $_SESSION['id_user'];
        $query = "SELECT COUNT(*) AS total FROM riwayat_file WHERE id_user='$id_user'";
        $existingData = $this->execute($query);

        // if ($existingData && $existingData->num_rows > 0) {
        return $existingData->fetch_assoc();
    }

    public function jumlah_konsultasi(){
        $query = "SELECT COUNT(*) AS total FROM konsultasi";
        $existingData = $this->execute($query);

        return $existingData->fetch_assoc();
    }



    public function instalasi()
    {
        // $this=new koneksi();
        $query = "SELECT * FROM unit";
        return $this->showData($query);
    }

    function pasien()
    {
        // $conn = new koneksi();
        $query = "SELECT * FROM pasien JOIN unit ON pasien.id_unit = unit.id";
        return $this->showData($query);
    }
    function aktivitas()
    {
        // $conn = new koneksi();
        $id_user = $_SESSION['id_user'];

        // Tambahkan nama tabel secara eksplisit untuk menghindari ambiguitas
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

        // if ($existingData && $existingData->num_rows > 0) {
        return $existingData->fetch_assoc();

        // }
    }
    function profile_peruser()
    {
        $query = "SELECT * FROM users join unit on users.id_unit = unit.id WHERE  id_user = '$_SESSION[id_user]'";
        $existingData = $this->execute($query);

        // if ($existingData && $existingData->num_rows > 0) {
        return $existingData->fetch_assoc();

        // }
    }
    function riwayat_peruser()
    {
        $query = "SELECT * FROM riwayat_file   WHERE id_user = '$_SESSION[id_user]'";


        // if ($existingData && $existingData->num_rows > 0) {
        return $this->showData($query);

        // }
    }
    function riwayat()
    {
        $query = "SELECT * FROM riwayat_file";
        return $this->showData($query);
        // }
    }
    //    public  function delete($id){
    // $this=new koneksi();
    // var_dump($id);
    public function delete($id)
    {
        // Membersihkan input $id untuk menghindari SQL injection
        $id = $this->escapeString($id);
        // var_dump($id);
        // Membuat query SQL untuk menghapus data dari tabel 'users' dengan id yang diberikan
        $query = "DELETE FROM users WHERE id = '$id'";

        // Menambahkan output debug untuk melihat query yang dihasilkan
        error_log("Query: $query");

        // Mengeksekusi query dan menyimpan hasilnya ke variabel $result
        $result = $this->execute($query);

        // Menambahkan output debug untuk melihat hasil eksekusi query
        // if (!$result) {
        //     $error = $this->getLastError(); // Asumsikan ada metode untuk mendapatkan kesalahan terakhir
        //     error_log("Error: $error");
        // }

        // Memeriksa apakah query berhasil dieksekusi
        if ($result) {
            // Jika berhasil, kembalikan array dengan status 'success' dan pesan berhasil
            return [
                'status' => 'success',
                'message' => 'Data berhasil dihapus.'
            ];
        } else {
            // error_log("Error: $error");
            // Jika gagal, kembalikan array dengan status 'error' dan pesan gagal
            return [
                'status' => 'error',
                'message' => 'Gagal menghapus data.'
            ];
        }
    }
}

<?php

// include '../koneksi.php';

// $this=new koneksi();
class Pegawai extends koneksi{


public function index()
    {
        $query = "SELECT * 
FROM users JOIN unit ON users.id_unit = unit.id WHERE users.role != 'admin'";
// $conn=new koneksi();
        return $this->showData($query);
    }

    public function instalasi(){
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

    function profile() {
        $query = "SELECT * FROM users WHERE id_user = '$_SESSION[id_user]'";
        $existingData = $this->execute($query);
        
        // if ($existingData && $existingData->num_rows > 0) {
            return $existingData->fetch_assoc();

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


    
    




    // $pegawai = new Pegawai();
    // if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    // delete($_GET['id']);
    
    //     if ($response['status'] === 'success') {
    // $_SESSION['hapus'] = "Data berhasil dihapus!";
    //         header("Location: ../view/admin/data-pegawai/index.php");
    //     } else {
    //         header("Location: ../view/admin/data-pegawai/index.php?message=Gagal menghapus data");
    //     }
    // } else {
    //     // Logika lain untuk Pegawai.php jika ada
    // }





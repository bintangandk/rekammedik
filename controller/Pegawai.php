<?php

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
}

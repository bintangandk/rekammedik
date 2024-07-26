<?php
class Pasien extends koneksi {

    public function index(){
        $query = "SELECT * FROM pasien";
        return $this->showData($query);
    }

    public function tambah_data(){





        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
    }
}

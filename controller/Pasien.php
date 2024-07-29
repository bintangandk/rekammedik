<?php

session_start();
include '../koneksi.php';


     function index(){
        $conn=new koneksi();
        $query = "SELECT * FROM pasien";
        return $conn->showData($query);
    }

     function tambah_data(){





        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
    }

<?php

class Pegawai extends koneksi{

    public function index(){
        $query = "SELECT * FROM pegawai";
        return $this->showData($query);
    }

    
public function update(){


}
}
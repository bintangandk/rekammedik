<?php 

class Unit extends koneksi{

    public function index(){
        $query = "SELECT * FROM unit";
        return $this->showData($query);
    }
    
}
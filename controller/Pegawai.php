<?php

class Pegawai extends koneksi
{

    public function index()
    {
        $query = "SELECT * 
FROM users JOIN unit ON users.id_unit = unit.id WHERE users.role != 'admin'";

        return $this->showData($query);
    }


    public function update()
    {
    }
}

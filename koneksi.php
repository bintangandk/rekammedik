<?php
class koneksi
{
    private $server = "localhost";
    private $username = "root";
    private $password = ""; 
    private $db = "rekammedik";
   

    private $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect($this->server, $this->username, $this->password, $this->db);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function prepareKoneksi()
    {
        return $this->conn;
    }

    public function execute($new_query)
    {
        return mysqli_query($this->prepareKoneksi(), $new_query);
    }

    public function insertData($query)
    {
        $result = $this->execute($query);
    }

    public function showData($query)
    {
        $result = $this->execute($query);
        $datas = [];
        while ($data = mysqli_fetch_assoc($result)) {
            $datas[] = $data;
        }

        return $datas;
    }

    public function escapeString($string)
    {
        return mysqli_real_escape_string($this->prepareKoneksi(), $string);
    }
}
?>
<?php
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();

function getAllMedikamentosa($db) {
    $sql = "SELECT * FROM dic_medikamentosa";
    return $db->showData($sql);
}

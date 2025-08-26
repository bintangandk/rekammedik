<?php
include_once __DIR__ . '/../koneksi.php';

$db = new koneksi();

function getAllTindakan($db) {
    $sql = "SELECT * FROM dic_tindakan";
    return $db->showData($sql);
}

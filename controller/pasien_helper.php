<?php
function getIdPasienByUser($db, $id_user)
{
    $id_user = (int)$id_user;
    $row = $db->showData("SELECT id_pasien FROM pasien WHERE id_user = $id_user LIMIT 1");
    if (!$row) return null;
    return (int)$row[0]['id_pasien'];
}

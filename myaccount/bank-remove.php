<?php
require_once('../config/db_config.php');
require_once('../config/auth.php');

$no_rek = $_GET['rek'];

$q_deleterekening = "DELETE FROM  tb_rekening WHERE nomor_rekening = :no_rek";
$stmt = $dbh->prepare($q_deleterekening);

$params = array(
    ":no_rek" => $no_rek,
);

$deleterekening = $stmt->execute($params);

if ($deleterekening) {
    header('Location: bank.php');
}else{
    echo('Bank Gagal di putus');
}


<?php
require_once('../config/db_config.php');

$no_rek = $_POST['rek'];

$q_deleterekening = "DELETE FROM tb_rekening WHERE no_rek = :no_rek";
$stmt = $dbh->prepare($q_deleterekening);

$params = array(
    ":no_rek" => $no_rek,
);

$deleterekening = $stmt->execute($params);


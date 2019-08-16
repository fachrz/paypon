<?php
require_once('../config/db_config.php');
require_once('../config/auth.php');

$id_topup = $_GET['id'];

$query = "DELETE FROM top_up WHERE id_topup = :id_topup";
$stmt = $dbh->prepare($query);

$params = array(
    ":id_topup" => $id_topup,
);

$topupdata = $stmt->execute($params);

if ($topupdata) {
    header("Location: dashboard.php");
}



<?php

require_once('../config/db_config.php');
require_once('../config/auth.php');
$email = $_SESSION['user']['email'];

/* Get last top-up data */
$query = "SELECT * FROM top_up WHERE email = :email ORDER BY id_topup DESC";
$stmt = $dbh->prepare($query);

$params = array(
    ":email" => $email,
);

$stmt->execute($params);
$last_topup = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($last_topup);
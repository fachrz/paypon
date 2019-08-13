<!DOCTYPE html>
<html lang="en">
<?php
require_once('../config/db_config.php');
require_once('../config/auth.php');
    
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        $id_topup = $_GET['id'];
        $query = "SELECT * FROM top_up WHERE id_topup = :id_topup";
        $stmt = $dbh->prepare($query);

        $params = array(
            ":id_topup" => $id_topup,
        );
        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
    ?>
    <h1>Top-up payment</h1>
    <p>silahkan bayar di gerai Paypon terdekat senilai</p>
    <h1>Rp.<?= $user['jumlah_topup'] ?></h1>
    <h1>Kode Pembayaran</h1>
    <h1><?= $user['kode_transaksi'] ?></h1>

    
</body>
</html>
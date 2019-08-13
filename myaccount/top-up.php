<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        require_once('../config/db_config.php');
        require_once('../config/auth.php');
    ?>

    <form action="" method="post">
        <input type="number" name="saldo-topup" placeholder="masukan jumlah topup" require>
        <input type="submit" name="top-up" value="top-up">
    </form>
    <table border="1">
        <tr>
            <td>ID Top-up</td>
            <td>Jumlah Top-Up</td>
            <td>Tanggal Top-Up</td>
            <td>Status</td>
            <td>Option</td>
        </tr>
        
        <?php

            $email = $_SESSION['user']['email'];

            if (isset($_POST['top-up'])) {
                $saldo_topup = filter_input(INPUT_POST, 'saldo-topup', FILTER_SANITIZE_STRING);
                $tgl_topup = date('Y-m-d H:i:s');
                $status = "red";

                // For generate id_topup
                $random_number = mt_rand(100000000, 999999999);
                $transaction_code = "PP".$random_number;
                
                $query = "INSERT INTO top_up (email, jumlah_topup, tgl_topup, status, kode_transaksi) VALUES (:email, :jumlah_topup, :tgl_topup, :status, :kode_transaksi)";
                $stmt = $dbh->prepare($query);
        
                $params = array(
                    ":email" => $email,
                    ":jumlah_topup" => $saldo_topup,
                    ":tgl_topup" => $tgl_topup,
                    ":status" => $status,
                    ":kode_transaksi" => $transaction_code
                );
        
                $topup_insert = $stmt->execute($params);

                if ($topup_insert) {
                    /* Get last top-up data */
                    $query = "SELECT * FROM top_up ORDER BY id_topup DESC LIMIT 1";
                    $stmt = $dbh->prepare($query);

                    $params = array(
                        ":email" => $email,
                    );

                    $stmt->execute($params);
                    $last_topup = $stmt->fetch(PDO::FETCH_ASSOC);
                    header("Location: top-up-confirm.php?id=".$last_topup['id_topup']);
                }
            }
            
            $query = "SELECT * FROM top_up WHERE email = :email AND status = :status";
            $stmt = $dbh->prepare($query);

            $params = array(
                ":email" => $email,
                ":status" => "red"
            );

            $stmt->execute($params);
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($user as $account) {?>
                <tr>
                    <td><?= $account['id_topup'] ?></td>
                    <td><?= $account['jumlah_topup'] ?></td>
                    <td><?= $account['tgl_topup'] ?></td>
                    <td>Menunggu Pembayaran</td>
                    <td>
                        <a href="top-up-confirm.php?id=<?= $account['id_topup'] ?>">Detail</a>
                        <a href="top-up-hapus.php?id=<?= $account['id_topup']?>">Hapus</a>
                    </td>
                    </tr>   
            <?php } ?>
    </table>
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/eb8b44741d.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <center><h1>Kode Pembayaran</h1></center>
            <input class="form-control" type="text" name="transaction-code" placeholder="masukan kode pembayaran">
            <input type="submit" name="topup-confirm" value="Confirm">
        </form>
        <a href="logout.php">Logout</a>
    </div>
<?php
    require_once('../config/db_config.php');

    if (isset($_POST['topup-confirm'])) {
        $transaction_code = filter_input(INPUT_POST, 'transaction-code', FILTER_SANITIZE_STRING);
        $status = "green";
        
        $q_gettopup = "SELECT email, jumlah_topup, status FROM top_up WHERE kode_transaksi = :kode_transaksi";
        $params = array(
            ":kode_transaksi" => $transaction_code,
        );
        $stmt = $dbh->prepare($q_gettopup);
        $stmt->execute($params);
        $topup_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($topup_data['status'] == "red") {
            $q_updatestatus = "UPDATE top_up SET status = :status WHERE kode_transaksi = :kode_transaksi";
            $params = array(
                ":status" => $status,
                ":kode_transaksi" => $transaction_code
            );
            $stmt = $dbh->prepare($q_updatestatus);
            $confirm_status = $stmt->execute($params);
    
            if ($confirm_status) {
                $q_accountdata = "SELECT email, saldo FROM account WHERE email = :email";
                $params = array(
                    ":email" => $topup_data['email'],
                );
                $stmt = $dbh->prepare($q_accountdata);
                $stmt->execute($params);
                $account_data = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($account_data) {
                    $total_saldo = $account_data['saldo'] + $topup_data['jumlah_topup'];
                    $q_saldoupdate = "UPDATE account SET saldo = :jumlah_saldo WHERE email = :email";
                    $params = array(
                        ":jumlah_saldo" => $total_saldo,
                        ":email" => $account_data['email']
                    );
                    $stmt = $dbh->prepare($q_saldoupdate);
                    $saldoupdate = $stmt->execute($params);
                    if ($saldoupdate) {
                        print('berhasil di konfirmasi');
                        $query5 = "INSERT INTO tb_aktivitas VALUES ('', :email, :tipe_aktivitas, :saldo_aktivitas, :tgl_aktivitas)";
                            $params = array(
                                ":email" => $topup_data['email'],
                                ":tgl_aktivitas" => date('Y-m-d H:i:s'),
                                ":saldo_aktivitas" => $topup_data['jumlah_topup'],
                                ":tipe_aktivitas" => "top-up",
                            );
                            $stmt = $dbh->prepare($query5);
                            $stmt->execute($params);
                    }else {
                        print('gagal di konfirmasi');
                    }
                }
            }
        }else {
            print('Kode sudah tidak berlaku');
        }
        
    }
?>
</body>
</html>


<br><br>




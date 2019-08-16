<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/style.css">
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
                $q_accountdata = "SELECT email, jumlah_saldo FROM account WHERE email = :email";
                $params = array(
                    ":email" => $topup_data['email'],
                );
                $stmt = $dbh->prepare($q_accountdata);
                $stmt->execute($params);
                $account_data = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($account_data) {
                    $total_saldo = $account_data['jumlah_saldo'] + $topup_data['jumlah_topup'];
                    $q_saldoupdate = "UPDATE account SET jumlah_saldo = :jumlah_saldo WHERE email = :email";
                    $params = array(
                        ":jumlah_saldo" => $total_saldo,
                        ":email" => $account_data['email']
                    );
                    $stmt = $dbh->prepare($q_saldoupdate);
                    $saldoupdate = $stmt->execute($params);
                    if ($saldoupdate) {
                        print('berhasil di konfirmasi');
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




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Withdraw</title>
</head>
<body>
    <?php
        include '../template/navbar.php';
        require_once('../config/db_config.php');
        require_once('../config/auth.php');
        $email = $_SESSION['user']['email'];
    ?>
    <style>
    .form-control{
        margin-bottom: 10px;
    }
    </style>
    <br>
    <br>
    <div class="container">
    <form action="" method="post">
        <input class="form-control" type="number" name="saldo-transfer" placeholder="masukan jumlah transfer" required>
        <select name="rekening" class="form-control">
            <?php
                 $q_getrekening = "SELECT * FROM v_rekening WHERE email = :email";
                 $params = array(
                     ":email" => $email,
                 );
                 $stmt = $dbh->prepare($q_getrekening);
                 $stmt->execute($params);
                 $getrekening = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 
                 foreach ($getrekening as $option) {?>

                    <option value="<?= $option['no_rek'] ?>"><?= $option['nama_bank'].' - '.$option['no_rek'] ?></option>

                 <?php } ?>
        </select> 
        <input type="submit" name="transfer-bank" class="btn btn-primary" value="Transfer">
    </form>
    </div>
    <?php
        if (isset($_POST['transfer-bank'])) {
            $saldotransfer = filter_input(INPUT_POST, 'saldo-transfer', FILTER_SANITIZE_STRING);
            $rekening = filter_input(INPUT_POST, 'rekening', FILTER_SANITIZE_STRING);
            $tgltransfer = date('Y-m-d H:i:s'); 

            
            $q_rekeningcheck = "SELECT * FROM v_rekening WHERE no_rek = :nomor_rekening AND email = :email ";
            $params = array(
                ":nomor_rekening" => $rekening,
                ":email" => $email
            );
            $stmt = $dbh->prepare($q_rekeningcheck);
            $stmt->execute($params);
            $rekeningcheck = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rekeningcheck) {
                $q_getaccountsaldo = "SELECT saldo FROM account WHERE email = :email";
                $params = array(
                    ":email" => $email,
                );
                $stmt = $dbh->prepare($q_getaccountsaldo);
                $stmt->execute($params);
                $accountsaldo = $stmt->fetch(PDO::FETCH_ASSOC);
                $result = $accountsaldo['saldo'] - $saldotransfer;
               
                if ($result >= 0) {
                    $q_transferbank = "INSERT INTO tb_withdraw (email, no_rek, jumlah_transfer, tgl_transfer) VALUES (:email, :no_rek, :jumlah_transfer, :tgl_transfer)";
                    $stmt = $dbh->prepare($q_transferbank);
        
                    $params = array(
                        ":email" => $rekeningcheck['email'],
                        ":no_rek" => $rekeningcheck['no_rek'],
                        ":jumlah_transfer" => $saldotransfer,
                        ":tgl_transfer" => $tgltransfer
                    );

                    $transferbank = $stmt->execute($params);

                    if ($transferbank) {
                        $q_updatesaldo = "UPDATE account SET saldo = :result WHERE email = :email";
                        $params = array(
                            ":email" => $email,
                            ":result" => $result
                        );
                        $stmt = $dbh->prepare($q_updatesaldo);
                        $updatesaldo = $stmt->execute($params);
                        if ($updatesaldo) {
                            $query5 = "INSERT INTO tb_aktivitas VALUES ('', :email, :tipe_aktivitas, :email_terkait, :saldo_aktivitas, :tgl_aktivitas)";
                            $params = array(
                                    ":email" => $email,
                                    ":tgl_aktivitas" => date('Y-m-d H:i:s'),
                                    ":saldo_aktivitas" => $saldotransfer,
                                    ":tipe_aktivitas" => "transfer bank",
                                    ":email_terkait" => $email
                            );
                            $stmt = $dbh->prepare($query5);
                            $stmt->execute($params);
                        }
                        header('Location: dashboard.php');
                    }
                    
                }else if($result < 0) {
                    print('anda melibihi saldo yang anda punya');
                }
            }else{
                print('gagal transfer');
            }
        }

    ?>
    
</body>
</html>
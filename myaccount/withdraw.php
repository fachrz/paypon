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
        $email = $_SESSION['user']['email'];
    ?>
    <form action="" method="post">
        <input type="number" name="saldo-transfer" placeholder="masukan jumlah transfer" required>
        <select name="rekening">
            <?php
                 $q_getrekening = "SELECT * FROM v_rekening WHERE email = :email";
                 $params = array(
                     ":email" => $email,
                 );
                 $stmt = $dbh->prepare($q_getrekening);
                 $stmt->execute($params);
                 $getrekening = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 
                 foreach ($getrekening as $option) {?>

                    <option value="<?= $option['nomor_rekening'] ?>"><?= $option['nama_bank'].' - '.$option['nomor_rekening'] ?></option>

                 <?php } ?>
        </select> 
        <input type="submit" name="transfer-bank" value="Transfer">
    </form>
    
    <?php
        if (isset($_POST['transfer-bank'])) {
            $saldotransfer = filter_input(INPUT_POST, 'saldo-transfer', FILTER_SANITIZE_STRING);
            $rekening = filter_input(INPUT_POST, 'rekening', FILTER_SANITIZE_STRING);
            $tgltransfer = date('Y-m-d H:i:s'); 

            
            $q_rekeningcheck = "SELECT * FROM v_rekening WHERE nomor_rekening = :nomor_rekening AND email = :email ";
            $params = array(
                ":nomor_rekening" => $rekening,
                ":email" => $email
            );
            $stmt = $dbh->prepare($q_rekeningcheck);
            $stmt->execute($params);
            $rekeningcheck = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rekeningcheck) {
                $q_getaccountsaldo = "SELECT jumlah_saldo FROM account WHERE email = :email";
                $params = array(
                    ":email" => $email,
                );
                $stmt = $dbh->prepare($q_getaccountsaldo);
                $stmt->execute($params);
                $accountsaldo = $stmt->fetch(PDO::FETCH_ASSOC);
                $result = $accountsaldo['jumlah_saldo'] - $saldotransfer;
               
                if ($result >= 0) {
                    $q_transferbank = "INSERT INTO transfer_bank (email, no_rek, jumlah_transfer, tgl_transfer) VALUES (:email, :no_rek, :jumlah_transfer, :tgl_transfer)";
                    $stmt = $dbh->prepare($q_transferbank);
        
                    $params = array(
                        ":email" => $rekeningcheck['email'],
                        ":no_rek" => $rekeningcheck['nomor_rekening'],
                        ":jumlah_transfer" => $saldotransfer,
                        ":tgl_transfer" => $tgltransfer
                    );

                    $transferbank = $stmt->execute($params);

                    if ($transferbank) {
                        $q_updatesaldo = "UPDATE account SET jumlah_saldo = :result WHERE email = :email";
                        $params = array(
                            ":email" => $email,
                            ":result" => $result
                        );
                        $stmt = $dbh->prepare($q_updatesaldo);
                        $stmt->execute($params);
                        header('Location: transfer_bank.php');
                    }
                    
                }else if($hasil < 0) {
                    print('anda melibihi saldo yang anda punya');
                }
            }else{
                print('gagal transfer');
            }
        }

    ?>
    
</body>
</html>
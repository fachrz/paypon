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
        <input type="number" name="saldo-transfer" placeholder="masukan jumlah transfer" required>
        <input type="email" name="email-tujuan" placeholder="Masukan Email Tujuan" required>
        <input type="text" name="deskripsi" placeholder="Masukan deskripsi (Optional)">
        <input type="submit" name="transfer" value="Transfer">
    </form>
    
    <?php
        if (isset($_POST['transfer'])) {

            $email = $_SESSION['user']['email'];
            $emailtujuan = filter_input(INPUT_POST, 'email-tujuan', FILTER_SANITIZE_STRING);
            $saldotransfer = filter_input(INPUT_POST, 'saldo-transfer', FILTER_SANITIZE_STRING);
            $tgltransfer = date('Y-m-d H:i:s');
            $deskripsi = filter_input(INPUT_POST, 'deskripsi', FILTER_SANITIZE_STRING);

            $query = "SELECT email, jumlah_saldo FROM account WHERE email = :emailtujuan";
            $params = array(
                ":emailtujuan" => $emailtujuan,
            );
            $stmt = $dbh->prepare($query);
            $stmt->execute($params);
            $checking = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($checking) {
                $query1 = "SELECT jumlah_saldo FROM account WHERE email = :email";
                $params = array(
                    ":email" => $email,
                );
                $stmt = $dbh->prepare($query1);
                $stmt->execute($params);
                $calc = $stmt->fetch(PDO::FETCH_ASSOC);
                $hasil = $calc['jumlah_saldo'] - $saldotransfer;
               
                if ($hasil >= 50000) {
                    $query2 = "INSERT INTO transfer (email, tgl_transfer, jumlah_transfer, email_tujuan, deskripsi) VALUES (:email, :tgl_transfer, :jumlah_transfer, :email_tujuan, :deskripsi)";
                    $stmt = $dbh->prepare($query2);
        
                    $params = array(
                        ":email" => $email,
                        ":tgl_transfer" => $tgltransfer,
                        ":jumlah_transfer" => $saldotransfer,
                        ":email_tujuan" => $emailtujuan,
                        ":deskripsi" => $deskripsi
                    );

                    $updatestatus = $stmt->execute($params);

                    if ($updatestatus) {
                        $query3 = "UPDATE account SET jumlah_saldo = :hasil WHERE email = :email";
                        $params = array(
                            ":email" => $email,
                            ":hasil" => $hasil
                        );
                        $stmt = $dbh->prepare($query3);
                        $stmt->execute($params);
                        header('Location: transfer.php');
                    }
                    $saldo_emailtujuan = $checking['jumlah_saldo'] + $saldotransfer;
                    $query4 = "UPDATE account SET jumlah_saldo = :hasil WHERE email = :emailtujuan";
                    $params = array(
                        ":emailtujuan" => $emailtujuan,
                        ":hasil" => $saldo_emailtujuan
                    );
                    $stmt = $dbh->prepare($query4);
                    $stmt->execute($params);
                    
                }else if($hasil <= 50000) {
                    print('Sisa saldo anda tidak mencukupi untuk transfer');
                }
            }else{
                print('Email Tujuan tidak terdaftar!');
            }
        }

    ?>
    
</body>
</html>
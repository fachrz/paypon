<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transfer</title>
</head>
<body>
    <?php
        require_once('../config/db_config.php');
        require_once('../config/auth.php');
        include '../template/navbar.php';
    ?>
    <div class="container transfer-container">
        <form action="" method="post">
            <div class="form-row">
                <div class="col">
                <input type="number" name="saldo-transfer" class="form-control" placeholder="Masukan Jumlah Transfer" required>
                </div>
                <div class="col">
                <input type="text" name="email-tujuan" class="form-control" placeholder="Masukan Email Tujuan" required>
                </div>
            </div>
            <input type="text" name="deskripsi" class="form-control form-deskripsi" placeholder="Masukan Deskripsi">
            <button type="submit" name="transfer" class="btn btn-primary btn-transfer">Transfer</button>
        </form>
    </div>

    <?php
    date_default_timezone_set('Asia/Jakarta');
        if (isset($_POST['transfer'])) {

            $email = $_SESSION['user']['email'];
            $emailtujuan = filter_input(INPUT_POST, 'email-tujuan', FILTER_SANITIZE_STRING);
            $saldotransfer = filter_input(INPUT_POST, 'saldo-transfer', FILTER_SANITIZE_STRING);
            $tgltransfer = date('Y-m-d H:i:s');
            $deskripsi = filter_input(INPUT_POST, 'deskripsi', FILTER_SANITIZE_STRING);

            $query = "SELECT email, saldo FROM account WHERE email = :emailtujuan";
            $params = array(
                ":emailtujuan" => $emailtujuan,
            );
            $stmt = $dbh->prepare($query);
            $stmt->execute($params);
            $checking = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($checking) {
                $query1 = "SELECT saldo FROM account WHERE email = :email";
                $params = array(
                    ":email" => $email,
                );
                $stmt = $dbh->prepare($query1);
                $stmt->execute($params);
                $calc = $stmt->fetch(PDO::FETCH_ASSOC);
                $hasil = $calc['saldo'] - $saldotransfer;
               
                if ($hasil >= 50000) {
                    $query2 = "INSERT INTO tb_transfer (email, tgl_transfer, jumlah_transfer, email_tujuan, deskripsi) VALUES (:email, :tgl_transfer, :jumlah_transfer, :email_tujuan, :deskripsi)";
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
                        $query3 = "UPDATE account SET saldo = :hasil WHERE email = :email";
                        $params = array(
                            ":email" => $email,
                            ":hasil" => $hasil
                        );
                        $stmt = $dbh->prepare($query3);
                        $akumulasi = $stmt->execute($params);
                        if ($akumulasi) {
                            $query5 = "INSERT INTO tb_aktivitas VALUES ('', :email, :tipe_aktivitas, :email_terkait, :saldo_aktivitas, :tgl_aktivitas)";
                            $params = array(
                                ":email" => $email,
                                ":tgl_aktivitas" => $tgltransfer,
                                ":saldo_aktivitas" => $saldotransfer,
                                ":email_terkait" => $emailtujuan,
                                ":tipe_aktivitas" => "transfer",
                                
                            );
                            $stmt = $dbh->prepare($query5);
                            $stmt->execute($params);
                        }
                        
                    }

                    $saldo_emailtujuan = $checking['saldo'] + $saldotransfer;
                    $query4 = "UPDATE account SET saldo = :hasil WHERE email = :emailtujuan";
                    $params = array(
                        ":emailtujuan" => $emailtujuan,
                        ":hasil" => $saldo_emailtujuan
                    );  
                    $stmt = $dbh->prepare($query4);
                    $updatesaldotransfer = $stmt->execute($params);
                    if ($updatesaldotransfer) {
                        $query5 = "INSERT INTO tb_aktivitas VALUES ('', :email, :tipe_aktivitas, :email_terkait, :saldo_aktivitas, :tgl_aktivitas)";
                        $params = array(
                                ":email" => $emailtujuan,
                                ":tipe_aktivitas" => "terima transfer",
                                ":email_terkait" => $email,
                                ":saldo_aktivitas" => $saldotransfer,
                                ":tgl_aktivitas" => date('Y-m-d H:i:s'),
                                
                                
                        );
                        $stmt = $dbh->prepare($query5);
                        $stmt->execute($params);
                    }
                    
                    

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
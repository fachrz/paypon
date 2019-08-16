<?php
        require_once('../config/db_config.php');
        require_once('../config/auth.php');
        $email = $_SESSION['user']['email'];
    ?>
<?php

            
            $bank = $_POST['kode-bank'];
            $rekening = $_POST['no-rekening'];
            
            $q_bankregister = "INSERT INTO tb_rekening VALUES (:email, :kode_bank, :nomor_rekening)";
            $params = array(
                ":email" => $email,
                ":kode_bank" => $bank,
                ":nomor_rekening" => $rekening,
                
            );
            $stmt = $dbh->prepare($q_bankregister);
            $bankregister = $stmt->execute($params);
            if ($bankregister) {
                header("Location: bank.php");   
            }else{
                print('Bank gagal di hubungkan');
            }
        
?>
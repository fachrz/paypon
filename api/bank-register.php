<?php
        include('../config/db_config.php');
        session_start();     
        $email = $_SESSION['user']['email'];
         
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
               $response = array(
                   'status' => 'berhasil' , 
                ); 
                echo json_encode($response);
            }else{
                $response = array(
                    'status' => 'gagal' , 
                );
                echo json_encode($response); 
            }
        
?>
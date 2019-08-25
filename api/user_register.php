<?php
        include '../config/db_config.php';

        $email = $_POST['email'];
        $password = $_POST['password'];
        $nama = $_POST['nama'];
        $no_telp = $_POST['no_telp'];
        $alamat = $_POST['alamat'];

        $q_accountcheck = "SELECT email FROM account WHERE email = :email";
        $stmt = $dbh->prepare($q_accountcheck);

        $params = array(
            ":email" => $email,
        );

        $stmt->execute($params);
        $accountcheck = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($accountcheck == false) {
            $q_emailregistered = "INSERT INTO account VALUES (:email, :password, :nama, :no_telp, :alamat, :saldo)";
            $stmt = $dbh->prepare($q_emailregistered);

            $params = array(
                ':email' => $email,
                ':password' => $password,
                ':nama' => $nama,
                ':no_telp' => $no_telp,
                ':alamat' => $alamat,
                ':saldo' => ""
            );

            $email_registered = $stmt->execute($params);
            if ($email_registered) {
                $status = array(
                    "status" => "sukses", 
                );
                echo json_encode($status);
            }else {
                $status = array(
                    "status" => "gagal", 
                );
                echo json_encode($status);
            }
            
        }else {
            $status = array(
                "status" => "terdaftar", 
            );
            echo json_encode($status);
        }
        
?>
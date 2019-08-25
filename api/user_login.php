<?php
        include '../config/db_config.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT email, password FROM account WHERE email = :email";
        $stmt = $dbh->prepare($query);

        $params = array(
            ":email" => $email,
        );

        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            if ($password == $user['password']) {
                session_start();
                $_SESSION["user"] = $user;
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
        }else{
            $status = array(
                "status" => "tidak terdaftar", 
            );
            echo json_encode($status);
        }
        
?>
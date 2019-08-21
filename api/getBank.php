<?php
        require_once('../config/db_config.php');
        session_start();
        $email = $_SESSION['user']['email'];
    ?>
    
        <?php
        header('Content-Type: application/json');

        $q_getBank = "SELECT * FROM tb_bank";
        $params = array(
            ":email" => $email,        
        );
        $stmt = $dbh->prepare($q_getBank);
        $stmt->execute($params);
        $getBank = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($getBank);
        
        ?>
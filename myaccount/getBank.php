<?php
        require_once('../config/db_config.php');
        require_once('../config/auth.php');
        $email = $_SESSION['user']['email'];
    ?>
    
        <?php
        $q_getBank = "SELECT * FROM tb_bank";
        $params = array(
            ":email" => $email,        
        );
        $stmt = $dbh->prepare($q_getBank);
        $stmt->execute($params);
        $getBank = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($getBank);
        
        ?>
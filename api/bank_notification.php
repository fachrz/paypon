    <?php
        require_once('../config/db_config.php');
        session_start();
        $email = $_SESSION['user']['email'];
    ?>
    
        <?php
        $q_bankregistered = "SELECT * FROM v_rekening WHERE email = :email";
        $params = array(
            ":email" => $email,        
        );
        $stmt = $dbh->prepare($q_bankregistered);
        $stmt->execute($params);
        $bankregistered = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($bankregistered) {?>
            <div class="card-header">
                <?= $bankregistered['nama_bank'] ?>
            </div>
            <div class="card-body">
                No. Rekening
                <p class="card-text"><?= $bankregistered['no_rek'] ?></p>
                <button onclick="disconnectBank()" id="<?= $bankregistered['no_rek'] ?>" class="btn btn-primary disconnect-bank">Putuskan</button>
            </div>  
        <?php } else if ($bankregistered == false) {?>
            <div class="card-body">
                    <h5 class="card-title">Hubungkan dengan bank anda</h5>
                    <p class="card-text">Anda sama sekali belum menghubungkan bank ke akun anda. silahkan hubungkan untuk menghilangkan batasan!</p>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#bank-modal">Hubungkan Bank</button>
            </div>
        <?php } ?>
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
            <div class="card-header bank-header">
                <?= $bankregistered['nama_bank'] ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-7">
                        No. Rekening
                        <p class="card-text"><?= $bankregistered['no_rek'] ?></p>
                    </div>
                    <div class="col-5 justify-content-center align-self-center">
                    <button onclick="disconnectBank()" id="<?= $bankregistered['no_rek'] ?>" class="btn btn-danger disconnect-bank d-flex">Putuskan</button>
                    </div>
            </div>  
               
                
            </div>  
        <?php } else if ($bankregistered == false) {?>
            <div class="card-body">
                    <h5 class="card-title">Hubungkan dengan bank anda</h5>
                    <p class="card-text">Anda sama sekali belum menghubungkan bank ke akun anda. silahkan hubungkan untuk menghilangkan batasan!</p>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#bank-modal">Hubungkan Bank</button>
            </div>
        <?php } ?>
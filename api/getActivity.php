<?php
        require_once('../config/db_config.php');
        session_start();
        $email = $_SESSION['user']['email'];
    ?>
    
        <?php
        $q_getActivity = "SELECT * FROM tb_aktivitas WHERE email = :email AND DATE(tgl_aktivitas) = CURRENT_DATE ORDER BY tgl_aktivitas DESC LIMIT 10";
        $params = array(
            ":email" => $email,        
        );
        $stmt = $dbh->prepare($q_getActivity);
        $stmt->execute($params);
        $getActivity = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($getActivity) {
            foreach ($getActivity as $activity) {?>
                <div class="activity-bar clearfix" id="topup-notif">
                    <div class="row no-gutters text-center">
                        <div class="col-sm-3 activity-date"><?= date('Y-m-d', strtotime($activity['tgl_aktivitas'])) ?></div>
                        <div class="col-sm-5 text-left activity-description"><?php
                            if ($activity['tipe_aktivitas'] == 'transfer') {
                                echo ucfirst($activity['tipe_aktivitas'])." Ke ".$activity['email_terkait'];
                            }else if ($activity['tipe_aktivitas'] == 'terima transfer') {
                                echo ucfirst($activity['tipe_aktivitas'])." Dari ".$activity['email_terkait'];
                            }else if ($activity['tipe_aktivitas'] == 'withdraw'){
                                echo ucfirst($activity['tipe_aktivitas'])." Ke ".$activity['email_terkait'];
                            }else if ($activity['tipe_aktivitas'] == 'transfer bank'){
                                echo ucwords($activity['tipe_aktivitas']);
                            }
                            
                        ?></div>
                        <div class="col-4 activity-saldo text-right"><?php
                        if ($activity['tipe_aktivitas'] == 'transfer') {
                            echo "- Rp.".number_format($activity['saldo_aktivitas'],2,',','.');
                        }else if ($activity['tipe_aktivitas'] == 'top-up') {
                            echo "+ Rp.".number_format($activity['saldo_aktivitas'],2,',','.');
                        }else if($activity['tipe_aktivitas'] == 'terima transfer'){
                            echo "+ Rp.".number_format($activity['saldo_aktivitas'],2,',','.');
                        }elseif ($activity['tipe_aktivitas'] == 'transfer bank') {
                            echo "- Rp.".number_format($activity['saldo_aktivitas'],2,',','.');
                        }
                        ?></div>
                    </div>
                </div>
            <?php } 
        }else {?>
            <p class="card-text">Tidak ada aktivitas apapun</p>
        <?php }
        ?>
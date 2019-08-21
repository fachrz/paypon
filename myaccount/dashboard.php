<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
        require_once("../config/auth.php");
        require_once("../config/db_config.php");
    ?>
    <title>Document</title>
</head>

<body>
    <?php
        include '../template/navbar.php';
        
        $email = $_SESSION['user']['email'];
        $query = "SELECT * FROM account WHERE email = :email";
        $stmt = $dbh->prepare($query);

        $params = array(
            ":email" => $email,
        );

        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $uname = $user['nama'];
        $saldo = $user['saldo'];
    ?>
    <?php

    $q_gettopup = "SELECT * FROM top_up WHERE email = :email AND status = :status ORDER BY id_topup DESC";
    $stmt = $dbh->prepare($q_gettopup);

    $params = array(
        ":email" => $email,
        ":status" => "red"
    );

    $stmt->execute($params);
    $gettopup = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    ?>
    
    <div class="container dashboard-container">
    <h1 class="dashboard-user text-center">Selamat Datang, <?= $uname ?></h1> 
        <div class="row no-gutters">
            <div class="col-lg">
                <div class="card">  
                <div class="card-body text-center">
                    <i class="fas fa-money-bill-wave"></i>
                    <h6>Saldo Paypon Anda</h6>
                    <h2 class="card-text">Rp. <?= $saldo ?></h2>
                    <button onclick="top_up()" id="btn-topup" class="btn btn-primary btn-topup" data-toggle="modal" data-target="#topup-modal">Top-up</button>   
                </div>
                </div>

                <div class="card activity">
                  <div class="card-body">
                      <h5 class="card-title">Aktivitas Terkini</h5>
                      <div class="activity-body">
                      
                      </div>
                      
                      <script>
                        getActivity();
                      </script>
                  </div>
                </div>
            </div>
            <div class="col-5 pp-sidebar">

            <div class="card" id="bank-card">
            <script>
              checkConnectedBank();
            </script>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top-up</h5>
                    <?php
                    if ($gettopup == false) {?>
                      <p class="card-text">Tidak ada aktivitas Top-up</p>
                    <?php }else {
                      foreach ($gettopup as $row) {?>
                        <div class="alert alert-dark" role="alert" id="topup-notif">
                          <p>Jumlah Topup Rp.<?= $row['jumlah_topup']?></p>
                          <p>ID Top-up No. <?= $row['id_topup'] ?></p>
                            <a href="top-up-confirm.php?id=<?= $row['id_topup'] ?>" class="btn btn-dark">Detail</a>
                            <a href="top-up-hapus.php?id=<?= $row['id_topup'] ?>" class="btn btn-danger delete-topup">Hapus</a>
                            
                        </div>
                    <?php } 
                    }?>
                     
                    
                </div>
            </div>
            </div>
            
        </div>  
    </div>
    <!-- Modal -->
    <div class="modal fade" id="topup-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Top-up </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="top-up.php" method="post">
          <div class="modal-body">
            <div class="form-group">
                  <label for="jumlah-topup">Jumlah Top-up</label>
                  <select class="form-control" id="jumlah-topup" name="jumlah-topup">
                    <option value="100000">Rp. 100.000</option>
                  </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" name="topup-submit" id="topup-submit" class="btn btn-primary" value="Top-up">
          </div>
          </form>
        </div>
      </div>
    </div>

     <!-- Modal -->
    <div class="modal fade" id="bank-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hubungkan Bank</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="bank-form">
          <div class="modal-body">
              <div class="form-group">
                <label for="jumlah-topup">Jumlah Top-up</label>
                <select class="form-control" id="nama-bank" name="kode-bank">
                  <script>getBank()</script>
                </select>
                <div class="form-group">
                  <label for="no-rekening">No. Rekening</label>
                  <input type="text" class="form-control" name="no-rekening" id="no-rekening" aria-describedby="emailHelp" placeholder="Masukan no rekening">
                </div>
              </div>
          </div>
          <div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="bank-submit">Hubungkan</button>
          </form>  
            <script>
              /* Click Enter bank forum */
              $("#bank-submit").click(function() {
                connectBank();
              });
              $("#bank-form").keypress(function(e) {
                var key = e.which;
                if (key == '13') {
                  connectBank();
                  return false;
                }
              })
            </script>
            
          </div>
        </div>
      </div>

</body>
</html>




<!-- <a href="transfer.php">Transfer Saldo</a>
<a href="withdraw.php">Cairkan Saldo</a>
<a href="top-up.php">Top-up Saldo</a>
<a href="bank.php">Hubungkan Dengan Bank</a>
<br><br>

Selamat Datang, <?= $uname ?><br>
saldo <?= $saldo ?><br>
<a href="settings.php">Account Settings</a>
<a href="logout.php">Logout</a> -->

 

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
    <title>Dashboard</title>
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
    <div class="alert-container d-none">

    </div>
    <h1 class="dashboard-user text-center">Selamat Datang, <?= $uname ?></h1> 
        <div class="row no-gutters">
            <div class="col-lg">
                <div class="card">  
                <div class="card-body text-center paypon-card">
                    <i class="fas fa-money-bill-wave"></i>
                    <h6>Saldo <span>PayPon</span> Anda</h6>
                    <h2 class="card-text">Rp. <?= number_format($saldo,2,',','.')?></h2>
                    <button onclick="top_up()" id="btn-topup" class="btn btn-danger btn-topup" data-toggle="modal" data-target="#topup-modal">Top-up</button>   
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
                      <div class="topup-bar clearfix" id="topup-notif">
                        <div class="row no-gutters text-center">
                          <div class="col-sm-2 topup-id">
                            <?= $row['id_topup'] ?>
                          </div>
                          <div class="col-sm-7 text-left topup-saldo">
                            Rp. <?= number_format($row['jumlah_topup'],2,',','.') ?>
                          </div>
                          <div class="col-3 topup-option">
                            <a href="top-up-confirm.php?id=<?= $row['id_topup'] ?>"><i class="fas fa-file-invoice"></i></a>
                            <a href="top-up-hapus.php?id=<?= $row['id_topup'] ?>"><i class="fas fa-trash-alt"></i></a>
                          </div>
                        </div>
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
                    <option value="100000">Rp. 100.000,00</option>
                    <option value="200000">Rp. 200.000,00</option>
                    <option value="300000">Rp. 300.000,00</option>
                  </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" name="topup-submit" id="topup-submit" class="btn btn-danger" value="Top-up">
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
                <label for="jumlah-topup">Nama Bank</label>
                <select class="form-control" id="nama-bank" name="kode-bank">
                  <script>getBank()</script>
                </select>
                </div>
                <div class="form-group">
                  <label for="no-rekening">No. Rekening</label>
                  <input type="text" class="form-control" name="no-rekening" id="no-rekening" aria-describedby="emailHelp" placeholder="Masukan no rekening">
                </div>
              
          </div>
          <div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" id="bank-submit">Hubungkan</button>
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
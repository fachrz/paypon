<?php
    require_once("../config/auth.php");
    require_once("../config/db_config.php");

    $email = $_SESSION['user']['email'];
    $query = "SELECT * FROM account WHERE email = :email";
    $stmt = $dbh->prepare($query);

    $params = array(
        ":email" => $email,
    );

    $stmt->execute($params);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $uname = $user['nama'];
    $saldo = $user['jumlah_saldo'];
?>


<a href="transfer.php">Transfer Saldo</a>
<a href="withdraw.php">Cairkan Saldo</a>
<a href="top-up.php">Top-up Saldo</a>
<a href="bank.php">Hubungkan Dengan Bank</a>
<br><br>

Selamat Datang, <?= $uname ?><br>
saldo <?= $saldo ?><br>
<a href="settings.php">Account Settings</a>
<a href="logout.php">Logout</a>

 

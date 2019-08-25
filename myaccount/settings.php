<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        require_once ('../config/auth.php');
        require_once ('../config/db_config.php');
        include '../template/navbar.php';

        $email = $_SESSION['user']['email'];
        $query = "SELECT * FROM account WHERE email = :email";
        $stmt = $dbh->prepare($query);

        $params = array(
            ":email" => $email,
        );

        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="container">
    <form class="border">
        <div class="form-group col-md-3">
            <label for="inputEmail4">Email</label>
            <input type="email" class="form-control" id="inputEmail4" value="<?= $user['email'];?>" placeholder="Email" disabled>
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress">Nama</label>
            <input type="text" class="form-control" id="inputAddress" value="<?= $user['nama']; ?>">
        
            <label for="inputPassword4">No Telpon</label>
            <input type="text" class="form-control" id="inputPassword4" value="<?= $user['no_telp']; ?>">

            <label for="inputAddress2">Address</label>
            <input type="text" class="form-control" id="inputAddress2" value="<?= $user['alamat']; ?>">

            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>  

        
       
</form>
    </div>
        
        <form class="d-none" action="" method="post">
            <label for="">Email</label>
            <input type="text" name="email" value="<?= $user['email'];?>" disabled><br>
            <label for="">Password</label>
            <input type="text" name="password" value="<?= $user['password']; ?>"><br>
            <label for="">Nama</label>
            <input type="text" name="nama" value="<?= $user['nama']; ?>"><br>
            <label for="">No Telp</label>
            <input type="text" name="no-telp" value="<?= $user['no_telp']; ?>"><br>
            <label for="">Email</label>
            <textarea name="alamat" id="" cols="30" rows="10"><?= $user['alamat']; ?></textarea>
            <input type="submit" name="account-data" value="Simpan">
            <a href="dashboard.php">Back</a>
        </form>

        <?php
            if (isset($_POST['account-data'])) {
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
                $no_telp = filter_input(INPUT_POST, 'no-telp', FILTER_SANITIZE_STRING);
                $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
    

                $q_accountupdate = "UPDATE account SET password = :password, nama = :nama, no_telp = :no_telp, alamat = :alamat WHERE email = :email";
                $params = array(
                    ":email" => $email,
                    ":password" => $password,
                    ":nama" => $nama,
                    ":no_telp" => $no_telp,
                    ":alamat" => $alamat,      
                );
                
                $stmt = $dbh->prepare($q_accountupdate);
                $accountupdate = $stmt->execute($params);
                    if ($accountupdate) {
                        print('Data diri berhasil di simpan');
                    }else {
                        print('Data diri gagal di simpan');
                    }
            }
        ?>
</body>
</html>
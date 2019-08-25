<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS Link -->
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://kit.fontawesome.com/eb8b44741d.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="assets/script.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lexend+Deca&display=swap" rel="stylesheet"> 
    <title>Paypon Register</title>
</head>
<body>
<div class="login-container">
    <h1 class="logo">Pay<span>Pon</span></h1>
    <div class="alert-container">

    </div>
    <form action="" method="post" class="register-form border">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Masukan Email" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Masukan Password" required>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                <label for="no_telp">No Telepon</label>
                <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="Masukan Nomor Telepon" required>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukan Alamat" required>
                </div>
            </div>
        </div>
        <input id="register-submit" type="submit" name="register" class="btn btn-danger btn-block" value="Daftar">
    </form>
    <p class="register-section">Sudah punya akun? <a href="login.php">Login Ajahh!!</a></p>
</div>
    <?php
        if (isset($_POST['register'])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $name = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
            $no_telp = filter_input(INPUT_POST, 'no_telp', FILTER_SANITIZE_STRING);
            $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
            
            if ($email == "" || $password == "" || $name == "" || $no_telp == "" || $alamat == "") {
                
            }else {?>
                <script>user_register("<?= $email ?>", "<?= $password ?>", "<?= $name ?>", "<?= $no_telp ?>", "<?= $alamat ?>")</script>
            <?php }
        }
        ?>

  
    
</body>
</html>
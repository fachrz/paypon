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
    <?php
        include 'session.php';
    ?>
    
    <title>Paypon Login</title>
</head>
<body>
<div class="login-container">
    <h1 class="logo">Pay<span>Pon</span></h1>
    <div class="alert-container">

    </div>
    <form action="" method="post" class="login-form border">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Masukan Email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Masukan Password" required>
        </div>
        <input id="login-submit" type="submit" name="login" class="btn btn-danger btn-block" value="Login">
    </form>
    <p class="register-section">Nggk punya akun? <a href="register.php">Daftar yuk!!</a></p>
    <?php
        $email =  filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if ($email == "" || $password == ""){
            
        }else if ($email !== "" && $password !== "") {?>
            <script>user_login("<?= $email ?>", "<?= $password ?>")</script>
    <?php } ?> 
</div>
</body>
</html>
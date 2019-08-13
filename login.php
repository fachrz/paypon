<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="assets/style.css">
    <title>Paypon-login</title>
</head>
<body>
<?php
require_once('config/db_config.php');
?> 
<div class="login-container">
    <i class="fas fa-money-bill-wave"></i>
    <h1>Paypon</h1>
    <form action="" method="post" class="login-form border">
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <button type="submit" name="login" class="btn btn-primary btn-block">Submit</button>
    </form>
    <p>Nggk punya akun? <a href="register.php">Daftar yuk!!</a></p>
</div>

<?php
    if (isset($_POST['login'])) {

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
        $query = "SELECT email, password FROM account WHERE email = :email";
        $stmt = $dbh->prepare($query);

        $params = array(
            ":email" => $email,
        );

        $stmt->execute($params);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($password == $user['password']) {
                session_start();
                $_SESSION["user"] = $user;
                header("Location: myaccount/dashboard.php");
            }else {
                echo "Password salah";
            }
        }else{
            echo "Akun tidak terdaftar";
        }
        
    }
?>
</body>
</html>
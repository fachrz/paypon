<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paypon-login</title>
</head>
<body>
<?php
require_once('config/db_config.php');
?>
<form action="" method="post">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="submit" name="login" value="Login">
</form>
<p>Nggk punya akun? <a href="register.php">Daftar yuk!!</a></p>

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
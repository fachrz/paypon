<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paypon Admin</title>
</head>
<body>
<?php
require_once('../config/db_config.php');
?>
<form action="" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="password">
    <input type="submit" name="admin-login" value="Login">
</form>
<p>Nggk punya akun? <a href="register.php">Daftar yuk!!</a></p>

<?php
    if (isset($_POST['admin-login'])) {

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
        $query = "SELECT username, password FROM tb_admin WHERE username = :username";
        $stmt = $dbh->prepare($query);

        $params = array(
            ":username" => $username,
        );

        $stmt->execute($params);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            if ($password == $admin['password']) {
                session_start();
                $_SESSION["admin"] = $admin['username'];
                header("Location: dashboard.php");
            }
        }else{
            echo "gagal";
        }
        
    }
?>
</body>
</html>
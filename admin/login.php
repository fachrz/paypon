<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Paypon Admin</title>
</head>
<body>
<?php
require_once('../config/db_config.php');
?>
<div class="login-container">
    <i class="fas fa-money-bill-wave"></i>
    <h1>Paypon Admin</h1>
    <form action="" method="post" class="login-form border">
    <div class="form-group">
        <label for="exampleInputEmail1">Username</label>
        <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <button type="submit" name="admin-login" class="btn btn-primary btn-block">Submit</button>
    </form>
</div>

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
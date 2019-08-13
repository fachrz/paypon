<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="email" name="email" placeholder="Masukan Email">
        <input type="password" name="password" placeholder="Masukan Password">
        <input type="text" name="nama" placeholder="Masukan Nama">
        <input type="text" name="no_telp" placeholder="Masukan Telp">
        <input type="text" name="alamat" placeholder="Masukan Alamat">
        <input type="submit" name="register" value="Register">
    </form>

    <?php
    require_once('config/db_config.php');

    if (isset($_POST['register'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
        $no_telp = filter_input(INPUT_POST, 'no_telp', FILTER_SANITIZE_STRING);
        $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);

        $query = "INSERT INTO account (email, password, nama, no_telp, alamat) VALUES (:email, :password, :nama, :no_telp, :alamat)";
        $stmt = $dbh->prepare($query);

        $params = array(
            ":email" => $email,
            ":password" => $password,
            ":nama" => $name,
            ":no_telp" => $no_telp,
            ":alamat" => $alamat,
        );

        $user = $stmt->execute($params);

        if ($user) {
            print('register sukses');
        }else{
            print('register gagal');
        }

    }
    ?>
</body>
</html>
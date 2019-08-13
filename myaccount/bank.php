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
        require_once('../config/db_config.php');
        require_once('../config/auth.php');
        $email = $_SESSION['user']['email'];
    ?>
    <form action="" method="post">
        <label for="">Bank</label>
        <select name="bank">
            <?php
                 $q_getbank = "SELECT * FROM tb_bank";
                 $stmt = $dbh->prepare($q_getbank);
                 $stmt->execute();
                 $getbank = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 
                 foreach ($getbank as $option) {?>

                    <option value="<?= $option['kode_bank'] ?>"><?= $option['nama_bank'] ?></option>

                 <?php } ?>
        </select> 
        <label for="">Nomor Rekening</label>
        <input type="text" name="rekening" required>
        <input type="submit" name="reg_bank" value="Hubungkan Bank">
    </form>
    
        <table border="1">
            <tr>
                <th>Nama Bank</th>
                <th>Nomor Rekening</th>
                <th>Option</th>
            </tr>
        
        <?php
        $q_bankregistered = "SELECT * FROM v_rekening WHERE email = :email";
        $params = array(
            ":email" => $email,        
        );
        $stmt = $dbh->prepare($q_bankregistered);
        $stmt->execute($params);
        $bankregistered = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($bankregistered) {
            foreach($bankregistered as $listbank) {?>
                <tr>
                    <td><?= $listbank['nama_bank'] ?></td>
                    <td><?= $listbank['nomor_rekening'] ?></td>
                    <td><a href="bank-remove.php?rek=<?= $listbank['nomor_rekening'] ?>">Putuskan</a></td>
                </tr>
            <?php } 
        } ?>
        </table>

    <?php
        if (isset($_POST['reg_bank'])) {
            $bank = filter_input(INPUT_POST, 'bank', FILTER_SANITIZE_STRING);
            $rekening = filter_input(INPUT_POST, 'rekening', FILTER_SANITIZE_STRING);
            
            $q_bankregister = "INSERT INTO tb_rekening VALUES (:email, :kode_bank, :nomor_rekening)";
            $params = array(
                ":email" => $email,
                ":kode_bank" => $bank,
                ":nomor_rekening" => $rekening,
                
            );
            $stmt = $dbh->prepare($q_bankregister);
            $bankregister = $stmt->execute($params);
            if ($bankregister) {
                header("Location: bank.php");   
            }else{
                print('Bank gagal di hubungkan');
            }
        }

        
        ?>
</body>
</html>
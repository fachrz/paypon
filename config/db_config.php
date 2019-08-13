<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "paypon_db";
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi bermasalah :".$e->getMessage();
    die;
}

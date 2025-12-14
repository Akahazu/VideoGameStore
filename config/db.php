<?php
// Cek apakah kode berjalan di server (Railway) atau di komputer lokal
$host = getenv('MYSQLHOST') ? getenv('MYSQLHOST') : "localhost";
$user = getenv('MYSQLUSER') ? getenv('MYSQLUSER') : "root";
$pass = getenv('MYSQLPASSWORD') ? getenv('MYSQLPASSWORD') : "";
$db   = getenv('MYSQLDATABASE') ? getenv('MYSQLDATABASE') : "gamestore";
$port = getenv('MYSQLPORT') ? getenv('MYSQLPORT') : 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

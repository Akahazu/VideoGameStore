<?php
session_start();
session_unset();   // hapus semua session
session_destroy(); // hapus session dari server

header("Location: index.php"); // kembali ke halaman utama
exit;
?>

<?php
session_start();
include "config/db.php";

// Pastikan user login
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

// Pastikan tombol 'pay_now' diklik dari halaman checkout
if(isset($_POST['pay_now'])){
    
    $user_id = $_SESSION['user']['id'];
    $game_id = $_POST['game_id'];
    $payment = $_POST['payment']; // Mengambil metode pembayaran (BCA/Gopay/dll)
    
    // Status default 'Success' (anggap pembayaran langsung berhasil untuk simulasi)
    $status = 'Success'; 

    // Insert ke tabel orders
    // Menggunakan Prepared Statement biar aman
    $stmt = $conn->prepare("INSERT INTO orders (user_id, game_id, payment_method, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $game_id, $payment, $status);
    
    if($stmt->execute()){
        // (Opsional) Kurangi stok game di sini jika mau
        // mysqli_query($conn, "UPDATE games SET stock = stock - 1 WHERE id = '$game_id'");

        // Redirect ke halaman sukses atau kembali ke store
        echo "<script>
            alert('Pembayaran Berhasil via $payment! Terima kasih sudah berbelanja.');
            window.location='store.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal memproses pesanan.');
            window.location='store.php';
        </script>";
    }

} else {
    // Jika user coba akses file ini langsung tanpa lewat checkout
    header("Location: store.php");
    exit;
}
?>
<?php
session_start();
include "config/db.php";

// 1. Cek Login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// 2. Cek ID Game
if (!isset($_GET['id'])) {
    header("Location: store.php");
    exit;
}

$game_id = $_GET['id'];

// Ambil data game
$query = mysqli_query($conn, "SELECT * FROM games WHERE id='$game_id'");
$game  = mysqli_fetch_assoc($query);

if (!$game) {
    echo "Game tidak ditemukan.";
    exit;
}
?>

<!-- Include Header terpisah karena struktur HTML sedikit beda -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Gamestore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; }
        .checkout-container { max-width: 900px; margin: 50px auto; }
    </style>
</head>
<body>

<div class="container checkout-container">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="fw-bold">Checkout Pesanan</h2>
            <a href="store.php" class="text-decoration-none text-muted">&larr; Kembali ke Store</a>
        </div>

        <!-- Bagian Kiri: Detail Produk -->
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Item yang dibeli</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img src="assets/img/<?= $game['image'] ?>" alt="Game" class="rounded" style="width: 100px; height: 100px; object-fit: cover; margin-right: 20px;">
                        <div>
                            <h4 class="mb-1"><?= htmlspecialchars($game['title']) ?></h4>
                            <span class="badge bg-secondary"><?= ucfirst($game['category']) ?> Edition</span>
                            <p class="mt-2 text-muted small"><?= substr($game['description'], 0, 100) ?>...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Metode Pembayaran</h5>
                </div>
                <div class="card-body">
                    <!-- Form ini akan dikirim ke order.php -->
                    <form action="order.php" method="POST" id="checkoutForm">
                        <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                        
                        <div class="mb-3">
                            <div class="form-check p-3 border rounded mb-2">
                                <input class="form-check-input" type="radio" name="payment" value="BCA" id="bca" checked>
                                <label class="form-check-label w-100 fw-bold" for="bca">
                                    Transfer Bank BCA
                                    <span class="float-end text-muted">Dicek Otomatis</span>
                                </label>
                            </div>
                            <div class="form-check p-3 border rounded mb-2">
                                <input class="form-check-input" type="radio" name="payment" value="GoPay" id="gopay">
                                <label class="form-check-label w-100 fw-bold" for="gopay">
                                    GoPay / QRIS
                                    <span class="float-end text-muted">Scan QR</span>
                                </label>
                            </div>
                            <div class="form-check p-3 border rounded">
                                <input class="form-check-input" type="radio" name="payment" value="Dana" id="dana">
                                <label class="form-check-label w-100 fw-bold" for="dana">
                                    DANA
                                    <span class="float-end text-muted">E-Wallet</span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Ringkasan Harga -->
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Harga Produk</span>
                        <span>Rp <?= number_format($game['price']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Diskon</span>
                        <span>- Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya Layanan</span>
                        <span>Rp 2.000</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total Tagihan</strong>
                        <strong class="fs-4 text-primary">Rp <?= number_format($game['price'] + 2000) ?></strong>
                    </div>

                    <!-- Tombol Bayar submit form di sebelah kiri -->
                    <button type="submit" form="checkoutForm" name="pay_now" class="btn btn-dark w-100 btn-lg py-3">Bayar Sekarang</button>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted"><i class="bi bi-shield-lock"></i> Transaksi 100% Aman</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
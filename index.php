<?php 
include "config/db.php";
include "includes/header.php"; 
include "includes/navbar.php";

// Ambil 4 Game Terbaru untuk ditampilkan di Home
$latest_games = mysqli_query($conn, "SELECT * FROM games WHERE category='store' ORDER BY id DESC LIMIT 4");
?>

<!-- 1. HERO SECTION (CAROUSEL SLIDER) -->
<div id="heroCarousel" class="carousel slide shadow-sm" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <!-- Ganti src dengan gambar bannermu sendiri nanti (ukuran rekomen: 1200x400) -->
            <div style="background-color: #333; height: 400px; display: flex; align-items: center; justify-content: center; color: white;">
                <div class="text-center">
                    <h1 class="display-4 fw-bold">Elden Ring: Shadow of the Erdtree</h1>
                    <p class="lead">Mainkan DLC terbaru sekarang juga!</p>
                    <a href="store.php" class="btn btn-light btn-lg mt-3">Beli Sekarang</a>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item">
            <div style="background-color: #555; height: 400px; display: flex; align-items: center; justify-content: center; color: white;">
                <div class="text-center">
                    <h1 class="display-4 fw-bold">Diskon Spesial Akhir Tahun</h1>
                    <p class="lead">Potongan harga hingga 50% untuk game pilihan.</p>
                    <a href="store.php" class="btn btn-outline-light btn-lg mt-3">Lihat Promo</a>
                </div>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item">
            <div style="background-color: #777; height: 400px; display: flex; align-items: center; justify-content: center; color: white;">
                <div class="text-center">
                    <h1 class="display-4 fw-bold">Punya Game Tidak Terpakai?</h1>
                    <p class="lead">Tukarkan game lama kamu dengan yang baru di Trade Center.</p>
                    <a href="trade.php" class="btn btn-warning btn-lg mt-3 text-dark">Trade Sekarang</a>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- 2. WHY CHOOSE US (INFO) -->
<div class="container mt-5">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card border-0 bg-light py-4">
                <h1 class="display-6">⚡</h1>
                <h5 class="fw-bold">Pengiriman Instan</h5>
                <p class="text-muted small px-3">Kode game dikirim otomatis ke email kamu detik itu juga setelah pembayaran.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 bg-light py-4">
                <h1 class="display-6">🔒</h1>
                <h5 class="fw-bold">Transaksi Aman</h5>
                <p class="text-muted small px-3">Pembayaran terproteksi dan garansi uang kembali jika kode bermasalah.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 bg-light py-4">
                <h1 class="display-6">🔄</h1>
                <h5 class="fw-bold">Fitur Trade-In</h5>
                <p class="text-muted small px-3">Satu-satunya platform yang menerima tukar tambah game digital bekas.</p>
            </div>
        </div>
    </div>
</div>

<!-- 3. NEW ARRIVALS (PREVIEW PRODUK) -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold">Game Terbaru</h2>
        <a href="store.php" class="btn btn-outline-dark btn-sm">Lihat Semua &rarr;</a>
    </div>

    <div class="row">
        <?php while($g = mysqli_fetch_assoc($latest_games)) { ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <!-- Gambar -->
                    <div style="height: 180px; overflow: hidden;">
                        <img src="assets/img/<?= $g['image'] ?>" class="card-img-top" style="object-fit: cover; height: 100%; width: 100%;" alt="<?= $g['title'] ?>">
                    </div>
                    
                    <div class="card-body">
                        <h6 class="card-title fw-bold"><?= htmlspecialchars($g['title']) ?></h6>
                        <p class="text-success fw-bold small">Rp <?= number_format($g['price']) ?></p>
                        <a href="checkout.php?id=<?= $g['id'] ?>" class="btn btn-dark w-100">Beli Sekarang</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- 4. CALL TO ACTION (CTA) -->
<div class="container-fluid bg-dark text-white text-center py-5 mt-5">
    <div class="container">
        <h2 class="fw-bold">Siap Bermain?</h2>
        <p class="lead text-light">Bergabunglah dengan ribuan gamer lainnya sekarang.</p>
        <?php if(!isset($_SESSION['user'])): ?>
            <a href="register.php" class="btn btn-primary btn-lg px-5">Daftar Gratis</a>
        <?php else: ?>
            <a href="store.php" class="btn btn-primary btn-lg px-5">Belanja Sekarang</a>
        <?php endif; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
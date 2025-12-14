<?php 
include "config/db.php";
include "includes/header.php";
include "includes/navbar.php";

$games = mysqli_query($conn, "SELECT * FROM games WHERE category='store'");
?>

<div class="container mt-5">
    <h2 class="mb-4 border-bottom pb-2">Game Store</h2>
    <div class="row">
        <?php while($g = mysqli_fetch_assoc($games)) { ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <!-- Placeholder Image jika gambar rusak/kosong -->
                    <img src="assets/img/<?= $g['image'] ?>" class="card-img-top" alt="<?= $g['title'] ?>" style="height: 200px; object-fit: cover; background:#ddd;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($g['title']) ?></h5>
                        <p class="card-text fw-bold text-success">Rp <?= number_format($g['price'], 0, ',', '.') ?></p>
                        <p class="card-text small text-muted"><?= substr($g['description'], 0, 50) ?>...</p>
                        
                        <div class="mt-auto">
                            <?php if(isset($_SESSION['user'])): ?>
                                <a href="checkout.php?id=<?= $g['id'] ?>" class="btn btn-dark w-100">Beli Sekarang</a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-outline-secondary w-100">Login untuk Beli</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
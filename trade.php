<?php 
include "config/db.php";
include "includes/header.php";
include "includes/navbar.php";

$games = mysqli_query($conn, "SELECT * FROM games WHERE category='trade'");
?>

<div class="container mt-5">
    <div class="alert alert-secondary">
        <strong>Trade Center:</strong> Temukan game bekas berkualitas atau tukarkan game kamu disini.
    </div>
    <div class="row">
        <?php while($g = mysqli_fetch_assoc($games)) { ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="assets/img/<?= $g['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover; background:#ddd;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($g['title']) ?></h5>
                        <p class="badge bg-warning text-dark">Available for Trade</p>
                        <p class="card-text">Estimasi Nilai: Rp <?= number_format($g['price'], 0, ',', '.') ?></p>
                        
                         <?php if(isset($_SESSION['user'])): ?>
                            <a href="#" class="btn btn-outline-dark w-100">Ajukan Tukar</a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-outline-secondary w-100">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">GAMESTORE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="store.php">Store</a></li>
        <li class="nav-item"><a class="nav-link" href="trade.php">Trade</a></li>
      </ul>
      
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user'])): ?>
            <!-- Jika Login -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    Halo, <?= htmlspecialchars($_SESSION['user']['name']) ?>
                </a>
                <ul class="dropdown-menu">
                    <?php if($_SESSION['user']['role'] == 'admin'): ?>
                        <li><a class="dropdown-item" href="admin/index.php">Admin Dashboard</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        <?php else: ?>
            <!-- Jika Tamu -->
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="btn btn-outline-dark btn-sm ms-2" href="register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
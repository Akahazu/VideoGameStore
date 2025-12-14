<?php
include "config/db.php";
include "includes/header.php"; 
include "includes/navbar.php";

if (isset($_POST['register'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];

    // 1. Cek Email
    $check = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        // 2. Enkripsi Password
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        
        // 3. Insert dengan aman
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $name, $email, $hashed_pass);
        
        if($stmt->execute()){
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
        } else {
            $error = "Gagal mendaftar.";
        }
    }
}
?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card p-4">
        <h3 class="text-center mb-4">Register</h3>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required></div>
            <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
            <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
            <button class="btn btn-primary w-100" name="register">Daftar Sekarang</button>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>
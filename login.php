<?php
include "config/db.php"; // Session start ada di header, jadi include db dulu, header nanti
// Tapi header.php ada session_start(), jadi urutan: include db -> logika php -> include header

// Logic Login
$error = "";
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $data  = mysqli_fetch_assoc($query);

    if($data){
        // Verifikasi Hash Password
        if(password_verify($pass, $data['password'])){
            // Simpan Session User
            session_start(); // Start session disini jika belum diload header
            $_SESSION['user'] = [
                'id' => $data['id'],
                'name' => $data['name'],
                'role' => $data['role']
            ];
            
            // Redirect sesuai role
            if($data['role'] == 'admin'){
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container mt-5" style="max-width: 400px;">
    <div class="card p-4">
        <h3 class="text-center mb-4">Login</h3>
        <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
            <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
            <button class="btn btn-dark w-100" name="login">Masuk</button>
        </form>
        <div class="text-center mt-3">
            <small>Belum punya akun? <a href="register.php">Daftar disini</a></small>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
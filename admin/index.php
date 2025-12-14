<?php
session_start();
include "../config/db.php";

// 1. Cek Login & Role Admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// 2. Handle Tambah Game & Upload Gambar
if(isset($_POST['add_game'])){
    $title = $_POST['title'];
    $price = $_POST['price'];
    $cat   = $_POST['category'];
    $desc  = $_POST['desc'];

    // Logika Upload Gambar
    $img_name = $_FILES['image']['name']; // Nama file asli
    $img_tmp  = $_FILES['image']['tmp_name']; // Lokasi sementara
    $img_err  = $_FILES['image']['error'];

    // Cek ada gambar yang diupload atau tidak
    if($img_err === 0){
        // Ekstensi yang diperbolehkan
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

        if(in_array($img_ext, $allowed_ext)){
            // Buat nama file baru yang unik (biar tidak bentrok)
            $new_img_name = uniqid("GAME-", true) . '.' . $img_ext;
            
            // Lokasi penyimpanan (folder assets/img di luar folder admin)
            $upload_path = '../assets/img/' . $new_img_name;

            // Pindahkan file
            move_uploaded_file($img_tmp, $upload_path);
        } else {
            echo "<script>alert('Format gambar harus JPG, JPEG, PNG, atau WEBP!');</script>";
            $new_img_name = "default.jpg"; // Fallback jika format salah
        }
    } else {
        $new_img_name = "default.jpg"; // Fallback jika tidak ada gambar
    }

    // Insert ke Database
    $stmt = $conn->prepare("INSERT INTO games (title, price, category, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $title, $price, $cat, $desc, $new_img_name);
    
    if($stmt->execute()){
        echo "<script>alert('Game berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
}

// 3. Handle Hapus Game & Gambarnya
if(isset($_GET['del'])){
    $id = $_GET['del'];
    
    // Ambil nama file gambar dulu untuk dihapus dari folder
    $query_img = mysqli_query($conn, "SELECT image FROM games WHERE id='$id'");
    $data_img  = mysqli_fetch_assoc($query_img);
    
    // Hapus file gambar jika bukan default
    if($data_img['image'] != 'default.jpg' && file_exists("../assets/img/" . $data_img['image'])){
        unlink("../assets/img/" . $data_img['image']);
    }

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM games WHERE id='$id'");
    header("Location: index.php");
}

$games = mysqli_query($conn, "SELECT * FROM games ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard - Gamestore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <div class="d-flex gap-2">
            <a href="../index.php" class="btn btn-outline-light btn-sm">Lihat Web</a>
            <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <!-- Form Tambah Game -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Tambah Game Baru</h5>
                </div>
                <div class="card-body">
                    <!-- Penting: enctype="multipart/form-data" wajib ada untuk upload file -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label class="form-label">Judul Game</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Kategori</label>
                            <select name="category" class="form-control">
                                <option value="store">Store (Baru)</option>
                                <option value="trade">Trade (Bekas/Tukar)</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Gambar Sampul</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <small class="text-muted">Format: jpg, png, webp</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="desc" class="form-control" rows="3"></textarea>
                        </div>

                        <button name="add_game" class="btn btn-success w-100">Simpan Data</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Data Game -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Daftar Game</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Img</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($games)): ?>
                                <tr>
                                    <td>
                                        <img src="../assets/img/<?= $row['image'] ?>" class="img-thumb" alt="icon">
                                    </td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td>
                                        <?php if($row['category'] == 'store'): ?>
                                            <span class="badge bg-primary">Store</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Trade</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>Rp <?= number_format($row['price']) ?></td>
                                    <td>
                                        <a href="index.php?del=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus game ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
session_start();

// Hanya admin yang boleh masuk
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Anda tidak memiliki akses!'); window.location='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Poppins', sans-serif;
        }
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #212529;
            color: white;
            position: fixed;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            padding: 12px;
            color: #bdbdbd;
            margin-bottom: 8px;
            text-decoration: none;
            border-radius: 6px;
        }
        .sidebar a:hover {
            background: #495057;
            color: white;
        }
        .content {
            margin-left: 280px;
            padding: 30px;
        }
        .card-custom {
            border-radius: 12px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 class="mb-4">⚙️ Admin Panel</h3>
    
    <a href="admin_dashboard.php">🏠 Dashboard</a>   
    <a href="add_dosen.php">➕ Tambah Dosen</a>
    <a href="daftar_dosen.php">👨‍🏫 Daftar Dosen</a>

    <hr class="bg-light">

    <a href="../logout.php" class="text-danger fw-bold">🚪 Logout</a>
</div>

<div class="content">
    <h2 class="fw-bold mb-4">Selamat Datang, <?= $_SESSION['nama']; ?> 👋</h2>

    <div class="row">

     <!-- Tambah Dosen -->
        <div class="col-md-6 mb-4">
            <div class="card shadow card-custom p-4">
                <h4 class="fw-bold">👨‍🏫 Tambah Dosen</h4>
                <p>Gunakan menu ini untuk menambahkan akun dosen baru.</p>
                <a href="add_dosen.php" class="btn btn-success">Tambah Dosen</a>
            </div>
        </div>

        <!-- Daftar Dosen -->
        <div class="col-md-6 mb-4">
            <div class="card shadow card-custom p-4">
                <h4 class="fw-bold">📋 Daftar Dosen</h4>
                <p>Lihat semua akun dosen yang terdaftar di sistem.</p>
                <a href="daftar_dosen.php" class="btn btn-primary">Lihat Daftar Dosen</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>

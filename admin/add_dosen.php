<?php
session_start();

// Cek apakah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Anda tidak memiliki akses!'); window.location.href='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Akun Dosen</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

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
        padding: 25px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3 class="mb-4">⚙️ Admin Panel</h3>

    <a href="admin_dashboard.php">🏠 Dashboard</a>
    <a href="add_dosen.php" style="background:#495057; color:white;">➕ Tambah Dosen</a>
    <a href="daftar_dosen.php">👨‍🏫 Daftar Dosen</a>

    <hr class="bg-light">

    <a href="../logout.php" class="text-danger fw-bold">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
    <div class="card-custom">
        <h3 class="mb-3 fw-bold">➕ Tambah Akun Dosen</h3>

        <form action="proses_add_dosen.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Nama Dosen</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">NIP / Username</label>
                <input type="text" name="nim" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jurusan</label>
                <select name="jurusan" class="form-select" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <option>Teknik Mesin</option>
                    <option>Teknik Informatika</option>
                    <option>Manajemen Bisnis</option>
                    <option>Akuntansi</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="text" name="telepon" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="pw" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Tambah Akun</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
session_start();

// Cek apakah user login
$isLogin = isset($_SESSION["user_id"]);

// Jika login, ambil datanya
$nama     = $isLogin ? $_SESSION["nama"] : null;
$nim      = $isLogin ? $_SESSION["nim"] : null;
$jurusan  = $isLogin ? $_SESSION["jurusan"] : null;
$role     = $isLogin ? $_SESSION["role"] : null;
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Teknik Elektronika - Portofolio PBL</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/jurusan.css">
</head>

<body>
  <div class="background"></div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="home.php">
        <img src="download-removebg-preview.png" alt="Logo" width="40" height="40">
        <span class="fw-bold">Portofolio PBL</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav me-3">
          <li class="nav-item"><a class="nav-link" href="home.php">Beranda</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="dropdown">Portofolio</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="Teknik Informatika.php">Teknik Informatika</a></li>
              <li><a class="dropdown-item active" href="#">Teknik Elektro</a></li>
              <li><a class="dropdown-item" href="Teknik Mesin.php">Teknik Mesin</a></li>
              <li><a class="dropdown-item" href="manajement-bisnis.php">Manajemen Bisnis</a></li>
            </ul>
          </li>

          <li class="nav-item"><a class="nav-link" href="about.php">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Kontak</a></li>
        </ul>

        <form action="search.php" method="GET" class="d-flex me-3">
                    <input type="text" name="q" class="form-control rounded-pill"
                        style="background-color:rgba(255,255,255,0.8)"
                        placeholder="Cari nama atau NIM..." required>
                    <button type="submit" class="btn btn-primary ms-2">Cari</button>
                </form>

                <!-- Profil / Login -->
                <?php if (isset($_SESSION['user_id'])): ?>

                    <!-- Dropdown Profil -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light rounded-circle p-0 border-0" type="button" data-bs-toggle="dropdown">
                            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" width="40" height="40" class="rounded-circle">
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end text-center p-3" style="min-width: 220px;">
                            <li class="mb-2">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" width="60" height="60" class="rounded-circle border border-light">
                            </li>

                            <li><strong class="text-white"><?= $nama ?></strong></li>
                            <li><small class="text-light"><?= $jurusan ?></small></li>
                            <hr class="dropdown-divider border-light">

                            <li><a class="dropdown-item text-white" href="profil.php">👤 Profil Saya</a></li>

                            <?php if ($role === 'dosen'): ?>
                                <li><a class="dropdown-item text-white" href="riwayat_penilaian.php">📁 Riwayat Penilaian</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item text-white" href="hasil.php">📁 My Portofolio</a></li>
                            <?php endif; ?>

                            <li><a class="dropdown-item text-white" href="logout.php">🚪 Logout</a></li>
                        </ul>
                    </div>

                <?php else: ?>

                    <!-- Tombol Login (user belum login) -->
                    <a href="login.php" class="btn btn-light">Login</a>

                <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero position-relative">
    <div class="container text-center">
      <h1>Teknik Elektronika</h1>
      <p>Menampilkan inovasi, kreativitas, dan solusi digital mahasiswa dalam bidang teknologi informasi.</p>
    </div>
    <div class="hero-divider"></div>
  </section>

  <!-- Proyek Mahasiswa -->
<section class="py-5">
  <div class="container">
    <h3 class="fw-bold mb-4 text-center">Proyek Mahasiswa</h3>

    <div class="row justify-content-center g-4">
      <!-- IoT Project -->
      <div class="col-md-4 d-flex">
        <div class="card p-3 text-center flex-fill">
          <img src="https://cdn-icons-png.flaticon.com/512/2910/2910765.png" width="80" class="mx-auto mb-3" alt="IoT Project">
          <h5 class="text-center"><a href="iot-project.php">IoT Project</a></h5>
          <p class="small text-center">Proyek berbasis sensor dan IoT untuk mengotomatisasi sistem rumah, industri, atau lingkungan.</p>
        </div>
      </div>

      <!-- Robotika -->
      <div class="col-md-4 d-flex">
        <div class="card p-3 text-center flex-fill">
          <img src="https://cdn-icons-png.flaticon.com/512/3022/3022334.png" width="80" class="mx-auto mb-3" alt="Robotika">
          <h5 class="text-center"><a href="robotika.php">Robotika</a></h5>
          <p class="small text-center">Pengembangan robot untuk otomasi, edukasi, maupun kompetisi berbasis mikrokontroler.</p>
        </div>
      </div>

        <!-- Aplikasi IoT -->
        
  </section>

  <footer>
    <p>© 2025 Portofolio PBL | Teknik Informatika | Polibatam</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
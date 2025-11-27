<?php
session_start();

// Jika ingin proteksi, tetap boleh
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Ambil data jika perlu
$nama     = $_SESSION['nama'];
$nim      = $_SESSION['nim'];
$jurusan  = $_SESSION['jurusan'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tentang Kami — Portofolio PBL</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2b1055, #7597de);
      color: white;
    }

    .navbar {
      background: rgba(255, 255, 255, 0.1) !important;
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .navbar-brand, .nav-link, .dropdown-item {
      color: #fff !important;
      font-weight: 500;
    }

    .nav-link:hover, .dropdown-item:hover {
      color: #00e6ff !important;
    }

    .navbar .dropdown-menu {
      background: linear-gradient(135deg, rgba(43, 16, 85, 0.95), rgba(117, 151, 222, 0.95)) !important;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(8px);
    }

    .navbar .dropdown-menu a {
      color: #fff !important;
      font-weight: 500;
      transition: 0.3s;
      padding: 10px 20px;
      border-radius: 8px;
    }

    .navbar .dropdown-menu a:hover {
      background: rgba(0, 230, 255, 0.2);
      color: #00e6ff !important;
    }
    footer {
      background: rgba(0, 0, 0, 0.4);
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      padding: 20px 0;
      text-align: center;
      color: #dbe8ff;
      backdrop-filter: blur(15px);
    }
  </style>

</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="home.php">
        <img src="download-removebg-preview.png" width="40" height="40">
        <span class="fw-bold">Portofolio PBL</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav me-3">
          <li class="nav-item"><a class="nav-link" href="home.php">Beranda</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Portofolio</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="Teknik Informatika.php">Teknik Informatika</a></li>
              <li><a class="dropdown-item" href="Teknik Elektro.php">Teknik Elektro</a></li>
              <li><a class="dropdown-item" href="Teknik Mesin.php">Teknik Mesin</a></li>
              <li><a class="dropdown-item" href="Manajemen Bisnis.php">Manajemen Bisnis</a></li>
            </ul>
          </li>

          <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>

        <!-- SEARCH -->
        <form class="d-flex me-3">
          <input class="form-control rounded-pill" style="background-color:rgba(255,255,255,0.8)"
            type="search" placeholder="Cari...">
        </form>

        <!-- USER DROPDOWN -->
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
            <li>
              <hr class="dropdown-divider border-light">
            </li>

            <li><a class="dropdown-item text-white" href="profil.php">👤 Profil Saya</a></li>

            <?php if ($_SESSION['role'] === "dosen"): ?>
              <li><a class="dropdown-item text-white" href="riwayat.php">📜 Riwayat Penilaian</a></li>
            <?php else: ?>
              <li><a class="dropdown-item text-white" href="hasil.php">📁 My Portofolio</a></li>
            <?php endif; ?>


            <li><a class="dropdown-item text-white" href="logout.php">🚪 Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- HALAMAN ABOUT -->
  <section class="py-5 text-center">
    <h2>Tentang Portofolio PBL</h2>
    <p>Platform digital karya mahasiswa Polibatam berbasis Project Based Learning.</p>
  </section>

  <!-- ABOUT SECTION -->
  <section class="py-5">
    <div class="container">
      <div class="row align-items-center justify-content-center g-5">
        <div class="col-lg-6">
          <h3 class="fw-bold mb-3">Siapa Kami?</h3>
          <p>
            <strong>Portofolio PBL</strong> adalah wadah digital bagi mahasiswa Politeknik Negeri Batam untuk menampilkan hasil karya dan proyek mereka.
            Melalui pendekatan <i>Project Based Learning</i>, kami mendorong mahasiswa untuk belajar langsung dari pengalaman nyata
            dan membangun solusi inovatif yang berdampak.
          </p>
          <p>
            Website ini dirancang agar setiap proyek dapat diakses oleh dosen, mahasiswa, maupun masyarakat luas
            sebagai bentuk transparansi, dokumentasi, dan inspirasi bagi generasi berikutnya.
          </p>

          <div class="mt-4 d-flex flex-column gap-3">
            <div class="point-card d-flex align-items-start gap-3">
              <div class="fs-3">💡</div>
              <div>
                <h5 class="fw-semibold mb-1">Inovatif</h5>
                <p class="mb-0 small">Mendorong pengembangan ide-ide baru yang solutif dan kreatif.</p>
              </div>
            </div>

            <div class="point-card d-flex align-items-start gap-3">
              <div class="fs-3">🤝</div>
              <div>
                <h5 class="fw-semibold mb-1">Kolaboratif</h5>
                <p class="mb-0 small">Menumbuhkan budaya kerja sama lintas jurusan dan disiplin ilmu.</p>
              </div>
            </div>

            <div class="point-card d-flex align-items-start gap-3">
              <div class="fs-3">🚀</div>
              <div>
                <h5 class="fw-semibold mb-1">Terarah</h5>
                <p class="mb-0 small">Fokus pada hasil yang aplikatif dan memberikan dampak nyata.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5 text-center">
          <img src="https://cdn-icons-png.flaticon.com/512/11084/11084256.png" alt="Ilustrasi PBL" class="img-fluid rounded-4 shadow-lg" style="max-width: 350px;">
        </div>
      </div>
    </div>
  </section>


  <footer class="text-center py-3">
    <p>© 2025 Portofolio PBL | Polibatam | All Rights Reserved</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
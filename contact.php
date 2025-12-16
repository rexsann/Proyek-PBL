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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portofolio PBL - Contact</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2b1055, #7597de);
      color: white;
    }

    .navbar {
      background: rgba(255, 255, 255, 0.1) !important;
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    .main-content {
  flex: 1;
}

    .navbar-brand,
    .nav-link,
    .dropdown-item {
      color: #fff !important;
      font-weight: 500;
    }

    .nav-link:hover,
    .dropdown-item:hover {
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

    .contact-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 30px;
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
          <li class="nav-item"><a class="nav-link" href="about.php">Tentang</a></li>
          <li class="nav-item"><a class="nav-link active" href="contact.php">Kontak</a></li>
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
                <li><a class="dropdown-item text-white" href="riwayat.php">📁 Riwayat Penilaian</a></li>
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

  <!-- CONTACT FORM -->
  <main class="main-content">
  <section class="contact-section py-5">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-5">
          <h3 class="fw-bold mb-3">Hubungi Kami</h3>
          <p>Kirimkan pesan Anda melalui formulir berikut:</p>
          <ul class="list-unstyled mt-3">
            <li><i class="bi bi-geo-alt-fill text-info me-2"></i>Politeknik Negeri Batam</li>
            <li><i class="bi bi-envelope-fill text-info me-2"></i>portofoliopbl@polibatam.ac.id</li>
            <li><i class="bi bi-telephone-fill text-info me-2"></i>+62 812 3456 7890</li>
          </ul>
        </div>
        <div class="col-lg-6">
          <div class="contact-card">
            <form id="contactForm" method="POST" action="send_massage.php">
              <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Pesan</label>
                <textarea class="form-control" name="pesan" rows="4" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  </main>

  <footer class="text-center">
    <p>© 2025 Portofolio PBL | Polibatam</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const data = new FormData(form);

      fetch(form.action, {
          method: 'POST',
          body: data
        })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            Swal.fire('Berhasil!', res.message, 'success');
            form.reset();
          } else {
            Swal.fire('Gagal!', res.message, 'error');
          }
        })
        .catch(() => {
          Swal.fire('Error!', 'Tidak bisa menghubungi server.', 'error');
        });
    });
  </script>
</body>

</html>
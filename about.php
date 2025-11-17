<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tentang Kami — Portofolio PBL (Glass Style)</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2b1055, #7597de);
      color: white;
      overflow-x: hidden;
    }

    .background {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 0%, transparent 40%),
                  radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 40%);
      filter: blur(40px);
      z-index: 0;
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

    .hero {
      text-align: center;
      padding: 120px 20px;
      position: relative;
      z-index: 1;
    }

    .hero h2 {
      font-weight: 700;
      text-shadow: 0 0 15px rgba(0, 230, 255, 0.6);
    }

    .hero p {
      max-width: 700px;
      margin: 15px auto;
      color: #dbe8ff;
    }

    .hero-divider {
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80%;
      height: 3px;
      border-radius: 50px;
      background: linear-gradient(90deg, rgba(0,198,255,0) 0%, rgba(0,198,255,0.8) 50%, rgba(0,198,255,0) 100%);
      box-shadow: 0 0 15px rgba(0,198,255,0.6);
      animation: pulseGlow 3s infinite ease-in-out;
    }

    @keyframes pulseGlow {
      0%, 100% { box-shadow: 0 0 10px rgba(0,198,255,0.4); opacity: 0.8; }
      50% { box-shadow: 0 0 25px rgba(0,198,255,0.9); opacity: 1; }
    }

    .point-card {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255,255,255,0.2);
      backdrop-filter: blur(20px);
      border-radius: 15px;
      padding: 15px 20px;
      color: white;
      transition: 0.3s;
    }

    .point-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 15px rgba(0,230,255,0.4);
    }

    h3.fw-bold, h5.fw-semibold {
      text-shadow: 0 0 10px rgba(0, 230, 255, 0.4);
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
  <div class="background"></div>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="home.html">
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
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Portofolio</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="Teknik Informatika.php">Teknik Informatika</a></li>
              <li><a class="dropdown-item" href="Teknik Elektro.php">Teknik Elektro</a></li>
              <li><a class="dropdown-item" href="Teknik Mesin.php">Teknik Mesin</a></li>
              <li><a class="dropdown-item" href="Manajemen Bisnis.php">Manajemen Bisnis</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link active" href="#">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>

        <form class="d-flex me-3">
          <input class="form-control rounded-pill" style="background-color:rgba(255,255,255,0.8)" type="search" placeholder="Cari...">
        </form>

        <div class="dropdown">
          <button class="btn btn-outline-light rounded-circle p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" width="40" height="40" class="rounded-circle">
          </button>
          <ul class="dropdown-menu dropdown-menu-end text-center p-3" style="min-width: 220px;">
            <li class="mb-2">
              <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" width="60" height="60" class="rounded-circle border border-light">
            </li>
            <li><strong class="text-white" id="profileName">Surya Dewata</strong></li>
            <li><small class="text-light" id="profileJurusan">Mahasiswa</small></li>
            <li><hr class="dropdown-divider border-light"></li>
            <li><a class="dropdown-item text-white" href="profil.php">👤 Profil Saya</a></li>
            <li><a class="dropdown-item text-white" href="hasil.php" id="portoLink">📁 My Portofolio</a></li>
            <li><a class="dropdown-item text-white" href="#" id="logoutBtn">🚪 Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero position-relative">
    <div class="container">
      <h2>Tentang Portofolio PBL</h2>
      <p>Platform yang mendukung kreativitas, kolaborasi, dan inovasi mahasiswa Polibatam melalui Project Based Learning.</p>
    </div>
    <div class="hero-divider"></div>
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

  <footer>
    <p>© 2025 Portofolio PBL | Polibatam | All Rights Reserved</p>
  </footer>

  <!-- SCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Ambil user dari localStorage
    const currentUser = JSON.parse(localStorage.getItem("currentUser"));

    // Proteksi login
    if (!currentUser) {
      Swal.fire({
        icon: "warning",
        title: "Login Diperlukan",
        text: "Silakan login terlebih dahulu untuk mengakses halaman ini.",
        confirmButtonText: "Login Sekarang",
        confirmButtonColor: "#00bfff",
        allowOutsideClick: false,
        allowEscapeKey: false
      }).then(() => {
        window.location.href = "login.php";
      });
    } else {
      document.getElementById("profileName").textContent = currentUser.nama || "Pengguna";
      document.getElementById("profileJurusan").textContent = currentUser.jurusan || "Mahasiswa";
    }

    // Logout
    document.getElementById("logoutBtn").addEventListener("click", (e) => {
      e.preventDefault();
      if (!currentUser) return;
      Swal.fire({
        icon: "warning",
        title: "Logout?",
        text: "Apakah Anda yakin ingin keluar?",
        showCancelButton: true,
        confirmButtonText: "Ya, Logout",
        cancelButtonText: "Batal",
        confirmButtonColor: "#e74c3c"
      }).then(result => {
        if (result.isConfirmed) {
          localStorage.removeItem("currentUser");
          localStorage.removeItem("isDosen");
          Swal.fire({
            icon: "success",
            title: "Berhasil Logout",
            showConfirmButton: false,
            timer: 1500
          }).then(() => window.location.href = "login.php");
        }
      });
    });

    // Proteksi link profil & hasil
    document.querySelectorAll('a[href="profil.php"], a[href="hasil.php"]').forEach(link => {
      link.addEventListener("click", (e) => {
        if (!currentUser) {
          e.preventDefault();
          Swal.fire({
            icon: "warning",
            title: "Login Diperlukan",
            text: "Silakan login terlebih dahulu.",
            confirmButtonText: "Login Sekarang",
            confirmButtonColor: "#00bfff"
          }).then(() => window.location.href = "login.php");
        }
      });
    });

    // Role handling dosen/mahasiswa
    const isDosen = localStorage.getItem("isDosen") === "true";
    const portoLink = document.getElementById("portoLink");
    if (isDosen && portoLink) {
      portoLink.textContent = "📜 Riwayat Penilaian";
      portoLink.href = "riwayat.php";
    } else if (portoLink) {
      portoLink.href = "hasil.php";
    }
  </script>
</body>
</html>

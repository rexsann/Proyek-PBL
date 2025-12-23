<?php
session_start();
include './config/koneksi.php';

// Ambil data session (gunakan null jika tidak login)
$nama     = $_SESSION['nama']     ?? null;
$jurusan  = $_SESSION['jurusan']  ?? null;
$nim      = $_SESSION['nim']      ?? null;
$role     = $_SESSION['role']     ?? null;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio PBL - Beranda</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="background"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img src="download-removebg-preview.png" alt="Logo" width="40" height="40">
                <span class="fw-bold">Portofolio PBL</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav me-3">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Portofolio</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="Teknik Informatika.php">Teknik Informatika</a></li>
                            <li><a class="dropdown-item" href="Teknik Elektro.php">Teknik Elektro</a></li>
                            <li><a class="dropdown-item" href="Teknik Mesin.php">Teknik Mesin</a></li>
                            <li><a class="dropdown-item" href="manajement-bisnis.php">Manajemen Bisnis</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="about.php">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Kontak</a></li>
                </ul>

                <!-- Search -->
                <!-- Search Form -->
<form action="search.php" method="GET" class="navbar-search d-flex me-3">
    <input type="text" name="q" class="form-control rounded-pill"
        style="background-color:rgba(255,255,255,0.8)"
        placeholder="Cari nama atau NIM..." required>
    <button type="submit" class="btn btn-primary ms-2">Cari</button>
</form>

<!-- Profil / Login -->
<?php if (isset($_SESSION['user_id'])): ?>

    <div class="dropdown navbar-profile">
        <button class="btn btn-outline-light rounded-circle p-0 border-0" 
                type="button" data-bs-toggle="dropdown">
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" 
                 width="40" height="40" class="rounded-circle">
        </button>

        <ul class="dropdown-menu dropdown-menu-end text-center p-3" style="min-width: 220px;">
            <li class="mb-2">
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" 
                     width="60" height="60" class="rounded-circle border border-light">
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

    <a href="login.php" class="btn btn-primary">Login</a>

<?php endif; ?>


            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero position-relative">
        <div class="container">
            <h1>Selamat Datang di Portofolio PBL</h1>
            <p>Website ini menampilkan hasil karya dan proyek Project Based Learning sebagai dokumentasi hasil kerja tim dan inovasi mahasiswa.</p>
        </div>
        <div class="hero-divider"></div>
    </section>

    <!-- Proyek Unggulan -->
    <section class="py-5">
        <div class="container">
            <h3 class="fw-bold mb-4">Proyek Unggulan</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card p-3 text-center">
                        <h5><a href="#">Sistem Informasi Akademik</a></h5>
                        <p class="small mt-2">Aplikasi untuk manajemen data mahasiswa, dosen, dan perkuliahan.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3 text-center">
                        <h5><a href="#">Website UMKM</a></h5>
                        <p class="small mt-2">Platform promosi digital untuk usaha menengah.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3 text-center">
                        <h5><a href="#">Aplikasi Mobile Edukasi</a></h5>
                        <p class="small mt-2">Aplikasi pembelajaran interaktif untuk pelajar sekolah menengah.</p>
                    </div>
                </div>
            </div>

            <h3 class="fw-bold mt-5 mb-4">Jurusan</h3>
            <div class="row g-4">
    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/906/906343.png"
                 width="60"
                 class="mx-auto d-block mb-2">
            <a href="Teknik Informatika.php" class="fw-bold d-block">
                Teknik Informatika
            </a>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/1076/1076333.png"
                 width="60"
                 class="mx-auto d-block mb-2">
            <a href="Teknik Mesin.php" class="fw-bold d-block">
                Teknik Mesin
            </a>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/2714/2714516.png"
                 width="60"
                 class="mx-auto d-block mb-2">
            <a href="Teknik Elektro.php" class="fw-bold d-block">
                Teknik Elektro
            </a>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/3176/3176363.png"
                 width="60"
                 class="mx-auto d-block mb-2">
            <a href="manajement-bisnis.php" class="fw-bold d-block">
                Manajemen Bisnis
            </a>
        </div>
    </div>
</div>

        </div>
    </section>

    <!-- Tim Kami -->
    <section class="py-5 text-center">
        <div class="container">
            <h3 class="fw-bold mb-4">Tim Kami</h3>
            <div class="row g-4 justify-content-center">
                <div class="col-md-3 d-flex flex-column align-items-center">
                    <img src="WhatsApp Image 2025-10-12 at 21.37.45_54559ebd.jpg" class="team-photo mb-3" alt="Muhammad Ihsan">
                    <b>Muhammad Ihsan</b>
                    <small class="text-light">Full Stack Manager</small>
                </div>

                <div class="col-md-3 d-flex flex-column align-items-center">
                    <img src="foto/wulan.jpg" class="team-photo mb-3" alt="Wulan Fawwazia">
                    <b>Wulan Fawwazia</b>
                    <small class="text-light">Frontend Developer</small>
                </div>

                <div class="col-md-3 d-flex flex-column align-items-center">
                    <img src="foto/rafli.jpg" class="team-photo mb-3" alt="M. Rafli Dwi Saputra">
                    <b>M. Rafli Dwi Saputra</b>
                    <small class="text-light">Backend Developer</small>
                </div>

                <div class="col-md-3 d-flex flex-column align-items-center">
                    <img src="foto/iwan.jpg" class="team-photo mb-3" alt="Iwan Gayus Pasaribu">
                    <b>Iwan Gayus Pasaribu</b>
                    <small class="text-light">Designer</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section class="py-5 text-center">
        <div class="container">
            <h3 class="fw-bold mb-3">Tentang Kami</h3>
            <p>Tim kami terdiri dari mahasiswa yang berdedikasi dalam menciptakan solusi digital melalui pendekatan Project Based Learning (PBL). Kami percaya bahwa setiap proyek adalah peluang untuk belajar dan berinovasi.</p>
        </div>
    </section>

    <!-- Hubungi Kami -->
    <section class="py-5 text-center">
        <div class="container">
            <h3 class="fw-bold mb-3">Hubungi Kami</h3>
            <p>Email: <b>portofoliopbl@polibatam.ac.id</b></p>
            <p>Alamat: Politeknik Negeri Batam, Batam Centre</p>
        </div>
    </section>

    <footer>
        <p>© 2025 Portofolio PBL | Polibatam | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Notifikasi login -->
    <?php if (isset($_SESSION['login_success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: '<?= $_SESSION['login_success']; ?>',
                timer: 1400,
                showConfirmButton: false
            });
        </script>
        <?php unset($_SESSION['login_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['logout_success'])): ?>
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Logout Berhasil',
            text: '<?= $_SESSION['logout_success']; ?>',
            timer: 1400,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['logout_success']); ?>
<?php endif; ?>


</body>

</html>
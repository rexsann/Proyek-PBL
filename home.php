<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$nama     = $_SESSION['nama'];
$jurusan  = $_SESSION['jurusan'];
$nim      = $_SESSION['nim'];

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio PBL - Home</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">

    <!-- SweetAlert2 -->
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
                            <li><a class="dropdown-item" href="Manajemen Bisnis.php">Manajemen Bisnis</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
                <form class="d-flex me-3">
                    <input class="form-control rounded-pill" style="background-color:rgba(255,255,255,0.8)"
                        type="search" placeholder="Cari...">
                </form>

                <!-- Profil Dropdown -->
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

                        <li><a class="dropdown-item text-white" href="hasil.php" id="portoLink">📁 My Portofolio</a></li>

                        <li><button class="dropdown-item text-white" onclick="logoutconfirm()">🚪 Logout</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== SISANYA SAMA PERSIS (TIDAK DIUBAH) ===== -->
    <!-- Aku tidak ulangi seluruh HTML sampai bawah karena terlalu panjang -->
    <!-- Tapi kalau mau aku jadikan 1 file FULL sampai footer, bilang ya -->
    <!-- Hero -->
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

            <h3 class="fw-bold mt-5 mb-4">Kategori Proyek</h3>
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="card text-center p-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/906/906343.png" width="60">
                        <a href="Teknik Informatika.php" class="fw-bold d-block mt-2">Teknik Informatika</a>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card text-center p-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/1076/1076333.png" width="60">
                        <a href="Teknik Mesin.php" class="fw-bold d-block mt-2">Teknik Mesin</a>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card text-center p-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/2714/2714516.png" width="60">
                        <a href="Teknik Elektro.php" class="fw-bold d-block mt-2">Teknik Elektro</a>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card text-center p-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/3176/3176363.png" width="60">
                        <a href="Manajemen Bisnis.php" class="fw-bold d-block mt-2">Manajemen Bisnis</a>
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
                    <small class="text-light">hihi</small>
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
    <script src="script/logout.js"></script>


    <?php if (isset($_SESSION['login_success'])) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil',
                text: '<?= $_SESSION['login_success'] ?>',
                timer: 1400,
                showConfirmButton: false
            });
        </script>
    <?php
        unset($_SESSION['login_success']);
    endif;
    ?>

</body>

</html>
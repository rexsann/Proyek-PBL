<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari SESSION
$nama     = $_SESSION["nama"];
$jurusan  = $_SESSION["jurusan"];
$nim      = $_SESSION["nim"] ?? "-";
$telepon  = $_SESSION["telepon"] ?? "-";

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya - Portofolio PBL</title>

  <!-- Bootstrap 5 -->
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

    .card-glass {
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      backdrop-filter: blur(25px);
      border-radius: 25px;
      padding: 40px;
      box-shadow: 0 0 25px rgba(0,230,255,0.1);
      color: #fff;
      transition: 0.3s;
    }

    .card-glass:hover {
      box-shadow: 0 0 25px rgba(0,230,255,0.4);
      transform: translateY(-5px);
    }

    .profile-img {
      border: 4px solid rgba(255,255,255,0.3);
      border-radius: 50%;
      width: 120px;
      height: 120px;
      object-fit: cover;
      margin-bottom: 20px;
    }

    .btn-back {
      border: none;
      font-weight: 600;
      padding: 12px 25px;
      border-radius: 10px;
      transition: 0.3s;
      background: linear-gradient(135deg, #00ff99, #00c6ff);
      color: white;
    }

    .btn-back:hover {
      box-shadow: 0 0 15px rgba(0,255,150,0.5);
      transform: translateY(-2px);
    }

    h3, p {
      text-shadow: 0 0 8px rgba(0,198,255,0.4);
    }
  </style>
</head>
<body>
  <div class="background"></div>

  <div class="container mt-5">
    <div class="card-glass text-center mx-auto" style="max-width: 600px;">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Profil" class="profile-img">
      
      <h3 class="fw-bold"><?= $nama ?></h3>
      <p class="text-info">Mahasiswa <?= $jurusan ?></p>
      <hr class="border-light">

      <p><b>NIM/NIK :</b> <?= $nim ?></p>
      <p><b>No. Telepon :</b> <?= $telepon ?></p>
      <p><b>Institusi:</b> Politeknik Negeri Batam</p>

      <hr class="border-light">
      <p class="small text-light">
        "Saya adalah mahasiswa yang tertarik dalam pengembangan web dan bisnis digital. 
        Berpengalaman dalam Project Based Learning, saya terus berinovasi untuk menciptakan solusi teknologi yang bermanfaat."
      </p>

      <div class="d-flex justify-content-center gap-2 mt-3">
        <a href="home.php" class="btn btn-back">Kembali ke Beranda</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

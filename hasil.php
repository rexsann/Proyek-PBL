<?php
session_start();
include './config/koneksi.php';

// Proteksi halaman
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('⚠️ Silakan login!'); window.location.href='login.php';</script>";
    exit;
}

$nama = $_SESSION['nama'];
$nim  = $_SESSION['nim'];

// ==============================
// 🔍 Ambil keyword search
// ==============================
$q = isset($_GET['q']) ? trim($_GET['q']) : "";
$search = mysqli_real_escape_string($conn, $q);

// ==============================
// 🔎 Query portofolio milik user
// ==============================
$portfolios = [];

$sql = "
    SELECT * FROM portfolios
    WHERE nim = '$nim'
    AND (
        judul LIKE '%$search%' 
        OR kategori LIKE '%$search%'
        OR nama LIKE '%$search%'
        OR nim LIKE '%$search%'
    )
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $portfolios[] = $row;
}

// Ambil kategori unik
$kategoriList = array_unique(array_map(fn($p) => $p['kategori'], $portfolios));
sort($kategoriList);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Portofolio Saya - Polibatam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2b1055, #7597de);
            color: white;
            min-height: 100vh;
            padding-top: 110px;
        }

        .navbar-custom {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            padding: 10px 30px;
        }

        .navbar-custom img {
            height: 55px;
            border-radius: 10px;
        }

        .form-control { border-radius: 12px; }
        .btn { font-weight: 600; border-radius: 10px; }
        .btn-back { background-color: #ffc107; color: black; border: none; }
        .btn-back:hover { background-color: #e0a800; }

        .btn-upload { background-color: #17a2b8; color: white; }
        .btn-upload:hover { background-color: #0d6efd; }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: .2s;
        }

        .card img {
            width: 100%;
            height: 220px;
            object-fit: contain;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 5px;
        }

        .btn-detail { background-color: #17a2b8; color: white; font-weight: 600; }
        .btn-detail:hover { background-color: #0d6efd; }
    </style>
</head>

<body>

<nav class="navbar-custom d-flex justify-content-between align-items-center flex-wrap">

    <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">
        <img src="download-removebg-preview.png" alt="Logo">
        <h4 class="m-0 fw-bold">Polibatam Portofolio</h4>
    </div>

    <!-- 🔍 FORM SEARCH -->
    <form action="hasil.php" method="GET" class="d-flex me-3">
        <input type="text" name="q" class="form-control"
               placeholder="Cari judul / kategori / nama..."
               value="<?= htmlspecialchars($q) ?>">
    </form>

    <div class="d-flex align-items-center gap-3">
        <select id="kategoriSelect" class="form-select" onchange="filterKategori(this.value)">
            <option value="semua">🌐 Semua Kategori</option>
            <?php foreach ($kategoriList as $k): ?>
                <option value="<?= htmlspecialchars($k) ?>"><?= htmlspecialchars($k) ?></option>
            <?php endforeach; ?>
        </select>
        <a href="home.php" class="btn btn-back">⬅️ Beranda</a>
        <a href="upload.php" class="btn btn-upload">➕ Upload</a>
    </div>

</nav>

<div class="container">
    <h2 class="mt-4 text-center fw-bold">📚 Daftar Portofolio Saya</h2>

    <?php if ($q != ""): ?>
        <p class="text-center mt-2">Hasil pencarian untuk: <b><?= htmlspecialchars($q) ?></b></p>
    <?php endif; ?>

    <div id="portfolioList" class="row g-4 mt-3">
        <?php if (count($portfolios) == 0): ?>
            <p class="text-center">Tidak ada portofolio ditemukan.</p>
        <?php else: ?>
            <?php foreach ($portfolios as $p): ?>
                <div class="col-md-4">
                    <div class="card p-3 h-100">

                        <img src="uploads/posters/<?= htmlspecialchars($p['poster']) ?>"
                             onerror="this.src='https://via.placeholder.com/400x200?text=No+Poster'">

                        <h5 class="fw-bold mt-3"><?= htmlspecialchars($p['judul']) ?></h5>
                        <p class="m-0">
                            <strong><?= htmlspecialchars($p['nama']) ?></strong>
                            (<?= htmlspecialchars($p['nim']) ?>)
                        </p>
                        <p class="small mb-2"><?= htmlspecialchars($p['kategori']) ?></p>

                        <a href="detail_hasil.php?id=<?= $p['id'] ?>" class="btn btn-detail w-100">🔍 Detail</a>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
function filterKategori(k) {
    const cards = document.querySelectorAll('#portfolioList .col-md-4');
    cards.forEach(card => {
        const kategori = card.querySelector('p.small').textContent.trim();
        card.style.display = (k === 'semua' || kategori === k) ? 'block' : 'none';
    });
}
</script>

</body>
</html>

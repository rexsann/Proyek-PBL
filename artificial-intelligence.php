<?php
session_start();
include './config/koneksi.php';

// Cek apakah user login
$isLogin = isset($_SESSION["user_id"]);

// Jika login, ambil datanya
$nama     = $isLogin ? $_SESSION["nama"] : null;
$nim      = $isLogin ? $_SESSION["nim"] : null;
$jurusan  = $isLogin ? $_SESSION["jurusan"] : null;
$role     = $isLogin ? $_SESSION["role"] : null;

// Filter kategori
$kategori = "Artificial Intelligence";

// AMANKAN agar tidak bisa disisipi SQL
$kategori_safe = mysqli_real_escape_string($conn, $kategori);

// Query tanpa prepare()
$sql = "SELECT * FROM portfolios WHERE kategori = '$kategori_safe' ORDER BY tanggal DESC";
$result = mysqli_query($conn, $sql);

// Ambil data
$portfolios = [];
if ($result && mysqli_num_rows($result) > 0) {
    $portfolios = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori: <?= htmlspecialchars($kategori) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/kategori.css">
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="Teknik Informatika.php" class="btn btn-back">⬅️ Kembali</a>
            <h3 class="text-center flex-grow-1">🌐 Kategori: <?= htmlspecialchars($kategori) ?></h3>
        </div>

        <div class="row g-4">
            <?php if (count($portfolios) === 0): ?>
                <p class="text-center fs-5">Belum ada portofolio untuk kategori ini.</p>
            <?php else: ?>
                <?php foreach ($portfolios as $p): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="card w-100 p-3 d-flex flex-column">
                            <img src="uploads/posters/<?= htmlspecialchars($p['poster']) ?>"
                                alt="Poster"
                                onerror="this.src='https://via.placeholder.com/400x200?text=No+Poster';">
                            <h5 class="mt-3"><?= htmlspecialchars($p['judul']) ?></h5>
                            <p class="mb-1"><strong><?= htmlspecialchars($p['nama']) ?></strong> (<?= htmlspecialchars($p['nim']) ?>)</p>
                            <p class="mb-2"><?= htmlspecialchars($p['kategori']) ?></p>
                            <a href="detail_hasil.php?id=<?= $p['id'] ?>&from=<?= urlencode('artificial-intelligence.php') ?>" class="btn btn-detail mt-auto w-100">Detail</a>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>
</body>

</html>
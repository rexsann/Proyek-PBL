<?php
session_start();
include './config/koneksi.php';

// Jika query kosong, kembali ke home
if (!isset($_GET['q']) || trim($_GET['q']) === '') {
    header("Location: home.php");
    exit;
}

$q = trim($_GET['q']);
$q_safe = mysqli_real_escape_string($conn, $q);

// Query pencarian
$sql = "SELECT * FROM portfolios 
        WHERE nama LIKE '%$q_safe%' 
        OR nim LIKE '%$q_safe%'";

$result = mysqli_query($conn, $sql);

$results = [];
while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

// Jika tidak ada hasil
if (count($results) === 0) {
    echo "<script>alert('Portofolio tidak ditemukan!'); window.history.back();</script>";
    exit;
}

// Jika hanya 1 hasil → langsung buka detail_hasil.php
if (count($results) === 1) {
    $data = $results[0];
    header("Location: detail_hasil.php?id=" . $data['id']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian: <?= htmlspecialchars($q) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4" style="background: linear-gradient(135deg, #2b1055, #7597de); color: white;">

    <h3>Hasil pencarian: <b><?= htmlspecialchars($q) ?></b></h3>
    <hr>

    <div class="row">
        <?php foreach ($results as $p): ?>
            <div class="col-md-4 mb-3">
                <div class="card p-3 text-center" style="background: rgba(255,255,255,0.1); border-radius: 15px;">
                    <img src="uploads/posters/<?= htmlspecialchars($p['poster']) ?>" class="card-img-top mb-2"
                        style="height:200px; object-fit:contain; background: rgba(255,255,255,0.1);"
                        onerror="this.src='https://via.placeholder.com/400x200?text=No+Poster';" alt="Poster">

                    <h5><?= htmlspecialchars($p['judul']) ?></h5>
                    <p><strong><?= htmlspecialchars($p['nama']) ?></strong> (<?= htmlspecialchars($p['nim']) ?>)</p>
                    <p><b><?= htmlspecialchars($p['kategori']) ?></b></p>

                    <!-- FIX: langsung masuk ke detail_hasil.php -->
                    <a href="detail_hasil.php?id=<?= $p['id'] ?>&src=search&q=<?= urlencode($q) ?>"
                        class="btn btn-primary w-100 mt-2">
                        Detail
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>
<?php
session_start();
include './config/koneksi.php';

// =============================
// VALIDASI DASAR
// =============================
if (!isset($_POST['portfolio_id'], $_POST['komentar'])) {
    die("Akses tidak valid");
}

$portfolio_id = (int) $_POST['portfolio_id'];
$komentar     = trim($_POST['komentar']);

if ($portfolio_id <= 0 || $komentar === '') {
    die("Data tidak lengkap");
}

// =============================
// TENTUKAN IDENTITAS KOMENTAR
// =============================

// Jika login (mahasiswa)
if (isset($_SESSION['nim'])) {
    $nim  = mysqli_real_escape_string($conn, $_SESSION['nim']);
    $nama = mysqli_real_escape_string($conn, $_SESSION['nama']);
} else {
    // Jika pengunjung
    $nim  = null;
    $nama = isset($_POST['nama']) && $_POST['nama'] !== ''
        ? $_POST['nama']
        : 'Anonim';
    $nama = mysqli_real_escape_string($conn, $nama);
}

// =============================
// AMANKAN KOMENTAR
// =============================
$komentar = mysqli_real_escape_string($conn, $komentar);

// =============================
// SIMPAN KE DATABASE
// =============================
$sql = "
    INSERT INTO komentar_portfolio 
    (portfolio_id, nim, nama, komentar, tanggal)
    VALUES
    (
        $portfolio_id,
        " . ($nim ? "'$nim'" : "NULL") . ",
        '$nama',
        '$komentar',
        NOW()
    )
";

mysqli_query($conn, $sql);

// Ambil ID komentar yang baru dibuat
$last_id = mysqli_insert_id($conn);

// Jika pengunjung, simpan ID komentar di session agar bisa dihapus
if (!isset($_SESSION['visitor_comments'])) {
    $_SESSION['visitor_comments'] = [];
}

if (!$nim) { // hanya untuk pengunjung
    $_SESSION['visitor_comments'][] = $last_id;
}

// =============================
// KEMBALI KE DETAIL
// =============================
header("Location: detail_hasil.php?id=$portfolio_id");
exit;

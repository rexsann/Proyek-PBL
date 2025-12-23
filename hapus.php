<?php
session_start();
include './config/koneksi.php';

// Proteksi halaman
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('⚠️ Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

// Cek ID
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='hasil.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data portofolio
$q = mysqli_query($conn, "SELECT file, poster, gallery FROM portfolios WHERE id='$id'");
$result = mysqli_fetch_assoc($q);

if (!$result) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='hasil.php';</script>";
    exit;
}

// ==========================
// HAPUS KOMENTAR TERKAIT
// ==========================
mysqli_query($conn, "DELETE FROM komentar_portfolio WHERE portfolio_id='$id'");

// ==========================
// HAPUS FILE PDF
// ==========================
if (!empty($result['file'])) {
    $filePath = 'uploads/files/' . $result['file'];
    if (file_exists($filePath)) unlink($filePath);
}

// ==========================
// HAPUS POSTER
// ==========================
if (!empty($result['poster'])) {
    $posterPath = 'uploads/posters/' . $result['poster'];
    if (file_exists($posterPath)) unlink($posterPath);
}

// ==========================
// HAPUS GALERI
// ==========================
$gallery = json_decode($result['gallery'], true);

if (is_array($gallery)) {
    foreach ($gallery as $img) {
        $galleryPath = 'uploads/gallery/' . $img;
        if (file_exists($galleryPath)) unlink($galleryPath);
    }
}

// ==========================
// HAPUS DATA PORTOFOLIO
// ==========================
$delete = mysqli_query($conn, "DELETE FROM portfolios WHERE id='$id'");

if ($delete) {
    echo "<script>alert('✅ Data berhasil dihapus!'); window.location.href='hasil.php';</script>";
} else {
    echo "<script>alert('❌ Gagal menghapus data!'); window.location.href='hasil.php';</script>";
}

exit;
?>

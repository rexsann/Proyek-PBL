<?php
session_start();
include './config/koneksi.php';

if (!isset($_SESSION['nim'])) {
    die("Unauthorized");
}

$id = $_GET['id'];
$pf = $_GET['pf']; // portfolio ID

// =============================
// Cek apakah komentar milik mahasiswa sendiri
// =============================
$q = mysqli_query($conn, "SELECT * FROM komentar_portfolio WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if (!$data || $data['nim'] != $_SESSION['nim']) {
    die("Tidak boleh hapus komentar orang lain");
}

// =============================
// HAPUS KOMENTAR
// =============================
mysqli_query($conn, "DELETE FROM komentar_portfolio WHERE id='$id'");

// Redirect kembali
header("Location: detail_hasil.php?id=$pf");
exit;

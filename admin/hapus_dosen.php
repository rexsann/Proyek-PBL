<?php
session_start();
include '../config/koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Tidak ada akses!'); window.location='login.php';</script>";
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM users WHERE id='$id' AND role='dosen'");

echo "<script>alert('Dosen berhasil dihapus!'); window.location='daftar_dosen.php';</script>";
?>

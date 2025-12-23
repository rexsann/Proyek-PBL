<?php
session_start();
include '../config/koneksi.php';

// Hanya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Tidak ada akses!'); window.location='login.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama       = $_POST['nama'];
    $nim        = $_POST['nim'];
    $jurusan    = $_POST['jurusan'];
    $telepon    = $_POST['telepon'];
    $pw         = $_POST['pw'];   // tetap aman
    $role       = 'dosen';

    // Cek NIM apakah sudah ada
    $check = mysqli_query($conn, "SELECT id FROM users WHERE nim='$nim'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('NIP sudah terdaftar!'); window.history.back();</script>";
        exit;
    }

    // Insert data
    $query = "INSERT INTO users (nama, nim, jurusan, telepon, pw, role)
              VALUES ('$nama', '$nim', '$jurusan', '$telepon', '$pw', '$role')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Akun dosen berhasil ditambahkan!'); window.location='daftar_dosen.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan dosen!'); window.history.back();</script>";
    }
}
?>

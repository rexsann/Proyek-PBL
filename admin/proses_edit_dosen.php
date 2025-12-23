<?php
session_start();
include '../config/koneksi.php';

// Hanya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Anda tidak memiliki akses!'); window.location='login.php';</script>";
    exit;
}

$id       = $_POST['id'] ?? '';
$nama     = $_POST['nama'] ?? '';
$nim      = $_POST['nim'] ?? '';
$jurusan  = $_POST['jurusan'] ?? '';
$telepon  = $_POST['telepon'] ?? '';
$pw       = $_POST['pw'] ?? '';

// Jika password kosong → tidak update password
if ($pw == '') {
    $query = "UPDATE users SET 
                nama='$nama',
                nim='$nim',
                jurusan='$jurusan',
                telepon='$telepon'
              WHERE id='$id'";
} else {
    $query = "UPDATE users SET 
                nama='$nama',
                nim='$nim',
                jurusan='$jurusan',
                telepon='$telepon',
                pw='$pw'
              WHERE id='$id'";
}

$update = mysqli_query($conn, $query);

if ($update) {
    echo "<script>
            alert('Data dosen berhasil diperbarui!');
            window.location='daftar_dosen.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal memperbarui data!');
            window.location='daftar_dosen.php';
          </script>";
}
?>

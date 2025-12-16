<?php
include './config/koneksi.php';
session_start();

$nim = $_POST['nim'];
$password = $_POST['password'];

// Query sama seperti gaya kamu sebelumnya
$data = mysqli_query($conn, "SELECT * FROM users WHERE nim='$nim'");

if (mysqli_num_rows($data) > 0) {

    $row = mysqli_fetch_array($data);

    // Cek password (karena database kamu pakai password biasa)
    if ($password == $row['pw']) {

        // Set session
        $_SESSION['nim']      = $row['nim'];
        $_SESSION['nama']     = $row['nama'];
        $_SESSION['user_id']  = $row['id'];
        $_SESSION['jurusan']  = $row['jurusan'];
        $_SESSION['telepon']  = $row['telepon'];
        $_SESSION['role']     = $row['role'];

        $_SESSION['login_success'] = "Selamat Datang " . $row['nama'] . "!";

        // Redirect berdasarkan role
        if ($row['role'] == 'admin') {
            header("Location: admin/admin_dashboard.php"); // ubah sesuai lokasi halaman admin kamu
            exit();
        } else {
            header("Location: home.php");
            exit();
        }

    } else {
        // Password salah
        $_SESSION['login_error'] = "NIM atau Password salah.";
        header("Location: login.php");
        exit();
    }

} else {
    // Tidak ada user
    $_SESSION['login_error'] = "NIM atau Password salah.";
    header("Location: login.php");
    exit();
}
?>

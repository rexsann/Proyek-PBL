<?php
include 'koneksi.php';
session_start();

$nim = $_POST['nim'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT nim, pw, jurusan, id, telepon, nama FROM users WHERE nim = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {

    $stmt->bind_result($db_nim, $db_pw, $db_jurusan, $db_id, $db_telepon, $db_nama);
    $stmt->fetch();

    if ($password === $db_pw && $nim === $db_nim) {

        $_SESSION['nim']      = $db_nim;
        $_SESSION['nama']     = $db_nama;
        $_SESSION['user_id']  = $db_id;
        $_SESSION['jurusan']  = $db_jurusan;
        $_SESSION['telepon']  = $db_telepon;

        $_SESSION['login_success'] = "Selamat Datang " . $_SESSION['nama'] . "!";

        header("Location: home.php");
        exit();

    } else {
        $_SESSION['login_error'] = "NIM atau Password salah.";
        header("Location: login.php");
        exit();
    }
}

$stmt->close();
$conn->close();
?>

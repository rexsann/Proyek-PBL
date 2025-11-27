<?php
include './config/koneksi.php';
session_start();

$nim = $_POST['nim'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT nim, pw, jurusan, id, telepon, nama, role FROM users WHERE nim = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {

    $stmt->bind_result($db_nim, $db_pw, $db_jurusan, $db_id, $db_telepon, $db_nama, $db_role);
    $stmt->fetch();

    if ($password === $db_pw && $nim === $db_nim) {

        $_SESSION['nim']      = $db_nim;
        $_SESSION['nama']     = $db_nama;
        $_SESSION['user_id']  = $db_id;
        $_SESSION['jurusan']  = $db_jurusan;
        $_SESSION['telepon']  = $db_telepon;
        $_SESSION['role']     = $db_role;

        $_SESSION['login_success'] = "Selamat Datang " . $_SESSION['nama'] . "!";

        // Arahkan berdasarkan role
        if ($db_role === 'dosen') {
            header("Location: dosen_home.php"); 
        } else {
            header("Location: home.php");
        }
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

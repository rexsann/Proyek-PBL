<?php
session_start();
include "../config/koneksi.php";

$message = ""; // untuk menyimpan alert kaca

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nim = $_POST["nim"];
    $password = $_POST["password"];

    // Ambil data user
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE nim='$nim'");

    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        // NIM tidak ditemukan
        $message = "
        <div class='modal-bg'>
            <div class='modal-box'>
                <h4>NIM / NIK tidak ditemukan!</h4>
                <button onclick='closeModal()'>OK</button>
            </div>
        </div>
        ";
    } else {
        // Cek password
        if ($data["password"] == $password) {

            // SIMPAN SEMUA DATA ke SESSION
            $_SESSION["user_id"] = $data["id"];
            $_SESSION["nama"]    = $data["nama"];
            $_SESSION["nim"]     = $data["nim"];
            $_SESSION["jurusan"] = $data["jurusan"];
            $_SESSION["telepon"] = $data["telepon"];

            // ALERT KACA + REDIRECT
            echo "<script>
        setTimeout(function(){
            window.location='home.php';
        }, 500);
    </script>";

            $message = "
    <div class='modal-bg'>
        <div class='modal-box success'>
            <h4>Login Berhasil!</h4>
            <p>Selamat datang kembali 🎉</p>
        </div>
    </div>";
        } else {
            $message = "
            <div class='modal-bg'>
                <div class='modal-box'>
                    <h4>Password salah!</h4>
                    <button onclick='closeModal()'>Coba Lagi</button>
                </div>
            </div>";
        }
    }
}
?>
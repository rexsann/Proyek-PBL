<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari SESSION
$nama     = $_SESSION["nama"];
$jurusan  = $_SESSION["jurusan"];
$isDosen  = isset($_SESSION["role"]) && $_SESSION["role"] === "dosen";
?>


<?php if ($isDosen): ?>
    <li><a class="dropdown-item text-white" href="riwayat.php">📜 Riwayat Penilaian</a></li>
<?php else: ?>
    <li><a class="dropdown-item text-white" href="hasil.php">📁 My Portofolio</a></li>
<?php endif; ?>

<?php
$isDosen  = isset($_SESSION["role"]) && $_SESSION["role"] === "dosen";
?>
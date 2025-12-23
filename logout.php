<?php
session_start();

// Hapus semua data session
$_SESSION = [];
session_unset();
session_destroy();

// Buat session baru khusus untuk notifikasi logout
session_start();
$_SESSION['logout_success'] = "Anda berhasil logout.";

// Arahkan ke halaman login atau home
header("Location: login.php");
exit;

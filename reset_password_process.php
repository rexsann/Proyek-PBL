<?php
session_start();
include "./config/koneksi.php";

$user_id = $_SESSION['reset_user_id'];
$pw = $_POST['password'];

// Update password
mysqli_query($conn, "UPDATE users SET pw='$pw', otp_code=NULL, otp_expired=NULL WHERE id=$user_id");

// Hapus session
unset($_SESSION['reset_user_id']);

// Redirect ke login
header("Location: login.php?reset=success");
exit;
?>

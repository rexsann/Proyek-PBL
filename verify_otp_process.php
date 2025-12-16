<?php
session_start();
include "./config/koneksi.php";

$user_id = $_SESSION['reset_user_id'];
$otp_input = $_POST['otp'];

$query = mysqli_query($conn, "SELECT otp_code, otp_expired FROM users WHERE id=$user_id LIMIT 1");
$data = mysqli_fetch_assoc($query);

if ($otp_input != $data['otp_code']) {
    die("OTP salah!");
}

if (strtotime($data['otp_expired']) < time()) {
    die("OTP kadaluarsa!");
}

header("Location: reset_password.php");
exit;
?>

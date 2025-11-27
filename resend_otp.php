<?php
session_start();
include "config/koneksi.php";

// Pastikan user sudah punya session OTP
if (!isset($_SESSION['reset_user_id'])) {
    echo "INVALID_SESSION";
    exit;
}

$user_id = $_SESSION['reset_user_id'];

// Ambil data user
$query = mysqli_query($conn, "SELECT telepon, otp_expired FROM users WHERE id=$user_id LIMIT 1");
$user = mysqli_fetch_assoc($query);

$telepon = $user['telepon'];

// Format ulang ke 62
if (substr($telepon, 0, 1) === "0") {
    $telepon = "62" . substr($telepon, 1);
}

// Generate OTP baru
$otp = rand(100000, 999999);
$expired = date("Y-m-d H:i:s", strtotime("+5 minutes"));

// Simpan OTP baru ke database
mysqli_query($conn, "UPDATE users SET otp_code='$otp', otp_expired='$expired' WHERE id=$user_id");

// === Kirim OTP via Fonnte ===
$token = "v3PNvwshkfvy3tEmtoHq";

$data = [
    'target' => $telepon,
    'message' => "Kode OTP baru Anda: $otp\n\nJangan bagikan kode ini kepada siapa pun."
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        "Authorization: $token"
    ],
]);

$response = curl_exec($curl);
curl_close($curl);

// Redirect ke halaman verifikasi lagi
header("Location: verify_otp.php?resend=1");
exit;
?>

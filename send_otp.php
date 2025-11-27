<?php
session_start();
include "config/koneksi.php";

$telepon = $_POST['telepon'];

// Format ke 62
if (substr($telepon, 0, 1) === "0") {
    $telepon = "62" . substr($telepon, 1);
}

// Cek apakah nomor ada di database
$query = mysqli_query($conn, "SELECT * FROM users WHERE telepon LIKE '%$telepon%' LIMIT 1");
if (mysqli_num_rows($query) == 0) {
    echo "Nomor tidak terdaftar!";
    exit;
}

$user = mysqli_fetch_assoc($query);

// Generate OTP random 6 digit
$otp = rand(100000, 999999);
$expired = date("Y-m-d H:i:s", strtotime("+5 minutes"));

// Simpan OTP ke database
mysqli_query($conn, "UPDATE users SET otp_code='$otp', otp_expired='$expired' WHERE id=".$user['id']);

// Kirim OTP via Fonnte
$token = "fqRGo6TVUUvHJtiHX3j8";

$data = [
    'target' => $telepon,
    'message' => "Kode OTP Anda adalah: $otp\n\nJangan berikan kode ini kepada siapa pun.\nKode berlaku 5 menit."
];

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
        "Authorization: $token"
    ),
));

$response = curl_exec($curl);
curl_close($curl);

// Simpan session untuk verifikasi
$_SESSION['reset_user_id'] = $user['id'];

header("Location: verify_otp.php");
exit;
?>

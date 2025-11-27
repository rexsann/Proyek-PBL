<?php
session_start();
if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot_password.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verifikasi OTP</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #2b1055, #7597de);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: 25px;
            padding: 40px;
            width: 420px;
            color: white;
            text-align: center;
            box-shadow: 0 0 25px rgba(0, 230, 255, 0.2);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2) !important;
            border: none !important;
            color: white !important;
            border-radius: 20px !important;
            padding: 12px 15px;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .btn-custom {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            color: white;
            border: none;
            border-radius: 20px;
            padding: 12px;
            width: 100%;
            font-weight: 600;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
        }

        a {
            color: #00eaff;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }
</style>

</head>
<body>

<div class="card-glass">
    <h2 class="fw-bold mb-2">Verifikasi OTP</h2>
    <p class="text-white-50 mb-4" style="font-size:14px;">
        Masukkan kode OTP yang telah dikirim ke WhatsApp Anda
    </p>

    <form action="verify_otp_process.php" method="POST">

        <div class="mb-3 text-start">
            <label class="form-label text-white fw-semibold">Kode OTP</label>
            <input type="text" name="otp" class="form-control" placeholder="6 digit kode" maxlength="6" required>
        </div>

        <button type="submit" class="btn-custom mt-2">Verifikasi</button>

        <div class="mt-3" style="font-size:13px;">
            Tidak menerima kode? <a href="resend_otp.php">Kirim ulang OTP</a>
        </div>

        <div class="mt-2">
            <a href="forgot_password.php">Kembali</a>
        </div>
    </form>
</div>

</body>
</html>

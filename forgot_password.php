<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lupa Kata Sandi</title>

  <!-- Bootstrap 5 CSS -->
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
            transition: 0.3s;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            transform: scale(1.03);
        }

        a {
            color: #00eaff;
            font-weight: 600;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
  </style>

</head>

<body>

<div class="card-glass">
    <h2 class="fw-bold mb-2">Lupa Kata Sandi</h2>
    <p class="mb-4" style="font-size:14px;">
        Masukkan nomor telepon Anda. Kami akan mengirimkan kode OTP untuk reset kata sandi.
    </p>

    <form action="send_otp.php" method="POST">

        <div class="mb-3 text-start">
            <label class="form-label">No. Telepon</label>
            <input type="tel" class="form-control" name="telepon" placeholder="Contoh: 62895xxxx" required>
        </div>

        <button type="submit" class="btn-custom mt-3">Kirim OTP</button>

        <div class="mt-3" style="font-size:13px;">
            Kembali ke <a href="login.php">Halaman Login</a>
        </div>
    </form>
</div>

</body>
</html>

<?php
session_start();
include "./config/koneksi.php";

if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot_password.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>

    <!-- Google Fonts -->
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
            border-radius: 25px;
            padding: 40px 35px;
            width: 400px;
            color: white;
            text-align: center;
            box-shadow: 0 0 25px rgba(0, 230, 255, 0.2);
        }

        .input-wrapper {
            width: 100%;
            position: relative;
            margin-bottom: 25px;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.2) !important;
            border: none !important;
            color: white !important;
            border-radius: 15px !important;
            padding: 12px 50px 12px 15px;
            font-size: 15px;
            height: 45px;
            box-sizing: border-box;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .toggle-eye {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: rgba(255, 255, 255, 0.85);
        }

        .toggle-eye:hover {
            color: white;
        }

        .btn-custom {
            width: 100%;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            color: white;
            border: none;
            border-radius: 18px;
            padding: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
        }
    </style>

</head>

<body>

    <div class="card-glass">
        <h2 style="font-weight: 700; margin-bottom: 15px;">Reset Password Baru</h2>
        <p style="opacity: 0.85; margin-bottom: 25px;">Silakan buat password baru untuk akun Anda</p>

        <form action="reset_password_process.php" method="POST">

            <div class="input-wrapper">
                <input type="password" id="pw" name="password" class="form-control" placeholder="Masukkan password baru" required>
                <span class="toggle-eye" onclick="togglePW()">👁️</span>
            </div>

            <button type="submit" class="btn-custom">Simpan Password</button>

        </form>
    </div>

    <script>
        function togglePW() {
            let pw = document.getElementById("pw");
            pw.type = pw.type === "password" ? "text" : "password";
        }
    </script>

</body>

</html>

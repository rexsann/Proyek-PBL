<?php
include "koneksi.php";
session_start();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Akun - Portofolio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">


</head>

<body>

    <div class="card-glass">
        <img src="download-removebg-preview.png" width="70" class="mb-3">

        <h3 class="fw-bold mb-4">Login Akun</h3>

        <form method="POST" action="auth_system.php">
            <div class="mb-3">
                <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM/NIK" required>
            </div>

            <div class="mb-3 position-relative">
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Kata Sandi" required>

                <span class="toggle-eye" onclick="togglePassword()">
                    👁️
                </span>
            </div>


            <button type="submit" class="btn btn-custom w-100">Masuk</button>
        </form>
        <div class="mt-2 justify-content-between m">
            <a href="lupa_password.php" class="text-info me-5">Lupa Password?</a>
            <a href="register.php" class="text-info ms-5">Daftar di sini</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION['login_error'])) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '<?= $_SESSION['login_error'] ?>',
                timer: 1200,
                showConfirmButton: false
            });
        </script>
    <?php
        unset($_SESSION['login_error']);
    endif;
    ?>

    <script>
        function closeModal() {
            document.querySelector('.modal-bg').remove();
        }
    </script>
    <script>
        function togglePassword() {
            let pass = document.getElementById("password");
            if (pass.type === "password") {
                pass.type = "text";
            } else {
                pass.type = "password";
            }
        }
    </script>


</body>

</html>
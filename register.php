<?php
include './config/koneksi.php';

$message = "";

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $jurusan = $_POST['jurusan'];
    $telepon = $_POST['telepon'];
    $password = $_POST['password'];

    // Cek apakah NIM sudah terdaftar
    $check = mysqli_query($conn, "SELECT * FROM users WHERE nim='$nim'");
    
    if (mysqli_num_rows($check) > 0) {
        $message = "<script>alert('❗ Akun dengan NIM tersebut sudah terdaftar!');</script>";
    } else {
        // Simpan ke database
        $query = mysqli_query($conn, 
            "INSERT INTO users (nama, nim, jurusan, telepon, pw) 
             VALUES ('$nama', '$nim', '$jurusan', '$telepon', '$password')");

        if ($query) {
            echo "<script>alert('✅ Registrasi berhasil!'); window.location='login.php';</script>";
            exit;
        } else {
            $message = "<script>alert('❌ Terjadi kesalahan saat registrasi.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Akun - Portofolio PBL</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/register.css">


</head>

<body>

<?php echo $message; ?>

<div class="card-glass text-center">
  <h3 class="mb-4 fw-bold">Registrasi Akun</h3>

  <form method="POST" action="">
    <div class="mb-3">
      <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
    </div>

    <div class="mb-3">
      <input type="text" name="nim" class="form-control" placeholder="NIM/NIK" required>
    </div>

    <div class="mb-3">
      <select name="jurusan" class="form-select" required>
        <option value="" disabled selected>Pilih Jurusan / Program Studi</option>
        <option value="Teknik Informatika">Teknik Informatika</option>
        <option value="Teknik Elektro">Teknik Elektro</option>
        <option value="Teknik Mesin">Teknik Mesin</option>
        <option value="Manajemen Bisnis">Manajemen Bisnis</option>
      </select>
    </div>

    <div class="mb-3">
      <input type="tel" name="telepon" class="form-control" placeholder="No. Telepon" required>
    </div>

    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
    </div>

    <button type="submit" class="btn btn-custom w-100">Daftar</button>
  </form>

  <p class="mt-3">Sudah punya akun? <a href="login.php" class="text-info">Login di sini</a></p>
</div>

</body>
</html>

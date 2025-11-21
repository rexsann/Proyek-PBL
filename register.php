<<<<<<< HEAD
<?php
include 'koneksi.php';

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

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2b1055, #7597de);
      color: white;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-glass {
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      backdrop-filter: blur(25px);
      border-radius: 25px;
      padding: 40px;
      width: 400px;
      box-shadow: 0 0 25px rgba(0,230,255,0.2);
    }

    .btn-custom {
      background: linear-gradient(135deg, #00c6ff, #0072ff);
      color: white;
      border: none;
      font-weight: 600;
    }

    .btn-custom:hover {
      background: linear-gradient(135deg, #0072ff, #00c6ff);
    }
  </style>
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
=======

>>>>>>> d6dbd605786cdeba592a1c053109f6795e15f3fa

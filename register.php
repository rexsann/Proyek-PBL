<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Akun - Portofolio PBL</title>

  <!-- Bootstrap -->
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

    a {
      color: #00e6ff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="card-glass text-center">
    <h3 class="mb-4 fw-bold">Registrasi Akun</h3>

    <form id="registerForm">
      <div class="mb-3">
        <input type="text" id="nama" class="form-control" placeholder="Nama Lengkap" required>
      </div>
      <div class="mb-3">
        <input type="text" id="nim" class="form-control" placeholder="NIM/NIK" required>
      </div>
      <div class="mb-3">
        <select id="jurusan" class="form-select" required>
          <option value="" disabled selected>Pilih Jurusan / Program Studi</option>
          <option value="Teknik Informatika">Teknik Informatika</option>
          <option value="Teknik Elektro">Teknik Elektro</option>
          <option value="Teknik Mesin">Teknik Mesin</option>
          <option value="Manajemen Bisnis">Manajemen Bisnis</option>
        </select>
      </div>
      <div class="mb-3">
        <input type="tel" id="telepon" class="form-control" placeholder="No. Telepon" required>
      </div>
      <div class="mb-3">
        <input type="password" id="password" class="form-control" placeholder="Kata Sandi" required>
      </div>
      <button type="submit" class="btn btn-custom w-100">Daftar</button>
    </form>

    <p class="mt-3">Sudah punya akun? <a href="login.php">Login di sini</a></p>
  </div>

  <script>
    document.getElementById("registerForm").addEventListener("submit", function(e) {
      e.preventDefault();

      const nama = document.getElementById("nama").value.trim();
      const nim = document.getElementById("nim").value.trim();
      const jurusan = document.getElementById("jurusan").value;
      const telepon = document.getElementById("telepon").value.trim();
      const password = document.getElementById("password").value.trim();

      if (!jurusan) {
        alert("⚠️ Silakan pilih jurusan terlebih dahulu!");
        return;
      }

      // Cek apakah akun sudah terdaftar
      if (localStorage.getItem("user_" + nim)) {
        alert("❗ Akun dengan NIM/NIK tersebut sudah terdaftar!");
        return;
      }

      // Simpan user baru ke localStorage
      const user = { nama, nim, jurusan, telepon, password };
      localStorage.setItem("user_" + nim, JSON.stringify(user));

      alert("✅ Registrasi berhasil! Silakan login dengan akun Anda.");
      window.location.href = "login.php"; // ⬅️ arahkan ke halaman login
    });
  </script>
</body>
</html>

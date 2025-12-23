<?php
session_start();
include './config/koneksi.php';

// Proteksi halaman
if (!isset($_SESSION['user_id'])) {
  echo "<script>alert('⚠️ Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
  exit;
}

// Ambil ID
if (!isset($_GET['id'])) {
  echo "<script>alert('ID portofolio tidak ditemukan!'); window.location.href='hasil.php';</script>";
  exit;
}

$id = intval($_GET['id']);

// AMBIL DATA LAMA (NO PREPARE)
$query = "SELECT * FROM portfolios WHERE id='$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
  echo "<script>alert('Data tidak ditemukan!'); window.location.href='hasil.php';</script>";
  exit;
}

// PROSES UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Escape input (wajib kalo tanpa prepare)
  $judul      = mysqli_real_escape_string($conn, $_POST['judul']);
  $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
  $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $repository = mysqli_real_escape_string($conn, $_POST['repository'] ?? '');
  $youtube    = mysqli_real_escape_string($conn, $_POST['youtube'] ?? '');

  // FILE UTAMA
  $fileUtamaName = $data['file'];

  if (!empty($_FILES['fileUtama']['name'])) {
    $targetDir = "uploads/files/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $ext = pathinfo($_FILES['fileUtama']['name'], PATHINFO_EXTENSION);
    $fileUtamaName = uniqid() . "_file." . $ext;

    move_uploaded_file($_FILES['fileUtama']['tmp_name'], $targetDir . $fileUtamaName);
  }

  // POSTER
  $posterName = $data['poster'];

  if (!empty($_FILES['poster']['name'])) {
    $targetDir = "uploads/posters/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $ext = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
    $posterName = uniqid() . "_poster." . $ext;

    move_uploaded_file($_FILES['poster']['tmp_name'], $targetDir . $posterName);
  }

  // GALERI
  if (!empty($_FILES['gallery']['name'][0])) {

    $galleryNow = [];
    $targetDir = "uploads/gallery/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    foreach ($_FILES['gallery']['name'] as $i => $filename) {

      if ($_FILES['gallery']['error'][$i] !== UPLOAD_ERR_OK) continue;

      $tmp = $_FILES['gallery']['tmp_name'][$i];
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      $newName = uniqid("gallery_") . "." . $ext;

      if (move_uploaded_file($tmp, $targetDir . $newName)) {
        $galleryNow[] = $newName;
      }
    }
  } else {
    // Tidak upload baru → pakai data lama
    $galleryNow = json_decode($data['gallery'], true);
    if (!is_array($galleryNow)) $galleryNow = [];
  }

  $galleryJSON = mysqli_real_escape_string($conn, json_encode($galleryNow, JSON_UNESCAPED_SLASHES));

  // UPDATE DATABASE (NO PREPARE)
  $updateQuery = "
        UPDATE portfolios SET
            judul='$judul',
            kategori='$kategori',
            deskripsi='$deskripsi',
            file='$fileUtamaName',
            poster='$posterName',
            repository='$repository',
            youtube='$youtube',
            gallery='$galleryJSON'
        WHERE id='$id'
    ";

  if (mysqli_query($conn, $updateQuery)) {

    echo "<script>
            alert('✅ Portofolio berhasil diperbarui!');
            window.location.href='hasil.php?id=$id';
        </script>";
    exit;
  } else {
    echo "<script>alert('❌ Gagal memperbarui data: " . mysqli_error($conn) . "');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Portofolio Mahasiswa</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea[name=deskripsi]',
      height: 350,
      plugins: 'lists link image table code advlist anchor autolink autoresize charmap codesample emoticons',
      toolbar: `
        undo redo |
        blocks fontfamily fontsize |
        bold italic underline strikethrough |
        forecolor backcolor |
        alignleft aligncenter alignright alignjustify |
        bullist numlist |
        table link code
      `,
      menubar: false,
      fontsize_formats: "10px 12px 14px 16px 18px 20px 24px 28px",
      content_style: `body { font-family: Poppins, sans-serif; }`
    });
  </script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2b1055, #7597de);
      color: white;
      padding: 40px;
    }

    .card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      border-radius: 15px;
      padding: 20px;
    }
  </style>
</head>

<body>

  <div class="container">
    <h2 class="fw-bold text-center mb-4">✏️ Edit Portofolio</h2>

    <div class="card shadow-lg">
      <form method="POST" enctype="multipart/form-data">

        <!-- JUDUL -->
        <label class="form-label">Judul Proyek</label>
        <input type="text" class="form-control" name="judul"
          value="<?= htmlspecialchars($data['judul']) ?>" required>

        <!-- KATEGORI -->
        <label class="form-label mt-3">Kategori</label>
        <input type="text" class="form-control" name="kategori"
          value="<?= htmlspecialchars($data['kategori']) ?>" required>

        <!-- DESKRIPSI -->
        <label class="form-label mt-3">Deskripsi</label>
        <textarea class="form-control" name="deskripsi" rows="5"><?= htmlspecialchars($data['deskripsi']) ?></textarea>

        <!-- FILE UTAMA -->
        <label class="form-label mt-3">File PDF</label>
        <small class="text-warning d-block mb-2">File sekarang: <?= htmlspecialchars($data['file']) ?></small>
        <input type="file" class="form-control" name="fileUtama" accept=".pdf">

        <!-- POSTER -->
        <label class="form-label mt-3">Poster</label>
        <input type="file" class="form-control" name="poster" accept="image/*">

        <!-- REPOSITORY -->
        <label class="form-label mt-3">Repository</label>
        <input type="url" class="form-control" name="repository"
          value="<?= htmlspecialchars($data['repository']) ?>">

        <!-- YOUTUBE -->
        <label class="form-label mt-3">YouTube</label>
        <input type="url" class="form-control" name="youtube"
          value="<?= htmlspecialchars($data['youtube']) ?>">

        <!-- GALERI -->
        <label class="form-label mt-3">Galeri Tambahan</label>
        <input type="file" class="form-control" name="gallery[]" multiple accept="image/*">

        <!-- SUBMIT -->
        <button type="submit" class="btn btn-primary w-100 mt-4 fw-bold">Simpan Perubahan</button>

      </form>
    </div>
  </div>

</body>

</html>
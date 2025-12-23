<?php
session_start();
include './config/koneksi.php';

/* ================== PROTEKSI ================== */
if (!isset($_SESSION['user_id'])) {
  echo "<script>alert('⚠️ Silakan login!'); window.location.href='login.php';</script>";
  exit;
}

/* ================== DATA USER ================== */
$nama    = $_SESSION['nama'];
$nim     = $_SESSION['nim'];
$jurusan = $_SESSION['jurusan'];

/* ================== INIT ================== */
$isEdit      = false;
$portfolioId = null;
$dataLama    = null;

/* ================== CEK MODE EDIT (GET / POST) ================== */
if (
  (isset($_GET['id']) && is_numeric($_GET['id'])) ||
  (isset($_POST['id']) && is_numeric($_POST['id']))
) {
  $isEdit = true;
  $portfolioId = isset($_POST['id'])
    ? (int)$_POST['id']
    : (int)$_GET['id'];

  $q = mysqli_query($conn, "
        SELECT * FROM portfolios 
        WHERE id = $portfolioId 
        AND nim = '$nim'
        LIMIT 1
    ");

  $dataLama = mysqli_fetch_assoc($q);

  if (!$dataLama) {
    echo "<script>alert('❌ Data tidak valid!');history.back();</script>";
    exit;
  }
}

/* ================== PROSES SIMPAN ================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  /* ---------- INPUT ---------- */
  $judul      = mysqli_real_escape_string($conn, $_POST['judul']);
  $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
  $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $repository = mysqli_real_escape_string($conn, $_POST['repository'] ?? '');
  $youtube    = mysqli_real_escape_string($conn, $_POST['youtube'] ?? '');

  /* ---------- FILE UTAMA ---------- */
  $fileUtamaName = $dataLama['file'] ?? '';

  if (!empty($_FILES['fileUtama']['name'])) {
    $dir = 'uploads/files/';
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $fileUtamaName = uniqid() . '_' . basename($_FILES['fileUtama']['name']);
    move_uploaded_file($_FILES['fileUtama']['tmp_name'], $dir . $fileUtamaName);
  }

  /* ---------- POSTER ---------- */
  $posterName = $dataLama['poster'] ?? '';

  if (!empty($_FILES['poster']['name'])) {
    $dir = 'uploads/posters/';
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $posterName = uniqid() . '_' . basename($_FILES['poster']['name']);
    move_uploaded_file($_FILES['poster']['tmp_name'], $dir . $posterName);
  }

  /* ---------- GALLERY ---------- */
  $galleryNames = ($dataLama && $dataLama['gallery'])
    ? json_decode($dataLama['gallery'], true)
    : [];

  if (!empty($_FILES['gallery']['name'][0])) {
    $galleryNames = [];
    $dir = 'uploads/gallery/';
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    foreach ($_FILES['gallery']['name'] as $i => $namaFile) {
      if ($_FILES['gallery']['error'][$i] !== UPLOAD_ERR_OK) continue;

      $ext = pathinfo($namaFile, PATHINFO_EXTENSION);
      $newName = uniqid('gallery_') . '.' . $ext;

      if (move_uploaded_file($_FILES['gallery']['tmp_name'][$i], $dir . $newName)) {
        $galleryNames[] = $newName;
      }
    }
  }

  $galleryJSON = json_encode($galleryNames, JSON_UNESCAPED_SLASHES);

  /* ================== QUERY ================== */
  if ($isEdit) {

    $sql = "
            UPDATE portfolios SET
                judul='$judul',
                kategori='$kategori',
                deskripsi='$deskripsi',
                file='$fileUtamaName',
                poster='$posterName',
                repository='$repository',
                youtube='$youtube',
                gallery='$galleryJSON'
            WHERE id=$portfolioId AND nim='$nim'
        ";
  } else {

    $sql = "
            INSERT INTO portfolios
            (nama, nim, jurusan, judul, kategori, deskripsi, file, poster, repository, youtube, gallery, tanggal)
            VALUES
            ('$nama','$nim','$jurusan','$judul','$kategori','$deskripsi','$fileUtamaName','$posterName','$repository','$youtube','$galleryJSON', NOW())
        ";
  }

  /* ================== EKSEKUSI ================== */
  if (mysqli_query($conn, $sql)) {
    $redirectId = $isEdit ? $portfolioId : mysqli_insert_id($conn);
    echo "<script>
            alert('✅ Portofolio berhasil disimpan!');
            window.location.href='hasil.php?id=$redirectId';
        </script>";
  } else {
    echo "<script>alert('❌ Error: " . mysqli_error($conn) . "');</script>";
  }
}
?>



<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Portofolio Mahasiswa - Polibatam</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2b1055, #7597de);
      color: white;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      border-radius: 15px;
      padding: 20px;
    }

    .btn-back {
      background-color: #ffc107;
      color: black;
      font-weight: 600;
    }

    .btn-back:hover {
      background-color: #e0a800;
    }

    .btn-primary {
      font-weight: 600;
    }
  </style>

  <!-- 🔥 TinyMCE Editor -->


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

      // Ukuran font seperti Word
      fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 24px 28px 32px 36px 48px 72px",

      // Aktifkan font-family dan font-size dropdown
      font_family_formats: "Poppins=Poppins, sans-serif; Arial=Arial, Helvetica, sans-serif; Times New Roman=Times New Roman, serif;",

      content_style: `
      body { font-family: Poppins, sans-serif; font-size:14px; }
  `
    });
  </script>

</head>

<body>

  <div class="container py-5 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="hasil.php" class="btn btn-back">⬅️ Kembali</a>
      <h2 class="text-center flex-grow-1 fw-bold m-0">📤 Upload Portofolio</h2>
      <div style="width: 80px;"></div>
    </div>

    <div class="card shadow-lg p-4">
      <form method="post" enctype="multipart/form-data">

        <?php if ($isEdit): ?>
          <input type="hidden" name="id" value="<?= $portfolioId ?>">
        <?php endif; ?>

        <!-- IDENTITAS -->
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($nama) ?>" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">NIM</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($nim) ?>" readonly>
          </div>
        </div>

        <!-- JUDUL & KATEGORI -->
        <div class="row g-3 mt-2">
          <div class="col-md-6">
            <label class="form-label">Judul Proyek</label>
            <input type="text" class="form-control" name="judul"
              value="<?= htmlspecialchars($dataLama['judul'] ?? '') ?>" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <select class="form-select" name="kategori" required>
              <option value="">Pilih Kategori</option>

              <?php
              $kategoriMap = [
                "Teknik Informatika" => [
                  "Aplikasi Web",
                  "Aplikasi Mobile",
                  "IoT",
                  "Artificial Intelligence",
                  "Erp & Pengembangan Aplikasi",
                  "Data Mining"
                ],
                "Teknik Mesin" => [
                  "Desain Mesin",
                  "Simulasi Mekanik"
                ],
                "Teknik Elektro" => [
                  "IoT Project",
                  "Robotika"
                ],
                "Manajemen Bisnis" => [
                  "Analisis Pasar & Strategi",
                  "Startup & Inovasi Bisnis"
                ]
              ];

              foreach ($kategoriMap[$jurusan] ?? [] as $k):
                $selected = (($dataLama['kategori'] ?? '') === $k) ? 'selected' : '';
              ?>
                <option value="<?= htmlspecialchars($k) ?>" <?= $selected ?>>
                  <?= htmlspecialchars($k) ?>
                </option>
              <?php endforeach; ?>

            </select>
          </div>


          <!-- DESKRIPSI -->
          <div class="mt-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" rows="4"><?= htmlspecialchars($dataLama['deskripsi'] ?? '') ?></textarea>
          </div>

          <!-- FILE UTAMA -->
          <div class="mt-3">
            <label class="form-label">File Utama (PDF)</label>

            <?php if (!empty($dataLama['file'])): ?>
              <div class="small mb-1">
                📄 File saat ini:
                <a href="uploads/files/<?= htmlspecialchars($dataLama['file']) ?>" target="_blank">
                  Lihat file
                </a>
              </div>
            <?php endif; ?>

            <input type="file" class="form-control" name="fileUtama" accept=".pdf">
          </div>

          <!-- POSTER -->
          <div class="mt-3">
            <label class="form-label">Poster / Thumbnail</label>

            <?php if (!empty($dataLama['poster'])): ?>
              <div class="mb-2">
                <img src="uploads/posters/<?= htmlspecialchars($dataLama['poster']) ?>"
                  class="img-thumbnail" style="max-height:120px;">
              </div>
            <?php endif; ?>

            <input type="file" class="form-control" name="poster" accept="image/*">
          </div>

          <!-- LINK -->
          <div class="mt-3">
            <label class="form-label">Link Repository (GitHub)</label>
            <input type="url" class="form-control" name="repository"
              value="<?= htmlspecialchars($dataLama['repository'] ?? '') ?>">
          </div>

          <div class="mt-3">
            <label class="form-label">Link Video YouTube</label>
            <input type="url" class="form-control" name="youtube"
              value="<?= htmlspecialchars($dataLama['youtube'] ?? '') ?>">
          </div>

          <!-- GALLERY -->
          <div class="mt-3">
            <label class="form-label">Gallery Tambahan</label>

            <?php if (!empty($dataLama['gallery'])):
              $gal = json_decode($dataLama['gallery'], true); ?>
              <div class="d-flex flex-wrap gap-2 mb-2">
                <?php foreach ($gal as $g): ?>
                  <img src="uploads/gallery/<?= htmlspecialchars($g) ?>"
                    class="img-thumbnail" style="height:80px;">
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <input type="file" class="form-control" name="gallery[]" accept="image/*" multiple>
          </div>

          <!-- SUBMIT -->
          <div class="mt-4 text-center">
            <button type="submit" class="btn btn-primary w-100 fw-bold">
              <?= $isEdit ? '💾 Simpan Perubahan' : '📤 Upload Portofolio' ?>
            </button>
          </div>

      </form>

    </div>
  </div>

</body>

</html>
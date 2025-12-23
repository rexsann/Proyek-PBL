<?php
session_start();
include './config/koneksi.php';


// AMBIL ID PORTOFOLIO
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<h3 class='text-center text-white'>❌ Portofolio tidak ditemukan.</h3>";
    exit;
}

// AMBIL DATA PORTOFOLIO
$sql = "SELECT * FROM portfolios WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<h3 class='text-center text-white'>❌ Portofolio tidak ditemukan.</h3>";
    exit;
}

$portfolioId = (int)$data['id'];

// CEK PEMILIK (JIKA LOGIN)
$isOwner = false;
if (isset($_SESSION['nim'])) {
    $isOwner = ($_SESSION['nim'] == $data['nim']);
}

// FIX TOMBOL KEMBALI (ANTI LOOP)
$currentPage = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['back_portfolio'])) {

    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $refererPage = basename(parse_url($referer, PHP_URL_PATH));

    if (!empty($referer) && $refererPage !== $currentPage) {
        $_SESSION['back_portfolio'] = $referer;
    } else {
        $_SESSION['back_portfolio'] = 'home.php';
    }
}

$back_url = $_SESSION['back_portfolio'];

// ROLE (DEFAULT PENGUNJUNG)
$role = $_SESSION['role'] ?? 'pengunjung';

// AMBIL SEMUA PENILAIAN (TANPA FILTER DOSEN)
$sqlPenilaian = "
    SELECT * FROM penilaian 
    WHERE portfolio_id = $portfolioId
    ORDER BY tanggal DESC
";

$penilaianResult = mysqli_query($conn, $sqlPenilaian);

// ⬇️ WAJIB ADA
$penilaianList = [];
if ($penilaianResult && mysqli_num_rows($penilaianResult) > 0) {
    while ($row = mysqli_fetch_assoc($penilaianResult)) {
        $penilaianList[] = $row;
    }
}

$penilaian = null;

if ($role === 'dosen' && isset($_SESSION['user_id'])) {
    foreach ($penilaianList as $p) {
        if ($p['dosen_id'] == $_SESSION['user_id']) {
            $penilaian = $p;
            break;
        }
    }
}


// AMBIL KOMENTAR
$sqlKomentar = "
    SELECT * FROM komentar_portfolio 
    WHERE portfolio_id = $portfolioId
    ORDER BY tanggal DESC
";
$komentarResult = mysqli_query($conn, $sqlKomentar);

$namaKomentar = $_SESSION['nama'] ?? 'Anonim';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Portofolio - Polibatam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2b1055, #7597de);
            color: white;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: start;
            padding: 40px 10px;
        }

        .detail-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 900px;
            width: 100%;
        }

        h1.title {
            text-transform: uppercase;
            text-align: center;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 25px;
        }

        .white-box {
            background: white;
            color: black;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            max-width: 100%;
            overflow: hidden;
        }

        .white-box p {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }

        img,
        iframe {
            border-radius: 10px;
            width: 100%;
        }

        .gallery img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        .btn-edit {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: 600;
        }

        .btn-delete {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: 600;
        }

        .btn-back {
            background-color: #ffc107;
            border: none;
            color: black;
            font-weight: 600;
        }

        .comment-box {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 16px;
            padding: 15px 18px;
            margin-bottom: 15px;
            color: #000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: 0.2s ease;
        }

        .comment-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
        }

        .comment-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #4c6ef5;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .comment-name {
            font-weight: 600;
            margin: 0;
        }

        .comment-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .delete-comment {
            font-size: 0.85rem;
            color: #dc3545;
        }

        .delete-comment:hover {
            color: #b91c1c;
        }
    </style>
</head>

<body>
    <div class="detail-card">
        <h1 class="title"><?= htmlspecialchars($data['judul']) ?></h1>
        <div class="white-box">
            <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></p>
            <p><strong>NIM:</strong> <?= htmlspecialchars($data['nim']) ?></p>
            <p><strong>Jurusan:</strong> <?= htmlspecialchars($data['jurusan']) ?></p>
            <p><strong>Kategori:</strong> <?= htmlspecialchars($data['kategori']) ?></p>
            <p><strong>Tanggal Upload:</strong> <?= htmlspecialchars($data['tanggal']) ?></p>
        </div>
        <div class="white-box">
            <p class="fw-bold mb-1">Deskripsi Proyek:</p>
            <div><?= $data['deskripsi'] ?></div>
        </div>
        <div class="white-box">
            <h5 class="fw-bold">📁 File Utama:</h5>
            <?php if ($data['file']): ?>
                <a href="uploads/files/<?= htmlspecialchars($data['file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">📄 Lihat / Download File PDF</a>
            <?php else: ?>
                <p class='text-muted'>Tidak ada file utama.</p>
            <?php endif; ?>
        </div>
        <div class="white-box">
            <h5 class="fw-bold">🖼️ Poster:</h5>
            <img src="uploads/posters/<?= htmlspecialchars($data['poster']) ?>" alt="Poster Portofolio">
        </div>
        <div class="white-box">
            <h5 class="fw-bold">🔗 Repository:</h5>
            <?php if (!empty($data['repository'])): ?>
                <p><a href="<?= htmlspecialchars($data['repository']) ?>" target="_blank"><?= htmlspecialchars($data['repository']) ?></a></p>
            <?php else: ?>
                <p class="text-muted">Tidak ada repository.</p>
            <?php endif; ?>
        </div>
        <div class="white-box">
            <h5 class="fw-bold">📷 Galeri Tambahan:</h5>
            <div class="row g-3 gallery">
                <?php
                $gallery = json_decode($data['gallery'], true);
                if ($gallery && count($gallery) > 0):
                    foreach ($gallery as $img):
                ?>
                        <div class="col-md-4">
                            <img src="uploads/gallery/<?= htmlspecialchars($img) ?>">
                        </div>
                    <?php endforeach;
                else: ?>
                    <p class='text-muted'>Tidak ada galeri tambahan.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="white-box">
            <h5 class="fw-bold">🎥 Video YouTube:</h5>
            <?php
            if ($data['youtube']):
                $youtube = $data['youtube'];
                $youtubeId = '';
                if (str_contains($youtube, 'youtu.be/')) {
                    $youtubeId = explode('youtu.be/', $youtube)[1];
                } elseif (str_contains($youtube, 'watch?v=')) {
                    $youtubeId = explode('v=', $youtube)[1];
                } elseif (str_contains($youtube, 'embed/')) {
                    $youtubeId = explode('embed/', $youtube)[1];
                }
                $youtubeId = explode('?', $youtubeId)[0];
                if ($youtubeId):
            ?>
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?= htmlspecialchars($youtubeId) ?>" frameborder="0" allowfullscreen></iframe>
                <?php else: ?>
                    <p class='text-muted'>Link YouTube tidak valid.</p>
                <?php endif;
            else: ?>
                <p class='text-muted'>Tidak ada video YouTube.</p>
            <?php endif; ?>
        </div>

        <?php
        $role = $_SESSION['role'] ?? 'mahasiswa'; // default mahasiswa

        // Jika dosen → tampilkan form / edit
        if ($role === 'dosen') :
        ?>
            <div class="white-box mt-4" id="penilaianContainer">
                <h5 class="fw-bold mb-3">📝 Penilaian Dosen</h5>
                <?php if ($penilaian): ?>
                    <div id="penilaianTampil"
                        data-nk="<?= $penilaian['nilai_kreatifitas'] ?>"
                        data-nf="<?= $penilaian['nilai_fungsionalitas'] ?>"
                        data-nr="<?= $penilaian['nilai_kerapian'] ?>"
                        data-ny="<?= $penilaian['nilai_karya'] ?>"
                        data-komentar="<?= htmlspecialchars($penilaian['komentar'], ENT_QUOTES) ?>"
                        data-id="<?= $penilaian['id'] ?>">

                        <p><strong>Dosen Penilai:</strong> <?= htmlspecialchars($penilaian['dosen_nama']) ?></p>
                        <p><strong>Nilai Kreatifitas & Inovasi:</strong> <?= $penilaian['nilai_kreatifitas'] ?></p>
                        <p><strong>Nilai Fungsionalitas:</strong> <?= $penilaian['nilai_fungsionalitas'] ?></p>
                        <p><strong>Nilai Kerapian / Profesionalitas:</strong> <?= $penilaian['nilai_kerapian'] ?></p>
                        <p><strong>Nilai Karya:</strong> <?= $penilaian['nilai_karya'] ?></p>
                        <p><strong>Komentar:</strong> <?= htmlspecialchars($penilaian['komentar']) ?></p>

                        <div class="d-flex gap-2 mt-3">
                            <button id="btnEditPenilaian" class="btn btn-edit px-4">✏️ Edit Penilaian</button>
                            <a href="hapus_penilaian.php?id=<?= $penilaian['id'] ?>" class="btn btn-delete px-4"
                                onclick="return confirm('Yakin ingin menghapus penilaian ini?');">🗑️ Hapus Penilaian</a>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- FORM untuk dosen menilai -->
                    <form id="penilaianForm">
                        <input type="hidden" name="portfolio_id" value="<?= $data['id'] ?>">

                        <label class="form-label">Nilai Kreatifitas & Inovasi</label>
                        <input type="number" name="nilai_kreatifitas" class="form-control mb-3" min="0" max="100" required>

                        <label class="form-label">Nilai Fungsionalitas</label>
                        <input type="number" name="nilai_fungsionalitas" class="form-control mb-3" min="0" max="100" required>

                        <label class="form-label">Nilai Kerapian / Profesionalitas</label>
                        <input type="number" name="nilai_kerapian" class="form-control mb-3" min="0" max="100" required>

                        <label class="form-label">Nilai Karya</label>
                        <input type="number" name="nilai_karya" class="form-control mb-3" min="0" max="100" required>

                        <label class="form-label">Komentar / Catatan</label>
                        <textarea name="komentar" class="form-control mb-3" rows="3"></textarea>

                        <button type="submit" class="btn btn-success w-100 fw-bold">💾 Simpan Penilaian</button>
                    </form>
                <?php endif; ?>
            </div>

        <?php elseif ($role === 'mahasiswa' || $role === 'pengunjung'): ?>

            <div class="white-box mt-4">
                <h5 class="fw-bold mb-3">📝 Penilaian Dosen</h5>

                <?php if (!empty($penilaianList)): ?>

                    <?php foreach ($penilaianList as $p): ?>
                        <div class="border rounded p-3 mb-3">

                            <p><strong>Dosen Penilai:</strong>
                                <?= htmlspecialchars($p['dosen_nama']) ?>
                            </p>

                            <p><strong>Nilai Kreatifitas & Inovasi:</strong>
                                <?= htmlspecialchars($p['nilai_kreatifitas']) ?>
                            </p>

                            <p><strong>Nilai Fungsionalitas:</strong>
                                <?= htmlspecialchars($p['nilai_fungsionalitas']) ?>
                            </p>

                            <p><strong>Nilai Kerapian / Profesionalitas:</strong>
                                <?= htmlspecialchars($p['nilai_kerapian']) ?>
                            </p>

                            <p><strong>Nilai Karya:</strong>
                                <?= htmlspecialchars($p['nilai_karya']) ?>
                            </p>

                            <?php if (!empty($p['komentar'])): ?>
                                <p><strong>Komentar:</strong>
                                    <?= nl2br(htmlspecialchars($p['komentar'])) ?>
                                </p>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <p class="text-muted">Belum ada penilaian dari dosen.</p>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <!-- Tampilkan daftar komentar -->
        <div class="white-box mt-4">
            <h5 class="fw-bold mb-3">💬 Komentar Mahasiswa</h5>

            <form action="simpan_komentar.php" method="POST" class="mb-4">
                <input type="hidden" name="portfolio_id" value="<?= $portfolioId ?>">

                <?php if ($role === 'pengunjung'): ?>
                    <!-- Pengunjung -->
                    <input type="text" name="nama" class="form-control mb-2"
                        placeholder="Nama (boleh anonim)" required>
                <?php else: ?>
                    <!-- Mahasiswa / Login -->
                    <input type="hidden" name="nama" value="<?= htmlspecialchars($namaKomentar) ?>">
                <?php endif; ?>

                <textarea name="komentar" class="form-control mb-2"
                    rows="3" placeholder="Tulis komentar..." required></textarea>

                <button class="btn btn-primary w-100 fw-bold">💬 Kirim Komentar</button>
            </form>

            <!-- Daftar Komentar -->
            <?php if ($komentarResult && $komentarResult->num_rows > 0): ?>
                <?php while ($k = $komentarResult->fetch_assoc()): ?>

                    <div class="comment-box d-flex gap-3">
                        <!-- Avatar -->
                        <div class="comment-avatar">
                            <?= strtoupper(substr($k['nama'] ?? 'A', 0, 1)) ?>
                        </div>
                        <!-- Konten Komentar -->
                        <div class="flex-grow-1">
                            <!-- Nama + Tanggal -->
                            <div class="d-flex align-items-center gap-2">
                                <p class="comment-name mb-0 fw-bold">
                                    <?= htmlspecialchars($k['nama'] ?? 'Anonim') ?>
                                </p>
                                <small class="comment-time text-muted">
                                    <?= htmlspecialchars($k['tanggal'] ?? '') ?>
                                </small>
                            </div>
                            <!-- Isi komentar -->
                            <div class="comment-text mt-1">
                                <?= nl2br(htmlspecialchars($k['komentar'] ?? '')) ?>
                            </div>
                        </div>

                        <!-- Tombol Hapus -->
                        <?php
                        $canDelete = false;

                        // Mahasiswa bisa hapus komentar sendiri
                        if ($role === 'mahasiswa' && !empty($k['nim']) && $k['nim'] === ($_SESSION['nim'] ?? '')) {
                            $canDelete = true;
                        }


                        ?>

                        <?php if ($canDelete): ?>
                            <a href="hapus_komentar.php?id=<?= $k['id'] ?>&pf=<?= $portfolioId ?>"
                                class="delete-comment align-self-start"
                                onclick="return confirm('Hapus komentar ini?');">
                                🗑
                            </a>
                        <?php endif; ?>

                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada komentar.</p>
            <?php endif; ?>
        </div>


        <div class="mt-4 d-flex justify-content-between">
            <?php if ($isOwner): ?>
                <a href="upload.php?id=<?= $data['id'] ?>" class="btn btn-warning">
                    ✏️ Edit
                </a>


                <a href="hapus.php?id=<?= $data['id'] ?>"
                    class="btn btn-delete px-4"
                    onclick="return confirm('Yakin ingin menghapus portofolio ini?');">
                    🗑️ Hapus
                </a>
            <?php endif; ?>

            <a href="<?= $back_url ?>" class="btn btn-primary"
                onclick="<?php unset($_SESSION['back_portfolio']); ?>">
                ⬅ Kembali
            </a>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('penilaianContainer');

            // Tombol Edit
            const btnEdit = document.getElementById('btnEditPenilaian');
            if (btnEdit) {
                btnEdit.addEventListener('click', () => {
                    const tampil = document.getElementById('penilaianTampil');
                    const nk = tampil.dataset.nk;
                    const nf = tampil.dataset.nf;
                    const nr = tampil.dataset.nr;
                    const ny = tampil.dataset.ny;
                    const komentar = tampil.dataset.komentar;
                    const id = tampil.dataset.id;

                    // Ganti container dengan form edit
                    container.innerHTML = `
                <form id="penilaianForm">
                    <input type="hidden" name="portfolio_id" value="<?= $data['id'] ?>">
                    <input type="hidden" name="penilaian_id" value="${id}">
                    <label class="form-label">Nilai Kreatifitas & Inovasi</label>
                    <input type="number" name="nilai_kreatifitas" class="form-control mb-3" min="0" max="100" value="${nk}" required>

                    <label class="form-label">Nilai Fungsionalitas</label>
                    <input type="number" name="nilai_fungsionalitas" class="form-control mb-3" min="0" max="100" value="${nf}" required>

                    <label class="form-label">Nilai Kerapian / Profesionalitas</label>
                    <input type="number" name="nilai_kerapian" class="form-control mb-3" min="0" max="100" value="${nr}" required>

                    <label class="form-label">Nilai Karya</label>
                    <input type="number" name="nilai_karya" class="form-control mb-3" min="0" max="100" value="${ny}" required>

                    <label class="form-label">Komentar / Catatan</label>
                    <textarea name="komentar" class="form-control mb-3" rows="3">${komentar}</textarea>

                    <button type="submit" class="btn btn-success w-100 fw-bold">💾 Simpan Perubahan</button>
                </form>
            `;

                    attachFormSubmit(); // Pasang event listener ke form baru
                });
            }

            // Fungsi attach submit Ajax
            function attachFormSubmit() {
                const form = document.getElementById('penilaianForm');
                if (!form) return;

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(form);

                    fetch('simpan_penilaian.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Update container menjadi tampilan Edit/Hapus
                                container.innerHTML = `
                        <h5 class="fw-bold mb-3">📝 Penilaian Dosen</h5>
                        <div id="penilaianTampil"
                             data-nk="${data.penilaian.nilai_kreatifitas}"
                             data-nf="${data.penilaian.nilai_fungsionalitas}"
                             data-nr="${data.penilaian.nilai_kerapian}"
                             data-ny="${data.penilaian.nilai_karya}"
                             data-komentar="${data.penilaian.komentar.replace(/"/g,'&quot;')}"
                             data-id="${data.penilaian.id}"
                        >
                            <p><strong>Nilai Kreatifitas & Inovasi:</strong> ${data.penilaian.nilai_kreatifitas}</p>
                            <p><strong>Nilai Fungsionalitas:</strong> ${data.penilaian.nilai_fungsionalitas}</p>
                            <p><strong>Nilai Kerapian / Profesionalitas:</strong> ${data.penilaian.nilai_kerapian}</p>
                            <p><strong>Nilai Karya:</strong> ${data.penilaian.nilai_karya}</p>
                            <p><strong>Komentar:</strong> ${data.penilaian.komentar}</p>
                            <div class="d-flex gap-2 mt-3">
                                <button id="btnEditPenilaian" class="btn btn-edit px-4">✏️ Edit Penilaian</button>
                                <a href="hapus_penilaian.php?id=${data.penilaian.id}" class="btn btn-delete px-4" onclick="return confirm('Yakin ingin menghapus penilaian ini?');">🗑️ Hapus Penilaian</a>
                            </div>
                        </div>
                    `;
                                attachFormSubmit(); // Pasang listener lagi ke tombol Edit baru
                                alert('✅ Penilaian berhasil disimpan!');
                            } else {
                                alert('❌ Gagal menyimpan penilaian!');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('❌ Terjadi kesalahan server.');
                        });
                });
            }
            // Pasang listener pertama kali untuk form baru
            attachFormSubmit();
        });
    </script>

</body>

</html>
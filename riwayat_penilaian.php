<?php
session_start();
include './config/koneksi.php';

// Cek login dosen
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'dosen') {
  echo "<script>alert('Silakan login sebagai dosen!'); window.location.href='login.php';</script>";
  exit;
}

$dosen_id = intval($_SESSION['user_id']); // aman

$sql = "
    SELECT p.*, pf.judul, pf.nama AS nama_mahasiswa, pf.nim, pf.kategori
    FROM penilaian p
    JOIN portfolios pf ON p.portfolio_id = pf.id
    WHERE p.dosen_id = $dosen_id
    ORDER BY p.tanggal DESC
";

$result = mysqli_query($conn, $sql);

$penilaian = [];
while ($row = mysqli_fetch_assoc($result)) {
  $row['total'] = round((
    $row['nilai_kreatifitas'] +
    $row['nilai_fungsionalitas'] +
    $row['nilai_kerapian'] +
    $row['nilai_karya']
  ) / 4, 2);

  $penilaian[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Penilaian Dosen - Polibatam</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #2b1055, #7597de);
      color: #fff;
      min-height: 100vh;
      margin: 0;
      padding: 40px 20px;
    }

    .container {
      max-width: 1100px;
      margin: auto;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      padding: 35px 40px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    h2 {
      text-align: center;
      font-weight: 700;
      margin-bottom: 25px;
    }

    .search-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
      gap: 10px;
    }

    .search-bar input,
    .search-bar select {
      padding: 10px 15px;
      border-radius: 10px;
      border: none;
      outline: none;
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      width: 48%;
    }

    .search-bar select option {
      background: #2b1055;
      color: #fff;
    }

    .search-bar input::placeholder {
      color: rgba(255, 255, 255, 0.8);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 12px;
      overflow: hidden;
      background: rgba(255, 255, 255, 0.15);
    }

    th,
    td {
      padding: 12px 16px;
      text-align: left;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    thead {
      background: rgba(255, 255, 255, 0.2);
    }

    th {
      font-weight: 600;
      color: #e0e8ff;
    }

    td {
      color: #fff;
    }

    .status {
      padding: 5px 12px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 13px;
      background: rgba(0, 255, 170, 0.2);
      color: #00ffb7;
    }

    .btn-detail,
    .btn-hapus,
    .btn-kembali {
      border: none;
      padding: 6px 12px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
      color: #fff;
    }

    .btn-detail {
      background: linear-gradient(90deg, #00bfff, #007bff);
    }

    .btn-hapus {
      background: linear-gradient(90deg, #ff5f6d, #ff3c3c);
    }

    .btn-kembali {
      background: linear-gradient(90deg, #06d6a0, #1b9aaa);
    }

    .btn-detail:hover,
    .btn-hapus:hover,
    .btn-kembali:hover {
      transform: scale(1.05);
      opacity: 0.9;
    }

    .actions {
      display: flex;
      justify-content: center;
      margin-top: 25px;
    }

    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      justify-content: center;
      align-items: center;
      z-index: 999;
    }

    .modal-content {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
    }

    .modal button {
      margin: 10px;
      border: none;
      padding: 8px 15px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
    }

    #confirmYes {
      background: #ff4b4b;
      color: #fff;
    }

    #confirmNo {
      background: #ccc;
      color: #000;
    }

    /* Toast Notification */
    .toast {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: rgba(0, 255, 170, 0.9);
      color: #000;
      padding: 12px 20px;
      border-radius: 12px;
      font-weight: 600;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.4s ease;
      z-index: 1000;
    }

    .toast.show {
      opacity: 1;
      transform: translateY(0);
    }

    /* ================= Responsive ================= */
    /* ================= Responsive ================= */
    @media (max-width: 768px) {

      /* Search bar full width */
      .search-bar input,
      .search-bar select {
        width: 100%;
      }

      /* Hilangkan header tabel */
      thead {
        display: none;
      }

      /* Tabel jadi bentuk kartu */
      table {
        width: 100%;
        border-collapse: collapse;
      }

      tbody tr {
        display: block;
        background: rgba(255, 255, 255, 0.05);
        padding: 12px;
        margin-bottom: 12px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.15);
      }

      tbody td {
        display: block;
        width: 100%;
        text-align: right;
        padding: 10px 10px 10px 50%;
        position: relative;
        border: none !important;
      }

      /* Label kiri */
      tbody td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        top: 10px;
        font-weight: 600;
        text-align: left;
        color: #e0e8ff;
      }
    }

    /* ========= HP kecil 480px ========= */
    @media (max-width: 480px) {

      .container {
        padding: 25px 15px;
      }

      .btn-detail,
      .btn-hapus,
      .btn-kembali {
        padding: 8px 10px;
        font-size: 14px;
      }

      .search-bar {
        gap: 5px;
      }
    }
  </style>

</head>

<body>
  <div class="container">
    <h2>Riwayat Penilaian Dosen</h2>

    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="🔍 Cari Nama, NIM, Judul atau Kategori">
      <select id="filterKategori">
        <option value="">Semua Kategori</option>
        <option value="Aplikasi Web">Aplikasi Web</option>
        <option value="Aplikasi Mobile">Aplikasi Mobile</option>
        <option value="Aplikasi IoT">Aplikasi IoT</option>
        <option value="Artificial Intelligence">Artificial Intelligence</option>
      </select>
    </div>

    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Mahasiswa</th>
          <th>NIM</th>
          <th>Kategori</th>
          <th>Judul Karya</th>
          <th>Total Nilai</th>
          <th>Status</th>
          <th>Tanggal Penilaian</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="tabelRiwayat">
        <?php foreach ($penilaian as $index => $p): ?>
          <tr
            data-nama="<?= strtolower($p['nama_mahasiswa']) ?>"
            data-nim="<?= strtolower($p['nim']) ?>"
            data-kategori="<?= strtolower($p['kategori']) ?>"
            data-judul="<?= strtolower($p['judul']) ?>"
            data-id="<?= $p['id'] ?>">


            <td data-label="No"><?= $index + 1 ?></td>
            <td data-label="Nama Mahasiswa"><?= htmlspecialchars($p['nama_mahasiswa']) ?></td>
            <td data-label="NIM"><?= htmlspecialchars($p['nim']) ?></td>
            <td data-label="Kategori"><?= htmlspecialchars($p['kategori']) ?></td>
            <td data-label="Judul Karya"><?= htmlspecialchars($p['judul']) ?></td>
            <td data-label="Total Nilai"><?= $p['total'] ?></td>
            <td data-label="Status"><span class="status">Dipublikasikan</span></td>
            <td data-label="Tanggal Penilaian"><?= date("d M Y H:i", strtotime($p['tanggal'])) ?></td>
            <td data-label="Aksi">
              <button class="btn-detail" onclick="lihatDetail(<?= $p['portfolio_id'] ?>)">Detail</button>
              <button class="btn-hapus" onclick="konfirmasiHapus(<?= $p['id'] ?>)">Hapus</button>
 
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (count($penilaian) === 0): ?>
          <tr>
            <td colspan="9" style="text-align:center;">Tidak ada penilaian</td>
          </tr>
        <?php endif; ?>
      </tbody>

    </table>

    <div class="actions">
      <button class="btn-kembali" onclick="window.location.href='home.php'">⬅️ Kembali ke Home</button>
    </div>
  </div>

  <!-- Modal Konfirmasi -->
  <div class="modal" id="modalConfirm">
    <div class="modal-content">
      <p>Yakin ingin menghapus penilaian ini?</p>
      <button id="confirmYes">Ya</button>
      <button id="confirmNo">Tidak</button>
    </div>
  </div>

  <!-- Toast -->
  <div id="toast" class="toast">Penilaian berhasil dihapus ✅</div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {

      let deleteId = null;

      const modal = document.getElementById("modalConfirm");
      const btnYes = document.getElementById("confirmYes");
      const btnNo = document.getElementById("confirmNo");
      const toast = document.getElementById("toast");
      const searchInput = document.getElementById("searchInput");
      const filterKategori = document.getElementById("filterKategori");
      const tabelRiwayat = document.getElementById("tabelRiwayat");

      // ===============================
      //   KONFIRMASI HAPUS
      // ===============================
      window.konfirmasiHapus = (id) => {
        deleteId = id;
        modal.style.display = "flex";
      };

      btnYes.addEventListener("click", () => {
        if (deleteId) {
          // Panggil PHP via fetch tanpa reload halaman
          fetch("hapus_penilaian.php?id=" + deleteId, {
              method: "GET"
            })
            .then(res => res.text())
            .then(data => {
              // Hapus row dari tabel
              const row = tabelRiwayat.querySelector(`tr[data-id='${deleteId}']`);
              if (row) row.remove();

              showToast("✅ Penilaian berhasil dihapus");
            })
            .catch(err => {
              console.error(err);
              showToast("❌ Gagal menghapus penilaian");
            });
        }
        modal.style.display = "none";
      });

      btnNo.addEventListener("click", () => {
        modal.style.display = "none";
      });

      // ===============================
      //   TOAST NOTIFICATION
      // ===============================
      window.showToast = (msg) => {
        toast.textContent = msg;
        toast.classList.add("show");
        setTimeout(() => {
          toast.classList.remove("show");
        }, 3000);
      };

      // ===============================
      //   LIHAT DETAIL / PORTOFOLIO
      // ===============================
      window.lihatDetail = (portfolioId) => {
        window.location.href = "detail_hasil.php?id=" + portfolioId;
      };

      // ===============================
      //   SEARCH & FILTER
      // ===============================
      function filterTabel() {
        const text = searchInput.value.toLowerCase();
        const kategori = filterKategori.value.toLowerCase();

        tabelRiwayat.querySelectorAll("tr").forEach(row => {
          if (!row.dataset.id) return;

          const nama = row.dataset.nama ?? "";
          const nim = row.dataset.nim ?? "";
          const judul = row.dataset.judul ?? "";
          const rowKategori = row.dataset.kategori ?? "";

          const matchText =
            nama.includes(text) ||
            nim.includes(text) ||
            judul.includes(text);

          const matchKategori = !kategori || rowKategori === kategori;

          row.style.display = (matchText && matchKategori) ? "" : "none";
        });
      }

      searchInput.addEventListener("input", filterTabel);
      filterKategori.addEventListener("change", filterTabel);

    });
  </script>


</body>

</html>
<?php
session_start();
include '../config/koneksi.php';

// Hanya admin yang boleh masuk
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Anda tidak memiliki akses!'); window.location='login.php';</script>";
    exit;
}

$data_dosen = mysqli_query($conn, "SELECT * FROM users WHERE role = 'dosen' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f5f5f5; font-family: 'Poppins', sans-serif; }
        .sidebar {
            width: 260px; height: 100vh; background: #212529;
            color: white; position: fixed; padding: 20px;
        }
        .sidebar a {
            display: block; padding: 12px; color: #bdbdbd;
            margin-bottom: 8px; text-decoration: none; border-radius: 6px;
        }
        .sidebar a:hover { background: #495057; color: white; }
        .content { margin-left: 280px; padding: 30px; }
        .table th { background: #343a40; color: white; }
        .card-box {
            background: white; padding: 25px; border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3 class="mb-4">⚙️ Admin Panel</h3>

    <a href="admin_dashboard.php">🏠 Dashboard</a>
    <a href="add_dosen.php">➕ Tambah Dosen</a>
    <a href="daftar_dosen.php" style="background:#495057;color:white;">👨‍🏫 Daftar Dosen</a>
    

    <hr class="bg-light">

    <a href="../logout.php" class="text-danger fw-bold">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
    <div class="card-box">
        <h3 class="fw-bold mb-3">👨‍🏫 Daftar Dosen</h3>

        <table class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th width="5%">No</th>
                    <th>Nama Dosen</th>
                    <th>NIP/NIM</th>
                    <th>Jurusan</th>
                    <th>No Telepon</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php $no=1; while ($d = mysqli_fetch_assoc($data_dosen)) : ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $d['nama']; ?></td>
                        <td><?= $d['nim']; ?></td>
                        <td><?= $d['jurusan']; ?></td>
                        <td><?= $d['telepon']; ?></td>
                        <td class="text-center">

                            <!-- Tombol buka modal edit -->
                            <button class="btn btn-warning btn-sm"
                                onclick="openEditModal(
                                    '<?= $d['id']; ?>',
                                    '<?= $d['nama']; ?>',
                                    '<?= $d['nim']; ?>',
                                    '<?= $d['jurusan']; ?>',
                                    '<?= $d['telepon']; ?>'
                                )">
                                Edit
                            </button>

                            <a href="hapus_dosen.php?id=<?= $d['id']; ?>"
                               onclick="return confirm('Yakin hapus dosen ini?')"
                               class="btn btn-danger btn-sm">Hapus</a>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</div>


<!-- ========== MODAL EDIT DOSEN ========== -->
<div class="modal fade" id="modalEditDosen" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

        <form action="proses_edit_dosen.php" method="POST">

            <div class="modal-header">
                <h5 class="modal-title">✏️ Edit Data Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="id" id="edit_id">

                <div class="mb-3">
                    <label>Nama Dosen</label>
                    <input type="text" name="nama" id="edit_nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>NIP / Username</label>
                    <input type="text" name="nim" id="edit_nim" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Jurusan</label>
                    <select name="jurusan" id="edit_jurusan" class="form-select" required>
                        <option>Teknik Mesin</option>
                        <option>Teknik Informatika</option>
                        <option>Manajemen Bisnis</option>
                        <option>Akuntansi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Telepon</label>
                    <input type="text" name="telepon" id="edit_telepon" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password Baru (Opsional)</label>
                    <input type="password" name="pw" class="form-control" placeholder="Kosongkan jika tidak diganti">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ================= FUNCTION OPEN MODAL =================
function openEditModal(id, nama, nim, jurusan, telepon) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_nim').value = nim;
    document.getElementById('edit_jurusan').value = jurusan;
    document.getElementById('edit_telepon').value = telepon;

    var modal = new bootstrap.Modal(document.getElementById('modalEditDosen'));
    modal.show();
}
</script>


</body>
</html>

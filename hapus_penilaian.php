<?php
session_start();
include './config/koneksi.php';

// Cek login dosen
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'dosen') {
    echo json_encode(['success' => false, 'msg' => 'Silakan login sebagai dosen']);
    exit;
}

// Ambil ID penilaian
$id = intval($_GET['id']);
if (!$id) {
    echo json_encode(['success' => false, 'msg' => 'ID tidak valid']);
    exit;
}

// Hapus data penilaian (tanpa prepare)
$delete = mysqli_query($conn, "DELETE FROM penilaian WHERE id='$id'");

if ($delete) {
    echo json_encode(['success' => true, 'msg' => 'Penilaian berhasil dihapus']);
} else {
    echo json_encode(['success' => false, 'msg' => 'Gagal menghapus penilaian']);
}

exit;
?>

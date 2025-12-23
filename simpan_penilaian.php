<?php
session_start();
include './config/koneksi.php';
header('Content-Type: application/json');

// Hanya dosen yang boleh menilai
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dosen') {
    echo json_encode(['success' => false, 'msg' => 'Anda tidak memiliki akses']);
    exit;
}

// Ambil POST dengan escape
$portfolio_id         = intval($_POST['portfolio_id'] ?? 0);
$nilai_kreatifitas    = intval($_POST['nilai_kreatifitas'] ?? 0);
$nilai_fungsionalitas = intval($_POST['nilai_fungsionalitas'] ?? 0);
$nilai_kerapian       = intval($_POST['nilai_kerapian'] ?? 0);
$nilai_karya          = intval($_POST['nilai_karya'] ?? 0);
$komentar             = mysqli_real_escape_string($conn, $_POST['komentar'] ?? '');

$dosen_id   = $_SESSION['user_id'];
$dosen_nama = mysqli_real_escape_string($conn, $_SESSION['nama']);

// Validasi dasar
if ($portfolio_id <= 0) {
    echo json_encode(['success' => false, 'msg' => 'ID portfolio tidak valid']);
    exit;
}

// ================================
// CEK APAKAH PENILAIAN SUDAH ADA
// ================================
$sqlCek = "
    SELECT * FROM penilaian 
    WHERE portfolio_id = $portfolio_id 
    AND dosen_id = $dosen_id
";
$cek = mysqli_query($conn, $sqlCek);
$existing = mysqli_fetch_assoc($cek);

// ================================
// UPDATE PENILAIAN
// ================================
if ($existing) {

    $id = $existing['id'];

    $sqlUpdate = "
        UPDATE penilaian SET
            dosen_nama = '$dosen_nama',
            nilai_kreatifitas = $nilai_kreatifitas,
            nilai_fungsionalitas = $nilai_fungsionalitas,
            nilai_kerapian = $nilai_kerapian,
            nilai_karya = $nilai_karya,
            komentar = '$komentar',
            tanggal = NOW()
        WHERE id = $id
    ";

    mysqli_query($conn, $sqlUpdate);

} else {

    // ================================
    // INSERT PENILAIAN BARU
    // ================================
    $sqlInsert = "
        INSERT INTO penilaian 
        (portfolio_id, dosen_id, dosen_nama, nilai_kreatifitas, nilai_fungsionalitas, 
         nilai_kerapian, nilai_karya, komentar, tanggal)
        VALUES
        ($portfolio_id, $dosen_id, '$dosen_nama', $nilai_kreatifitas, $nilai_fungsionalitas,
         $nilai_kerapian, $nilai_karya, '$komentar', NOW())
    ";

    mysqli_query($conn, $sqlInsert);
    $id = mysqli_insert_id($conn);
}

// ================================
// AMBIL DATA TERBARU
// ================================
$sqlGet = "SELECT * FROM penilaian WHERE id = $id";
$data = mysqli_query($conn, $sqlGet);
$penilaian = mysqli_fetch_assoc($data);

// Output JSON
echo json_encode([
    'success' => true,
    'penilaian' => $penilaian
]);

exit;
?>

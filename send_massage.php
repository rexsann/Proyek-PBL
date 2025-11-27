<?php
header('Content-Type: application/json');
session_start();
include './config/koneksi.php';

$nama  = $_POST['nama'] ?? '';
$email = $_POST['email'] ?? '';
$pesan = $_POST['pesan'] ?? '';

if(empty($nama) || empty($email) || empty($pesan)){
    echo json_encode(['status'=>'error','message'=>'Semua field harus diisi.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO messages (nama,email,pesan) VALUES (?,?,?)");
$stmt->bind_param("sss",$nama,$email,$pesan);

if($stmt->execute()){
    echo json_encode(['status'=>'success','message'=>'Pesan Anda berhasil dikirim.']);
}else{
    echo json_encode(['status'=>'error','message'=>'Terjadi kesalahan, coba lagi nanti.']);
}

$stmt->close();
$conn->close();

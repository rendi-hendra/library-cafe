<?php
include '../../connectdb.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Anda belum login']);
    exit;
}

$barang_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'];

// Validasi input
if ($barang_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID barang tidak valid']);
    exit;
}

// Masukkan atau update jumlah
$sql = "INSERT INTO keranjang (id_user, id_barang, jumlah)
        VALUES ($user_id, $barang_id, 1)
        ON DUPLICATE KEY UPDATE jumlah = jumlah + 1";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true, 'message' => 'Barang berhasil ditambahkan ke keranjang']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan ke keranjang: ' . mysqli_error($conn)]);
}
?>

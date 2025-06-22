<?php
include '../../connectdb.php';
session_start();

// Cek apakah user login
if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$id_barang = isset($_POST['id_barang']) ? (int)$_POST['id_barang'] : 0;

// Validasi input
if ($id_barang <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Hapus barang dari keranjang
$query = "DELETE FROM keranjang WHERE id_user = $user_id AND id_barang = $id_barang";
if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus item']);
}
?>

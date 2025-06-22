<?php
include '../../connectdb.php';
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data dari POST
$id_barang = isset($_POST['id_barang']) ? (int)$_POST['id_barang'] : 0;
$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 0;

// Validasi input
if ($id_barang <= 0 || $qty < 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

if ($qty == 0) {
    // Hapus item jika qty = 0
    $delete = "DELETE FROM keranjang WHERE id_user=$user_id AND id_barang=$id_barang";
    mysqli_query($conn, $delete);
} else {
    // Tambah atau update jumlah
    $insert = "INSERT INTO keranjang (id_user, id_barang, jumlah)
               VALUES ($user_id, $id_barang, $qty)
               ON DUPLICATE KEY UPDATE jumlah = VALUES(jumlah)";
    mysqli_query($conn, $insert);
}

echo json_encode(['success' => true]);
?>

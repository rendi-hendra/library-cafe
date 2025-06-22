<?php
include '../../connectdb.php';
session_start();

// Cek login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data JSON dari body request
$data = json_decode(file_get_contents("php://input"), true);
$items = $data['items'] ?? [];

if (empty($items)) {
    echo json_encode(['success' => false, 'message' => 'Tidak ada item untuk checkout']);
    exit;
}

$total = 0;
$detail_values = [];

// Loop item dan hitung total
foreach ($items as $item) {
    $id_barang = (int)$item['id_barang'];
    $qty = (int)$item['qty'];

    if ($qty <= 0) continue;

    // Ambil harga dari database
    $result = mysqli_query($conn, "SELECT harga FROM barang WHERE id = $id_barang");
    $barang = mysqli_fetch_assoc($result);

    if (!$barang) continue;

    $harga = (int)$barang['harga'];
    $subtotal = $qty * $harga;
    $total += $subtotal;

    $detail_values[] = [
        'id_barang' => $id_barang,
        'jumlah' => $qty,
        'harga' => $harga,
        'subtotal' => $subtotal
    ];
}

if (empty($detail_values)) {
    echo json_encode(['success' => false, 'message' => 'Item tidak valid']);
    exit;
}

// Simpan transaksi
mysqli_query($conn, "INSERT INTO transaksi (id_user, total, status) VALUES ($user_id, $total, 'selesai')");
$transaksi_id = mysqli_insert_id($conn);

// Simpan detail transaksi
foreach ($detail_values as $item) {
    $id_barang = $item['id_barang'];
    $jumlah = $item['jumlah'];
    $harga = $item['harga'];
    $subtotal = $item['subtotal'];

    mysqli_query($conn, "INSERT INTO transaksi_detail (id_transaksi, id_barang, jumlah, harga, subtotal)
                        VALUES ($transaksi_id, $id_barang, $jumlah, $harga, $subtotal)");

    mysqli_query($conn, "UPDATE barang SET stok = stok - $jumlah WHERE id = $id_barang");
}

// Hapus item yang dibeli dari keranjang
foreach ($detail_values as $item) {
    $id_barang = $item['id_barang'];
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = $user_id AND id_barang = $id_barang");
}

// Sukses
echo json_encode(['success' => true, 'message' => 'Checkout berhasil']);
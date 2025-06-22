<?php
include '../../connectdb.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    exit("ID tidak valid.");
}

// Cek gambar jika ada
$query = mysqli_query($conn, "SELECT gambar FROM barang WHERE id = $id");
$data = mysqli_fetch_assoc($query);

// if ($data && !empty($data['gambar'])) {
//     $gambarPath = '../../img/' . $data['gambar'];
//     if (file_exists($gambarPath)) {
//         unlink($gambarPath); // Hapus gambar dari folder
//     }
// }

// Update status barang menjadi nonaktif (soft delete)
$sql = "UPDATE barang SET status = 'nonaktif' WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    header("Location: ../../barang.php");
    exit;
} else {
    echo "Gagal menonaktifkan barang: " . mysqli_error($conn);
}

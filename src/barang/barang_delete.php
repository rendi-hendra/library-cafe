<?php
include '../../connectdb.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    exit("ID tidak valid.");
}

$query = mysqli_query($conn, "SELECT gambar FROM barang WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if ($data && !empty($data['gambar'])) {
    $gambarPath = '../../img/' . $data['gambar'];
    if (file_exists($gambarPath)) {
        unlink($gambarPath);
    }
}

// Hapus data dari database
$sql = "DELETE FROM barang WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    header("Location: ../../barang.php");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}

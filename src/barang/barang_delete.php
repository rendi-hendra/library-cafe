<?php
include '../../connectdb.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT gambar FROM barang WHERE id=$id");
$gambar = mysqli_fetch_assoc($query)['gambar'] ?? null;
unlink('../../img/' . $gambar);
$sql = "DELETE FROM barang WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    echo "Data berhasil dihapus.";
    header("Location: ../../barang.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

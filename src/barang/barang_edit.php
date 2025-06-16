<?php include '../../connectdb.php'; ?>
<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
?>

<?php
$id = $_GET['id'];
if (isset($_POST['edit'])) {
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $keterangan = $_POST['keterangan'];

    $sql = "UPDATE barang SET nama='$nama', harga='$harga', stok='$stok', keterangan='$keterangan' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../barang.php");
    } else {
        echo "gagal";
    }
    exit;
}
?>
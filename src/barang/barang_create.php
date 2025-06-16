<?php include '../../connectdb.php'; ?>

<?php
if (isset($_POST['create'])) {
    echo "Create Barang";
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $stok = mysqli_real_escape_string($conn, $_POST['stok']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    
    $sql = "INSERT INTO barang (nama, harga, stok, keterangan) VALUES ('$nama', '$harga', '$stok', '$keterangan')";
    if (mysqli_query($conn, $sql)) {
        header("Location: ../../barang.php");
        echo "<div class='alert alert-success'>Data berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
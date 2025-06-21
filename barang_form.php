<?php include 'connectdb.php';
 $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
?>

<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
?>
<?php include 'layout/header.php'; ?>

<body>
    <?php include 'layout/layout.php'; ?>
    <div class="container mt-4">

        <?php
        if (!$id) {
            echo '
                <h2>Tambah Barang</h2>
        <form method="POST" action="src/barang/barang_create.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="text" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="text" name="stok" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input class="form-control" type="file" name="gambar" id="gambar" required>
            </div>
            <input type="submit" name="create" value="Create" class="btn btn-success">
        </form>
                ';
        } else {
            $sql = "SELECT * FROM barang WHERE id=$id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            echo "
                <h2>Edit Barang</h2>
        <form method='POST' action='src/barang/barang_edit.php?id=". $id ."' enctype='multipart/form-data'>
            <input type='hidden' name='gambarLama' value='" . $row['gambar'] . "'>
            <div class='mb-3'>
                <label class='form-label'>Nama</label>
                <input type='text' name='nama' class='form-control' value='". $row['nama'] ."' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Harga</label>
                <input type='text' name='harga' class='form-control' value='". $row['harga'] ."' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Stok</label>
                <input type='text' name='stok' class='form-control' value='". $row['stok'] ."' required>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Keterangan</label>
                <input type='text' name='keterangan' class='form-control' value='". $row['keterangan'] ."' required>
            </div>
            <div class='mb-3'>
                <label for='gambar' class='form-label'>Gambar</label> <br>
                <img src='img/" . $row['gambar'] . "' width='150'>
                <input class='form-control' type='file' name='gambar' id='gambar'>
            </div>
            <input type='submit' name='edit' value='Update' class='btn btn-success'>
        </form>
                
                ";
        }
        ?>
    </div>
</body>
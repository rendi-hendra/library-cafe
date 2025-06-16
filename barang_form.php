<?php include 'connectdb.php';
 $id = $_GET['id'];
 $sql = "SELECT * FROM barang WHERE id=$id";
 $result = mysqli_query($conn, $sql);
 $row = mysqli_fetch_assoc($result);
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
        <form method="POST" action="src/barang/barang_create.php">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="text" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="text" name="stok" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <input type="text" name="keterangan" class="form-control" required>
            </div>
            <input type="submit" name="create" value="Create" class="btn btn-primary">
        </form>
                ';
        } else {
            echo "
                <h2>Edit Barang</h2>
        <form method='POST' action='src/barang/barang_edit.php?id=". $id ."'>
            <div class='mb-3'>
                <label>Nama</label>
                <input type='text' name='nama' class='form-control' value='". $row['nama'] ."' required>
            </div>
            <div class='mb-3'>
                <label>Harga</label>
                <input type='text' name='harga' class='form-control' value='". $row['harga'] ."' required>
            </div>
            <div class='mb-3'>
                <label>Stok</label>
                <input type='text' name='stok' class='form-control' value='". $row['stok'] ."' required>
            </div>
            <div class='mb-3'>
                <label>Keterangan</label>
                <input type='text' name='keterangan' class='form-control' value='". $row['keterangan'] ."' required>
            </div>
            <input type='submit' name='edit' value='Edit' class='btn btn-primary'>
        </form>
                
                ";
        }
        ?>
    </div>
</body>
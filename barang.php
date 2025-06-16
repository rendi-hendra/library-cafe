<?php include 'connectdb.php'; ?>
<?php 
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
?>
<?php include 'layout/header.php'; ?>

<body>
    <div>
        <?php include 'layout/layout.php'; ?>
        <div class="container">
            <a href="barang_form.php" class="btn btn-primary mt-5">Tambah Barang</a>
            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
                <?php
                $sql = "SELECT * FROM barang";
                $result = mysqli_query($conn, $sql);
                ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col">
                        <div class="card">
                            <!-- <img src="..." class="card-img-top" alt="..."> -->
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['nama'] ?></h5>
                                <p class="card-text">Harga: <?= $row['harga'] ?> Stok: <?= $row['stok'] ?></p>
                                <a href="barang_form.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
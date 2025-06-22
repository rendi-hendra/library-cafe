<?php
include 'connectdb.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$isAdmin = isset($_SESSION['admin']);
$barang = mysqli_query($conn, "SELECT * FROM barang");

include 'layout/header.php';
?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .hover-shadow:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        transition: 0.3s;
    }
</style>

<body>
    <?php include 'layout/layout.php'; ?>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- <h2 class="mb-0">Daftar Barang</h2> -->
            <?php if ($isAdmin): ?>
                <a href="barang_form.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Barang
                </a>
            <?php endif; ?>
        </div>

        <?php if (mysqli_num_rows($barang) > 0): ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 g-4 mb-2">
                <?php while ($row = mysqli_fetch_assoc($barang)): ?>
                    <div class="col">
                        <div class="card h-100 border-0 hover-shadow shadow-sm">
                            <img
                                src="img/<?= htmlspecialchars($row['gambar']) ?>"
                                alt="<?= htmlspecialchars($row['nama']) ?>"
                                class="card-img-top rounded-top object-fit-cover"
                                style="height: 180px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($row['nama']) ?></h5>
                                <p class="card-text small text-muted"><?= htmlspecialchars($row['keterangan']) ?></p>
                                <p class="card-text fw-bold">
                                    Rp <?= number_format($row['harga'], 0, ',', '.') ?><br>
                                    <span class="text-secondary fw-normal">Stok: <?= htmlspecialchars($row['stok']) ?></span>
                                </p>
                                <div class="mt-auto">
                                    <?php if ($isAdmin): ?>
                                        <a href="barang_form.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm me-1">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm btn-delete" data-id="<?= $row['id'] ?>">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-outline-success w-100 btn-buy" data-id="<?= $row['id'] ?>">
                                            <i class="bi bi-cart-plus"></i> Keranjang
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning mt-4">Tidak ada barang.</div>
        <?php endif; ?>
    </div>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-buy').forEach(button => {
            button.addEventListener('click', function(e) {
                const id = this.dataset.id;

                fetch(`src/keranjang/keranjang_create.php?id=${id}`)
                    .then(res => {
                        if (!res.ok) throw new Error("Gagal menambahkan ke keranjang");
                        return res.text(); // atau .json jika responnya json
                    })
                    .then(data => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Barang telah ditambahkan ke keranjang.',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Lihat Keranjang',
                            cancelButtonText: 'Lanjut Belanja'
                        }).then(result => {
                            if (result.isConfirmed) {
                                window.location.href = 'keranjang.php';
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire('Error', error.message, 'error');
                    });
            });
        });

        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.dataset.id;

                Swal.fire({
                    title: 'Yakin mau hapus?',
                    text: "Data akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Barang berasil dihapus.",
                            icon: "success"
                        }).then(oke => {
                            if (oke.isConfirmed) {
                                window.location.href = `src/barang/barang_delete.php?id=${id}`;
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
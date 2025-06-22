<?php
include 'connectdb.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION["admin"])) {
    header("Location: barang.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$data = [
    'nama' => '',
    'harga' => '',
    'stok' => '',
    'keterangan' => '',
    'gambar' => '',
];
$action = 'src/barang/barang_create.php';
$button = 'Create';
$title = 'Tambah Barang';
$requireImage = 'required';

if ($id) {
    $query = mysqli_query($conn, "SELECT * FROM barang WHERE id=$id");
    $data = mysqli_fetch_assoc($query);
    $action = "src/barang/barang_edit.php?id=$id";
    $button = 'Update';
    $title = 'Edit Barang';
    $requireImage = ''; // tidak wajib upload gambar baru saat edit
}
?>

<?php include 'layout/header.php'; ?>

<style>
    .form-wrapper {
        max-width: 600px;
        margin: auto;
        background: #ffffff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    .form-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 1.5rem;
    }
</style>

<body>
<?php include 'layout/layout.php'; ?>

<div class="container py-5">
    <div class="form-wrapper">
        <h2 class="form-title"><?= $title ?></h2>

        <form method="POST" action="<?= $action ?>" enctype="multipart/form-data">
            <?php if ($id): ?>
                <input type="hidden" name="gambarLama" value="<?= $data['gambar'] ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($data['harga']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($data['stok']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2" required><?= htmlspecialchars($data['keterangan']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar</label><br>
                <?php if ($id && $data['gambar']): ?>
                    <img src="img/<?= htmlspecialchars($data['gambar']) ?>" class="mb-2 rounded shadow-sm" width="120"><br>
                <?php endif; ?>
                <input class="form-control" type="file" name="gambar" <?= $requireImage ?>>
                <?php if (!$requireImage): ?>
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                <?php endif; ?>
            </div>

            <div class="d-grid">
                <button type="submit" name="<?= strtolower($button) ?>" class="btn btn-success">
                    <i class="bi bi-save"></i> <?= $button ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap Icons (untuk ikon tombol) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>

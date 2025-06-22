<?php include 'connectdb.php'; ?>
<?php 
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION["admin"])) {
    header("Location: user.php");
    exit;
}
?>

<?php include 'layout/header.php'; ?>

<?php
$id = $_GET['id'];
$sql = "SELECT id, nama, email FROM user WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
    .form-wrapper {
        max-width: 500px;
        margin: auto;
        background: #fff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
</style>

<body>
    <?php include 'layout/layout.php'; ?>

    <div class="container py-5">
        <div class="form-wrapper">
            <h2 class="mb-4 text-center fw-bold">Edit Data User</h2>

            <form method="POST" action="src/user/user_update.php?id=<?= $id ?>">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']) ?>" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="update" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <a href="user.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>

<?php
include 'connectdb.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$isAdmin = isset($_SESSION['admin']);

$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);

include 'layout/header.php';
?>

<body>
    <?php include 'layout/layout.php'; ?>
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Pengguna</h4>
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <?php if ($isAdmin): ?>
                                        <th scope="col">Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $i => $row): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= htmlspecialchars($row['nama']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <?php if ($isAdmin): ?>
                                            <td>
                                                <a href="user_form.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $row['id'] ?>">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center">Tidak ada data pengguna.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const userId = this.getAttribute('data-id');

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
                                window.location.href = `src/user/user_delete.php?id=${userId}`;
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

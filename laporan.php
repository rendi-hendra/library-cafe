<?php
include 'connectdb.php';
session_start();

// Cek apakah admin
if (!isset($_SESSION["login"]) || !$_SESSION['admin']) {
    header("Location: login.php");
    exit;
}

include 'layout/header.php';

// Ambil data statistik
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi"))['total'];
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM transaksi"))['total'] ?? 0;
$total_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM user"))['total'];

// Ambil barang terlaris
$barang_terlaris = mysqli_query($conn, "
    SELECT b.nama, SUM(td.jumlah) as total_terjual
    FROM transaksi_detail td
    JOIN barang b ON td.id_barang = b.id
    GROUP BY td.id_barang
    ORDER BY total_terjual DESC
    LIMIT 5
");
?>

<body>
<?php include 'layout/layout.php'; ?>
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Dashboard Laporan Admin</h2>

    <!-- Stat cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 bg-light">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <i class="bi bi-cart4 display-4 text-primary mb-3"></i>
                    <h5 class="fw-semibold">Total Transaksi</h5>
                    <p class="fs-3 mb-0"><?= $total_transaksi ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 bg-light">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <i class="bi bi-cash-coin display-4 text-success mb-3"></i>
                    <h5 class="fw-semibold">Total Pendapatan</h5>
                    <p class="fs-3 mb-0">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 bg-light">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <i class="bi bi-people display-4 text-dark mb-3"></i>
                    <h5 class="fw-semibold">Jumlah Pengguna</h5>
                    <p class="fs-3 mb-0"><?= $total_user ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Terlaris -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <h4 class="fw-bold mb-3">Barang Terlaris</h4>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Total Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($barang_terlaris)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= $row['total_terjual'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if ($no === 1): ?>
                        <tr><td colspan="3" class="text-center text-muted">Belum ada data penjualan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>

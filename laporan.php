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
    <div class="container-fluid">
        <!-- <h2 class="mb-4 fw-bold">Dashboard Laporan Admin</h2> -->

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-4 text-gray-800 mt-5">Dashboard Laporan Admin</h1>
        </div>

        <!-- Stat cards -->
        <div class="row justify-content-center">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_transaksi ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pendapatan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pengguna</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_user ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
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
                        <?php $no = 1;
                        while ($row = mysqli_fetch_assoc($barang_terlaris)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= $row['total_terjual'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($no === 1): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data penjualan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
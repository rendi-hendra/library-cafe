<?php
include 'connectdb.php';
session_start();

// Cek apakah admin
if (!isset($_SESSION["login"]) || !$_SESSION['admin']) {
    header("Location: login.php");
    exit;
}


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


include 'layout/header.php';
?>

<body>
    <?php include 'layout/layout.php'; ?>
    <div class="container-fluid mt-4">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Laporan Admin</h1>
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

        <div class="row mt-5 mb-4">
            <!-- Chart 1: Area Chart -->
            <div class="col-md-6">
                <div class="card shadow mb-4 h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Total Pendapatan Perhari</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart 2: Bar Chart -->
            <div class="col-md-6">
                <div class="card shadow mb-4 h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Total Barang Terjual</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'layout/footer.php'; ?>
    </div>


    <!-- Page level custom scripts -->
    <?php include 'src/chart/chart-area.php'; ?>
    <?php include 'src/chart/chart-bar.php'; ?>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</body>
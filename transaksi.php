<?php
include 'connectdb.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Filter tanggal jika ada
$start = $_GET['start_date'] ?? '';
$end = $_GET['end_date'] ?? '';

$filter = "";
if ($start && $end) {
    $filter = "AND t.tanggal BETWEEN '$start' AND '$end'";
} elseif ($start) {
    $filter = "AND t.tanggal >= '$start'";
} elseif ($end) {
    $filter = "AND t.tanggal <= '$end'";
}

$transaksi = mysqli_query($conn, "
    SELECT t.id, t.tanggal, t.total, t.status, td.jumlah, td.harga, b.nama, b.gambar 
    FROM transaksi t 
    JOIN transaksi_detail td ON t.id = td.id_transaksi 
    JOIN barang b ON td.id_barang = b.id 
    WHERE t.id_user = $user_id $filter
    ORDER BY t.tanggal DESC
");


$riwayat = [];
while ($row = mysqli_fetch_assoc($transaksi)) {
    $id = $row['id'];
    if (!isset($riwayat[$id])) {
        $riwayat[$id] = [
            'tanggal' => $row['tanggal'],
            'total' => $row['total'],
            'status' => $row['status'],
            'items' => [],
        ];
    }
    $riwayat[$id]['items'][] = [
        'nama' => $row['nama'],
        'jumlah' => $row['jumlah'],
        'harga' => $row['harga'],
        'gambar' => $row['gambar'],
    ];
}

include 'layout/header.php';
?>

<body>
    <?php include 'layout/layout.php'; ?>
    <div class="container-fluid">
        <h3 class="mb-4">Riwayat Transaksi</h3>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-5">
                <input type="date" name="start_date" class="form-control" value="<?= $_GET['start_date'] ?? '' ?>">
            </div>
            <div class="col-md-5">
                <input type="date" name="end_date" class="form-control" value="<?= $_GET['end_date'] ?? '' ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>


        <?php if (empty($riwayat)): ?>
            <div class="text-center p-5 bg-light rounded shadow-sm">
                <img src="public/empty.png" width="100" alt="Belum ada transaksi" class="mb-3">
                <h4 class="fw-bold">Kamu belum pernah bertransaksi</h4>
                <p class="text-muted">Yuk, mulai belanja dan penuhi berbagai kebutuhanmu!</p>
                <a href="barang.php" class="btn btn-success fw-bold">Mulai Belanja</a>
            </div>
        <?php else: ?>
            <?php foreach ($riwayat as $id => $trx): ?>
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="ms-3"><?= date('j M Y', strtotime($trx['tanggal'])) ?></span>
                                <?php if ($trx['status'] === 'selesai'): ?>
                                    <span class="badge bg-success ml-2 text-white">Selesai</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary ms-2"><?= ucfirst($trx['status']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">Total Belanja</small>
                                <div class="fw-bold">Rp <?= number_format($trx['total'], 0, ',', '.') ?></div>
                            </div>
                        </div>
                        <?php foreach ($trx['items'] as $item): ?>
                            <div class="d-flex align-items-center border-top py-3">
                                <img src="img/<?= htmlspecialchars($item['gambar']) ?>" width="64" height="64" class="rounded mx-3" alt="<?= htmlspecialchars($item['nama']) ?>">
                                <div>
                                    <div class="fw-semibold"><?= htmlspecialchars($item['nama']) ?></div>
                                    <div class="text-muted small"><?= $item['jumlah'] ?> barang x Rp<?= number_format($item['harga'], 0, ',', '.') ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php include 'layout/footer.php'; ?>
</body>
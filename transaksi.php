<?php
include 'connectdb.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Ambil data transaksi dan detail
$transaksi = mysqli_query($conn, "
    SELECT t.id, t.tanggal, t.total, t.status, td.jumlah, td.harga, b.nama, b.gambar 
    FROM transaksi t 
    JOIN transaksi_detail td ON t.id = td.id_transaksi 
    JOIN barang b ON td.id_barang = b.id 
    WHERE t.id_user = $user_id 
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
    <div class="container py-4">
        <h3 class="mb-4">Riwayat Transaksi</h3>

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
                                    <span class="badge bg-success ms-2">Selesai</span>
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
                            <div class="d-flex align-items-center border-top pt-3">
                                <img src="img/<?= htmlspecialchars($item['gambar']) ?>" width="64" height="64" class="rounded me-3" alt="<?= htmlspecialchars($item['nama']) ?>">
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
</body>
<?php
// Hubungkan ke database
include 'connectdb.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Ambil user ID dari session
$user_id = $_SESSION['user_id'];

// Ambil data keranjang dengan informasi barang
$sql = "SELECT k.id_barang, k.jumlah, b.nama, b.harga, b.gambar 
        FROM keranjang k 
        JOIN barang b ON k.id_barang = b.id 
        WHERE k.id_user = $user_id";
$result = mysqli_query($conn, $sql);

// Gabungkan barang yang sama dan jumlahkan qty-nya
$cartItems = [];
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_barang'];
    if (!isset($cartItems[$id])) {
        $cartItems[$id] = $row;
        $cartItems[$id]['qty'] = 1;
    } else {
        $cartItems[$id]['qty'] += 1;
    }
}

include 'layout/header.php';
?>

<body>
    <?php include 'layout/layout.php'; ?>
    <div class="container-fluid">
        <h2 class="mb-4">Keranjang</h2>
        <div class="row">
            <div class="col-md-8">
                <!-- Daftar item keranjang -->
                <div id="cartItems">
                    <?php if (empty($cartItems)): ?>
                        <div class="text-center p-5 bg-white rounded shadow-sm" style="margin-top: 40px;">
                            <img src="https://lf-web-assets.tokopedia-static.net/obj/tokopedia-web-sg/backfunnel_v3/4d27af6a.svg" alt="Keranjang Kosong" width="120" class="mb-3">
                            <h4 class="fw-bold">Wah, keranjang belanjamu kosong</h4>
                            <p class="text-muted">Yuk, isi dengan barang-barang impianmu!</p>
                            <a href="barang.php" class="btn btn-success fw-bold">Mulai Belanja</a>
                        </div>
                    <?php else: ?>
                        <!-- Checkbox untuk memilih semua item -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-semibold" for="selectAll">Pilih Semua</label>
                        </div>
                        <?php foreach ($cartItems as $item): ?>
                            <div id="cartItems">
                                <div class="card mb-3 cart-item" data-price="<?= $item['harga'] ?>" data-id="<?= $item['id_barang'] ?>">
                                    <div class="card-body d-flex align-items-center">
                                        <input class="form-check-input ml-0 item-checkbox" type="checkbox">
                                        <img src="img/<?= htmlspecialchars($item['gambar']) ?>" width="80" height="80" class="ml-4 mr-3 rounded" alt="<?= htmlspecialchars($item['nama']) ?>">
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1"><?= htmlspecialchars($item['nama']) ?></h5>
                                            <p class="mb-1 text-muted">Rp<span class="item-price"><?= number_format($item['harga'], 0, ',', '.') ?></span></p>
                                            <div class="input-group w-auto">
                                                <!-- Tombol pengurang -->
                                                <button class="btn btn-outline-secondary btn-sm btn-minus">-</button>
                                                <!-- Input jumlah item -->
                                                <input type="text" class="form-control form-control-sm text-center item-qty" value="<?= $item['jumlah'] ?>" style="max-width: 50px;">
                                                <!-- Tombol penambah -->
                                                <button class="btn btn-outline-secondary btn-sm btn-plus">+</button>
                                            </div>
                                        </div>
                                        <!-- Tombol hapus item -->
                                        <button class="btn btn-outline-danger btn-delete btn-sm ms-3">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ringkasan belanja -->
            <div class="col-md-4" style="margin-top: 40px;">
                <div class="card rounded shadow-sm bg-white">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Belanja</h5>
                        <p>Total: <strong>Rp<span id="totalHarga">0</span></strong></p>
                        <button class="btn btn-success w-100" id="btnCheckout">Beli</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Format angka ke dalam format Rupiah
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        // Perbarui total harga belanja saat checkbox dipilih atau qty berubah
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const checkbox = item.querySelector('.item-checkbox');
                if (checkbox.checked) {
                    const price = parseInt(item.dataset.price);
                    const qty = parseInt(item.querySelector('.item-qty').value);
                    total += price * qty;
                }
            });
            document.getElementById('totalHarga').innerText = formatRupiah(total);
        }

        // Kirim perubahan qty ke server via AJAX
        function updateQtyToServer(item) {
            const id_barang = item.dataset.id;
            const qty = item.querySelector('.item-qty').value;

            fetch('src/keranjang/update_qty.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id_barang=${id_barang}&qty=${qty}`
            }).then(res => res.json()).then(data => {
                if (!data.success) alert("Gagal menyimpan qty ke server");
            });
        }

        // Pilih semua checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.item-checkbox').forEach(cb => {
                cb.checked = this.checked;
            });
            updateTotal();
        });

        // Update total saat item dipilih atau batal dipilih
        document.querySelectorAll('.item-checkbox').forEach(cb => {
            cb.addEventListener('change', updateTotal);
        });

        // Tambah qty
        document.querySelectorAll('.btn-plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const item = this.closest('.cart-item');
                const input = item.querySelector('.item-qty');
                input.value = parseInt(input.value) + 1;
                updateTotal();
                updateQtyToServer(item);
            });
        });

        // Kurangi qty
        document.querySelectorAll('.btn-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const item = this.closest('.cart-item');
                const input = item.querySelector('.item-qty');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    updateTotal();
                    updateQtyToServer(item);
                }
            });
        });

        // Deteksi input manual pada qty dan update
        document.querySelectorAll('.item-qty').forEach(input => {
            input.addEventListener('input', function() {
                const item = this.closest('.cart-item');
                updateTotal();
                updateQtyToServer(item);
            });
        });

        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const item = this.closest('.cart-item');
                const id_barang = item.dataset.id;
                fetch('src/keranjang/keranjang_delete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id_barang=${id_barang}`
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            item.remove(); // Hapus dari tampilan
                            updateTotal(); // Update total belanja

                            // Cek apakah masih ada item di keranjang
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload(); // Jika kosong, reload halaman untuk menampilkan tampilan kosong
                            }
                        } else {
                            alert("Gagal menghapus item");
                        }
                    });
            });
        });

        document.getElementById('btnCheckout').addEventListener('click', function() {
            // Ambil item yang dicentang
            const selectedItems = [];
            document.querySelectorAll('.cart-item').forEach(item => {
                const checkbox = item.querySelector('.item-checkbox');
                if (checkbox.checked) {
                    const id = item.dataset.id;
                    const qty = item.querySelector('.item-qty').value;
                    selectedItems.push({
                        id_barang: id,
                        qty: parseInt(qty)
                    });
                }
            });

            // Jika tidak ada barang dipilih
            if (selectedItems.length === 0) {
                Swal.fire('Peringatan', 'Pilih minimal satu barang untuk checkout.', 'warning');
                return;
            }

            // Konfirmasi sebelum checkout
            Swal.fire({
                title: 'Konfirmasi Checkout',
                text: "Yakin ingin melakukan pembelian?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, beli!'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch('src/keranjang/checkout.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                items: selectedItems
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            console.log(data);
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Transaksi berhasil dilakukan.',
                                    icon: 'success'
                                }).then(() => {
                                    location.reload(); // Refresh halaman
                                });
                            } else {
                                Swal.fire('Gagal', data.message || 'Terjadi kesalahan saat checkout.', 'error');
                            }
                        }).catch(err => {
                            console.error('Fetch error:', err);
                            Swal.fire('Error', 'Tidak bisa terhubung ke server.', 'error');
                        });
                }
            });
        });
    </script>
</body>
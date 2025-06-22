<?php
// Ambil path aktif dari URI
$activePage = basename($_SERVER['REQUEST_URI']);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($_SESSION['admin']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="barang.php">Library Cafe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link <?= $activePage === 'barang.php' ? 'active fw-bold' : '' ?>" href="barang.php">
                        Barang
                    </a>
                </li>
                <?php if (!$isAdmin): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $activePage === 'keranjang.php' ? 'active fw-bold' : '' ?>" href="keranjang.php">
                        Keranjang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $activePage === 'transaksi.php' ? 'active fw-bold' : '' ?>" href="transaksi.php">
                        Transaksi
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $activePage === 'user.php' ? 'active fw-bold' : '' ?>" href="user.php">
                        User
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <button class="btn btn-outline-light btn-sm btn-logout">Logout</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-logout').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin mau logout?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = 'logout.php';
                    }
                });
            });
        });
    </script>

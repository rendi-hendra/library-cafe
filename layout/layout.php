<?php
// Ambil path aktif dari URI
$activePage = basename($_SERVER['REQUEST_URI']);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($_SESSION['admin']);
?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="position: sticky; top: 0; height: 100vh; z-index: 1020;">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="barang.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?= $isAdmin ? 'Admin' : 'User' ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item my-0 <?= $activePage === 'barang.php' ? 'active fw-bold' : '' ?>">
                <a class="nav-link" href="barang.php">
                    <i class="fa-solid fa-box"></i>
                    <span>Barang</span>
                </a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <?php if ($isAdmin): ?>
                <li class="nav-item <?= $activePage === 'laporan.php' ? 'active fw-bold' : '' ?>">
                    <a class="nav-link" href="laporan.php">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Laporan</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (!$isAdmin): ?>
                <li class="nav-item <?= $activePage === 'keranjang.php' ? 'active fw-bold' : '' ?>">
                    <a class="nav-link" href="keranjang.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Keranjang</span>
                    </a>
                </li>
                <li class="nav-item <?= $activePage === 'transaksi.php' ? 'active fw-bold' : '' ?>">
                    <a class="nav-link" href="transaksi.php">
                        <i class="fa-solid fa-money-bill"></i>
                        <span>Transaksi</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($isAdmin): ?>
                <!-- Nav Item - Utilities Collapse Menu -->
                <li class="nav-item <?= $activePage === 'user.php' ? 'active fw-bold' : '' ?>">
                    <a class="nav-link" href="user.php">
                        <i class="fa-solid fa-users"></i>
                        <span>User</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand font-weight-bold" href="barang.php">Library Cafe</a>
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-lg-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control bg-light border-0 small"
                                placeholder="Search for..."
                                aria-label="Search"
                                aria-describedby="basic-addon2" />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['username'] ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    <button class=" btn btn-logout">Logout</button>
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
<nav
    class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body"
    data-bs-theme="dark">
    <div class="container">
        <a href="index.php" class="navbar-brand fw-semibold">Library Cafe</a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php
                    if ($_SERVER['REQUEST_URI'] == "/library-cafe/barang.php") {
                        echo '<a class="nav-link active" href="barang.php">Barang</a>';
                    } else {
                        echo '<a class="nav-link" href="barang.php">Barang</a>';
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <?php
                    if ($_SERVER['REQUEST_URI'] == "/library-cafe/transaksi.php") {
                        echo '<a class="nav-link active" href="transaksi.php">Transaksi</a>';
                    } else {
                        echo '<a class="nav-link" href="transaksi.php">Transaksi</a>';
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <?php
                    if ($_SERVER['REQUEST_URI'] == "/library-cafe/user.php") {
                        echo '<a class="nav-link active" href="user.php">User</a>';
                    } else {
                        echo '<a class="nav-link" href="user.php">User</a>';
                    }
                    ?>
                </li>
                <a href="logout.php" class="btn btn-danger ms-3">Logout</a>
            </ul>
        </div>
    </div>
</nav>